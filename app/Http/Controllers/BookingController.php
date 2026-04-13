<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingApprovedMail;
use App\Mail\BookingRejectedMail;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'fasilitas_id' => 'required|exists:fasilitas,id',
            'tgl_mulai' => 'required|date',
            'package_type' => 'required|in:harian,bulanan',
            'duration' => 'required|integer|min:1',
            'adults' => 'required|integer|min:1',
            'rooms_count' => 'required|integer|min:1',
        ]);

        $fasilitas = \App\Models\Fasilitas::findOrFail($request->fasilitas_id);
        $totalPrice = 0;
        $tgl_selesai = null;
        $duration = (int)$request->duration;

        if ($request->package_type === 'harian') {
            // Calculate price based on duration * base price (fasilitas->harga)
            $totalPrice = $duration * $fasilitas->harga;
            $start = \Carbon\Carbon::parse($request->tgl_mulai);
            $tgl_selesai = $start->copy()->addDays($duration - 1)->format('Y-m-d');
        } else {
            // Bulanan: duration in months
            $start = \Carbon\Carbon::parse($request->tgl_mulai);
            $tgl_selesai = $start->copy()->addMonths($duration)->subDay()->format('Y-m-d');
            
            // For now, monthly price is duration * price * 30 (approx)
            // Ideally should have a specific monthly price column
            $totalPrice = $duration * $fasilitas->harga * 30;
        }

        // Create renter
        $penyewa = \App\Models\Penyewa::create([
            'nama' => $request->name,
            'whatsapp' => $request->whatsapp,
            'email' => $request->email
        ]);

        $booking = \App\Models\Booking::create([
            'penyewa_id' => $penyewa->id,
            'fasilitas_id' => $request->fasilitas_id,
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_selesai' => $tgl_selesai,
            'package_type' => $request->package_type,
            // Store technical details in JSON or separate columns if needed
            'selected_packages' => json_encode([
                'duration' => $duration,
                'adults' => $request->adults,
                'children' => $request->children_count ?? 0,
                'rooms' => $request->rooms_count,
                'child_ages' => $request->child_age ?? []
            ]),
            'total_harga' => $totalPrice,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Reservasi Anda telah berhasil dikirim! Silakan tunggu konfirmasi admin.'
        ]);
    }

    public function indexAdmin()
    {
        $pendingBookings = \App\Models\Booking::with(['penyewa', 'fasilitas'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard.jadwalBooking', compact('pendingBookings'));
    }

    public function approve($id)
    {
        $booking = \App\Models\Booking::with('penyewa')->findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        // Generate PDF attach data
        $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
        $pdfOutput = $pdf->output();

        // Send Email using Mail facade safely
        try {
            Mail::to($booking->penyewa->email)->send(new BookingApprovedMail($booking, $pdfOutput));
        } catch (\Exception $e) {
            // Log if email fails, but continue approval process
            \Log::error("Failed to send approval email for booking #{$id}: " . $e->getMessage());
        }

        $publicReceiptUrl = route('public.receipt', $booking->id);

        return response()->json([
            'success' => true,
            'message' => 'Booking #' . $id . ' telah disetujui! Email telah dikirim.',
            'name' => $booking->penyewa->nama,
            'phone' => $booking->penyewa->whatsapp,
            'booking_id' => $id,
            'public_receipt_url' => $publicReceiptUrl
        ]);
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        $booking = \App\Models\Booking::with('penyewa')->findOrFail($id);
        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $request->reason
        ]);

        // Send Email using Mail facade safely
        try {
            Mail::to($booking->penyewa->email)->send(new BookingRejectedMail($booking, $request->reason));
        } catch (\Exception $e) {
            \Log::error("Failed to send rejection email for booking #{$id}: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Booking #' . $id . ' telah ditolak dengan alasan: ' . $request->reason,
            'name' => $booking->penyewa->nama,
            'phone' => $booking->penyewa->whatsapp,
            'reason' => $request->reason
        ]);
    }

    public function downloadReceipt($id)
    {
        $booking = \App\Models\Booking::with(['penyewa', 'fasilitas'])->findOrFail($id);
        
        $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
        
        return $pdf->download('Kwitansi_BOE_' . $booking->id . '.pdf');
    }

    public function publicReceipt($id)
    {
        // Public method to stream the receipt for sharing via WA link
        $booking = \App\Models\Booking::with(['penyewa', 'fasilitas'])->findOrFail($id);

        if ($booking->status !== 'confirmed') {
            abort(403, 'Kwitansi ini belum valid untuk diunduh karena belum disetujui.');
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('booking'));
        
        return $pdf->stream('Kwitansi_BOE_' . $booking->id . '.pdf');
    }
}

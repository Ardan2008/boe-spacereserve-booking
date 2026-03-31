<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admins;
use App\Models\Fasilitas;
use App\Models\Booking;
use App\Models\Penyewa;

class AdminsController extends Controller
{
    public function login(Request $request)
    {

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari admin berdasarkan username
        $admin = Admins::where('username', $request->username)->first();

        // Cek username & password (tanpa hash)
        if ($admin && $request->password === $admin->password) {
            // Simpan session
            $request->session()->put('id_log', $admin->id_log);
            $request->session()->put('nama', $admin->nama);


            return response()->json([
                'success' => true,
                'redirect' => route('dashboardMaster')
            ]);
        }

        return response()->json([
            'success' => false,
            'errors' => [
                'login' => ['Username atau password salah!']
            ]
        ], 422);
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['id_log', 'nama']);
        $request->session()->flush();

        return redirect()->route('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:admins,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $admin = Admins::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => $request->password,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Admin Berhasil Ditambahkan',
            'admin' => $admin,
        ]);
    }

    // Password hanya diupdate jika diisi di form
    public function update(Request $request, $id_log)
    {
        try {
            // contoh update
            $admin = Admins::where('id_log', $id_log)->first();

            if (!$admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $admin->update([
                // isi field kamu
                'name' => $request->name,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Tambahkan fungsi ini di dalam AdminsController
    public function manage($id_log)
    {
        // Mengambil data admin berdasarkan primary key id_log
        $admin = Admins::findOrFail($id_log);

        // Meneruskan variabel $admin ke view
        return view('admin.dashboard.management.manage_admin_control', compact('admin'));
    }

    public function index()
    {
        // 1. Ambil Data Statistik untuk Summary Card
        $totalFasilitas = Fasilitas::count();
        $totalBooking = Booking::count();
        $totalPenyewa = Penyewa::count();

        // 2. Ambil data untuk Chart Fasilitas
        $fasilitas = Fasilitas::withCount('booking')->get();

        // Label: Nama Fasilitas
        $labelsFasilitas = $fasilitas->pluck('nama_fasilitas')->toArray();

        // Data: Jumlah booking per fasilitas
        $dataBookingPerFasilitas = $fasilitas->pluck('booking_count')->toArray();

        // 3. Kirim semua data ke satu view dashboard
        return view('admin.dashboard.index', compact(
            'totalFasilitas',
            'totalBooking',
            'totalPenyewa',
            'labelsFasilitas',
            'dataBookingPerFasilitas'
        ));
    }

    /**
     * Menampilkan Daftar Admin (Dipisahkan dari index dashboard)
     */
    public function adminActiveControl()
    {
        $admins = Admins::all();
        return view('admin.dashboard.management.admin_active_control', compact('admins'));
    }

    public function view($id_log)
    {
        $admin = Admins::findOrFail($id_log);
        return view('admin.dashboard.management.view_admin', compact('admin'));
    }
}
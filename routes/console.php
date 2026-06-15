<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\Schedule;
use App\Models\Booking;
use App\Models\AuditLog;

Schedule::call(function () {
    $expiredBookings = Booking::whereIn('status', ['pending', 'confirmed'])
        ->whereNotNull('expired_at')
        ->where('expired_at', '<', now())
        ->get();

    foreach ($expiredBookings as $booking) {
        $reason = $booking->status === 'pending'
            ? 'Sistem Otomatis: Melewati batas waktu reservasi.'
            : 'Sistem Otomatis: Melewati batas waktu konfirmasi/pembayaran.';

        $booking->update([
            'status' => 'cancelled',
            'rejection_reason' => $reason,
        ]);

        $fasilitasNama = $booking->fasilitas->nama ?? '-';

        AuditLog::catat(
            'Auto Expire',
            "Membatalkan reservasi #{$booking->id} secara otomatis karena {$reason}",
            [
                'target_tipe'    => 'booking',
                'target_id'      => $booking->id,
                'fasilitas_nama' => $fasilitasNama,
            ]
        );
    }
})->name('auto-expire-bookings')->everyMinute()->withoutOverlapping();

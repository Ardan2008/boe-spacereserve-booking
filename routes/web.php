<?php

use Illuminate\Support\Facades\Route;
// --- TAMBAHKAN IMPORT CONTROLLER DI SINI ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\FasilitasController;
use App\Http\Controllers\KontrolJadwalController;
use App\Http\Controllers\RiwayatController;

// --- ROUTE ASLI KAMU (TIDAK DIUBAH) ---

Route::get('/', function () {
    $facilities = \App\Models\Fasilitas::all();
    return view('home', compact('facilities'));
})->name('home');

Route::get('/formBooking', function (\Illuminate\Http\Request $request) {
    $facilities = \App\Models\Fasilitas::all();
    $selectedId = $request->query('id', '');
    return view('formBooking', compact('facilities', 'selectedId'));
})->name('formBooking');

Route::post('/bookings/store', [BookingController::class, 'store'])->name('bookings.store');
Route::get('/receipt/public/{id}', [BookingController::class, 'publicReceipt'])->name('public.receipt');

Route::get('/schedule_booking', function () {
    return view('schedule_booking');
})->name('schedule_booking');

// Bagian Admin
Route::get('/admin/formLogin', function () {
    return view('admin.formLogin');
})->name('formLogin');

// Auth Admin
Route::post('/admin/login', [AdminsController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');

Route::middleware(['admin.access'])->group(function () {
    // Route Khusus Owner
    Route::middleware(['admin.access:owner'])->group(function () {
        Route::get('/admin/dashboard/management/add_new_admin', function () {
            return view('admin.dashboard.management.add_new_admin');
        })->name('dashboardAddNewAdmin');
        
        Route::post('/admin/store', [AdminsController::class, 'store'])->name('admin.store');
        Route::get('/admin/dashboard/management/admin_active_control', [AdminsController::class, 'adminActiveControl'])->name('admin.active.control');
        Route::get('/admin/dashboard/management/active-list', [AdminsController::class, 'adminActiveControl'])->name('admin.active.list');

        // Role Management Methods
        Route::put('/admin/permissions/{id_log}', [AdminsController::class, 'updatePermissions'])->name('admin.updatePermissions');
        Route::post('/admin/promote/{id_log}', [AdminsController::class, 'promoteToOwner'])->name('admin.promote');
        Route::post('/admin/force-logout/{id_log}', [AdminsController::class, 'forceLogoutAdmin'])->name('admin.forceLogout');
        Route::delete('/admin/delete/{id_log}', [AdminsController::class, 'destroyAdmin'])->name('admin.destroyAdmin');
        Route::put('/admin/update-credentials/{id_log}', [AdminsController::class, 'updateAdminCredentials'])->name('admin.updateCredentials');
        
        // Admin detail for owner to view
        Route::get('/admin/view/{id_log}', [AdminsController::class, 'view'])->name('admin.view');
        Route::get('/admin/dashboard/management/view_admin', function () {
            return view('admin.dashboard.management.view_admin');
        })->name('dashboardViewAdmin');
    });

    // Routing umum Admin
    Route::get('/admin/dashboard/master', [AdminDashboardController::class, 'index'])->name('dashboardMaster');

    Route::get('/admin/dashboard/layouts/sidebar', function () {
        return view('admin.dashboard.layouts.sidebar');
    })->name('dashboardSidebar');

    Route::get('/admin/dashboard/dataFasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

    Route::get('/admin/dashboard/dataHargaSewa', [AdminsController::class, 'dataHargaSewa'])->name('dashboardHargaSewa');
    Route::delete('/admin/dashboard/dataHargaSewa/delete/{id}', [AdminsController::class, 'destroyHargaSewa'])->name('admin.deleteHargaSewa');
    Route::post('/admin/dashboard/dataHargaSewa/bulk-delete', [AdminsController::class, 'bulkDestroyHargaSewa'])->name('admin.bulkDeleteHargaSewa');

    Route::get('/admin/dashboard/dataPenyewa', [AdminsController::class, 'dataPenyewa'])->name('dashboardPenyewa');
    Route::delete('/admin/dashboard/dataPenyewa/delete/{id}', [AdminsController::class, 'destroyPenyewa'])->name('admin.deletePenyewa');
    Route::post('/admin/dashboard/dataPenyewa/bulk-delete', [AdminsController::class, 'bulkDestroyPenyewa'])->name('admin.bulkDeletePenyewa');

    Route::get('/admin/dashboard/kontrolJadwal', function (){
        return view('admin.dashboard.kontrolJadwal');
    })->name('dashboardkontrolJadwal');

    Route::get('/admin/dashboard/jadwalBooking', [BookingController::class, 'indexAdmin'])->name('dashboardjadwalBooking');
    Route::post('/admin/bookings/{id}/approve', [BookingController::class, 'approve'])->name('admin.bookings.approve');
    Route::post('/admin/bookings/{id}/reject', [BookingController::class, 'reject'])->name('admin.bookings.reject');
    Route::get('/admin/bookings/{id}/receipt', [BookingController::class, 'downloadReceipt'])->name('admin.bookings.receipt');

    Route::get('/admin/dashboard/historyBooking', function () {
        return view('admin.dashboard.historyBooking');
    })->name('dashboardhistoryBooking');

    Route::get('/admin/dashboard/search/searchBar', function () {
        return view('admin.dashboard.search.searchBar');
    })->name('dashboardSearchBar');

    Route::get('/admin/dashboard/detail/detailBooking', function () {
        return view('admin.dashboard.detail.detailBooking');
    })->name('dashboarddetailBooking');

    Route::get('/admin/dashboard/detail/detailPenyewa', [AdminsController::class, 'detailPenyewa'])->name('dashboarddetailPenyewa');

    Route::get('/admin/dashboard/stats', [AdminsController::class, 'index'])->name('admin.stats');

    // Route edit/update/create perlu can_edit (readonly check)
    Route::middleware(['admin.access:can_edit'])->group(function () {
        Route::get('/admin/dashboard/create/createFasilitas', function () {
            return view('admin.dashboard.create.createFasilitas');
        })->name('dashboardcreateFasilitas');
        
        Route::post('/admin/fasilitas/store', [FasilitasController::class, 'store'])->name('fasilitas.store');
        Route::get('/admin/dashboard/edit/{id}', [FasilitasController::class, 'edit'])->name('fasilitas.edit');
        Route::put('/admin/dashboard/update/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');
        Route::put('/admin/fasilitas/paket-harian/{id}', [FasilitasController::class, 'updatePaketHarian'])->name('fasilitas.updatePaketHarian');
        Route::delete('/admin/fasilitas/delete/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
        Route::put('/admin/update/{id_log}', [AdminsController::class, 'update'])->name('admin.update');
    });

    Route::get('/admin/manage/{id_log}', [AdminsController::class, 'manage'])->name('admin.manage');
});
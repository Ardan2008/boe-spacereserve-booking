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
    return view('home');
})->name('home');

Route::get('/formBooking', function () {
    return view('formBooking');
})->name('formBooking');

Route::get('/schedule_booking', function () {
    return view('schedule_booking');
})->name('schedule_booking');

// Bagian Admin
Route::get('/admin/formLogin', function () {
    return view('admin.formLogin');
})->name('formLogin');

Route::get('/admin/dashboard/master', function (){
    return view('admin.dashboard.master');
})->name('dashboardMaster');

// Sidebar
Route::get('/admin/dashboard/layouts/sidebar', function () {
    return view('admin.dashboard.layouts.sidebar');
})->name('dashboardSidebar');

Route::get('/admin/dashboard/dataFasilitas', [FasilitasController::class, 'index'])->name('fasilitas.index');

Route::get('/admin/dashboard/dataHargaSewa', function (){
    return view('admin.dashboard.dataHargaSewa');
})->name('dashboardHargaSewa');

Route::get('/admin/dashboard/dataPenyewa', function (){
    return view('admin.dashboard.dataPenyewa');
})->name('dashboardPenyewa');

Route::get('/admin/dashboard/kontrolJadwal', function (){
    return view('admin.dashboard.kontrolJadwal');
})->name('dashboardkontrolJadwal');

Route::get('/admin/dashboard/jadwalBooking', function () {
    return view('admin.dashboard.jadwalBooking');
})->name('dashboardjadwalBooking');

Route::get('/admin/dashboard/historyBooking', function () {
    return view('admin.dashboard.historyBooking');
})->name('dashboardhistoryBooking');

// Search
Route::get('/admin/dashboard/search/searchBar', function () {
    return view('admin.dashboard.search.searchBar');
})->name('dashboardSearchBar');

// Detail Booking
Route::get('/admin/dashboard/detail/detailBooking', function () {
    return view('admin.dashboard.detail.detailBooking');
})->name('dashboarddetailBooking');

Route::get('/admin/dashboard/detail/detailPenyewa', function () {
    return view('admin.dashboard.detail.detailPenyewa');
})->name('dashboarddetailPenyewa');

// Edit
// Route::get('/admin/dashboard/edit/editFasilitas', function () {
//     return view('admin.dashboard.edit.editFasilitas');
// })->name('dashboardeditFasilitas');

// Create
Route::get('/admin/dashboard/create/createFasilitas', function () {
    return view('admin.dashboard.create.createFasilitas');
})->name('dashboardcreateFasilitas');

// Management
Route::get('/admin/dashboard/management/add_new_admin', function () {
    return view('admin.dashboard.management.add_new_admin');
})->name('dashboardAddNewAdmin');



Route::get('/admin/dashboard/management/view_admin', function () {
    return view('admin.dashboard.management.view_admin');
})->name('dashboardViewAdmin');

Route::post('/admin/store', [AdminsController::class, 'store'])->name('admin.store');


// --- TAMBAHKAN ROUTE LOGIKA CONTROLLER DI BAWAH INI ---

// Auth Admin
Route::post('/admin/login', [AdminsController::class, 'login'])->name('admin.login');
Route::get('/admin/logout', [AdminsController::class, 'logout'])->name('admin.logout');

// Dashboard Data (Index Logic)
Route::get('/admin/dashboard/stats', [AdminsController::class, 'index'])->name('admin.stats');

Route::put('/admin/update/{id_log}', [AdminsController::class, 'update'])->name('admin.update');

// Pastikan parameter {id} sesuai dengan yang dikirim dari halaman daftar admin
Route::get('/admin/manage/{id_log}', [AdminsController::class, 'manage'])->name('admin.manage');

// Management Admin Logic
Route::get('/admin/view/{id_log}', [AdminsController::class, 'view'])->name('admin.view');
Route::get('/admin/dashboard/management/active-list', [AdminsController::class, 'adminActiveControl'])->name('admin.active.list');
Route::get('/admin/dashboard/management/view/{id}', [AdminsController::class, 'view'])->name('admin.view.detail');

Route::get('/admin/dashboard/management/admin_active_control', [AdminsController::class, 'adminActiveControl'])->name('admin.active.control');

// Tambahkan route ini agar form bisa mengirim data ke function store
Route::post('/admin/fasilitas/store', [FasilitasController::class, 'store'])->name('fasilitas.store');

Route::get('/', [HomeController::class, 'index'])->name('home');

    // 1. Route untuk MENAMPILKAN halaman (pake GET)
Route::get('/admin/dashboard/edit/{id}', [FasilitasController::class, 'edit'])->name('fasilitas.edit');

// 2. Route untuk PROSES UPDATE ke database (pake PUT)
Route::put('/admin/dashboard/update/{id}', [FasilitasController::class, 'update'])->name('fasilitas.update');

// delete
Route::delete('/admin/fasilitas/delete/{id}', [FasilitasController::class, 'destroy'])->name('fasilitas.destroy');
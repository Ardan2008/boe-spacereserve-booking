<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/admin/dashboard/dataFasilitas', function (){
    return view('admin.dashboard.dataFasilitas');
})->name('dashboardFasilitas');

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
Route::get('/admin/dashboard/edit/editFasilitas', function () {
    return view('admin.dashboard.edit.editFasilitas');
})->name('dashboardeditFasilitas');

// Create
Route::get('/admin/dashboard/create/createFasilitas', function () {
    return view('admin.dashboard.create.createFasilitas');
})->name('dashboardcreateFasilitas');

// Management
Route::get('/admin/dashboard/management/add_new_admin', function () {
    return view('admin.dashboard.management.add_new_admin');
})->name('dashboardAddNewAdmin');

Route::get('/admin/dashboard/management/admin_active_control', function () {
    return view('admin.dashboard.management.admin_active_control');
})->name('dashboardAdminActiveControl');

Route::get('/admin/dashboard/management/manage_admin_control', function () {
    return view('admin.dashboard.management.manage_admin_control');
})->name('dashboardManageAdminControl');

Route::get('/admin/dashboard/management/view_admin', function () {
    return view('admin.dashboard.management.view_admin');
})->name('dashboardViewAdmin');
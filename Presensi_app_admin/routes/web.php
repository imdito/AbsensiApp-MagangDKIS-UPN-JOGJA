<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\presensiManagement\LaporanController;
use App\Http\Controllers\presensiManagement\QRController;
use App\Http\Controllers\presensiManagement\StatistikController;
use App\Http\Controllers\userManagement\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

});

Route::middleware(['auth:sanctum', 'is_superAdmin'])->group(function () {
    Route::get('/Super-Admin', [StatistikController::class, 'superAdmin'])->name('dashboard.super_admin');
    Route::resource('skpd', App\Http\Controllers\SkpdController::class);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/', [StatistikController::class, 'index'])->name('home');
});

Route::middleware(['auth:sanctum', 'is_admin_or_superAdmin'])->group(function () {

    //Bidang Management
    Route::get('/bidang/log', [LogsController::class, 'bidang'])->name('logs.bidang');
    Route::resource('bidang', BidangController::class);
    Route::get('/bidang/{id}/detail', [StatistikController::class, 'statistik'])->name('bidang.statistik');

    //user Management
    Route::get('/tambah-user', [UserController::class, 'index']);
    Route::post('tambah-user', [UserController::class, 'store']);
    Route::get('/karyawan', [UserController::class, 'listUsers']);
    Route::get('/karyawan/edit/{id}', [UserController::class, 'editPage']);
    Route::put('/karyawan/update/{id}', [UserController::class, 'update']);
    Route::delete('/karyawan/delete/{id}', [UserController::class, 'destroy']);
    Route::get('/karyawan/log', [LogsController::class, 'pegawai'])->name('logs.pegawai');


    //Presensi
    Route::get('/presensi', [PresensiController::class, 'create'])->name('presensi');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/edit/{id}', [PresensiController::class, 'edit'])->name('presensi.edit');
    Route::put('/presensi/update/{id}', [PresensiController::class, 'update'])->name('presensi.update');
    Route::get('/presensi/log', [LogsController::class, 'presensi'])->name('logs.presensi');
    //Presensi QR Code
    Route::get('/presensi/QR', [QRController::class, 'index'])->name('presensi.QR');
    Route::post('/presensi/generateQR', [QRController::class, 'generateQR'])->name('presensi.generateQR');

    //Laporan Presensi
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'print'])->name('laporan.print');
});

Route::middleware(['auth:sanctum', 'is_frontliner'])->group(function () {
    Route::get('/frontliner', [QRController::class, 'lihatQR'])->name('frontliner.index');
});


// Route untuk halaman "Bukan Admin"
Route::get('/mobile-only', function () {
    return view('mobileOnly');
})->name('user.mobile-only')->middleware('auth');

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');


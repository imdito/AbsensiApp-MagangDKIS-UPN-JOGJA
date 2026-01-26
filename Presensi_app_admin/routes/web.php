<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\LogsController;
use App\Http\Controllers\presensiManagement\LaporanController;
use App\Http\Controllers\presensiManagement\QRController;
use App\Http\Controllers\presensiManagement\StatistikController;
use App\Http\Controllers\userManagement\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'authenticate'])->name('login.post');

});

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {

    Route::get('/', [StatistikController::class, 'index'])->name('home');

    //auth logout

    //Presensi
    Route::get('/presensi', [PresensiController::class, 'create'])->name('presensi');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/edit/{id}', [PresensiController::class, 'edit'])->name('presensi.edit');
    Route::put('/presensi/update/{id}', [PresensiController::class, 'update'])->name('presensi.update');
    Route::get('/presensi/generateQR/', [QRController::class, 'generateQR'])->name('presensi.generateQR');
    Route::get('/presensi/log', [LogsController::class, 'presensi'])->name('logs.presensi');

    //User Management
    Route::get('/tambah-user', [UserController::class, 'index']);
    Route::post('tambah-user', [UserController::class, 'store']);
    Route::get('/karyawan', [UserController::class, 'listUsers']);
    Route::get('/karyawan/edit/{id}', [UserController::class, 'editPage']);
    Route::put('/karyawan/update/{id}', [UserController::class, 'update']);
    Route::delete('/karyawan/delete/{id}', [UserController::class, 'destroy']);
    Route::get('/karyawan/log', [LogsController::class, 'pegawai'])->name('logs.pegawai');


    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'print'])->name('laporan.print');


    //Bidang Management
    Route::get('/bidang/log', [LogsController::class, 'bidang'])->name('logs.bidang');
    Route::resource('bidang', BidangController::class);
    Route::get('/bidang/{id}/detail', [StatistikController::class, 'statistik'])->name('bidang.statistik');

    Route::get('/presensi/lihatQR', [QRController::class, 'lihatQR'])->name('presensi.lihatQR');

});

// Route untuk halaman "Bukan Admin"
Route::get('/mobile-only', function () {
    return view('mobileOnly');
})->name('user.mobile-only')->middleware('auth');

Route::post('/logout', [loginController::class, 'logout'])->name('logout')->middleware('auth');


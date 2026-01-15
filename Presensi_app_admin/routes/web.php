<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\BidangController;
use App\Http\Controllers\presensiManagement\LaporanController;
use App\Http\Controllers\presensiManagement\QRController;
use App\Http\Controllers\userManagement\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'authenticate'])->name('login.post');

});

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {

    Route::get('/', [PresensiController::class, 'index'])->name('home');

    //auth logout

    //Presensi
    Route::get('/presensi', [PresensiController::class, 'create'])->name('presensi');
    Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');
    Route::get('/presensi/edit/{id}', [PresensiController::class, 'edit'])->name('presensi.edit');
    Route::put('/presensi/update/{id}', [PresensiController::class, 'update'])->name('presensi.update');
    Route::delete('/presensi/delete/{id}', [PresensiController::class, 'destroy'])->name('presensi.delete');
    Route::get('/presensi/generateQR/{Tipe_QR}', [QRController::class, 'generateQR'])->name('presensi.generateQR');

    //User Management
    Route::get('/tambah-user', [UserController::class, 'index']);
    Route::post('tambah-user', [UserController::class, 'store']);
    Route::get('/karyawan', [UserController::class, 'listUsers']);
    Route::get('/karyawan/edit/{id}', [UserController::class, 'editPage']);
    Route::put('/karyawan/update/{id}', [UserController::class, 'update']);
    Route::delete('/karyawan/delete/{id}', [UserController::class, 'destroy']);

    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::post('/laporan/cetak', [LaporanController::class, 'print'])->name('laporan.print');


    //Bidang Management
    Route::resource('bidang', BidangController::class);

});

// Route untuk halaman "Bukan Admin"
Route::get('/mobile-only', function () {
    return view('mobileOnly');
})->name('user.mobile-only')->middleware('auth');

Route::post('/logout', [loginController::class, 'logout'])->name('logout')->middleware('auth');

<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\presensiManagement\QRController;
use App\Http\Controllers\userManagement\UserController;
use App\Models\presensi;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;


Route::middleware('guest')->group(function () {
    Route::get('/login', [loginController::class, 'index'])->name('login');
    Route::post('/login', [loginController::class, 'authenticate'])->name('login.post');

});

Route::middleware(['auth', 'is_admin'])->group(function () {

    Route::get('/', [PresensiController::class, 'index'])->name('home');

    //auth logout
    Route::post('/logout', [loginController::class, 'logout'])->name('logout');

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

});

Route::get('/cek-jam', function () {
    $now = \Carbon\Carbon::now();

    return [
        'jam_server_asli' => $now->format('Y-m-d H:i:s'), // Ini pasti WIB
        'timezone_aktif'  => date_default_timezone_get(), // Harus Asia/Jakarta
        'jam_utc_json'    => $now, // Ini pasti balik ke UTC (Z)
    ];
});


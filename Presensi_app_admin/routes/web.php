<?php

use App\Http\Controllers\auth\loginController;
use App\Models\presensi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;

Route::get('/', [PresensiController::class, 'index'])->name('home')->middleware('auth');
Route::get('/presensi', [PresensiController::class, 'create'])->name('presensi');

Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');

Route::get('/presensi/edit/{id}', [PresensiController::class, 'edit'])->name('presensi.edit');

Route::put('/presensi/update/{id}', [PresensiController::class, 'update'])->name('presensi.update');

Route::delete('/presensi/delete/{id}', [PresensiController::class, 'destroy'])->name('presensi.delete');

Route::get('/presensi/buatQR', function () {
    return view('app.buatQR', ['namaKelas'=> 'tes kelas', 'tanggal' => date('Y-m-d'), 'qrData' => 'tes data qr']);
})->name('buatQR')->middleware('auth');

Route::get('/login', function () {
    return view('auth.login', [loginController::class, 'index']);
})->name('login')->middleware('guest');

Route::post('/login', [loginController::class, 'authenticate'])->name('login.post')->middleware('guest');

Route::post('/logout', [loginController::class, 'logout'])->name('logout')->middleware('auth');

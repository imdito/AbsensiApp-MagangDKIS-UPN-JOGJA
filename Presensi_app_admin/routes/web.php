<?php

use App\Models\presensi;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresensiController;

Route::get('/', [PresensiController::class, 'index'])->name('home');
Route::get('/presensi', [PresensiController::class, 'create'])->name('presensi');

Route::get('/belajar', function () {
    return view('belajar');
});

Route::get('/route', function () {
    return view('route', ['nama'=> 'ditok']);
});

Route::post('/kirim', function () {
    return view('welcome');
});
Route::get('/cek-php', function () {
    return php_ini_loaded_file();
});

Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensi.store');

Route::get('/presensi/edit/{id}', [PresensiController::class, 'edit'])->name('presensi.edit');

Route::put('/presensi/update/{id}', [PresensiController::class, 'update'])->name('presensi.update');

Route::delete('/presensi/delete/{id}', [PresensiController::class, 'destroy'])->name('presensi.delete');

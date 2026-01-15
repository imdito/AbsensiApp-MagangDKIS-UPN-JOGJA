<?php

use App\Http\Controllers\auth\loginController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\userManagement\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::post('/login', [loginController::class, 'loginAPI'])->middleware('guest');

Route::post('/presensiViaQR', [presensiController::class, 'storeViaQR'])->middleware('auth:sanctum');

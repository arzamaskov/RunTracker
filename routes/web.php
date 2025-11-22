<?php

use App\Http\Controllers\Identity\AuthController;
use App\Http\Controllers\Identity\RegisterUserController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('health-check', function () {
    return new JsonResponse(
        ['status' => 'OK']
    );
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'authenticate'])->name('login.store');
    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [RegisterUserController::class, '__invoke'])->name('register.store');
});

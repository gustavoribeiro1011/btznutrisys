<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Middleware\GuestCustom;
use Illuminate\Support\Facades\Route;

Route::middleware([GuestCustom::class])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'authenticate'])->name('auth.authenticate');
    Route::get('/register', [AuthController::class, 'register'])->name('auth.register');
    Route::post('/register', [AuthController::class, 'store'])->name('auth.register');
});

// Sair do sistema
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');


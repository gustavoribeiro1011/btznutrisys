<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Volt;

Route::get('/', function () {
    if (Auth::check()) {
        // Se o usuário estiver logado, redireciona para o dashboard
        return redirect()->route('dashboard');
    }
    // Caso contrário, redireciona para a página de login
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})
    // ->middleware(['auth', 'verified'])
    ->name('dashboard');


require __DIR__ . '/auth.php';

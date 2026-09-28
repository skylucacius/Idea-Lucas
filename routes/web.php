<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'welcome')->name('home');
// Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});


Route::middleware('guest')->group(function () {
    // Registra a rota /register apontando para o componente Volt
    Volt::route('register', 'auth.register')
        ->name('register');
});

require __DIR__.'/settings.php';

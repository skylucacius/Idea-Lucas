<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
    });


Route::middleware('guest')->group(function () {
    Volt::route('registrar', 'auth.register')->name('register');
    Volt::route('/', 'welcome')->name('home');
    // Route::view('/', 'welcome')->name('home');
    });

require __DIR__.'/settings.php';

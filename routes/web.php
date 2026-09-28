<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Volt::route('/', 'welcome');
// Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';

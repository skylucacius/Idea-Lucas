<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;


Route::middleware(['auth', 'verified'])->group(function () {
    Volt::route('/ideas', 'dashboard')->name('dashboard');
    Volt::route('/ideas/{id}', 'idea.show')->name('ideas.show');
    Volt::route('/profile/edit', 'settings.profile')->name('profile.edit');
    });


Route::middleware('guest')->group(function () {
    Volt::route('registrar', 'auth.register')->name('register');
    Volt::route('/', 'welcome')->name('home');
    });



require __DIR__.'/settings.php';

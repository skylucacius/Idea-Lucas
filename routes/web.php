<?php
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;
use App\Http\Controllers\IdeaController;

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::put('/ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update');
    Route::delete('/ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy');
    Volt::route('/ideas', 'dashboard')->name('dashboard');
    Volt::route('/ideas/{id}', 'idea.show')->name('ideas.show');
    Volt::route('/profile/edit', 'settings.profile')->name('profile.edit');
    });


Route::middleware('guest')->group(function () {
    Volt::route('registrar', 'auth.register')->name('register');
    Volt::route('/', 'welcome')->name('home');
    });



require __DIR__.'/settings.php';

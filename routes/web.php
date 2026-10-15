<?php

use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\GroupeEtudiantController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Welcome')->name('home');

Route::middleware(['auth'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
    Route::get('etudiant', [EtudiantController::class, 'index'])->name('etudiant.list');
    Route::post('etudiant', [EtudiantController::class, 'store'])->name('etudiant.store');
    Route::post('creation-groupe', [GroupeEtudiantController::class, 'store']);
});

require __DIR__ . '/settings.php';

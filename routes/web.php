<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EquipoController;
use App\Http\Controllers\PrestamoController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // CRUD de Equipos
    Route::resource('equipos', EquipoController::class);

    // Módulo de Préstamos
    Route::resource('prestamos', PrestamoController::class)->except(['edit', 'update', 'show']);
    Route::patch('/prestamos/{id}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
});

require __DIR__.'/auth.php';

use App\Http\Controllers\UserController;

Route::middleware(['auth'])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
});
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;

Route::get('/', function () {
    return redirect('/login');
});

// Instalador
Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'store'])->name('install.store');

// Login, Logout, Password Reset (Breeze)
require __DIR__.'/auth.php';

// ✅ Panel Administrativo con prefijo /admin
Route::middleware(['auth'])->prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});

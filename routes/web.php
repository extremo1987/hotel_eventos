<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

/*
|--------------------------------------------------------------------------
| 🚪 LOGIN ADMIN (solo para invitados)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {

    // Mostrar formulario de login
    Route::get('/admin/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    // Procesar inicio de sesión
    Route::post('/admin/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store');
});

/*
|--------------------------------------------------------------------------
| 🏠 REDIRECCIÓN INICIAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect('/admin/login');
});

/*
|--------------------------------------------------------------------------
| 🛠 INSTALADOR
|--------------------------------------------------------------------------
*/
Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'store'])->name('install.store');

/*
|--------------------------------------------------------------------------
| 🚪 CERRAR SESIÓN (solo usuarios autenticados)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->post('/admin/logout', 
    [AuthenticatedSessionController::class, 'destroy']
)->name('logout');

/*
|--------------------------------------------------------------------------
| 🧭 RUTAS DEL PANEL ADMIN (protegidas)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->prefix('admin')->group(function () {
    require __DIR__.'/admin.php';
});

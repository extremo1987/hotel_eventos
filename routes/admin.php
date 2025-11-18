<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    DashboardController,
    ClientController,
    SalonController,
    ReservationController,
    QuoteController,
    InvoiceController,
    InventoryController,
    PackageController,
    PromotionController,
    StaffController,
    ExpenseController,
    ReportController,
    SettingController
};

// ================================
// 🟦 DASHBOARD ADMIN
// ================================
Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

// ================================
// 🟦 MÓDULOS CRUD PRINCIPALES
// ================================
Route::resource('clientes', ClientController::class);
Route::resource('salones', SalonController::class);
Route::resource('reservas', ReservationController::class);
Route::resource('cotizaciones', QuoteController::class);
Route::resource('facturas', InvoiceController::class);
Route::resource('inventario', InventoryController::class);
Route::resource('paquetes', PackageController::class);
Route::resource('promociones', PromotionController::class);
Route::resource('personal', StaffController::class);
Route::resource('gastos', ExpenseController::class);

// ❌ ESTA LÍNEA NO VA
// Route::resource('configuracion', ExpenseController::class);

// ================================
// 🟩 FACTURAS — ACCIONES ESPECIALES
// ================================

// Crear factura desde reserva
Route::get('reservas/{id}/generar-factura', 
    [InvoiceController::class, 'createFromReservation']
)->name('facturas.from-reservation');

// Marcar factura como pagada
Route::post('facturas/{id}/pagar', 
    [InvoiceController::class, 'markPaid']
)->name('facturas.pagar');

// Descargar / Ver PDF
Route::get('facturas/{id}/pdf', 
    [InvoiceController::class, 'pdf']
)->name('facturas.pdf');

// ================================
// 🟦 REPORTES
// ================================
Route::get('reportes', [ReportController::class, 'index'])->name('reportes.index');
Route::resource('paquetes', PackageController::class);
// ================================
// 🛠 CONFIGURACIÓN DEL SISTEMA
// ================================
Route::get('configuracion', [SettingController::class, 'index'])->name('config.index');
Route::post('configuracion', [SettingController::class, 'update'])->name('config.update');

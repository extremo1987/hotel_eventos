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
Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

// ================================
// 🟦 CRUD PRINCIPALES
// ================================
Route::resource('clientes', ClientController::class);
Route::resource('salones', SalonController::class);
Route::resource('reservas', ReservationController::class);
Route::resource('cotizaciones', QuoteController::class);
Route::resource('facturas', InvoiceController::class);
Route::resource('paquetes', PackageController::class);
Route::resource('promociones', PromotionController::class);
Route::resource('personal', StaffController::class);
Route::resource('gastos', ExpenseController::class);

// ================================
// 🟦 INVENTARIO (FULL ERP)
// ================================
Route::get('inventario/export-csv', [InventoryController::class, 'exportCsv'])
    ->name('admin.inventario.export');

Route::get('inventario/{inventory}/movimientos', 
    [InventoryController::class, 'movements'])
    ->name('admin.inventario.movements');

Route::post('inventario/movimiento', 
    [InventoryController::class, 'addMovement'])
    ->name('admin.inventario.add-movement');

Route::resource('inventario', InventoryController::class, [
    'names' => 'admin.inventario'
]);

// ================================
// 🟩 FACTURAS · ACCIONES ESPECIALES
// ================================
Route::get('reservas/{id}/generar-factura',
    [InvoiceController::class, 'createFromReservation'])
    ->name('facturas.from-reservation');

Route::post('facturas/{id}/pagar',
    [InvoiceController::class, 'markPaid'])
    ->name('facturas.pagar');

Route::get('facturas/{id}/pdf',
    [InvoiceController::class, 'pdf'])
    ->name('facturas.pdf');

// ================================
// 🟦 REPORTES
// ================================
Route::get('reportes', [ReportController::class, 'index'])
    ->name('reportes.index');

// ================================
// 🛠 CONFIGURACIÓN
// ================================
Route::get('configuracion', [SettingController::class, 'index'])
    ->name('config.index');

Route::post('configuracion', [SettingController::class, 'update'])
    ->name('config.update');

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            // Relación (opcional) con reserva
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();

            // Cliente (requerido)
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();

            // Número de factura (manual, único)
            $table->string('invoice_number', 50)->unique();

            // Fecha de emisión
            $table->date('issued_at');

            // Totales (se calculan en el controlador a partir de los ítems)
            $table->decimal('subtotal', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->decimal('tax_15', 12, 2)->default(0);
            $table->decimal('tax_18', 12, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Estado
            $table->enum('status', ['emitida', 'anulada'])->default('emitida');

            // Notas
            $table->text('notes')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

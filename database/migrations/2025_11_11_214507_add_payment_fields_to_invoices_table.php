<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('invoices', function (Blueprint $table) {

            // Agregar nuevo estado
            $table->enum('status', ['emitida', 'pagada', 'anulada'])
                  ->default('emitida')
                  ->change();

            // Fecha en que se paga
            $table->timestamp('paid_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->enum('status', ['emitida', 'anulada'])
                  ->default('emitida')
                  ->change();

            $table->dropColumn('paid_at');
        });
    }
};

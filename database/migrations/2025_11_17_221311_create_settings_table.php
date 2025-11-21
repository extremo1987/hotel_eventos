<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();

            // Datos de empresa
            $table->string('company_name')->nullable();
            $table->string('company_rtn')->nullable();
            $table->string('company_phone')->nullable();
            $table->string('company_email')->nullable();
            $table->string('company_address')->nullable();

            // Logo
            $table->string('company_logo')->nullable();

            // Facturación
            $table->string('invoice_prefix')->default('FAC-');
            $table->integer('invoice_start_number')->default(1);

            // Impuestos configurables
            $table->boolean('tax_15_enabled')->default(true);
            $table->boolean('tax_18_enabled')->default(true);
            $table->decimal('extra_tax', 10, 2)->default(0);

            // Descuento configurable
            $table->boolean('discount_enabled')->default(true);
            $table->enum('discount_type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('discount_value', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};

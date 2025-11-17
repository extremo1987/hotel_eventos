<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->decimal('payment_amount', 12, 2)->nullable();
        $table->string('payment_method')->nullable();
        $table->decimal('change_amount', 12, 2)->nullable();
    });
}

public function down()
{
    Schema::table('invoices', function (Blueprint $table) {
        $table->dropColumn(['payment_amount', 'payment_method', 'change_amount']);
    });
}

};

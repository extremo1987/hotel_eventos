<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('quotes', function(Blueprint $t){
    $t->id();
    $t->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
    $t->string('reference')->unique();
    $t->decimal('subtotal',12,2)->default(0);
    $t->decimal('discount',12,2)->default(0);
    $t->decimal('tax',12,2)->default(0);
    $t->decimal('total',12,2)->default(0);
    $t->enum('status',['borrador','enviada','aceptada','rechazada','vencida'])->default('borrador');
    $t->date('valid_until')->nullable();
    $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('quotes'); }
};
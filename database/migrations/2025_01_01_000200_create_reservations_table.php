<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('reservations', function(Blueprint $t){
    $t->id();
    $t->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
    $t->foreignId('salon_id')->constrained('salons')->cascadeOnDelete();
    $t->string('title');
    $t->dateTime('start_at');
    $t->dateTime('end_at');
    $t->enum('status',['pendiente','confirmada','cancelada'])->default('pendiente');
    $t->decimal('total',12,2)->default(0);
    $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('reservations'); }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('salons', function(Blueprint $t){
    $t->id();
    $t->string('name');
    $t->integer('capacity')->default(0);
    $t->string('location')->nullable();
    $t->decimal('rate',10,2)->default(0);
    $t->enum('status',['disponible','mantenimiento','ocupado'])->default('disponible');
    $t->text('notes')->nullable();
    $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('salons'); }
};
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('inventory_items', function(Blueprint $t){
    $t->id();
    $t->string('name');
    $t->string('category')->nullable();
    $t->json('attributes')->nullable();
    $t->integer('stock')->default(0);
    $t->decimal('unit_cost',10,2)->default(0);
    $t->timestamps();
  });
 }
 public function down(){ Schema::dropIfExists('inventory_items'); }
};
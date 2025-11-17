<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(){
  Schema::create('packages', function(Blueprint $t){
    $t->id();
    $t->string('name');
    $t->text('description')->nullable();
    $t->decimal('price',12,2)->default(0);
    $t->boolean('is_active')->default(true);
    $t->timestamps();
  });
  Schema::create('promotions', function(Blueprint $t){
    $t->id();
    $t->string('name');
    $t->enum('type',['percent','fixed'])->default('percent');
    $t->decimal('value',10,2)->default(0);
    $t->date('starts_at')->nullable();
    $t->date('ends_at')->nullable();
    $t->boolean('is_active')->default(false);
    $t->timestamps();
  });
  Schema::create('staff', function(Blueprint $t){
    $t->id();
    $t->string('name');
    $t->string('role');
    $t->string('phone')->nullable();
    $t->string('email')->nullable();
    $t->boolean('available')->default(true);
    $t->timestamps();
  });
  Schema::create('expenses', function(Blueprint $t){
    $t->id();
    $t->string('type');
    $t->string('description')->nullable();
    $t->decimal('amount',12,2)->default(0);
    $t->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
    $t->timestamps();
  });
  Schema::create('settings', function(Blueprint $t){
    $t->string('key')->primary();
    $t->text('value')->nullable();
  });
 }
 public function down(){
  Schema::dropIfExists('packages');
  Schema::dropIfExists('promotions');
  Schema::dropIfExists('staff');
  Schema::dropIfExists('expenses');
  Schema::dropIfExists('settings');
 }
};
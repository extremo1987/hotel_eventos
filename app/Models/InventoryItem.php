<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryItem extends Model {
  use HasFactory;
  protected $fillable = ['name','category','attributes','stock','unit_cost'];
  protected $casts = ['attributes'=>'array'];
}
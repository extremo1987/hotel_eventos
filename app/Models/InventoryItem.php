<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryItem extends Model
{
    use HasFactory;

    protected $table = 'inventory_items';

    protected $fillable = [
        'sku',
        'name',
        'category',
        'description',
        'quantity',
        'min_stock',
        'unit_price',
        'attributes',
        'is_active',
    ];

    protected $casts = [
        'attributes' => 'array',
        'is_active' => 'boolean',
    ];

    /* ===========================================
       RELACIONES
    ============================================*/

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class, 'inventory_item_id');
    }

    /* ===========================================
       MÉTODOS CUSTOM
    ============================================*/

    // Retorna TRUE si está bajo stock
    public function isLowStock(): bool
    {
        return $this->quantity <= $this->min_stock;
    }

    // Valor total del artículo = cantidad * precio unitario
    public function value(): float
    {
        return ($this->quantity ?? 0) * ($this->unit_price ?? 0);
    }
}

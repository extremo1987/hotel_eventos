<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryItem;

class InventorySeeder extends Seeder
{
    public function run()
    {
        InventoryItem::create([
            'sku'=>'SKU-001','name'=>'Mesa rectangular','category'=>'Mobiliario','quantity'=>10,'min_stock'=>2,'unit_price'=>250.00,'description'=>'Mesa para eventos','is_active'=>true
        ]);
        InventoryItem::create([
            'sku'=>'SKU-002','name'=>'Silla plegable','category'=>'Mobiliario','quantity'=>50,'min_stock'=>10,'unit_price'=>25.00,'description'=>'Silla de plástico','is_active'=>true
        ]);
    }
}

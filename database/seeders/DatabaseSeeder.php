<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\SettingsSeeder;
use Database\Seeders\InventorySeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingsSeeder::class,   // ← Este se usa
            InventorySeeder::class,  // ← Este también
        ]);
    }
}

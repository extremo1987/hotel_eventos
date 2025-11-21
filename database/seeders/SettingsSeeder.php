<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->updateOrInsert(
            ['id' => 1], // único registro

            [
                'company_name'        => 'Hotel & Eventos Demo',
                'company_rtn'         => '0000000000000',
                'company_phone'       => '9999-9999',
                'company_email'       => 'info@hotel.demo',
                'company_address'     => 'Ciudad, País',
                'company_logo'        => null,

                'invoice_prefix'      => 'FAC-',
                'invoice_start_number'=> 1,

                'tax_15_enabled'      => true,
                'tax_18_enabled'      => true,
                'extra_tax'           => 0,

                'discount_enabled'    => true,
                'discount_type'       => 'percentage',
                'discount_value'      => 0,

                'created_at'          => now(),
                'updated_at'          => now(),
            ]
        );
    }
}

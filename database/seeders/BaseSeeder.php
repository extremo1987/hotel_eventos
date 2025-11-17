<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BaseSeeder extends Seeder {
  public function run(){
    DB::table('settings')->updateOrInsert(['key'=>'company.name'],['value'=>'Hotel Demo']);
  }
}
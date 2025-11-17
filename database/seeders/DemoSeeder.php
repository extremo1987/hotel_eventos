<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DemoSeeder extends Seeder {
  public function run(){
    DB::table('clients')->insert([
      ['name'=>'Juan Pérez','email'=>'juan@example.com','phone'=>'+504 9999-0001','company'=>'Personal','notes'=>null,'created_at'=>now(),'updated_at'=>now()],
      ['name'=>'Eventos S.A.','email'=>'ventas@eventos.com','phone'=>'+504 9999-0002','company'=>'Eventos S.A.','notes'=>'Cliente frecuente','created_at'=>now(),'updated_at'=>now()],
    ]);
    DB::table('salons')->insert([
      ['name'=>'Gran Salón','capacity'=>300,'location'=>'Edificio Principal','rate'=>15000,'status'=>'disponible','created_at'=>now(),'updated_at'=>now()],
      ['name'=>'Salón Jardín','capacity'=>120,'location'=>'Área Verde','rate'=>8000,'status'=>'disponible','created_at'=>now(),'updated_at'=>now()],
    ]);
    DB::table('inventory_items')->insert([
      ['name'=>'Mesa redonda','category'=>'mobiliario','attributes'=>json_encode(['color'=>'blanco','diametro'=>'1.5m']),'stock'=>50,'unit_cost'=>700,'created_at'=>now(),'updated_at'=>now()],
      ['name'=>'Silla Tiffany','category'=>'mobiliario','attributes'=>json_encode(['color'=>'blanco']),'stock'=>200,'unit_cost'=>250,'created_at'=>now(),'updated_at'=>now()],
      ['name'=>'Equipo de sonido','category'=>'audio','attributes'=>json_encode(['potencia'=>'1000W']),'stock'=>4,'unit_cost'=>5000,'created_at'=>now(),'updated_at'=>now()],
    ]);
    DB::table('staff')->insert([
      ['name'=>'Carlos','role'=>'Mesero','phone'=>'+504 8888-0001','email'=>null,'available'=>true,'created_at'=>now(),'updated_at'=>now()],
      ['name'=>'María','role'=>'DJ','phone'=>'+504 8888-0002','email'=>null,'available'=>true,'created_at'=>now(),'updated_at'=>now()],
    ]);
    DB::table('promotions')->insert([
      ['name'=>'Navidad','type'=>'percent','value'=>10,'starts_at'=>'2025-12-01','ends_at'=>'2025-12-31','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
      ['name'=>'San Valentín','type'=>'fixed','value'=>1500,'starts_at'=>'2025-02-01','ends_at'=>'2025-02-15','is_active'=>true,'created_at'=>now(),'updated_at'=>now()],
    ]);
  }
}
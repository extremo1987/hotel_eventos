<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class InstallController extends Controller {
  public function index(){ return view('install.index'); }
  public function store(Request $r){
    $r->validate([
      'company' => 'required|string|max:150',
      'admin_email' => 'required|email',
      'password' => 'required|min:6'
    ]);
    // Run migrations & seeders
    Artisan::call('migrate', ['--force' => true]);
    if($r->boolean('demo')){
      Artisan::call('db:seed', ['--force' => true, '--class' => 'DemoSeeder']);
    } else {
      Artisan::call('db:seed', ['--force' => true, '--class' => 'BaseSeeder']);
    }
    // Create admin user
    User::updateOrCreate(['email'=>$r->admin_email],[
      'name' => 'Administrador',
      'password' => Hash::make($r->password),
      'email_verified_at' => now(),
    ]);
    // Basic app config
    DB::table('settings')->updateOrInsert(['key'=>'company.name'],['value'=>$r->company]);
    return redirect('/login')->with('status','Instalación completada. Inicie sesión.');
  }
}
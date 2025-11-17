<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller {
  public function index(){ return view('admin.staff.index'); }
  public function create(){ return view('admin.staff.create'); }
  public function store(Request $r){ /* TODO: validate & save */ return back()->with('ok','Creado'); }
  public function show($id){ return view('admin.staff.show'); }
  public function edit($id){ return view('admin.staff.edit'); }
  public function update(Request $r,$id){ return back()->with('ok','Actualizado'); }
  public function destroy($id){ return back()->with('ok','Eliminado'); }
}

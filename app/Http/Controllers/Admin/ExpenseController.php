<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpenseController extends Controller {
  public function index(){ return view('admin.expense.index'); }
  public function create(){ return view('admin.expense.create'); }
  public function store(Request $r){ /* TODO: validate & save */ return back()->with('ok','Creado'); }
  public function show($id){ return view('admin.expense.show'); }
  public function edit($id){ return view('admin.expense.edit'); }
  public function update(Request $r,$id){ return back()->with('ok','Actualizado'); }
  public function destroy($id){ return back()->with('ok','Eliminado'); }
}

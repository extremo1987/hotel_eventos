<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
    
        $clientes = \App\Models\Client::when($search, function ($query) use ($search) {
                $query->where('name', 'LIKE', "%$search%")
                      ->orWhere('phone', 'LIKE', "%$search%")
                      ->orWhere('email', 'LIKE', "%$search%");
            })
            ->orderBy('id', 'DESC')
            ->paginate(10) // ← PAGINACIÓN
            ->withQueryString(); // ← Mantiene la búsqueda al cambiar de página
    
        return view('admin.client.index', compact('clientes', 'search'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'phone'  => 'nullable',
            'email'  => 'nullable|email'
        ]);

        Client::create($request->only('name', 'phone', 'email'));

        return redirect()->route('clientes.index')->with('ok', 'Cliente creado correctamente');
    }

    public function show($id)
    {
        $cliente = Client::findOrFail($id);
        return view('admin.client.show', compact('cliente'));
    }

    public function edit($id)
    {
        $cliente = Client::findOrFail($id);
        return view('admin.client.edit', compact('cliente'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'   => 'required',
            'phone'  => 'nullable',
            'email'  => 'nullable|email'
        ]);

        Client::findOrFail($id)->update($request->only('name', 'phone', 'email'));

        return redirect()->route('clientes.index')->with('ok', 'Cliente actualizado correctamente');
    }

    public function destroy($id)
    {
        Client::findOrFail($id)->delete();

        return redirect()->route('clientes.index')->with('ok', 'Cliente eliminado correctamente');
    }
}

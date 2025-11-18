<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * LISTAR PAQUETES
     */
    public function index()
    {
        $paquetes = Package::orderBy('id', 'desc')->paginate(10);
        return view('admin.paquetes.index', compact('paquetes'));
    }

    /**
     * FORMULARIO CREAR
     */
    public function create()
    {
        return view('admin.paquetes.create');
    }

    /**
     * GUARDAR PAQUETE NUEVO
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'costo'       => 'nullable|numeric|min:0',
            'tipo_menu'   => 'nullable|string|max:255',
        ]);

        Package::create([
            'nombre'      => $request->nombre,
            'categoria'   => $request->categoria,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'costo'       => $request->costo,
            'tipo_menu'   => $request->tipo_menu,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('paquetes.index')
            ->with('ok', 'Paquete creado correctamente.');
    }

    /**
     * MOSTRAR UN PAQUETE (vista show)
     */
    public function show(Package $paquete)
    {
        return view('admin.paquetes.show', compact('paquete'));
    }

    /**
     * FORMULARIO EDITAR
     */
    public function edit(Package $paquete)
    {
        return view('admin.paquetes.edit', compact('paquete'));
    }

    /**
     * ACTUALIZAR PAQUETE
     */
    public function update(Request $request, Package $paquete)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
            'categoria'   => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'costo'       => 'nullable|numeric|min:0',
            'tipo_menu'   => 'nullable|string|max:255',
        ]);

        $paquete->update([
            'nombre'      => $request->nombre,
            'categoria'   => $request->categoria,
            'descripcion' => $request->descripcion,
            'precio'      => $request->precio,
            'costo'       => $request->costo,
            'tipo_menu'   => $request->tipo_menu,
            'is_active'   => $request->has('is_active'),
        ]);

        return redirect()->route('paquetes.index')
            ->with('ok', 'Paquete actualizado correctamente.');
    }

    /**
     * ELIMINAR PAQUETE
     */
    public function destroy(Package $paquete)
    {
        $paquete->delete();

        return redirect()->route('paquetes.index')
            ->with('ok', 'Paquete eliminado correctamente.');
    }
}

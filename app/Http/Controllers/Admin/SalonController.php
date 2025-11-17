<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Salon;

class SalonController extends Controller
{
    public function index()
    {
        // Usamos paginación en lugar de get() para mayor control
        $salones = Salon::orderBy('id', 'DESC')->paginate(10);

        return view('admin.salon.index', compact('salones'));
    }

    public function create()
    {
        return view('admin.salon.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'price'    => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'rate'     => 'nullable|string|max:255',
            'status'   => 'required|string|max:50',
            'notes'    => 'nullable|string',
        ]);

        Salon::create($validated);

        // Redirige al index con mensaje flash
        return redirect()
            ->route('salones.index')
            ->with('ok', '✅ Salón creado correctamente.');
    }

    public function show($id)
    {
        $salon = Salon::findOrFail($id);
        return view('admin.salon.show', compact('salon'));
    }

    public function edit($id)
    {
        $salon = Salon::findOrFail($id);
        return view('admin.salon.edit', compact('salon'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'price'    => 'nullable|numeric|min:0',
            'location' => 'nullable|string|max:255',
            'rate'     => 'nullable|string|max:255',
            'status'   => 'required|string|max:50',
            'notes'    => 'nullable|string',
        ]);

        $salon = Salon::findOrFail($id);
        $salon->update($validated);

        return redirect()
            ->route('salones.index')
            ->with('ok', '✅ Salón actualizado correctamente.');
    }

    public function destroy($id)
    {
        $salon = Salon::findOrFail($id);
        $salon->delete();

        return redirect()
            ->route('salones.index')
            ->with('ok', '🗑️ Salón eliminado correctamente.');
    }
}

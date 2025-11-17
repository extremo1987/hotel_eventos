<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;
use App\Models\Client;
use App\Models\Salon;

class QuoteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $cotizaciones = Quote::with(['client', 'salon'])
            ->when($search, function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                      ->orWhereHas('client', fn($q) => $q->where('name', 'like', "%$search%"))
                      ->orWhereHas('salon', fn($q) => $q->where('name', 'like', "%$search%"));
            })
            ->orderBy('id', 'DESC')
            ->paginate(10)
            ->withQueryString();

        return view('admin.cotizaciones.index', compact('cotizaciones', 'search'));
    }

    public function create()
    {
        $clientes = Client::orderBy('name')->get();
        $salones = Salon::orderBy('name')->get();
        return view('admin.cotizaciones.create', compact('clientes', 'salones'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'salon_id'   => 'nullable|exists:salons,id',
            'title'      => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'total'      => 'nullable|numeric',
            'status'     => 'required|string|max:50',
            'notes'      => 'nullable|string',
        ]);

        Quote::create($request->all());

        return redirect()->route('cotizaciones.index')->with('ok', 'Cotización creada correctamente');
    }

    public function show($id)
    {
        $cotizacion = Quote::with(['client', 'salon'])->findOrFail($id);
        return view('admin.cotizaciones.show', compact('cotizacion'));
    }

    public function edit($id)
    {
        $cotizacion = Quote::findOrFail($id);
        $clientes = Client::orderBy('name')->get();
        $salones = Salon::orderBy('name')->get();

        return view('admin.cotizaciones.edit', compact('cotizacion', 'clientes', 'salones'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'salon_id'   => 'nullable|exists:salons,id',
            'title'      => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'total'      => 'nullable|numeric',
            'status'     => 'required|string|max:50',
            'notes'      => 'nullable|string',
        ]);

        Quote::findOrFail($id)->update($request->all());

        return redirect()->route('cotizaciones.index')->with('ok', 'Cotización actualizada correctamente');
    }

    public function destroy($id)
    {
        Quote::findOrFail($id)->delete();
        return redirect()->route('cotizaciones.index')->with('ok', 'Cotización eliminada correctamente');
    }
}

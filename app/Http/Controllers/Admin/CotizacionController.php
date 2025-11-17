<?php

namespace App\Http\Controllers;

use App\Models\Quote;
use App\Models\Client;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
    public function create()
    {
        $clientes = Client::orderBy('name')->get();
        return view('cotizaciones.create', compact('clientes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id'   => 'required|exists:clients,id',
            'reference'   => 'required|string|max:50|unique:quotes,reference',
            'subtotal'    => 'required|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0',
            'tax'         => 'nullable|numeric|min:0',
            'total'       => 'required|numeric|min:0',
            'status'      => 'required|string',
            'valid_until' => 'required|date',
        ]);

        Quote::create($data);

        return redirect()->route('cotizaciones.index')
            ->with('ok', 'Cotización creada correctamente');
    }
}

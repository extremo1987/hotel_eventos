<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Client;
use App\Models\Salon;

class ReservationController extends Controller
{
    public function index()
    {
        $reservas = Reservation::with(['client','salon'])->orderBy('id','desc')->paginate(10);
        return view('admin.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $clientes = Client::orderBy('name')->get();
        $salones  = Salon::orderBy('name')->get();
        return view('admin.reservas.create', compact('clientes','salones'));
    }

    public function store(Request $r)
    {
        $validated = $r->validate([
            'client_id'  => 'required|exists:clients,id',
            'salon_id'   => 'required|exists:salons,id',
            'title'      => 'nullable|string|max:255',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date|after:start_at',
            'status'     => 'required|string|max:50',
            'total'      => 'nullable|numeric',
            'notes'      => 'nullable|string',
        ]);

        Reservation::create($validated);

        // ROUTE: usa el nombre exacto (ver php artisan route:list)
        return redirect()->route('reservas.index')->with('ok', 'Reserva creada correctamente');
    }

    public function show(Reservation $reserva)
    {
        return view('admin.reservas.show', compact('reserva'));
    }

    public function edit(Reservation $reserva)
    {
        $clientes = Client::orderBy('name')->get();
        $salones  = Salon::orderBy('name')->get();
        return view('admin.reservas.edit', compact('reserva','clientes','salones'));
    }

    public function update(Request $r, Reservation $reserva)
    {
        $validated = $r->validate([
            'client_id'  => 'required|exists:clients,id',
            'salon_id'   => 'required|exists:salons,id',
            'title'      => 'nullable|string|max:255',
            'start_at'   => 'required|date',
            'end_at'     => 'required|date|after:start_at',
            'status'     => 'required|string|max:50',
            'total'      => 'nullable|numeric',
            'notes'      => 'nullable|string',
        ]);

        $reserva->update($validated);

        return redirect()->route('reservas.index')->with('ok', 'Reserva actualizada correctamente');
    }

    public function destroy(Reservation $reserva)
    {
        $reserva->delete();
        return redirect()->route('reservas.index')->with('ok', 'Reserva eliminada correctamente');
    }
}

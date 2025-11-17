<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Reservation;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Mostrar listado de facturas
     */
    public function index()
    {
        $facturas = Invoice::with('client')->latest()->paginate(15);
        return view('admin.facturas.index', compact('facturas'));
    }

    /**
     * Crear FACTURA desde cero
     */
    public function create()
    {
        $clientes = Client::all();
        return view('admin.facturas.create', compact('clientes'));
    }

    /**
     * Crear factura ligada a una reserva
     */
    public function createFromReservation($id)
    {
        $reserva = Reservation::with(['client', 'salon'])->findOrFail($id);

        return view('admin.facturas.create-from-reservation', compact('reserva'));
    }

    /**
     * Guardar factura
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'invoice_number' => 'required|string|max:50|unique:invoices,invoice_number',
            'issued_at'      => 'required|date',
        ]);

        DB::beginTransaction();

        try {
            // Crear encabezado
            $factura = Invoice::create([
                'reservation_id' => $request->reservation_id,
                'client_id'      => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'issued_at'      => $request->issued_at,
                'subtotal'       => 0,
                'discount'       => $request->discount ?? 0,
                'tax_15'         => 0,
                'tax_18'         => 0,
                'total'          => 0,
                'notes'          => $request->notes,
            ]);

            // Calcular totales
            $subtotal = 0;
            $tax_15   = 0;
            $tax_18   = 0;

            foreach ($request->items as $item) {
                $line_total = $item['quantity'] * $item['unit_price'];

                // Impuestos
                switch ($item['tax_type']) {
                    case 'isv15': $tax_15 += $line_total * 0.15; break;
                    case 'isv18': $tax_18 += $line_total * 0.18; break;
                }

                $subtotal += $line_total;

                InvoiceItem::create([
                    'invoice_id'  => $factura->id,
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'tax_type'    => $item['tax_type'],
                    'line_total'  => $line_total,
                ]);
            }

            // Total final
            $total = $subtotal - ($request->discount ?? 0) + $tax_15 + $tax_18;

            // Actualizar encabezado
            $factura->update([
                'subtotal' => $subtotal,
                'tax_15'   => $tax_15,
                'tax_18'   => $tax_18,
                'total'    => $total,
            ]);

            DB::commit();

            return redirect()->route('facturas.show', $factura->id)
                ->with('ok', 'Factura creada correctamente');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }

    /**
     * Mostrar factura
     */
    public function show($id)
    {
        $factura = Invoice::with(['client', 'items', 'reservation'])->findOrFail($id);
        return view('admin.facturas.show', compact('factura'));
    }

    /**
     * Editar factura
     */
    public function edit($id)
    {
        $factura = Invoice::with('items')->findOrFail($id);
        $clientes = Client::all();

        return view('admin.facturas.edit', compact('factura', 'clientes'));
    }

    /**
     * Actualizar factura
     */
    public function update(Request $request, $id)
    {
        $factura = Invoice::findOrFail($id);
    
        $request->validate([
            'client_id'      => 'required|exists:clients,id',
            'invoice_number' => "required|max:50|unique:invoices,invoice_number,{$id}",
            'issued_at'      => 'required|date',
            'status'         => 'required|in:emitida,pagada,anulada',
        ]);
    
        DB::beginTransaction();
    
        try {
    
            // ACTUALIZAR ENCABEZADO
            $factura->update([
                'client_id'      => $request->client_id,
                'invoice_number' => $request->invoice_number,
                'issued_at'      => $request->issued_at,
                'discount'       => $request->discount ?? 0,
                'notes'          => $request->notes,
                'status'         => $request->status,  // <<<<<<<<<<<<<<<<<< IMPORTANTE
            ]);
    
            // BORRAR ÍTEMS ANTERIORES
            InvoiceItem::where('invoice_id', $id)->delete();
    
            // RECREAR ÍTEMS
            $subtotal = 0;
            $tax_15   = 0;
            $tax_18   = 0;
    
            foreach ($request->items as $item) {
    
                $line_total = $item['quantity'] * $item['unit_price'];
    
                switch ($item['tax_type']) {
                    case 'isv15': $tax_15 += $line_total * 0.15; break;
                    case 'isv18': $tax_18 += $line_total * 0.18; break;
                }
    
                $subtotal += $line_total;
    
                InvoiceItem::create([
                    'invoice_id'  => $id,
                    'description' => $item['description'],
                    'quantity'    => $item['quantity'],
                    'unit_price'  => $item['unit_price'],
                    'tax_type'    => $item['tax_type'],
                    'line_total'  => $line_total,
                ]);
            }
    
            // TOTAL
            $total = $subtotal - ($request->discount ?? 0) + $tax_15 + $tax_18;
    
            $factura->update([
                'subtotal' => $subtotal,
                'tax_15'   => $tax_15,
                'tax_18'   => $tax_18,
                'total'    => $total,
            ]);
    
            DB::commit();
    
            return redirect()->route('facturas.show', $factura->id)
                ->with('ok', 'Factura actualizada correctamente');
    
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error: '.$e->getMessage());
        }
    }
    

    /**
     * Eliminar factura
     */
    public function destroy($id)
    {
        Invoice::findOrFail($id)->delete();
        return redirect()->route('admin.facturas.index')->with('ok', 'Factura eliminada');
    }

    public function markPaid($id)
{
    $factura = Invoice::findOrFail($id);

    // Si ya está pagada no hacer nada
    if ($factura->status === 'pagada') {
        return back()->with('ok', 'La factura ya está pagada.');
    }

    $factura->update([
        'status' => 'pagada',
        'paid_at' => now(),
    ]);

    return back()->with('ok', 'Factura marcada como pagada correctamente.');
}

public function pdf($id)
{
    $factura = Invoice::with('client', 'items')->findOrFail($id);

    $pdf = Pdf::loadView('admin.facturas.pdf', compact('factura'))
              ->setPaper('letter', 'portrait');

    return $pdf->stream('factura-'.$factura->invoice_number.'.pdf');
}

}

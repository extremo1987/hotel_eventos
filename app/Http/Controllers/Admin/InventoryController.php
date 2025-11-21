<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\InventoryMovement;
use App\Http\Requests\InventoryItemRequest;
use App\Http\Requests\InventoryMovementRequest;
use DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryItem::query();

        if ($request->filled('q')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%'.$request->q.'%')
                  ->orWhere('sku', 'like', '%'.$request->q.'%');
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $items = $query->orderBy('name')->paginate(15);

        // Estadísticas
        $totalValue = InventoryItem::sum(DB::raw('unit_price * quantity'));
        $lowStockCount = InventoryItem::get()->filter->isLowStock()->count();
        $outOfStockCount = InventoryItem::where('quantity', 0)->count();

        return view('admin.inventario.index', compact(
            'items', 'totalValue', 'lowStockCount', 'outOfStockCount'
        ));
    }

    public function create()
    {
        return view('admin.inventario.create');
    }

    public function store(InventoryItemRequest $request)
    {
        $data = $request->validated();
        $item = InventoryItem::create($data);

        // Registrar movimiento inicial
        if (($data['quantity'] ?? 0) > 0) {
            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'type' => 'entrada',
                'quantity' => $data['quantity'],
                'balance_after' => $item->quantity,
                'unit_price' => $data['unit_price'] ?? 0,
                'total_price' => ($data['unit_price'] ?? 0) * $data['quantity'],
                'reason' => 'Creación inicial',
                'responsible' => auth()->user()->name ?? 'Sistema',
            ]);
        }

        return redirect()->route('admin.inventario.index')->with('success', 'Artículo creado.');
    }

    public function show(InventoryItem $inventory)
    {
        $movements = $inventory->movements()->orderByDesc('created_at')->get();

        return view('admin.inventario.show', [
            'item' => $inventory,
            'movements' => $movements
        ]);
    }

    public function edit(InventoryItem $inventory)
    {
        return view('admin.inventario.edit', compact('inventory'));
    }

    public function update(InventoryItemRequest $request, InventoryItem $inventory)
    {
        $data = $request->validated();
        $inventory->update($data);

        return redirect()->route('admin.inventario.index')
                         ->with('success', 'Artículo actualizado.');
    }

    public function destroy(InventoryItem $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin.inventario.index')
                         ->with('success', 'Artículo eliminado.');
    }

    // Kardex
    public function movements(InventoryItem $inventory)
    {
        $movements = $inventory->movements()->orderByDesc('created_at')->paginate(25);

        return view('admin.inventario.movements', compact('inventory', 'movements'));
    }

    public function addMovement(InventoryMovementRequest $request)
    {
        $data = $request->validated();

        return DB::transaction(function () use ($data) {
            $item = InventoryItem::findOrFail($data['inventory_item_id']);
            $prev = $item->quantity;
            $qty = (int) $data['quantity'];

            if ($data['type'] == 'entrada') {
                $item->quantity = $prev + $qty;
            } elseif ($data['type'] == 'salida') {
                $item->quantity = max(0, $prev - $qty);
            } else {
                // Ajuste directo
                $item->quantity = $qty;
            }

            $item->save();

            InventoryMovement::create([
                'inventory_item_id' => $item->id,
                'type' => $data['type'],
                'quantity' => $qty,
                'balance_after' => $item->quantity,
                'reason' => $data['reason'] ?? null,
                'responsible' => auth()->user()->name ?? 'Sistema',
                'unit_price' => $data['unit_price'] ?? $item->unit_price,
                'total_price' => ($data['unit_price'] ?? $item->unit_price) * $qty,
            ]);

            return true;
        });
    }

    public function exportCsv()
    {
        $items = InventoryItem::orderBy('name')->get();
        $csv = "sku,name,category,quantity,min_stock,unit_price,value\n";

        foreach ($items as $i) {
            $value = $i->quantity * $i->unit_price;
            $csv .= "\"{$i->sku}\",\"{$i->name}\",\"{$i->category}\",{$i->quantity},{$i->min_stock},{$i->unit_price},{$value}\n";
        }

        $fileName = 'inventory_export_'.date('Ymd_His').'.csv';

        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }
}

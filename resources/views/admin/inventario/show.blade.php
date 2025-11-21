@extends('layouts.app')
@section('title', $item->name)
@section('content')
<div class="grid md:grid-cols-3 gap-4">
    <div class="md:col-span-2 bg-white p-4 rounded shadow">
        <h2 class="text-xl font-bold">{{ $item->name }}</h2>
        <p class="text-sm text-gray-600">SKU: {{ $item->sku }} • Categoria: {{ $item->category }}</p>
        <p class="mt-4">{{ $item->description }}</p>
        <div class="mt-4">
            <strong>Stock: </strong> {{ $item->quantity }} (Min: {{ $item->min_stock }})
        </div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="font-semibold">Movimiento rápido</h3>
        <form action="{{ route('admin.inventario.add-movement') }}" method="POST">
            @csrf
            <input type="hidden" name="inventory_item_id" value="{{ $item->id }}">
            <div class="mt-2">
                <label>Tipo</label>
                <select name="type" class="border p-2 rounded w-full">
                    <option value="entrada">Entrada</option>
                    <option value="salida">Salida</option>
                    <option value="ajuste">Ajuste</option>
                </select>
            </div>
            <div class="mt-2">
                <label>Cantidad</label>
                <input type="number" name="quantity" value="1" class="border p-2 rounded w-full">
            </div>
            <div class="mt-2">
                <label>Precio unit.</label>
                <input name="unit_price" class="border p-2 rounded w-full">
            </div>
            <div class="mt-2">
                <label>Motivo</label>
                <input name="reason" class="border p-2 rounded w-full">
            </div>
            <div class="mt-4">
                <button class="btn-blue">Agregar</button>
            </div>
        </form>
    </div>
</div>

<div class="mt-6 bg-white p-4 rounded shadow">
    <h4 class="font-semibold">Kardex / Movimientos</h4>
    <table class="table-ui w-full mt-2">
        <thead><tr><th>Fecha</th><th>Tipo</th><th>Cantidad</th><th>Saldo</th><th>Responsable</th><th>Motivo</th></tr></thead>
        <tbody>
            @foreach($movements as $m)
            <tr>
                <td>{{ $m->created_at }}</td>
                <td>{{ ucfirst($m->type) }}</td>
                <td>{{ $m->quantity }}</td>
                <td>{{ $m->balance_after }}</td>
                <td>{{ $m->responsible }}</td>
                <td>{{ $m->reason }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

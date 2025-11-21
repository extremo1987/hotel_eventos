@extends('layouts.app')

@section('title', 'Editar Item')

@section('content')
<div class="bg-white p-6 shadow rounded-lg">

    <h2 class="text-xl font-semibold mb-4">Editar Item</h2>

    <form action="{{ route('inventario.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-2 gap-4">

            <div>
                <label>SKU</label>
                <input type="text" name="sku" value="{{ $item->sku }}" class="input" required>
            </div>

            <div>
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $item->name }}" class="input" required>
            </div>

            <div>
                <label>Categoría</label>
                <input type="text" name="category" value="{{ $item->category }}" class="input">
            </div>

            <div>
                <label>Stock</label>
                <input type="number" name="stock" value="{{ $item->stock }}" class="input" required>
            </div>

            <div>
                <label>Costo unitario</label>
                <input type="number" step="0.01" name="unit_cost" value="{{ $item->unit_cost }}" class="input" required>
            </div>

        </div>

        <button class="btn-blue mt-4">Actualizar</button>

    </form>
</div>
@endsection

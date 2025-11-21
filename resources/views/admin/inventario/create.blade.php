@extends('layouts.app')
@section('title','Crear artículo')
@section('content')
<div class="bg-white p-6 rounded shadow">
    <form action="{{ route('admin.inventario.store') }}" method="POST">
        @csrf
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <label>SKU</label>
                <input name="sku" value="{{ old('sku') }}" class="border p-2 rounded w-full">
            </div>
            <div>
                <label>Nombre</label>
                <input name="name" value="{{ old('name') }}" required class="border p-2 rounded w-full">
            </div>
            <div>
                <label>Categoría</label>
                <input name="category" value="{{ old('category') }}" class="border p-2 rounded w-full">
            </div>
            <div>
                <label>Cantidad</label>
                <input type="number" name="quantity" value="{{ old('quantity',0) }}" class="border p-2 rounded w-full">
            </div>
            <div>
                <label>Stock mínimo</label>
                <input type="number" name="min_stock" value="{{ old('min_stock',5) }}" class="border p-2 rounded w-full">
            </div>
            <div>
                <label>Precio unitario</label>
                <input name="unit_price" value="{{ old('unit_price',0) }}" class="border p-2 rounded w-full">
            </div>
            <div class="md:col-span-2">
                <label>Descripción</label>
                <textarea name="description" class="border p-2 rounded w-full">{{ old('description') }}</textarea>
            </div>
        </div>

        <div class="mt-4">
            <button class="btn-blue">Guardar</button>
            <a href="{{ route('admin.inventario.index') }}" class="btn-gray">Cancelar</a>
        </div>
    </form>
</div>
@endsection

@extends('layouts.app')

@section('title', 'Salones')

@section('content')

@if(session('ok'))
    <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 text-green-800 border border-green-200">
        {{ session('ok') }}
    </div>
@endif

{{-- Tabla dinámica (Livewire) --}}
<livewire:salon-table />

@endsection

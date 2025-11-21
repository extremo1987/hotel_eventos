@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

{{-- Tarjetas estadísticas --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <div class="bg-white p-5 rounded-xl shadow-soft border">
        <div class="text-gray-500 text-sm">Ingresos del mes</div>
        <div class="text-3xl font-bold mt-1">L {{ number_format($stats['ingresos_mes'] ?? 0, 2) }}</div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-soft border">
        <div class="text-gray-500 text-sm">Gastos del mes</div>
        <div class="text-3xl font-bold mt-1">L {{ number_format($stats['gastos_mes'] ?? 0, 2) }}</div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-soft border">
        <div class="text-gray-500 text-sm">Promociones activas</div>
        <div class="text-3xl font-bold mt-1">{{ $stats['promociones_activas']->count() }}</div>
    </div>

    <div class="bg-white p-5 rounded-xl shadow-soft border">
        <div class="text-gray-500 text-sm">Reservas futuras</div>
        <div class="text-3xl font-bold mt-1">{{ $stats['reservas_proximas']->count() }}</div>
    </div>

</div>

{{-- Gráfico moderno --}}
<div class="bg-white p-6 rounded-xl shadow-soft border">
    <h2 class="text-lg font-semibold mb-4">Ingresos últimos 6 meses</h2>
    <div id="chartIngresos" class="w-full h-64"></div>
</div>

<script type="module">
import ApexCharts from "apexcharts";

let options = {
    chart: {
        type: 'line',
        height: 300,
        toolbar: { show: false }
    },
    series: [{
        name: 'Ingresos',
        data: [1200, 1800, 1000, 3200, 2500, 4000]
    }],
    xaxis: {
        categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun']
    },
    stroke: {
        curve: 'smooth',
        width: 3
    },
    colors: ['#4f46e5'],
    markers: {
        size: 4
    }
};

let chart = new ApexCharts(document.querySelector("#chartIngresos"), options);
chart.render();
</script>

@endsection

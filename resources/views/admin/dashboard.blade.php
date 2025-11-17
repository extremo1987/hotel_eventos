@extends('layouts.app')
@section('content')
<div class="grid md:grid-cols-3 gap-4">
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Ingresos del mes</div>
    <div class="text-2xl font-bold">L {{ number_format($stats['ingresos_mes'] ?? 0,2) }}</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Gastos del mes</div>
    <div class="text-2xl font-bold">L {{ number_format($stats['gastos_mes'] ?? 0,2) }}</div>
  </div>
  <div class="p-4 bg-white rounded shadow">
    <div class="text-sm opacity-70">Promociones activas</div>
    <div class="text-2xl font-bold">{{ ($stats['promociones_activas'] ?? collect())->count() }}</div>
  </div>
</div>
<div class="mt-6 p-4 bg-white rounded shadow">
  <canvas id="chart1"></canvas>
</div>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    import('chart.js').then(({Chart}) => {
      const ctx = document.getElementById('chart1');
      new Chart(ctx, {
        type: 'bar',
        data: { labels: ['Ene','Feb','Mar','Abr','May','Jun'], datasets: [{ label:'Ingresos', data:[12,19,3,5,2,3] }] },
        options: { responsive: true }
      });
    });
  });
</script>
@endsection

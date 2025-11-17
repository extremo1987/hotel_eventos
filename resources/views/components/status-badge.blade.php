@props(['value'])

@php
    $styles = [
        'Disponible' => 'bg-emerald-200 text-emerald-800 dark:bg-emerald-700 dark:text-emerald-100',
        'Mantenimiento' => 'bg-amber-200 text-amber-800 dark:bg-amber-600 dark:text-amber-100',
        'Ocupado' => 'bg-rose-200 text-rose-800 dark:bg-rose-700 dark:text-rose-100',
    ];

    $style = $styles[$value] ?? 'bg-gray-200 text-gray-700 dark:bg-gray-700 dark:text-gray-200';
@endphp

<span class="px-2 py-1 rounded text-xs font-semibold {{ $style }}">
    {{ $value }}
</span>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 13px; }
        .header { width: 100%; margin-bottom: 20px; }
        .logo { float: left; }
        .company { float: right; text-align: right; }
        .clear { clear: both; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background: #2563eb; color:white; padding: 8px; }
        td { border:1px solid #ddd; padding:6px; }
        .totales { float: right; width: 45%; margin-top:20px; }
        .totales td { padding:5px; }
        .titulo { font-weight:bold; font-size:18px; margin-top:20px; }
    </style>
</head>
<body>


{{-- ===========================================
     ENCABEZADO (LOGO + EMPRESA)
=========================================== --}}
<div class="header">
    <div class="logo">
        @if(setting('company_logo'))
            <img src="{{ public_path(setting('company_logo')) }}" height="65">
        @endif
    </div>

    <div class="company">
        <strong>{{ setting('company_name') }}</strong><br>
        RTN: {{ setting('company_rtn') }} <br>
        {{ setting('company_address') }} <br>
        Tel: {{ setting('company_phone') }} <br>
        {{ setting('company_email') }}
    </div>

    <div class="clear"></div>
</div>



{{-- ===========================================
     ENCABEZADO DE FACTURA
=========================================== --}}
<h2>
    Factura: {{ setting('invoice_prefix') }}{{ $factura->invoice_number }}
</h2>

<p>
    <strong>Fecha:</strong> {{ $factura->issued_at }} <br>
    <strong>Cliente:</strong> {{ $factura->client->name }} <br>
    <strong>RTN Cliente:</strong> {{ $factura->client->rtn ?? 'N/A' }}
</p>



{{-- ===========================================
     TABLA DE ÍTEMS
=========================================== --}}
<table>
    <thead>
        <tr>
            <th>Descripción</th>
            <th>Cant.</th>
            <th>Precio</th>
            <th>Impuesto</th>
            <th>Total</th>
        </tr>
    </thead>

    <tbody>

        @php
            $totalExento = 0;
            $totalGravado15 = 0;
            $totalGravado18 = 0;
        @endphp

        @foreach($factura->items as $item)
            @php
                $line = $item->quantity * $item->unit_price;

                $isv = match($item->tax_type) {
                    'isv15' => $line * 0.15,
                    'isv18' => $line * 0.18,
                    default => 0
                };

                if ($item->tax_type === 'exento') { $totalExento += $line; }
                if ($item->tax_type === 'isv15') { $totalGravado15 += $line; }
                if ($item->tax_type === 'isv18') { $totalGravado18 += $line; }
            @endphp

            <tr>
                <td>{{ $item->description }}</td>
                <td>{{ number_format($item->quantity, 2) }}</td>
                <td>L. {{ number_format($item->unit_price, 2) }}</td>
                <td>{{ strtoupper($item->tax_type) }}</td>
                <td>L. {{ number_format($line + $isv, 2) }}</td>
            </tr>
        @endforeach

    </tbody>
</table>



{{-- ===========================================
     DESGLOSE FISCAL (SAR)
=========================================== --}}
<div class="titulo">Desglose Fiscal</div>

<table>
    <tr>
        <td>Total Exento:</td>
        <td>L. {{ number_format($totalExento, 2) }}</td>
    </tr>

    <tr>
        <td>Gravado 15%:</td>
        <td>L. {{ number_format($totalGravado15, 2) }}</td>
    </tr>

    <tr>
        <td>Gravado 18%:</td>
        <td>L. {{ number_format($totalGravado18, 2) }}</td>
    </tr>
</table>


{{-- ===========================================
     TOTALES
=========================================== --}}
<div class="totales">
    <table>
        <tr>
            <td>Subtotal:</td>
            <td>L. {{ number_format($factura->subtotal, 2) }}</td>
        </tr>

        <tr>
            <td>Descuento:</td>
            <td>L. {{ number_format($factura->discount, 2) }}</td>
        </tr>

        <tr>
            <td>ISV 15%:</td>
            <td>L. {{ number_format($factura->tax_15, 2) }}</td>
        </tr>

        <tr>
            <td>ISV 18%:</td>
            <td>L. {{ number_format($factura->tax_18, 2) }}</td>
        </tr>

        <tr>
            <td><strong>Total Pagar:</strong></td>
            <td><strong>L. {{ number_format($factura->total, 2) }}</strong></td>
        </tr>
    </table>
</div>


</body>
</html>

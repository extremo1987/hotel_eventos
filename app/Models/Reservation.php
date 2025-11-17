<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Importa los modelos para usarlos sin FQCN
use App\Models\Client;
use App\Models\Salon;
use App\Models\Invoice;
use App\Models\InvoiceItem;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'salon_id',
        'title',
        'start_at',
        'end_at',
        'status',
        'total',
        // 'notes', // <-- descomenta si tu columna existe en BD
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at'   => 'datetime',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function salon()
    {
        return $this->belongsTo(Salon::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'reservation_id');
    }

    /**
     * Genera factura automáticamente cuando la reserva cambia a "confirmada"
     */
    protected static function booted()
    {
        static::updated(function (Reservation $reserva) {

            // ¿Cambió realmente el status?
            if (! $reserva->wasChanged('status')) {
                return;
            }

            // Normaliza el estado a minúsculas
            $status = strtolower((string) $reserva->status);

            // Solo actuar cuando queda en "confirmada"
            if ($status !== 'confirmada') {
                return;
            }

            // Ya tiene factura? no dupliques
            if ($reserva->invoice) {
                return;
            }

            // Asegura tener cargado el salón/cliente
            $reserva->loadMissing(['salon', 'client']);

            // Toma precio del salón si existe
            $price     = optional($reserva->salon)->price ?? 0;
            $salonName = optional($reserva->salon)->name  ?? 'Salón';

            // Correlativo anual: FAC-YYYY-XXX
            $year        = now()->year;
            $secuencia   = Invoice::whereYear('issued_at', $year)->count() + 1;
            $invoiceNo   = 'FAC-' . $year . '-' . str_pad($secuencia, 3, '0', STR_PAD_LEFT);

            // Impuesto (ISV 15%) sobre precio base
            $tax15  = round($price * 0.15, 2);
            $total  = round($price + $tax15, 2);

            // Crea la factura
            $factura = Invoice::create([
                'reservation_id' => $reserva->id,
                'client_id'      => $reserva->client_id,
                'invoice_number' => $invoiceNo,
                'issued_at'      => now()->toDateString(),
                'subtotal'       => $price,
                'discount'       => 0,
                'tax_15'         => $tax15,
                'tax_18'         => 0,
                'total'          => $total,
                'notes'          => 'Factura generada automáticamente al confirmar la reserva.',
            ]);

            // Crea el ítem (solo si hay precio)
            InvoiceItem::create([
                'invoice_id'  => $factura->id,
                'description' => 'Alquiler del salón: ' . $salonName,
                'quantity'    => 1,
                'unit_price'  => $price,
                'tax_type'    => 'isv15',   // exento | isv15 | isv18
                'line_total'  => $price,
            ]);
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'reservation_id',
        'client_id',
        'invoice_number',
        'issued_at',
        'subtotal',
        'discount',
        'tax_15',
        'tax_18',
        'total',
        'status',
        'notes'
    ];

    public function reservation()
    {
        return $this->belongsTo(\App\Models\Reservation::class);
    }

    public function client()
    {
        return $this->belongsTo(\App\Models\Client::class);
    }

    public function items()
    {
        return $this->hasMany(\App\Models\InvoiceItem::class);
    }
}

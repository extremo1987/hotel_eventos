<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
        'invoice_id',
        'description',
        'quantity',
        'unit_price',
        'tax_type',
        'line_total'
    ];

    public function invoice()
    {
        return $this->belongsTo(\App\Models\Invoice::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'salon_id',
        'title',
        'event_date',
        'total',
        'status',
        'notes'
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
}

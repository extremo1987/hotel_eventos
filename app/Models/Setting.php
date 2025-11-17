<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'company_name',
        'company_rtn',
        'company_phone',
        'company_email',
        'company_address',
        'company_logo',
        'invoice_prefix',
        'invoice_start_number',
    ];
}

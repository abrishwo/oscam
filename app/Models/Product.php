<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'qr_code',
        'product_name',
        'batch_number',
        'status',
        'scan_count',
        'last_scan'
    ];
}


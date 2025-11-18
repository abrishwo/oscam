<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_id',
        'scanned_at',
        'device_id',
        'geo_location',
        'user_agent',
        'raw_qr_text',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'scanned_at' => 'datetime',
        'geo_location' => 'array',
    ];

    /**
     * Get the product that was scanned.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

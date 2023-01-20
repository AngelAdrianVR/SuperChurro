<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price_id',
        'product_id',
    ];

    // relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function price()
    {
        return $this->belongsTo(Price::class);
    }

}

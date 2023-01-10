<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'low_stock',
        'unit_id',
    ];

    // relationships
    public function prices() 
    {
        return $this->hasMany(Price::class);
    }

    public function unit() 
    {
        return $this->belongsTo(Unit::class);
    }

    public function movements()
    {
        return $this->hasMany(WarehouseMovement::class);
    }

    public function currentPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany();
    }

}

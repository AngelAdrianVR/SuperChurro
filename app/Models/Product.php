<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia; 

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'code',
        'low_stock',
        'unit_id',
    ];

    // relationships
    public function prices() 
    {
        return $this->hasMany(Price::class)->where('is_employee_price', 0);
    }

    public function employeePrices()
    {
        return $this->hasMany(Price::class)->where('is_employee_price', 1);
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
        return $this->hasOne(Price::class)->where('is_employee_price', 0)->latest();
    }

    public function currentEmployeePrice()
    {
        return $this->hasOne(Price::class)->where('is_employee_price', 1)->latest();
    }

}

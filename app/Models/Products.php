<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // relationships
    public function prices() 
    {
        return $this->hasMany(Price::class);
    }

    public function currentPrice()
    {
        return $this->hasOne(Price::class)->latestOfMany();
    }

}

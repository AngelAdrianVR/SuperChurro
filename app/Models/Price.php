<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;

    protected $fillable = ['price', 'product_id', 'is_employee_price'];

    // relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

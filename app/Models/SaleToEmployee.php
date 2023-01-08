<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleToEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'products',
        'user_id',
    ];

    protected $casts = [
        'products' => 'array',
    ];
}

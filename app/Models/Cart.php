<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'products',
        'is_active',
    ];

    protected $casts = [
        'products' => 'array',
    ];
} 

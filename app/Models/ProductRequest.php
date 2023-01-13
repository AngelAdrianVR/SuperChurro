<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'products',
        'cart_id',
        'user_id',
    ];  

    protected $casts = [
        'products' => 'array',
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

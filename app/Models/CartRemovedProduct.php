<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartRemovedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'products',
        'concept',
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

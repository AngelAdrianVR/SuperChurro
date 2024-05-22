<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsumableRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'consumables',
        'cart_id',
        'user_id',
    ];  

    protected $casts = [
        'consumables' => 'array',
    ];

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

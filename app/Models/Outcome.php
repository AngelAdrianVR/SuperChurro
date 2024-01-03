<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outcome extends Model
{
    use HasFactory;

    protected $fillable = [
        'concept',
        'cost',
        'quantity',
        'notes',
        'user_id',
        'created_at',
        'category',
        'date',
        'provider',
        'payment_method',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    //relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

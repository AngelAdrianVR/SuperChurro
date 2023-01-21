<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'remaining',
        'authorized_at',
        'description',
        'user_id',
    ];

    //Rellationships
    public function user(){
        return $this->belongsTo(User::class);
    }
}

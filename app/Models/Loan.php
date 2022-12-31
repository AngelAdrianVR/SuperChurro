<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'status',
        'description',
        'user_id',
        'payed_at',
    ];

    protected $dates = [
        'payed_at',
    ];

    //Rellationships
    public function user(){
        return $this->belongsTo(User::class);
    }
}

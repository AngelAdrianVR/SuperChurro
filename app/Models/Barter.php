<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barter extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'status',
        'transmitter_user_id',
        'receptor_user_id'
    ];

    protected $dates = ['date'];

    // relationships
    public function transmitter()
    {
        return $this->belongsTo(User::class, 'transmitter_user_id');
    }

    public function receptor()
    {
        return $this->belongsTo(User::class, 'receptor_user_id');
    }

}

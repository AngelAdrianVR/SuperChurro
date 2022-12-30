<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory;

    protected $fillable = [
        'week',
        'start_date',
        'is_active',
    ];

    protected $dates = [
        'start_date'
    ];


    //Rellationships
    public function users()
    {
        return $this->belongsToMany(User::class)->using(PayrollUser::class);
    }
}

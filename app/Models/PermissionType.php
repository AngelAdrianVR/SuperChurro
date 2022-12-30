<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_full_day',
    ];

    //Relationships
    public function workPermits(){
        return $this->hasMany(WorkPermit::class);
    }
}

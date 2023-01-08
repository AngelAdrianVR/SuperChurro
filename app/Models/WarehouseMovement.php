<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarehouseMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'notes',
        'user_id',
        'movement_concept_id',
        'product_id',
        'warehouse_id',
    ];  
}

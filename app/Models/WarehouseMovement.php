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

    // relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function concept()
    {
        return $this->belongsTo(MovementConcept::class, 'movement_concept_id');
    }

    // public function warehouse()
    // {
    //     return $this->belongsTo(Warehouse::class);
    // }

    
}

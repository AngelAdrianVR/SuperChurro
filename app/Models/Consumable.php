<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Consumable extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'name',
        'code',
        'low_stock',
        'unit_id',
        'notes',
    ];

    // relationships
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}

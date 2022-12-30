<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PayrollUser extends Pivot
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    protected $fillable = [
        'registers',
        'discounts',
    ];

    protected $casts = [
        'registers' => 'array',
    ];

}

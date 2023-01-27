<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleToEmployee extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'product_id',
        'notes',
        'price',
        'user_id',
    ];

    // relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  static methods
    static public function totalSaleOnDate(String $date)
    {
        $sales = self::whereDate('created_at', $date)
            ->get();
        
        return $sales->sum('price');
    }
}

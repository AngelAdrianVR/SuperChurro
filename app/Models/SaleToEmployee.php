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
        
        $percentage_off = 50;
        $discount_factor = 1 - ($percentage_off / 100);

        return $sales->sum(fn ($sale) => $sale->quantity * $sale->price * $discount_factor);
    }
}

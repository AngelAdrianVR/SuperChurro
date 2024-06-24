<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'quantity',
        'price',
        'product_id',
        'created_at',
    ];

    // relationships
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // static methods
    static public function calculateCommissions(String $date)
    {
        $total_sale = self::shift1TotalSaleOnDate($date) 
            + self::shift2TotalSaleOnDate($date)
            + SaleToEmployee::totalSaleOnDate($date);
        
            
        $churro_price = 25;
        $churros_to_ceil = 5;
        
        $churros_sold = ($total_sale / $churro_price) + $churros_to_ceil; 

        return intval($churros_sold / 100) * 10;
    }

    static public function shift1TotalSaleOnDate(String $date)
    {
        $half_time = Carbon::parse($date)->addHours(16);

        $shift_1_sales = self::whereDate('created_at', $date)
            ->whereTime('created_at', '<', $half_time)
            ->get();
        
        return $shift_1_sales->sum(fn ($sale) => $sale->quantity * $sale->price);
    }

    static public function shift2TotalSaleOnDate(String $date)
    {
        $half_time = Carbon::parse($date)->addHours(16);

        $shift_2_sales = self::whereDate('created_at', $date)
            ->whereTime('created_at', '>', $half_time)
            ->get();
        
        return $shift_2_sales->sum(fn ($sale) => $sale->quantity * $sale->price);
    }


}

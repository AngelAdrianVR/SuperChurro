<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleToEmployee;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return inertia('Sales/Index', compact('products'));
    }

    public function create()
    {
        $products = Product::all();
        return inertia('Sales/Create', compact('products'));
    }

    public function store(Request $request)
    {
        $sales = [];
        $new_cart_stock = [];
        $cart = Cart::first();

        foreach ($cart->products as $product_id => $quantity) {
            $request->validate([
                "product.$product_id" => "numeric|max:$quantity"
            ]);

            $remaining_quantity = $request->product[$product_id];
            $new_cart_stock[$product_id] = $remaining_quantity;
            $sales[] = [
                'quantity' => $cart->products[$product_id] - $request->product[$product_id],
                'product_id' => $product_id,
                'price' => Product::find($product_id)->currentPrice->id,
                'created_at' => now(),
            ];
        }

        Sale::insert($sales);

        $cart->products = $new_cart_stock;
        $cart->save();

        request()->session()->flash('flash.banner', '¡Se ha creado el corte correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('carts.index');
    }

    public function show($sale_date)
    {
        $sale = Sale::whereDate('created_at', $sale_date)->get();
        dd($sale);
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        //
    }

    public function destroy(Sale $sale)
    {
        //
    }

    public function getByDate(Request $request)
    {
        $middle_date = Carbon::parse($request->date)->addHours(16);
        
        $shift_1_sales = Sale::whereDate('created_at', $request->date)
            ->whereTime('created_at', '<', $middle_date)
            ->with('product')
            ->get();

        $shift_2_sales = Sale::whereDate('created_at', $request->date)
        ->whereTime('created_at', '>', $middle_date)
        ->with('product')
        ->get();

        $sales_to_employees = SaleToEmployee::whereDate('created_at', $request->date)
        ->with('product', 'user')
        ->get();

        // get employees at $request->date to show in sales histories

        return response()->json(compact('shift_1_sales', 'shift_2_sales', 'sales_to_employees'));
    }
}

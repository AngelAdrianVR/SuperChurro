<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CashRegister;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleToEmployee;
use App\Models\User;
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

        // store sales
        foreach ($cart->products as $product_id => $quantity) {
            $request->validate([
                "product.$product_id" => "numeric|max:$quantity"
            ]);

            $remaining_quantity = $request->product[$product_id];
            $new_cart_stock[$product_id] = $remaining_quantity;
            $sales[] = [
                'quantity' => $cart->products[$product_id] - $request->product[$product_id],
                'product_id' => $product_id,
                'price' => Product::find($product_id)->currentPrice->price,
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
        //
    }

    public function edit(Sale $sale)
    {
        //
    }

    public function update(Request $request, Sale $sale)
    {
        $sale->update(['quantity' => $request->quantity]);
    }

    public function destroy(Sale $sale)
    {
        //
    }

    // API
    public function getByDate(Request $request)
    {
        // refactor (used in cartController too)
        $middle_date = Carbon::parse($request->date)->addHours(17);
        
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

        $stored_cash = CashRegister::whereDate('date', $request->date)->get();

        // get employees at $request->date to show in sales histories
        $employees = User::where('id', '!=', 1)->get()->where(function($user) use ($request){
            return $user->hasAttendanceOn($request->date);
        });

        return response()->json(compact('shift_1_sales', 'shift_2_sales', 'sales_to_employees', 'stored_cash', 'employees'));
    }

    public function getMonthSale(Request $request)
    {
        // refactor (used in cartController too)
        $middle_date = Carbon::parse($request->date)->addHours(17);
        $month = Carbon::parse($request->date)->month;
        
        $month_sales = Sale::whereMonth('created_at', $month)
            ->with('product')
            ->get();
            
        $month_sales_to_employees = SaleToEmployee::whereMonth('created_at', $month)
        ->with('product', 'user')
        ->get();

        $month_stored_cash = CashRegister::whereMonth('date', $month)->get()->sum('cash');

        return response()->json(compact('month_sales', 'month_sales_to_employees', 'month_stored_cash'));
    }
}

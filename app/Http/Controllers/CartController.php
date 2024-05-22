<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartRemovedProduct;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Sale;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseMovement;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart_products = Cart::get('products');
        $products = Product::with('unit', 'media')->get();
        $requests = ProductRequest::whereDate('created_at', now())->with('user')->latest()->get();
        $employees = User::all()->filter(
            fn ($user) => $user->hasCheckedInToday() && $user->shiftOn(today()->dayOfWeek) !== 'cocina'
        );

        $middle_date = Carbon::parse(today())->addHours(17);
        $sales = [];

        $shift_1_sales = Sale::whereDate('created_at', today())
            ->whereTime('created_at', '<', $middle_date)
            ->with('product')
            ->get();

        if ($shift_1_sales->count()) $sales[] = "Corte del primer turno realizado";
        
        $shift_2_sales = Sale::whereDate('created_at', today())
        ->whereTime('created_at', '>', $middle_date)
        ->with('product')
        ->get();

        if ($shift_2_sales->count()) $sales[] = "Corte del segundo turno realizado";

        // return $products;

        return inertia('Cart/Index', compact('cart_products', 'products', 'requests', 'employees', 'sales'));
    }

    public function createRemovedProducts()
    {
        $products = Product::all();
        $cart_stock = Cart::first()->products;

        return inertia('Cart/RemoveProducts', compact('products', 'cart_stock'));
    }

    public function removeProducts(Request $request)
    {
        $items = $request->validate([
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.product_id' => 'required|numeric|min:1',
        ]);

        // create request
        CartRemovedProduct::create([
            'products' => $items['items'],
            'concept' => $request->concept,
            'user_id' => auth()->id(),
            'cart_id' => 1,
        ]);

        $warehouse = Warehouse::find(1);
        $current_products = $warehouse->products;
        
        $cart = Cart::find(1);
        $current_products_cart = $cart->products;
        foreach ($request->items as $item) {
            // update warehouse stock if it is back to the warehouse
            if ($request->concept == 'Devolución a cocina') {
                WarehouseMovement::create([
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id'],
                    'movement_concept_id' => 8,
                    'notes' => 'Mercancía devuelta desde carrito 1',
                    'user_id' => auth()->id(),
                    'warehouse_id' => 1
                ]);

                $current_products[$item['product_id']] += $item['quantity'];
            }
            $current_products_cart[$item['product_id']] -= $item['quantity'];
        }

        $warehouse->update(['products' => $current_products]);
        $cart->update(['products' => $current_products_cart]);

        request()->session()->flash('flash.banner', 'Producto(s) removido(s) con correctamente');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('carts.index');
    }

    public function requestsIndex()
    {
        return inertia('Cart/RequestsIndex');
    }
}

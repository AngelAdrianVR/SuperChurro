<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart_products = Cart::get('products');
        $products = Product::with('unit')->get();
        $requests = ProductRequest::whereDate('created_at', now())->with('user')->latest()->get();
        $employees = User::all()->filter(
            fn($user) => $user->hasCheckedInToday() && $user->employee_properties['shift'] !== 'cocina'
        );
        
        return inertia('Cart/Index', compact('cart_products', 'products', 'requests', 'employees'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Cart $cart)
    {
        //
    }

    public function edit(Cart $cart)
    {
        //
    }

    public function update(Request $request, Cart $cart)
    {
        //
    }

    public function destroy(Cart $cart)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Cart;
use App\Models\Price;
use App\Models\Product;
use App\Models\Unit;
use App\Models\Warehouse;
use App\Models\WarehouseMovement;
use Illuminate\Http\Request;

class productController extends Controller
{

    public function index()
    {
        $products = ProductResource::collection(Product::with('unit', 'currentPrice', 'currentEmployeePrice', 'media')->get());

        return inertia('Product/Index', compact('products'));
    }


    public function create()
    {
        $units = Unit::all();

        return inertia('Product/Create', compact('units'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $new_product = Product::create($validated);

        // Guardar el archivo en media
        if ($request->hasFile('media')) {
            $new_product->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());
        }

        // store price
        Price::create([
            'price' => $request->price,
            'product_id' => $new_product->id,
            'created_at' => now(),
        ]);

        // store employee price
        Price::create([
            'price' => $request->employee_price,
            'product_id' => $new_product->id,
            'created_at' => now(),
            'is_employee_price' => true
        ]);

        // Add new product to warehouse (with initial stock) & cart (0 initial stock)
        $warehouse = Warehouse::first();
        $cart = Cart::first();
        $products = $warehouse->products + [$new_product->id => $request->initial_stock];
        $cart_products = $cart->products + [$new_product->id => 0];
        $warehouse->update(['products' => $products]);
        $cart->update(['products' => $cart_products]);

        // store warehouse movement
        WarehouseMovement::create([
            'quantity' => $request->initial_stock,
            'product_id' => $new_product->id,
            'movement_concept_id' => 1,
            'notes' => 'Stock de apertura al crear nuevo producto',
            'user_id' => auth()->id(),
            'warehouse_id' => $warehouse->id
        ]);

        request()->session()->flash('flash.banner', '¡Se ha creado un nuevo producto correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('products.index');
    }


    public function show(product $product)
    {
        //
    }


    public function edit($product_id)
    {
        $product = Product::with('currentPrice', 'unit', 'currentEmployeePrice', 'media')->find($product_id);
        $units = Unit::all();

        return inertia('Product/Edit', compact('product', 'units'));
    }


    public function update(Request $request, product $product)
    {
        $validated = $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $product->update($validated);

        // update current price if setted different
        if ($product->currentPrice->price != $request->price) {
            Price::create([
                'price' => $request->price,
                'product_id' => $product->id,
                'created_at' => now(),
            ]);
        }

        // update current employee price if setted different
        if ($product->currentEmployeePrice->price != $request->employee_price) {
            Price::create([
                'price' => $request->employee_price,
                'product_id' => $product->id,
                'created_at' => now(),
                'is_employee_price' => true
            ]);
        }

        request()->session()->flash('flash.banner', '¡Se ha actualizado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('products.index');
    }


    public function updateWithMedia(Request $request, product $product)
    {
        $request->validate([
            'name' => 'required|max:25',
            'low_stock' => 'numeric',
            'unit_id' => 'required',
            'code' => 'nullable|string',
        ]);

        $product->update($request->all());

        // update current price if setted different
        if ($product->currentPrice->price != $request->price) {
            Price::create([
                'price' => $request->price,
                'product_id' => $product->id,
                'created_at' => now(),
            ]);
        }

        // update current employee price if setted different
        if ($product->currentEmployeePrice->price != $request->employee_price) {
            Price::create([
                'price' => $request->employee_price,
                'product_id' => $product->id,
                'created_at' => now(),
                'is_employee_price' => true
            ]);
        }

          // update image
        $product->clearMediaCollection();
        $product->addAllMediaFromRequest()->each(fn ($file) => $file->toMediaCollection());

        request()->session()->flash('flash.banner', '¡Se ha actualizado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');

        return to_route('products.index');
    }


    public function destroy(product $product)
    {
        $product->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success');
        return redirect()->route('products.index');
    }


    public function searchProduct(Request $request)
    {
        $query = $request->input('query');

        // Realiza la búsqueda en la base de datos local
        $products = Product::with(['media', 'currentPrice'])
            ->where('name', 'like', "%$query%")
            ->orWhere('code', 'like', "%$query%")
            ->get()
            ->take(10);

        return response()->json(['items' => $products]);
    }


    public function getProductScaned($product_id)
    {
        $product = Product::where('id', $product_id)->with(['media', 'currentPrice'])->first();

        return response()->json(['item' => $product]);
    }
}

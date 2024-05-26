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
    public function pointIndex()
    {
        $products = Product::all(['id','name','code']);

        //recupera la primera caja registradora de la tienda para mandar su info como current_cash
        // $cash_register = CashRegister::where('store_id', auth()->user()->store_id)->first();

        return inertia('Sales/Point', compact('products'));
    }


    public function index()
    {
        $products = Product::all();

        return inertia('Sales/Index', compact('products'));
    }


    public function create()
    {
        $products = Product::all();
        $cart = Cart::first();

        return inertia('Sales/Create', compact('products', 'cart'));
    }


    public function store(Request $request)
    {
        $cart = Cart::first();
        $is_after3PM = now()->isAfter(today()->setHour(15));

        foreach ($request->saleProducts as $sale) {
            $product_sold_today = Sale::whereDate('created_at', today())->where('product_id', $sale['product']['id'])->latest()->first(); 
            // obtener el precio de producto depende del tipo de venta seleccionado (a publico, empleado o cortesia)
            if ($request->saleType == 'publico') {
                $price = $sale['product']['current_price']['price'];
            } elseif ($request->saleType == 'empleado') {
                $price = $sale['product']['current_employee_price']['price'];
            } else {
                $price = 0;
            }

            //si es despues de las 3pm (turno vespertino) se revisa si el registro creado ya es del turno vespertino
            if ( $is_after3PM ) {
                // si el producto se creó despues de las 3pm se incrementa la cantidad del mismo registro para evitar crear mas registros
                if ( $product_sold_today?->created_at->isAfter(today()->setHour(15)) ) {
                    $product_sold_today->increment('quantity', $sale['quantity']);
                } else {
                    // Si el registro de ese producto no se ha creado entonces lo crea
                    Sale::create([
                        'quantity' => $sale['quantity'],
                        'product_id' => $sale['product']['id'],
                        'price' => $price,
                    ]);
                }
            } else {
                if ( $product_sold_today ) {
                    $product_sold_today->increment('quantity', $sale['quantity']);
                } else {
                    Sale::create([
                        'quantity' => $sale['quantity'],
                        'product_id' => $sale['product']['id'],
                        'price' => $price,
                    ]);
                }
            }
            
            // Verificar si el producto está presente en el carrito
            if (isset($cart->products[$sale['product']['id']])) {
                $cart_products = $cart->products;
                // Actualizar la cantidad de productos que hay en el carrito con la venta realizada
                // Guardar el carrito actualizado
                $cart_products[$sale['product']['id']] -= $sale['quantity'];
                $cart->update([
                    'products' => $cart_products
                ]);
            }
            
        }

        // request()->session()->flash('flash.banner', '¡Se ha creado el corte correctamente!');
        // request()->session()->flash('flash.bannerStyle', 'success');
        
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
        $middle_date = Carbon::parse($request->date)->addHours(15);

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
        $employees = User::where('id', '!=', 1)->get()->where(function ($user) use ($request) {
            return $user->hasAttendanceOn($request->date);
        });

        return response()->json(compact('shift_1_sales', 'shift_2_sales', 'sales_to_employees', 'stored_cash', 'employees'));
    }

    public function getMonthSale(Request $request)
    {
        // refactor (used in cartController too)
        $middle_date = Carbon::parse($request->date)->addHours(15);
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


    public function printSales()
    {
        // Obtener todas las ventas con sus productos relacionados donde la cantidad sea mayor que 0
        $sales = Sale::with('product')->where('quantity', '>', 0)->get();

        // Inicializar un array para almacenar los totales por fecha
        $totalsByDate = [];

        // Iterar sobre cada venta
        foreach ($sales as $sale) {
            // Obtener la fecha de la venta sin la hora para agrupar por fecha
            $date = explode(' ', $sale->created_at)[0];

            // Calcular el total de dinero vendido para esta venta
            $total = $sale->quantity * $sale->price;

            // Sumar al total de la fecha correspondiente
            if (isset($totalsByDate[$date])) {
                $totalsByDate[$date] += $total;
            } else {
                $totalsByDate[$date] = $total;
            }
        }

        // Devolver los totales por fecha
        return inertia('Sales/Print', compact('totalsByDate'));
    }
}

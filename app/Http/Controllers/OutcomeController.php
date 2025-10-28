<?php

namespace App\Http\Controllers;

use App\Models\Outcome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OutcomeController extends Controller
{

    public function index(Request $request)
    {
        // Valida y obtiene el rango de fechas.
        $validated = $request->validate([
            'date_from' => 'nullable|date_format:Y-m-d',
            'date_to' => 'nullable|date_format:Y-m-d',
        ]);

        // Usa el mes actual como default si no se proveen fechas
        $dateFrom = $validated['date_from'] ?? now()->startOfMonth()->toDateString();
        $dateTo = $validated['date_to'] ?? now()->endOfMonth()->toDateString();

        // 1. Calcula el total del rango de forma eficiente
        // Aseguramos cubrir el día completo en 'dateTo'
        $total_outcomes_money = Outcome::whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->sum(DB::raw('cost * quantity'));

        // 2. Crea la consulta base para los días
        $datesQuery = Outcome::select(DB::raw('DATE(created_at) as outcome_date'))
            ->whereBetween('created_at', [$dateFrom . ' 00:00:00', $dateTo . ' 23:59:59'])
            ->distinct()
            ->latest('outcome_date');

        // 3. Pagina los días (ej. 10 días por página)
        // withQueryString() agrega los parámetros (date_from, date_to) a los enlaces de paginación
        $paginatedDates = $datesQuery->paginate(10)->withQueryString();

        // 4. Obtiene los egresos solo para los días de la página actual
        $dates = $paginatedDates->pluck('outcome_date');
        $outcomes_groups = Outcome::with('user')
            ->whereIn(DB::raw('DATE(created_at)'), $dates)
            ->latest()
            ->get()
            // Agrupa en PHP (es rápido porque solo procesa los datos de una página)
            ->groupBy(function ($data) {
                return $data->created_at->toDateString();
            });

        // 5. Devuelve los datos a Inertia
        return Inertia::render('Outcome/Index', [
            'outcomes' => $paginatedDates, // Este es el objeto paginador (links, data, etc.)
            'outcomes_groups' => $outcomes_groups, // Estos son los egresos agrupados
            'total_outcomes_money' => number_format($total_outcomes_money, 2),
            'filters' => [ // Devolvemos los filtros aplicados
                'date_from' => $dateFrom,
                'date_to' => $dateTo,
            ]
        ]);
    }


    public function create()
    {
        return inertia('Outcome/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'items.*.concept' => 'required|max:191',
            'items.*.quantity' => 'required|numeric|min:1',
            'items.*.cost' => 'required|numeric|min:1',
            'notes' => 'max:191|nullable',
            'category' => 'required|string',
            'date' => 'required|date',
            'payment_method' => 'required|string',
            'provider' => 'required|string',
        ]);

        foreach ($request->items as $item) {
            Outcome::create([
                'concept' => $item['concept'],
                'category' => $request->category,
                'date' => $request->date,
                'provider' => $request->provider,
                'payment_method' => $request->payment_method,
                'quantity' => $item['quantity'],
                'cost' => $item['cost'],
                'notes' => $request->notes,
                'user_id' => auth()->id(),
            ]);
        }

        return to_route('outcomes.index');
    }


    public function show(Outcome $outcome)
    {
        $outcomes = Outcome::whereDate('created_at', $outcome->created_at)->get();

        // return $outcomes;
        return inertia('Outcome/Show', compact('outcomes'));
    }


    public function edit(Outcome $outcome)
    {
        $outcomes = Outcome::whereDate('created_at', $outcome->created_at)->get();

        // return $outcomes;

        return inertia('Outcome/Edit', compact('outcome', 'outcomes'));
    }


    public function update(Request $request, Outcome $outcome)
    {
        $outcome->update([
            'concept' => $request->concept,
            'quantity' => $request->quantity,
            'cost' => $request->cost
        ]);
    }


    public function destroy(Request $request)
    {
        $outcomesArray = $request->input('outcomesArray');

        foreach ($outcomesArray as $outcomeId) {
            // Realiza la lógica para eliminar el elemento con el ID $outcomeId
            Outcome::destroy($outcomeId);
        }

        return response()->json(['items' => $outcomesArray]);
    }

    public function filter(Request $request)
    {
        $total_outcomes_money = 0;

        $replaced_month = str_replace("Dec", "Diciembre", $request->month);

        $outcomes = Outcome::query()->when($request->year, function ($query) use ($request) {
            return $query->whereYear('created_at', $request->year);
        })->when($request->month, function ($query) use ($request) {
            return $query->whereMonth('created_at', $request->month);
        })->with('user')->latest()->get()->groupBy(function ($data) {
            return $data->created_at->toDateString();
        });


        foreach ($outcomes as $outcome) {
            $total_outcomes_money += $outcome->sum(function ($outcome) {
                return $outcome->cost * $outcome->quantity;
            });
        }

        $total_outcomes_money = number_format($total_outcomes_money, 2);

        return response()->json(compact('outcomes', 'total_outcomes_money'));
    }

    public function printOutcomes()
    {
        // Obtener todas las ventas con sus productos relacionados donde la cantidad sea mayor que 0
        $sales = Outcome::where('quantity', '>', 0)->get();

        // Inicializar un array para almacenar los totales por fecha
        $totalsByDate = [];

        // Iterar sobre cada venta
        foreach ($sales as $sale) {
            // Obtener la fecha de la venta sin la hora para agrupar por fecha
            $date = explode(' ', $sale->created_at)[0];

            // Calcular el total de dinero vendido para esta venta
            $total = $sale->quantity * $sale->cost;

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

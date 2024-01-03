<?php

namespace App\Http\Controllers;

use App\Models\JustificationEvent;
use Illuminate\Http\Request;

class JustificationEventController extends Controller
{
    public function index()
    {
        $justifications = JustificationEvent::all();

        return response()->json(['items' => $justifications]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(JustificationEvent $justificationEvent)
    {
        //
    }

    public function edit(JustificationEvent $justificationEvent)
    {
        //
    }

    public function update(Request $request, JustificationEvent $justificationEvent)
    {
        //
    }

    public function destroy(JustificationEvent $justificationEvent)
    {
        //
    }
}

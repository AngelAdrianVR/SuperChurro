<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
  
    public function index()
    {
        $notices = Notice::all();
        return inertia('Notice/Index',compact('notices'));
    }

   
    public function create()
    {
        return inertia('Notice/Create');
    }

   
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:50',
            'content' => 'required',
        ]);

        Notice::create($request->all());

        request()->session()->flash('flash.banner', 'Se ha publicado tu Aviso');
        request()->session()->flash('flash.bannerStyle', 'success');

        return redirect()->route('notices.index');

    }


    public function show(Notice $notice)
    {
        //
    }

    public function edit(Notice $notice)
    {
        //
    }


    public function update(Request $request, Notice $notice)
    {
        //
    }


    public function destroy(Notice $notice)
    {
        $notice->delete();
        request()->session()->flash('flash.banner', '¡Se ha eliminado correctamente!');
        request()->session()->flash('flash.bannerStyle', 'success'); 
        return redirect()->route('notices.index');
    }
}

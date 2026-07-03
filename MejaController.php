<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use Illuminate\Http\Request;

class MejaController extends Controller
{

    public function index()
    {

        $mejas=Meja::all();

        return view('admin.meja.index',compact('mejas'));

    }

    public function create()
    {

        return view('admin.meja.create');

    }

    public function store(Request $request)
    {

        Meja::create($request->all());

        return redirect('/meja');

    }

    public function edit(Meja $meja)
    {

        return view('admin.meja.edit',compact('meja'));

    }

    public function update(Request $request,Meja $meja)
    {

        $meja->update($request->all());

        return redirect('/meja');

    }

    public function destroy(Meja $meja)
    {

        $meja->delete();

        return back();

    }

}
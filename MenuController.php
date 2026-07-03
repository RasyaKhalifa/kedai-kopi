<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{

    public function index()
    {
        $menus=Menu::all();

        return view('admin.menu.index',compact('menus'));
    }

    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {

        Menu::create($request->all());

        return redirect('/menu');

    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.edit',compact('menu'));
    }

    public function update(Request $request,Menu $menu)
    {

        $menu->update($request->all());

        return redirect('/menu');

    }

    public function destroy(Menu $menu)
    {

        $menu->delete();

        return back();

    }

}

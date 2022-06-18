<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Carbon;

class MenusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->is_admin == 1) {
            $menu = Menu::all();
            return view('admin.menu', compact('menu'));
        }
        Session::flash('bidden', 'Anda tidak memiliki Hak Akses!!');
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function aktif(Request $request, Menu $menu)
    {
        $aktif = Menu::where('id', $request->id)
            ->update([
                'aktif' => $request->aktif,
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        if ($aktif) {
            return redirect()->route('akses_menu')->with('success', 'Menu berhasil diubah');
        }
        return redirect()->back()->with('fai', 'Menu gagal diubah');
    }
}

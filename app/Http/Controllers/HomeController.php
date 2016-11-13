<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zona;
class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return redirect('control');
    }
    
    public function indexUsers()
    {
        $zonas = Zona::all();
        return view('recaudacion.seleccionar', compact('zonas'));
    }

}

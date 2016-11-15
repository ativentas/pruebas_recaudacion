<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Zona;
use App\Maquina;
use App\Estanco;



class MaquinaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct()
    {
        $this->middleware(['auth','admin']);

    }

    public function index()
    {
        $query = Maquina::orderBy('zona')->orderBy('nombre');
        $query = \Request::has('zona') ? $query->where('zona',\Request::input('zona')) : $query;
        $query = \Request::has('estanco') ? $query->where('estanco',\Request::input('estanco')) : $query;

        $maquinas = $query->get();        

        $zonas = Zona::all();
        $estancos = Estanco::all();
        
        return view('maquinas.listadomaquinas', compact('maquinas','zonas','estancos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estancos = Estanco::all();
        $zonas = Zona::all();

        return view('maquinas.nuevamaquina', compact('estancos','zonas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'nombre' => 'required|unique:maquinas|min:4|max:35',
        'zona' => 'required',
        'estanco' => 'required',   
        ]);

        $maquina = new Maquina;
        $maquina->nombre = $request->nombre;
        $maquina->zona = $request->zona;
        $maquina->estanco = $request->estanco;
        $maquina->save();
    
        return redirect()->back()->with('info', 'Nueva maquina creada');

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $maquina = Maquina::where('id',$id)->first();
        $zonas=Zona::all();
        $estancos=Estanco::all();
        return view('maquinas.modificarmaquina',compact('maquina','zonas','estancos'));    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('estado')) {
        $maquina=Maquina::where('id',$id)->first();
        $maquina->activa=$request->estado;
        $maquina->save();
        }else {  
        $this->validate($request, [
        'nombre' => 'required|min:4|max:35|unique:maquinas,nombre,'.$id.',id',
        'zona' => 'required',
        'estanco' => 'required',   
        ]);
        $maquina=Maquina::where('id',$id)->first();
        $maquina->nombre = $request->nombre;
        $maquina->zona = $request->zona;
        $maquina->estanco = $request->estanco;
        $maquina->save();
        return redirect()->route('maquinas.index')->with('info','Máquina modificada');
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        dd('destroy');
    }
}

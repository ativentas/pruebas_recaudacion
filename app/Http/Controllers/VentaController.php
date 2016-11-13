<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Http\Requests;

use App\Zona;
use App\Estanco;
use App\Maquina;
use App\PlantillaZona;

class VentaController extends Controller
{
    public function index()
    {
        $zonas = Zona::all();
        $estancos = Estanco::all();
        $maquinas = Maquina::all();
        // dd($maquinas);
        return view('ventas.seleccionarInforme', compact('maquinas','zonas','estancos'));
    }

    public function crearInforme(Request $request){
    	
		$zona = $request->centro;
    	$hace7 = Carbon::today()->subDays(7);
    	$semanapasada = $hace7->weekOfYear;
    	$yearsemanapasada = $hace7->year;
    	$semanadesde = $semanapasada - 6;
    	$desde = $yearsemanapasada.$semanadesde;
    	$plantillas = PlantillaZona::all()->where('zona',$zona)->where('year_semana', '>',$desde)->sortByDesc('year_semana');
    	
        $semanal[] = ['semana','año actual','año anterior'];
        foreach ($plantillas as $plantilla){
            $semanal[] = [$plantilla->semana, (int)$plantilla->total, (int)$plantilla->totalAnterior];
        }        
        $semanal = json_encode($semanal);

        return view('ventas.informeVentasSemanal', compact('zona','plantillas','semanal'));
    

    }
}

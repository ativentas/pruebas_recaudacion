<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Carbon\Carbon;
use App\Http\Requests;

use App\Zona;
use App\Estanco;
use App\Maquina;
use App\Linea;
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

    public function mostrarDescuadres(){
        $hace7 = Carbon::today()->subDays(7);
        $semanapasada = $hace7->weekOfYear;
        $yearsemanapasada = $hace7->year;
        $s_2 = $semanapasada-1;
        $s_3 = $semanapasada-2;
        $s_4 = $semanapasada-3;
        $s_5 = $semanapasada-4;

        $zonas = Zona::all();
        $estancos = Estanco::all();
        $semanas = [$semanapasada,$s_2,$s_3,$s_4,$s_5];

        $maquinas = Maquina::activa()->get();

            $diferencias = DB::table('lineas')
            ->join('plantillazonas', 'lineas.plantillazona_id', '=', 'plantillazonas.id')
            ->where('plantillazonas.year',2016)
            ->select(
                'lineas.maquina_id', 
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[0] THEN lineas.diferencia ELSE NULL END) AS 's_43'"),                
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[1] THEN lineas.diferencia ELSE NULL END) AS 's_44'"))

            ->groupBy ('lineas.maquina_id')
            ->get();
            // dd($diferencias);


        return view('ventas.descuadres', compact('zonas','estancos','semanas','maquinas','diferencias'));
    }
}

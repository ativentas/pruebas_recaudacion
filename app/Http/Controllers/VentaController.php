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
            $semanal[] = [$plantilla->semana, (int)$plantilla->totalR, (int)$plantilla->totalAnterior];
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
        $s_6 = $semanapasada-5;
        $s_7 = $semanapasada-6;
        $s_8 = $semanapasada-7;
        $s_9 = $semanapasada-8;
        $s_10 = $semanapasada-9;

        $zonas = Zona::all();
        $estancos = Estanco::all();
        $semanas = [$s_10,$s_9,$s_8,$s_7,$s_6,$s_5,$s_4,$s_3,$s_2,$semanapasada];

        $maquinas = Maquina::activa()->get();

            $diferencias = DB::table('lineas')
            ->join('plantillazonas', 'lineas.plantillazona_id', '=', 'plantillazonas.id')
            ->join('maquinas', 'lineas.maquina_id', '=', 'maquinas.id')
            ->where('plantillazonas.year',2016)
            ->select(
                'maquinas.nombre AS maquina', 
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[0] THEN lineas.diferencia ELSE NULL END) AS 's1'"),                
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[1] THEN lineas.diferencia ELSE NULL END) AS 's2'"),
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[2] THEN lineas.diferencia ELSE NULL END) AS 's3'"),
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[3] THEN lineas.diferencia ELSE NULL END) AS 's4'"),
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[4] THEN lineas.diferencia ELSE NULL END) AS 's5'"),                
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[5] THEN lineas.diferencia ELSE NULL END) AS 's6'"),               
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[6] THEN lineas.diferencia ELSE NULL END) AS 's7'"),                
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[7] THEN lineas.diferencia ELSE NULL END) AS 's8'"),                
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[8] THEN lineas.diferencia ELSE NULL END) AS 's9'"),
                DB::raw("group_concat(CASE WHEN plantillazonas.semana = $semanas[9] THEN lineas.diferencia ELSE NULL END) AS 's10'")
                )
            ->groupBy ('lineas.maquina_id')
            ->get();
            // dd($diferencias);


        return view('ventas.descuadres', compact('zonas','estancos','semanas','maquinas','diferencias'));
    }
}

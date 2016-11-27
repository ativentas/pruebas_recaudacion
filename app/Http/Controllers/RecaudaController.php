<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Linea;
use Carbon\Carbon;
use App\PlantillaZona;
use App\Maquina;

class RecaudaController extends Controller
{

    public function listadoPlantillas() {
    	if(Auth::user()->isAdmin()){
    	$plantillas = PlantillaZona::orderBy('archivado','asc')->orderBy('year','desc')->orderBy('semana','desc')->orderBy('zona','desc')->get();
    	}else{
    	$hoy = Carbon::today();
    	$semanahoy = $hoy->weekOfYear;
    	$hace7 = Carbon::today()->subDays(7);
    	$semanahace7 = $hace7->weekOfYear;
    	$yearhoy = $hoy->year;
    	$yearhace7 = $hace7->year;

    	$plantillasnow = PlantillaZona::where('year',$yearhoy)->where('semana',$semanahoy);
       	$plantillas = PlantillaZona::where('year',$yearhace7)->where('semana',$semanahace7)->union($plantillasnow)->orderBy('archivado','asc')->orderBy('year','desc')->orderBy('semana','desc')->orderBy('zona','desc')->get();
    	}
    	return view('recaudacion.control',compact('plantillas'));
    }

    /**
     * Mostrar la plantilla para introducir recaudaciones o para consultarla
     */
    public function prepara(Request $request)
	{
		$this->validate($request, [
			'zona' => 'required',
			'fecha' => 'required|date',
			]);
        
        //calcular semana y año a partir de la fecha
		$fecha = $request->input('fecha');
		$semana_anterior = Carbon::parse($request->input('fecha'))->subWeek()->weekOfYear;
		$fecha = strtotime($fecha);
		$year = date('Y', $fecha);
		$semana = date ('W', $fecha);

		$semanaactual = date('W');
		$yearactual = date ('Y');
		$zona = $request->input('zona');

		//seleccionar plantillazona correspondiente
		$plantilla = PlantillaZona::
			where('semana', $semana)->
			where('year', $year)->
			where('zona', $zona)->first();
		
		// si no existe la plantilla y es la semana actual se crea. Si es una semana futura o pasada, mostrar error
		
		if ($plantilla === null) {

			$pendiente = 0;

			if (date('w', $fecha) == 1) {
			    $primerdiasemana = date('d M', $fecha);} // 1 es Lunes
			else {$primerdiasemana = date('d M', strtotime('previous monday', $fecha));}
			
			if (date('w', $fecha) == 0) {
			    $ultimodiasemana = date('d M', $fecha);}  // 0 es Domingo
			else {$ultimodiasemana = date('d M', strtotime('next sunday', $fecha));}

			if ($semanaactual == $semana && $yearactual == $year) {

				$plantilla = new PlantillaZona;
				$plantilla->semana = $semana;
				$plantilla->year = $year;
				$plantilla->zona = $zona;
				$plantilla->primerdia = $primerdiasemana;
				$plantilla->ultimodia = $ultimodiasemana;
				$plantilla->save();
				
				$maquinas = Maquina::activa()->where('zona', $zona)->get();
				// dd($maquinas);
				foreach ($maquinas as $maquina) {
					// dd($maquina->id);
					$plantilla_anterior = PlantillaZona::where('zona',$zona)->where('semana',$semana_anterior)->where('year',$year)->first()->id;

					// dd($plantilla_anterior);
					$linea_anterior = Linea::where('maquina_id',$maquina->id)->where('plantillazona_id',$plantilla_anterior)->first();
					$linea = new Linea;
					$linea->plantillazona_id = $plantilla->id;
					$linea->maquina_id = $maquina->id;
					$linea->maquina_nombre = $maquina->nombre;
					$linea->pendiente = $linea_anterior->acumular;
					$linea->usuario = Auth::user()->name;			
					$linea->save();		
				}

			}elseif ($semanaactual > $semana || $yearactual > $year) {
				// return back()->with('info','Revisa la fecha, en la semana de esa fecha no se introdujeron las recaudaciones');
//de momento para poder pasar datos de semanas pasadas
				$plantilla = new PlantillaZona;
				$plantilla->semana = $semana;
				$plantilla->year = $year;
				$plantilla->zona = $zona;
				$plantilla->primerdia = $primerdiasemana;
				$plantilla->ultimodia = $ultimodiasemana;
				$plantilla->save();
				
				$maquinas = Maquina::activa()->where('zona', $zona)->get();

				foreach ($maquinas as $maquina) {
					$linea = new Linea;
					$linea->plantillazona_id = $plantilla->id;
					$linea->maquina_nombre = $maquina->nombre;
					$linea->maquina_id = $maquina->id;
					$linea->usuario = Auth::user()->name;			
					$linea->save();
				}
//hasta aqui borrar cuando haya que desabilitar la posibilidad de crear plantillas pasadas
			}else {
				return back()->with('info','Revisa la fecha, no se pueden introducir datos de semanas futuras');
					
			}

			return redirect('detalle/'.$plantilla->id);			
		}

		/*como entonces existe, ir a la plantilla seleccionada. Pero si la plantilla es de la semana actual y está abierta, entonces comprobar si hay máquinas nuevas y añadirlas automáticamente y dar de baja las que no estén activas y el totalR sea 0.*/

		if ($semanaactual == $semana && $yearactual == $year && $plantilla->archivado == 0) {

			$maquinas = Maquina::activa()->where('zona', $zona)
				->whereNotIn('id', function($q) use($plantilla) {
					$q->select('maquina_id')->from('lineas')
					->where('plantillazona_id',$plantilla->id);
				})->get();

			if ($maquinas->count()>0){
				foreach ($maquinas as $maquina) {
					$linea = new Linea;
					$linea->plantillazona_id = $plantilla->id;
					$linea->maquina_id = $maquina->id;
					$linea->maquina_nombre = $maquina->nombre;
					$linea->usuario = Auth::user()->name;			
					$linea->save();		
				}
			}
			$bajas = Linea::where('plantillazona_id',$plantilla->id)->where('totalR',0)
				->whereNotIn('maquina_id', function($q) use($zona) {
					$q->select('id')->from('maquinas')
					->where('activa',1)->where('zona',$zona);
				})->delete();
		}
		return redirect('detalle/'.$plantilla->id);
	}

/**
 * Guarda datos de linea/s en la Base de Datos
 */	
	public function guarda_linea($request, $linea){
		//Monedas Real	
		$monedasR = 'monedasR'.$linea->id;		
		$linea->monedasR = $request[$monedasR];
		//Número de billetes
		$bv = 'bv-'.$linea->id;
		$bx = 'bx-'.$linea->id;
		$b2x = 'b2x-'.$linea->id;
		$bl = 'bl-'.$linea->id;
		$bc = 'bc-'.$linea->id;
		$linea->bv = $request[$bv];
		$linea->bx = $request[$bx];
		$linea->b2x = $request[$b2x];
		$linea->bl = $request[$bl];
		$linea->bc = $request[$bc];
		//Billetes
		$billetesR = 'billetesR'.$linea->id;
		$linea->billetesR = $request[$billetesR]; 
		//Pagos
		$pagos = 'pagos'.$linea->id;
		$pago1 = 'pago1I'.$linea->id;
		$pago2 = 'pago2I'.$linea->id;
		$concepto1 = 'pago1C'.$linea->id;
		$concepto2 = 'pago2C'.$linea->id;
		$descripcion1 = 'pago1D'.$linea->id;
		$descripcion2 = 'pago2D'.$linea->id;
		$linea->pagos = $request[$pagos];
		$linea->pago1 = $request[$pago1];
		$linea->pago2 = $request[$pago2];
		$linea->concepto1 = $request[$concepto1];
		$linea->concepto2 = $request[$concepto2];
		$linea->descripcion1 = $request[$descripcion1];
		$linea->descripcion2 = $request[$descripcion2];
		//Lectura
		$monedasL = 'monedasL'.$linea->id;
		$linea->monedasL = $request[$monedasL];
		$billetesL = 'billetesL'.$linea->id;
		$linea->billetesL = $request[$billetesL];
		//Acumular
		$acumular = 'acumular'.$linea->id;
		$linea->acumular = $request[$acumular];
		//Totales
		$totalR = 'totalR'.$linea->id;
		$linea->totalR = $request[$totalR];		
		$totalL = 'totalL'.$linea->id;
		$linea->totalL = $request[$totalL];		
		//Diferencias
		$diferencia = 'diferencia'.$linea->id;
		$linea->diferencia = $request[$diferencia];
		$descuadre = 'descuadre'.$linea->id;
		$linea->descuadre = $request[$descuadre];

		$linea->usuario = Auth::user()->name;					
		$linea->save();
	}

    public function guarda_totales($request, $plantilla){	
		// dd($request);
		$plantilla->monedasR = $request['columna_monedasR'];
		$plantilla->bv = $request['columna_bv'];
		$plantilla->bx = $request['columna_bx'];
		$plantilla->b2x = $request['columna_b2x'];
		$plantilla->bl = $request['columna_bl'];
		$plantilla->bc = $request['columna_bc'];
		$plantilla->billetesR = $request['columna_billetesR'];
		$plantilla->totalR = $request['columna_totalR'];
		$plantilla->pagos = $request['columna_pagos'];
		$plantilla->monedasL = $request['columna_monedasL'];
		$plantilla->billetesL = $request['columna_billetesL'];
		$plantilla->totalL = $request['columna_totalL'];
		$plantilla->diferencia = $request['columna_diferencia'];
		$plantilla->acumular = $request['columna_acumular'];
		$plantilla->descuadre = $request['columna_descuadre'];

		$plantilla->save();
    }
    
    public function guardar(Request $request, $linea_id, $plantilla_id) {
		
		$plantilla = PlantillaZona::where('id',$plantilla_id)->first();
		$request = $request->request->all();
		$request = str_replace(array('.', ','), array('', '.'), $request);		
	
	//Completar la plantilla
		if($linea_id=='Todas'){
			$lineas = Linea::where('plantillazona_id',$plantilla_id)->get();
			foreach ($lineas as $linea) {
				$this->guarda_linea($request, $linea);
			}
		    $yearAnterior = $plantilla->year - 1;

			$plantillaAnterior = PlantillaZona::where('semana',$plantilla->semana)->where('year',$yearAnterior)->where('zona',$plantilla->zona)->first();
			if ($plantillaAnterior === null) {
		    	$plantilla->totalAnterior = 0;
			}else {
				$plantilla->totalAnterior = $plantillaAnterior->totalR;
			} 
			$this->guarda_totales($request, $plantilla);	
			$plantilla->archivado = '1';
			$plantilla->save();

	//Guardar cambios
		}elseif ($linea_id == 'Algunas') {
			$lineas = Linea::where('plantillazona_id',$plantilla_id)->get();
			foreach ($lineas as $linea) {
				$this->guarda_linea($request, $linea);
		 	}
			$this->guarda_totales($request, $plantilla);
		}else{alert('opcion no posible');}
    }

    public function detallePlantilla($plantilla_id) {
    	$plantilla = PlantillaZona::where('id', $plantilla_id)->first();
		$lineas = Linea::where('plantillazona_id', $plantilla_id)->orderBy('maquina_nombre','asc')->get();
		return view('recaudacion.detallePlantilla', compact('plantilla', 'lineas'));		
    }

    public function modificarPlantilla($plantilla_id, $archivado){
    	$plantilla = PlantillaZona::where('id', $plantilla_id)->first();
    	$plantilla->archivado = $archivado;
    	$plantilla->save();

    }

}

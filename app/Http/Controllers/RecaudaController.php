<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use DB;
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

				foreach ($maquinas as $maquina) {
					$linea = new Linea;
					$linea->plantillazona_id = $plantilla->id;
					$linea->maquina_id = $maquina->id;
					$linea->maquina = $maquina->nombre;
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
					$linea->maquina = $maquina->nombre;
					$linea->usuario = Auth::user()->name;			
					$linea->save();
				}
//hasta aqui borrar cuando haya que desabilitar la posibilidad de crear plantillas pasadas
			}else {
				return back()->with('info','Revisa la fecha, no se pueden introducir datos de semanas futuras');
	
				
			}

			return redirect('detalle/'.$plantilla->id);			
		}

		//como entonces existe, ir a la plantilla seleccionada. Pero si la plantilla es de la semana actual y está abierta, entonces comprobar si hay máquinas nuevas y añadirlas automáticamente.

		if ($semanaactual == $semana && $yearactual == $year && $plantilla->estado == 0) {

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
					$linea->maquina = $maquina->nombre;
					$linea->usuario = Auth::user()->name;			
					$linea->save();		
				}
			}
			$bajas = Linea::where('plantillazona_id',$plantilla->id)->where('total',0)
				->whereNotIn('maquina_id', function($q) use($zona) {
					$q->select('id')->from('maquinas')
					->where('activa',1)->where('zona',$zona);
				})->delete();

		}
		//asimismo se borrarán las que ya no estén activas y no tengan introducidas recaudaciones

		//esto falta hacerlo

		return redirect('detalle/'.$plantilla->id);
	}

    /**
     * Guarda datos de linea/s en la Base de Datos
     */
    public function guardar(Request $request, $linea_id, $plantilla_id) {
		$plantilla = PlantillaZona::where('id',$plantilla_id)->first();
	
	//Completar la plantilla
		if($linea_id=='Todas'){
			$lineas = Linea::where('plantillazona_id',$plantilla_id)->get();
			foreach ($lineas as $linea) {
				$monedas = 'monedas'.$linea->id;
				$linea->monedas = $request->$monedas;
				
				$bv = 'bv-'.$linea->id;
				$bx = 'bx-'.$linea->id;
				$bxx = 'bxx-'.$linea->id;
				$bl = 'bl-'.$linea->id;
				$bc = 'bc-'.$linea->id;
				$linea->bv = $request->$bv;
				$linea->bx = $request->$bx;
				$linea->bxx = $request->$bxx;
				$linea->bl = $request->$bl;
				$linea->bc = $request->$bc;

				$billetes = 'billetes'.$linea->id;
				$linea->billetes = $request->$billetes;
				$total = 'totalR'.$linea->id;
				$linea->total = $request->$total;
				$monedasI = 'monedasI'.$linea->id;
				$linea->monedasI = $request->$monedasI;
				$billetesI = 'billetesI'.$linea->id;
				$linea->billetesI = $request->$billetesI;
				$totalI = 'totalI'.$linea->id;
				$linea->totalI = $request->$totalI;
				$diferencia = 'diferencia'.$linea->id;
				$linea->diferencia = $request->$diferencia;

				$linea->verificado = '1';
				$linea->save();

			}
		    $yearAnterior = $plantilla->year - 1;

			$plantillaAnterior = PlantillaZona::where('semana',$plantilla->semana)->where('year',$yearAnterior)->where('zona',$plantilla->zona)->first();
			if ($plantillaAnterior === null) {
		    $plantilla->totalAnterior = 0;
			}else {
			$plantilla->totalAnterior = $plantillaAnterior->total;
			} 
		
			$plantilla->total = $request->TOTALPlantilla;
			$plantilla->totalI = $request->TOTALPlantillaI;
			$plantilla->diferencia = $request->diferencia;
			$plantilla->archivado = '1';
			$plantilla->save();
	//Guardar cambios
		}elseif ($linea_id == 'Algunas') {

			$lineas = Linea::where('plantillazona_id',$plantilla_id)->where('verificado',0)->get();

			foreach ($lineas as $linea) {
				$monedas = 'monedas'.$linea->id;
				$linea->monedas = $request->$monedas;

				$bv = 'bv-'.$linea->id;
				$bx = 'bx-'.$linea->id;
				$bxx = 'bxx-'.$linea->id;
				$bl = 'bl-'.$linea->id;
				$bc = 'bc-'.$linea->id;

				$linea->bv = $request->$bv;
				$linea->bx = $request->$bx;
				$linea->bxx = $request->$bxx;
				$linea->bl = $request->$bl;
				$linea->bc = $request->$bc;


				$billetes = 'billetes'.$linea->id;
				$linea->billetes = $request->$billetes;
				$total = 'totalR'.$linea->id;
				$linea->total = $request->$total;
				$monedasI = 'monedasI'.$linea->id;
				$linea->monedasI = $request->$monedasI;
				$billetesI = 'billetesI'.$linea->id;
				$linea->billetesI = $request->$billetesI;
				$totalI = 'totalI'.$linea->id;
				$linea->totalI = $request->$totalI;
				if ($linea->total > 0 || $linea->totalI > 0){$linea->verificado = '1';}
				$diferencia = 'diferencia'.$linea->id;
				$linea->diferencia = $request->$diferencia;
				$linea->save();
			}
			$plantilla->total = $request->TOTALPlantilla;
			$plantilla->totalI = $request->TOTALPlantillaI;
			$plantilla->diferencia = $request->diferencia;
			$plantilla->save();

	//Validar una linea
		}else {

		$monedas = 'monedas'.$linea_id;
		
		$bv = 'bv-'.$linea_id;
		$bx = 'bx-'.$linea_id;
		$bxx = 'bxx-'.$linea_id;
		$bl = 'bl-'.$linea_id;
		$bc = 'bc-'.$linea_id;
		$bv = $request->$bv;
		$bx = $request->$bx;
		$bxx = $request->$bxx;
		$bl = $request->$bl;
		$bc = $request->$bc;
		$billetes = 'billetes'.$linea_id;
		$total = 'totalR'.$linea_id;		
		$monedasI = 'monedasI'.$linea_id;
		$billetesI = 'billetesI'.$linea_id;
		$totalI = 'totalI'.$linea_id;
		$verificado = 'verificado'.$linea_id;
		$diferencia = 'diferencia'.$linea_id;
		$monedas = $request->$monedas;
		$billetes = $request->$billetes;
		$total = $request->$total;		
		$monedasI = $request->$monedasI;
		$billetesI = $request->$billetesI;
		$totalI = $request->$totalI;
		$diferencia = $request->$diferencia;		
		$verificado = $request->$verificado;

		$linea= Linea::where('id', $linea_id)->first();
		$linea->monedas = $monedas;
		$linea->bv = $bv;
		$linea->bx = $bx;
		$linea->bxx = $bxx;
		$linea->bl = $bl;
		$linea->bc = $bc;
		$linea->billetes = $billetes;
		$linea->total = $total;		
		$linea->monedasI = $monedasI;
		$linea->billetesI = $billetesI;
		$linea->totalI = $totalI;
		$linea->diferencia = $diferencia;
		$linea->verificado = $verificado;
		$linea->save();

		$total = $request->TOTALPlantilla;
		$totalI = $request->TOTALPlantillaI;
		$diferencia = $request->diferencia;
		$plantilla->total = $total;
		$plantilla->totalI = $totalI;
		$plantilla->diferencia = $diferencia;
		$plantilla->save();
		}

    }

    public function detallePlantilla($plantilla_id) {
    	$plantilla = PlantillaZona::where('id', $plantilla_id)->first();
		$lineas = Linea::where('plantillazona_id', $plantilla_id)->orderBy('maquina','asc')->get();
		return view('recaudacion.detallePlantilla', compact('plantilla', 'lineas'));		
    }

    public function modificarPlantilla($plantilla_id, $archivado){
    	$plantilla = PlantillaZona::where('id', $plantilla_id)->first();
    	$plantilla->archivado = $archivado;
    	if($archivado == 0){
    		$plantilla->total = 0;
    	}
    	if($archivado == 1 && !empty($plantilla->totalprov)){
    		$plantilla->total = $plantilla->totalprov;
    	}
    	$plantilla->save();

    }

    // public function guardarTotalPlantilla($plantilla_id, $total){
    // 	$plantilla = PlantillaZona::where('id', $plantilla_id)->first();
    // 	$plantilla->total = $total;
    // 	$plantilla->save();
    // }




}

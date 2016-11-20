@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
<script src="{{asset('js/numeral.js')}}"></script>
<script src="{{asset('js/es-ES.js')}}"></script>

<link href="{{asset('css/nueva_entrada_datos.css')}}" media="all" rel="stylesheet" type="text/css" />

@section('content')

<div class="container">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">

    <div class="panel-heading"><h2>Semana {{$plantilla['semana']}}. {{$plantilla['primerdia']}} al {{$plantilla['ultimodia']}}  - {{$plantilla['zona']}} -</h2>
       @include('layouts.alerts')            
        <div class="row">
                <ol class="breadcrumb">
                    <li><a href="{{ url('control') }}">Listado</a></li>
                    <li><a href="{{ url('seleccionar') }}">Nueva Recaudacion</a></li>
                    @if ($plantilla->archivado == '0')
                    <li style="margin:0 0 0 20em;"><button class="btn-primary btn-xs btn-guardar" name="guardar">Guardar Cambios</button></li>
                    @endif
                </ol>
        </div>
    </div>

    <div class="panel-body">

<div class="st-wrap">
<table class="st-table" style="undefined;table-layout: fixed; width: 1005px">
<colgroup>
    <col style="width: 22px">
    <col class="ancho_maquina" style="width: 115px">
    <col class="ancho_pendiente" style="width: 66px">
    <col class="ancho_moneda real" style="width: 66px">
    <col class="ancho_5" style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col style="width: 31px">
    <col class="ancho_billete real" style="width: 50px">
    <col class="ancho_total real" style="width: 70px">
    <col style="width: 51px">
    <col class="ancho_moneda" style="width: 66px">
    <col class="ancho_billete" style="width: 50px">
    <col class="ancho_total" style="width: 70px">
    <col style="width: 66px">
    <col style="width: 66px">
    <col style="width: 66px">
    <col style="width: 67px">
</colgroup>
  <tr>
    <th class="st-vh0g" rowspan="2">#</th>
    <th class="st-ftxs" rowspan="2">Maquina</th>
    <th class="st-4und" colspan="10">Recaudacion</th>
    <th class="st-4und" colspan="3">Lectura</th>
    <th class="st-4und" colspan="3">Descuadres</th>
    <th class="st-il6h" rowspan="2"></th>
  </tr>
  <tr>
    <th class="st-14nr">Pdte.</th>
    <th class="st-y2da">Mon.</th>
    <th class="st-y2da ">5</th>
    <th class="st-y2da ">10</th>
    <th class="st-y2da ">20</th>
    <th class="st-y2da ">50</th>
    <th class="st-y2da ">100</th>
    <th class="st-y2da">Tot.Bill</th>
    <th class="st-y2da">TOTAL</th>
    <th class="st-14nr">Pag.</th>
    <th class="st-y2da">Mon.</th>
    <th class="st-y2da">Bill.</th>
    <th class="st-y2da">TOTAL</th>
    <th class="st-ltqa">Dif.</th>
    <th class="st-14nr">Acum.</th>
    <th class="st-14nr">Desc.</th>
  </tr>
    <?php $i = 1;?>
<!-- empiezan las lineas -->
    @foreach($lineas as $linea)
  <tr data-id="{{$linea->id}}">
    <td class="st-orden">{{ $i++ }}</td>
    <td class="st-maquina">{{$linea->maquina}}</td>
<!-- !!!!!!!está mal, hay que poner oculto -->
    <td class="st-pendiente"><input class="" name="pendiente{{$linea->id}}" type="text" value="{{number_format($linea->pendiente,2,',','.')}}"></td>
    <td class="st-entrada real">
<!-- entrada monedas real -->
    <input class="parcial_linea" id="monedasR-{{$linea->id}}" name="monedas{{$linea->id}}" type="text" pattern="^\d+(\.\d{1,2})?$" value="{{number_format($linea->monedas,2,',','.')}}"></td>
<!-- entrada billetes -->
    <td data-valor="5" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bv}}" name="bv-{{$linea->id}}"/></td>
    <td data-valor="10" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bx}}" name="bx-{{$linea->id}}"/></td>
    <td data-valor="20" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bxx}}" name="bxx-{{$linea->id}}"/></td>
    <td data-valor="50" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bl}}" name="bl-{{$linea->id}}"/></td>
    <td data-valor="100" name="bc-{{$linea->id}}" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bc}}" /></td>
<!-- suma billetes -->
    <td class="st-suma_billetes"><span class="" id="span-billetesR-{{$linea->id}}">{{number_format($linea->billetes,0,',','.')}}</span>
    <input class="parcial_linea" type="hidden" id="billetesR-{{$linea->id}}" name="billetesR{{$linea->id}}" value="{{number_format($linea->billetes,0,',','.')}}"></td>
<!-- total linea real -->
    <td class="st-total"><span class="" id="span-totalR-{{$linea->id}}">{{number_format($linea->total,2,',','.')}}</span><input  class="" type="hidden" id="" name="" value=""></td>
<!-- pagos -->
    <td class="st-entrada">{{number_format($linea->pagos,2,',','.')}}</td>
<!-- lectura -->
    <td class="st-entrada parcial_linea" id="monedasL-{{$linea->id}}">{{number_format($linea->monedasI,2,',','.')}}</td>
    <td class="st-entrada parcial_linea">{{number_format($linea->billetesI,2,',','.')}}</td>
    <td class="st-total">{{number_format($linea->totalI,2,',','.')}}</td>
    <td class="st-diferencia">{{number_format($linea->diferencia,2,',','.')}}</td>
    <td class="st-entrada">{{number_format($linea->acumular,2,',','.')}}</td>
    <td class="st-diferencia">{{number_format($linea->descuadre,2,',','.')}}</td>
<!-- botones -->
    <td class="st-vuu7">Validar</td>
  </tr>
    @endforeach
  <tr>
    <td class="st-bsv2"></td>
    <td class="st-ypb4">TOTALES</td>
    <td class="st-hv2l">720,00</td>
    <td class="st-dw4u">1.210,50</td>
    <td class="st-9vst"></td>
    <td class="st-9vst">20</td>
    <td class="st-9vst">1</td>
    <td class="st-my2k"></td>
    <td class="st-my2k"></td>
    <td class="st-c7at">220</td>
    <td class="st-85oi">1.110,50</td>
    <td class="st-l2oz">25,00</td>
    <td class="st-c7at">1.011,00</td>
    <td class="st-c7at">500</td>
    <td class="st-n1j6">1.510,00</td>
    <td class="st-n1j6">320,50</td>
    <td class="st-l2oz">320,00</td>
    <td class="st-n1j6">1,50</td>
    <td class="st-my2k"></td>
  </tr>
</table></div>

        @if ($plantilla->archivado == 0)     
        <div class="checkbox">
            <label>
                <input type="checkbox" name="completado" id="completado" value="1"> Ya están pasadas TODAS las recaudaciones
            </label>
            <button class="btn-primary btn-xs btn-danger btn-completar" name="completar">Completado!!</button>
        </div>
        @elseif($plantilla->archivado == 1)
        Ya completado!!
        @endif
    </div> <!-- Fin del panel body -->
 
 </div> <!-- Fin del panel default-->
</div>
</div>
</div>



@endsection
<script src="{{asset('js/tabla_entrada.js')}}"></script>

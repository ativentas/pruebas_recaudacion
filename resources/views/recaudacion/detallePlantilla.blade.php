@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
<script src="{{asset('js/numeral.js')}}"></script>
<script src="{{asset('js/es-ES.js')}}"></script>

<link href="{{asset('css/entrada_datos.css')}}" media="all" rel="stylesheet" type="text/css" />

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
<!-- pendiente -->
    <td class="st-pendiente"><span class="" id="span-pendiente-{{$linea->id}}">{{number_format($linea->pendiente,2,',','.')}}</span>
    <input data-signo = 1 class="subtotal_linea" type="hidden" id="pendiente-{{$linea->id}}" name="pendiente{{$linea->id}}"  value="{{number_format($linea->pendiente,2,',','.')}}"></td>
<!-- entrada monedas real --> 
<!-- Este fallaba para el punto de los miles: pattern="^[0-9]{1,4}([,][0-9]{1,2})?$" -->
<!-- También se puede borrar el pattern y entonces sale todo bien, lo único es que no hay límite de tamaño en la pantalla y no podré mostrar los errores (si es que lo voy a hacer) -->
    <td class="st-entrada real">
    <input class="parcial_linea real decimales" id="monedasR-{{$linea->id}}" name="monedas{{$linea->id}}" type="text" pattern="^([0-9]{1,2}\.)?([0-9]{1,3})([,][0-9]{1,2})?$" placeholder="monedas" value="{{number_format($linea->monedas,2,',','.')}}"></td>
<!-- entrada billetes -->
    <td data-valor="5" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bv}}" name="bv-{{$linea->id}}"/></td>
    <td data-valor="10" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bx}}" name="bx-{{$linea->id}}"/></td>
    <td data-valor="20" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bxx}}" name="bxx-{{$linea->id}}"/></td>
    <td data-valor="50" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bl}}" name="bl-{{$linea->id}}"/></td>
    <td data-valor="100" name="bc-{{$linea->id}}" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bc}}" /></td>
<!-- suma billetes -->
    <td class="st-suma_billetes"><span class="" id="span-billetesR-{{$linea->id}}">{{number_format($linea->billetes,0,',','.')}}</span>
    <input class="parcial_linea real" type="hidden" id="billetesR-{{$linea->id}}" name="billetesR{{$linea->id}}" value="{{number_format($linea->billetes,0,',','.')}}"></td>
<!-- total linea real -->
    <td class="st-total"><span class="" id="span-totalR-{{$linea->id}}">{{number_format($linea->total,2,',','.')}}</span>
    <input data-signo = 1 class="subtotal_linea" type="hidden" id="totalR-{{$linea->id}}" name="total{{$linea->id}}" value="{{number_format($linea->total,2,',','.')}}"></td>
<!-- pagos -->
    <td class="st-entrada">
    <input data-signo = 1 class="subtotal_linea decimales entradas_especiales" id="pagos-{{$linea->id}}" name="pagos{{$linea->id}}" type="text" pattern="^[0-9]{1,3}([,][0-9]{1,2})?$" value="{{number_format($linea->pagos,2,',','.')}}"></td>
<!-- lectura -->
    <td class="st-entrada">
    <input class="parcial_linea lectura decimales" id="monedasL-{{$linea->id}}" name="monedasI{{$linea->id}}" type="text" value="{{number_format($linea->monedasI,2,',','.')}}"></td>
    <td class="st-entrada">
    <input class="parcial_linea lectura" id="billetesL-{{$linea->id}}" name="billetesI{{$linea->id}}" type="text" value="{{number_format($linea->billetesI,0,',','.')}}"></td>
<!-- total linea Lectura -->
    <td class="st-total"><span class="" id="span-totalL-{{$linea->id}}">{{number_format($linea->totalI,2,',','.')}}</span>
    <input data-signo = -1 class="subtotal_linea" type="hidden" id="totalL-{{$linea->id}}" name="totalI{{$linea->id}}" value="{{number_format($linea->totalI,2,',','.')}}"></td>
<!-- Diferencias -->
    <td class="st-diferencia"><span class="rojo" id="span-diferencia-{{$linea->id}}">{{number_format($linea->diferencia,2,',','.')}}</span>
    <input class="subresultado" type="hidden" id="diferencia-{{$linea->id}}" name="diferencia{{$linea->id}}" value="{{number_format($linea->diferencia,2,',','.')}}"></td>
    <td class="st-entrada">
    <input class="entradas_especiales decimales" id="acumular-{{$linea->id}}" name="acumular{{$linea->id}}" type="text" pattern="^([0-9]{1,2}\.)?([0-9]{1,3})([,][0-9]{1,2})?$" value="{{number_format($linea->acumular,2,',','.')}}"></td>
    <td class="st-diferencia"><span class="rojo" id="span-descuadre-{{$linea->id}}">{{number_format($linea->descuadre,2,',','.')}}</span>
    <input  class="subresultado" type="hidden" id="descuadre-{{$linea->id}}" name="descuadre{{$linea->id}}" value="{{number_format($linea->descuadre,2,',','.')}}"></td>
<!-- botones -->
    <td class="st-vuu7">Validar</td>
  </tr>
    @endforeach
  <tr>
    <td class="st-my2k"></td>
    <td class="st-ypb4"><span>TOTALES</span></td>
    <td class="st-Total"><span></span></td>
    <td class="st-totalMonedas">1.210,50</td>
    <td class="st-billete"></td>
    <td class="st-billete">20</td>
    <td class="st-billete">1</td>
    <td class="st-billete"></td>
    <td class="st-billete"></td>
    <td class="st-billetes">220</td>
    <td class="st-Total">1.110,50</td>
    <td class="st-TotalVarios">25,00</td>
    <td class="st-totalMonedas">1.011,00</td>
    <td class="st-billetes">500</td>
    <td class="st-Total">1.510,00</td>
    <td class="st-Total">320,50</td>
    <td class="st-TotalVarios">320,00</td>
    <td class="st-Total">1,50</td>
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

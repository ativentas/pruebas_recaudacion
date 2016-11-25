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
    <div class="panel-heading">
    <div class="row">
    <div class="col-md-4"><span style="background-color: #800000; color: #ffffff; display: inline-block; margin:0px 5px 7px 5px ;padding: 3px 10px; font-weight: bold; border-top-left-radius: 5px; border-top-right-radius: 5px; border-bottom-right-radius: 5px; border-bottom-left-radius: 5px;">Semana {{$plantilla['semana']}} ({{$plantilla['primerdia']}} al {{$plantilla['ultimodia']}})</span></div><div style="margin:-2px 0px 0px 0px; color:#800000;font-weight:bold;font-size:22px;" class="col-md-offset-2 col-md-2">- {{$plantilla['zona']}} -</div>
    </div>
       @include('layouts.alerts')            
        <div class="row">
                <ol class="breadcrumb">
                    <li><a href="{{ url('control') }}">Volver a Listado</a></li>
                    <li><a href="#">Lunes</a></li>
                    <li><a href="#">Martes</a></li>
                    <li><a href="#">Mierc.</a></li>
                    <li><a href="#">Jueves</a></li>
                    <li><a href="#">Viernes</a></li>
                    <li><a href="#">Sábado</a></li>
                    <li><a href="#">Domingo</a></li>
                    <!-- <li><a href="{{ url('seleccionar') }}">Nueva Recaudacion</a></li> -->
                    @if ($plantilla->archivado == '0')
                    <li><button class="btn-success btn-xs btn-guardar" name="guardar">Guardar Cambios</button></li>
                    @endif
                </ol>
        </div>
    </div>

    <div class="panel-body">

<div class="st-wrap">
<form id="form_guardar" action="{{route('guardar',array('linea'=>':LINEA_ID','plantilla'=>$plantilla['id']))}}" method="POST"> 
{{csrf_field()}}

<table class="st-table" style="undefined;table-layout: fixed; width: 1005px;">
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
    <!-- <col style="width: 67px"> -->
</colgroup>
  <tr>
    <th class="st-vh0g" rowspan="2">#</th>
    <th class="st-ftxs" rowspan="2">Maquina</th>
    <th class="st-4und" colspan="10">Recaudacion</th>
    <th class="st-4und" colspan="3">Lectura</th>
    <th class="st-4und" colspan="3">Descuadres</th>
    <!-- <th class="st-il6h" rowspan="2"></th> -->
  </tr>
  <tr>
    <th class="st-14nr">Pdte.</th>
    <th class="st-y2da">Mon.</th>
    <th class="st-y2da ">5</th>
    <th class="st-y2da ">10</th>
    <th class="st-y2da ">20</th>
    <th class="st-y2da ">50</th>
    <th class="st-y2da ">100</th>
    <th class="st-y2da">Bill.</th>
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
  <tr id="tr-{{$linea->id}}" data-id="{{$linea->id}}">
    <td class="st-orden">{{ $i++ }}</td>
    <td class="st-maquina">{{$linea->maquina_nombre}}</td>
<!-- pendiente -->
    <td class="st-pendiente"><span class="" id="span-pendiente-{{$linea->id}}">{{number_format($linea->pendiente,2,',','.')}}</span>
    <input data-signo = 1 class="subtotal_linea pendiente" type="hidden" id="pendiente-{{$linea->id}}" name="pendiente{{$linea->id}}"  value="{{number_format($linea->pendiente,2,',','.')}}"></td>
<!-- entrada monedas real --> 
<!-- También se puede borrar el pattern y entonces sale todo bien, lo único es que no hay límite de tamaño en la pantalla y no podré mostrar los errores (si es que lo voy a hacer) -->
    <td class="st-entrada real">
    <input class="parcial_linea real decimales" id="monedasR-{{$linea->id}}" name="monedasR{{$linea->id}}" type="text" pattern="^([0-9]{1,2}\.)?([0-9]{1,3})([,][0-9]{1,2})?$" placeholder="monedas" value="{{number_format($linea->monedas,2,',','.')}}"></td>
<!-- entrada billetes -->
    <td data-valor="5" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bv}}" id="bv-{{$linea->id}}" name="bv-{{$linea->id}}"/></td>
    <td data-valor="10" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bx}}" id="bx-{{$linea->id}}" name="bx-{{$linea->id}}"/></td>
    <td data-valor="20" class="st-entrada"><input class="billetes" type='text' value="{{$linea->b2x}}" id="b2x-{{$linea->id}}" name="b2x-{{$linea->id}}"/></td>
    <td data-valor="50" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bl}}" id="bl-{{$linea->id}}" name="bl-{{$linea->id}}"/></td>
    <td data-valor="100" class="st-entrada"><input class="billetes" type='text' value="{{$linea->bc}}" id="bc-{{$linea->id}}" name="bc-{{$linea->id}}"/></td>
<!-- suma billetes -->
    <td class="st-suma_billetes"><span class="" id="span-billetesR-{{$linea->id}}">{{number_format($linea->billetes,0,',','.')}}</span>
    <input class="parcial_linea real" type="hidden" id="billetesR-{{$linea->id}}" name="billetesR{{$linea->id}}" value="{{number_format($linea->billetes,0,',','.')}}"></td>
<!-- total linea real -->
    <td class="st-total"><span class="" id="span-totalR-{{$linea->id}}">{{number_format($linea->total,2,',','.')}}</span>
    <input data-signo = 1 class="subtotal_linea totales" type="hidden" id="totalR-{{$linea->id}}" name="totalR{{$linea->id}}" value="{{number_format($linea->totalR,2,',','.')}}"></td>
<!-- pagos -->
    <td class="st-entrada">
    <!-- <input data-signo = 1 class="subtotal_linea decimales entradas_especiales" id="pagos-{{$linea->id}}" name="pagos{{$linea->id}}" type="text" pattern="^[0-9]{1,3}([,][0-9]{1,2})?$" value="{{number_format($linea->pagos,2,',','.')}}"></td> -->
    <span class="" id="span-pagos-{{$linea->id}}">{{number_format($linea->pagos,2,',','.')}}</span>
    <input data-signo = 1 class="subtotal_linea decimales entradas_especiales" type="hidden" id="pagos-{{$linea->id}}" name="pagos{{$linea->id}}" value="{{number_format($linea->pagos,2,',','.')}}"></td>
    <input type="hidden" name="pago1I{{$linea->id}}" id="pago1I-{{$linea->id}}" value="{{$linea->pago1}}">
    <input type="hidden" name="pago1C{{$linea->id}}" id="pago1C-{{$linea->id}}" value="{{$linea->concepto1}}">
    <input type="hidden" name="pago1D{{$linea->id}}" id="pago1D-{{$linea->id}}" value="{{$linea->concepto1}}">
    <input type="hidden" name="pago2I{{$linea->id}}" id="pago2I-{{$linea->id}}" value="{{$linea->pago2}}">
    <input type="hidden" name="pago2C{{$linea->id}}" id="pago2C-{{$linea->id}}" value="{{$linea->concepto2}}">
    <input type="hidden" name="pago2D{{$linea->id}}" id="pago2D-{{$linea->id}}" value="{{$linea->concepto2}}">

<!-- lectura -->
    <td class="st-entrada">
    <input class="parcial_linea lectura decimales" id="monedasL-{{$linea->id}}" name="monedasL{{$linea->id}}" type="text" value="{{number_format($linea->monedasL,2,',','.')}}"></td>
    <td class="st-entrada">
    <input class="parcial_linea lectura enteros" id="billetesL-{{$linea->id}}" name="billetesL{{$linea->id}}" type="text" value="{{number_format($linea->billetesL,0,',','.')}}"></td>
<!-- total linea Lectura -->
    <td class="st-total"><span class="" id="span-totalL-{{$linea->id}}">{{number_format($linea->totalI,2,',','.')}}</span>
    <input data-signo = -1 class="subtotal_linea totales" type="hidden" id="totalL-{{$linea->id}}" name="totalL{{$linea->id}}" value="{{number_format($linea->totalL,2,',','.')}}"></td>
<!-- Diferencias -->
    <td class="st-diferencia"><span class="rojo" id="span-diferencia-{{$linea->id}}">{{number_format($linea->diferencia,2,',','.')}}</span>
    <input class="subresultado totales" type="hidden" id="diferencia-{{$linea->id}}" name="diferencia{{$linea->id}}" value="{{number_format($linea->diferencia,2,',','.')}}"></td>
    <td class="st-entrada">
    <input class="entradas_especiales decimales" id="acumular-{{$linea->id}}" name="acumular{{$linea->id}}" type="text" pattern="^([0-9]{1,2}\.)?([0-9]{1,3})([,][0-9]{1,2})?$" value="{{number_format($linea->acumular,2,',','.')}}"></td>
    <td class="st-diferencia"><span class="rojo" id="span-descuadre-{{$linea->id}}">{{number_format($linea->descuadre,2,',','.')}}</span>
    <input  class="subresultado totales" type="hidden" id="descuadre-{{$linea->id}}" name="descuadre{{$linea->id}}" value="{{number_format($linea->descuadre,2,',','.')}}"></td>
<!-- botones y verificado -->
<!--     <td class="st-vuu7">
    @if ($plantilla->archivado == '0') 
    <button class="btn btn-success btn-xs btn-toggle" id="marcar-{{$linea->id}}" name="marcar{{$linea->id}}" type="button"</span>Marcar</button>
    <button class="btn btn-info btn-xs btn-toggle" id="desmarcar-{{$linea->id}}" name="desmarcar{{$linea->id}}" type="button" style="display:none;"></span>Desmarcar</button>
    @endif
    </td> -->
    <input type="hidden" id="marcado-{{$linea->marcado}}" name="marcado{{$linea->marcado}}">
  </tr>
    @endforeach
<!-- FOOT foot: ver si es mejor especificar el foot (yo creo que sí)-->
  <tr>
    <td class="st-my2k"></td>
    <td class="st-ypb4"><span>TOTALES</span></td>
    <td class="st-Total"><span id="span-columna_pendiente"></span><input id="columna_pendiente" type="hidden" name="columna_pendiente"></td>
<!-- FOOT: REAL -->
    <td class="st-totalMonedas"><span id="span-columna_monedasR">{{number_format($plantilla->monedasR,2,',','.')}}</span><input id="columna_monedasR" type="hidden" name="columna_monedasR" value="{{number_format($plantilla->monedasR,2,',','.')}}" ></td>
    <td class="st-billete"><span id="span-columna_bv">{{number_format($plantilla->bv,0,',','.')}}</span><input id="columna_bv" type="hidden" name="columna_bv" value="{{number_format($plantilla->bv,0,',','.')}}"></td>
    <td class="st-billete"><span id="span-columna_bx">{{number_format($plantilla->bx,0,',','.')}}</span><input id="columna_bx" type="hidden" name="columna_bx" value="{{number_format($plantilla->bx,0,',','.')}}"></td>
    <td class="st-billete"><span id="span-columna_b2x">{{number_format($plantilla->b2x,0,',','.')}}</span><input id="columna_b2x" type="hidden" name="columna_b2x" value="{{number_format($plantilla->b2x,0,',','.')}}"></td>
    <td class="st-billete"><span id="span-columna_bl">{{number_format($plantilla->bl,0,',','.')}}</span><input id="columna_bl" type="hidden" name="columna_bl" value="{{number_format($plantilla->bl,0,',','.')}}"></td>
    <td class="st-billete"><span id="span-columna_bc">{{number_format($plantilla->bc,0,',','.')}}</span><input id="columna_bc" type="hidden" name="columna_bc" value="{{number_format($plantilla->bc,0,',','.')}}"></td>
    <td class="st-billetes"><span id="span-columna_billetesR">{{number_format($plantilla->billetesR,0,',','.')}}</span><input id="columna_billetesR" type="hidden" name="columna_billetesR" value="{{number_format($plantilla->billetesR,0,',','.')}}"></td>
    <td class="st-Total"><span id="span-columna_totalR">{{number_format($plantilla->total,2,',','.')}}</span><input id="columna_totalR" type="hidden" name="columna_totalR" value="{{number_format($plantilla->total,2,',','.')}}"></td>
<!-- FOOT: PAGOS -->
    <td class="st-TotalVarios"><span id="span-columna_pagos">{{number_format($plantilla->pagos,2,',','.')}}</span><input id="columna_pagos" type="hidden" name="columna_pagos" value="{{number_format($plantilla->pagos,2,',','.')}}"></td>
<!-- FOOT: LECTURA -->
    <td class="st-totalMonedas"><span id="span-columna_monedasL">{{number_format($plantilla->monedasL,2,',','.')}}</span><input id="columna_monedasL" type="hidden" name="columna_monedasL" value="{{number_format($plantilla->monedasL,2,',','.')}}"></td>
    <td class="st-billetes"><span id="span-columna_billetesL">{{number_format($plantilla->billetesL,0,',','.')}}</span><input id="columna_billetesL" type="hidden" name="columna_billetesL" value="{{number_format($plantilla->billetesL,0,',','.')}}"></td>
    <td class="st-Total"><span id="span-columna_totalL">{{number_format($plantilla->totalI,2,',','.')}}</span><input id="columna_totalL" type="hidden" name="columna_totalL" value="{{number_format($plantilla->totalI,2,',','.')}}"></td>
    <td class="st-Total"><span class="rojo" id="span-columna_diferencia">{{number_format($plantilla->diferencia,2,',','.')}}</span><input id="columna_diferencia" type="hidden" name="columna_diferencia" value="{{number_format($plantilla->diferencia,2,',','.')}}"></td>
    <td class="st-TotalVarios"><span id="span-columna_acumular">{{number_format($plantilla->acumular,2,',','.')}}</span><input id="columna_acumular" type="hidden" name="columna_acumular" value="{{number_format($plantilla->acumular,2,',','.')}}"></td>
    <td class="st-Total"><span class="rojo" id="span-columna_descuadre">{{number_format($plantilla->descuadre,2,',','.')}}</span><input id="columna_descuadre" type="hidden" name="columna_descuadre" value="{{number_format($plantilla->descuadre,2,',','.')}}"></td>
    <!-- <td class="st-my2k"></td> -->

  </tr>
</table>
</form>

</div>

<!--Pagos Form -->
<div id="pagosdiv">
<h3>Pagos</h3>
<hr/>   
<table class="tg" style="undefined;table-layout: fixed; width: 353px">
<colgroup>
    <col style="width: 63px">
    <col style="width: 91px">
    <col style="width: 201px">
</colgroup>
  <tr>
    <th class="tg-0ord"><span>Importe</span></th>
    <th class="tg-031e"><span>Concepto</span></th>
    <th class="tg-031e"><span>Descripcion</span></th>
  </tr>
  <tr>
    <td class="tg-0ord"><input type="text" name="m_pago1I" id="m_pago1I" value=""></td>
    <td class="tg-031e"><input type="text" name="m_pago1C" id="m_pago1C" value=""></td>
    <td class="tg-031e"><input type="text" name="m_pago1D" id="m_pago1D" value=""></td>
  </tr>
  <tr>
    <td class="tg-0ord"><input type="text" name="m_pago2I" id="m_pago2I" value=""></td>
    <td class="tg-031e"><input type="text" name="m_pago2C" id="m_pago2C" value=""></td>
    <td class="tg-031e"><input type="text" name="m_pago2D" id="m_pago2D" value=""></td>
  </tr>
</table>

    <input type="button" id="aceptar" value="Aceptar"/>
</div>

        @if ($plantilla->archivado == 0)     
        <div class="checkbox">

                <input style="text-align:left;width:auto;margin:6px" type="checkbox" name="completado" id="completado" value="1"><span style="margin-left: 35px">Ya están pasadas TODAS las recaudaciones</span>

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
<script type="text/javascript" src="{{asset('js/tabla_entrada.js')}}"></script>

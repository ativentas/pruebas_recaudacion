@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
<style>
.tg td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#669;background-color:#e8edff;}
.tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:#aabcfe;color:#039;background-color:#b9c9fe;}
.table > tbody > tr > td, .table > tbody > tr > th, .table > tfoot > tr > td, .table > tfoot > tr > th, .table > thead > tr > td, .table > thead > tr > th {padding:5px !important;}
</style>
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
        <div class="row">

<form id="form_guardar" action="{{route('guardar',array('linea'=>':LINEA_ID','plantilla'=>$plantilla['id']))}}" method="POST"> 
{{csrf_field()}} 
        <table class="table table-striped tg">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width:10em;">Máquina</th>
                    <th>Mon.</th>
                    <th>5</th>
                    <th>10</th>
                    <th>20</th>
                    <th>50</th>
                    <th>100</th>
                    <th>Bill.</th>
                    <th>Total</th>
                    <th>Mon.</th>
                    <th>Bill.</th>
                    <th>Total</th>
                    <th>Dif.</th>

                </tr>
            </thead>

         
            <tbody>
            <?php $i = 1;?>
            @foreach($lineas as $linea)
                <tr data-id="{{$linea->id}}">
                    <th scope="row">{{ $i++ }}</th>
                    <td> {{ $linea->maquina }}</td>
                    <td>
                    <input class="dinero" type="number" min="0" max="9999" step="0.01" tabindex="" name="monedas{{$linea->id}}" pattern="[0-9]+([,\.][0-9][0-9])?" id="monedas{{$linea->id}}" size="" placeholder="" align="" value={{$linea->monedas}} style="width: 5em;" @if($linea->verificado==1) disabled @endif>
                    </td>
            <!-- billetes -->
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="1" tabindex="" name="bv-{{$linea->id}}" pattern="/d*" id="bv{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bv}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="1" tabindex="" name="bx-{{$linea->id}}" pattern="/d*" id="bx{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bx}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="1" tabindex="" name="bxx-{{$linea->id}}" pattern="/d*" id="bxx{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bxx}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="1" tabindex="" name="bl-{{$linea->id}}" pattern="/d*" id="bl{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bl}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="1" tabindex="" name="bc-{{$linea->id}}" pattern="/d*" id="bc{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bc}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="dinero" type="number" min="0" max="9999" step="5" tabindex="" name="billetes{{$linea->id}}" pattern="/d*" id="billetes{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetes}} style="width: 4em;" disabled readonly="true">
                    <!-- <input class="dinero" type="number" min="0" max="9999" step="5" tabindex="" name="billetes{{$linea->id}}" pattern="/d*" id="billetes{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetes}} style="width: 4em;" @if($linea->verificado==1) disabled @endif> -->
                    </td>
            <!-- fin billetes. Abajo total de la suma de monedas y billetes de la linea --> 
                    <td>
                    <label id="ltotal{{$linea->id}}">{{ number_format($linea->total,2,',','.')}}</label>
                    <input class="dinerototalR" type="hidden" id="totalR{{$linea->id}}" name="totalR{{$linea->id}}" value={{$linea->total}} >
                    </td>
            <!-- aquí van las recaudaciones que marcan las máquinas -->
                    <td>
                    <input class="dineroI" type="number" min="0" max="9999" step="0.01" tabindex="" name="monedasI{{$linea->id}}" pattern="[0-9]+([,\.][0-9][0-9])?" id="monedasI{{$linea->id}}" size="" placeholder="" align="" value={{$linea->monedasI}} style="width: 5em;" @if($linea->verificado=='1') disabled @endif>
                    </td>
                    <td>
                    <input class="dineroI" type="number" min="0" max="9999" step="5" tabindex="" name="billetesI{{$linea->id}}" pattern="/d*" id="billetesI{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetesI}} style="width: 4em;" @if($linea->verificado=='1') disabled @endif>
                    </td>                    
            <!-- totales por linea y diferencia -->
                    <td>
                    <label id="ltotalI{{$linea->id}}">{{ number_format($linea->totalI,2,',','.') }}</label>
                    <input class="dinerototal" type="hidden" id="totalI{{$linea->id}}" name="totalI{{$linea->id}}" value={{$linea->totalI}} >
                    </td>
                    <td>
                    <label class="signo" id="ldif{{$linea->id}}">{{ number_format($linea->diferencia,2,',','.')}}</label> 
                    <input class="" type="hidden" id="diferencia{{$linea->id}}" name="diferencia{{$linea->id}}" value={{$linea->diferencia}} >
                    </td>
            <!-- botones validar/modificar -->
                    <td>
                    @if ($plantilla->archivado == '0') 
                    <button class="btn btn-success btn-xs btn-validar" type="button" value={{$linea->id}} name="botonValidarLinea" id="validar{{$linea->id}}" @if($linea->verificado==1) style="display:none;" @endif></span>Validar
                    </button>
                    <button class="btn btn-info btn-xs btn-modificar" type="button" value={{$linea->id}} name="botonModificarLinea" id="modificar{{$linea->id}}" @if($linea->verificado=='0') style="display:none;" @endif></span>Modificar
                    </button>
                    @endif                     
                    </td>
            <!-- almacena el estado -->
                    <input type="text" id="verificado{{$linea->id}}" name="verificado{{$linea->id}}" value="{{$linea->verificado}}" style=display:none;">
                </tr>
            <script>
            $(document).ready(function() {

                $("#monedas{{$linea->id}}").change(function() {                              
                    var m = parseFloat($("#monedas{{$linea->id}}").val());
                    var b = parseFloat($("#billetes{{$linea->id}}").val());        
                    var sum = m + b;
                    var mI = parseFloat($("#monedasI{{$linea->id}}").val());
                    var bI = parseFloat($("#billetesI{{$linea->id}}").val());        
                    var sumI = mI + bI;
                    sumI = sumI.toFixed(2);
                    var dif = sum - sumI;
                    dif = dif.toFixed(2);
                    $("#ltotal{{$linea->id}}").text(sum);
                    $("#totalR{{$linea->id}}").val(sum);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                    $("#ldif{{$linea->id}}:contains('-')").attr('style','color:red');

                });
        // Cuando cambia el total de una linea de billetes.OK
                $("#billetes{{$linea->id}}").change(function() {   
                    var m = parseFloat($("#monedas{{$linea->id}}").val());
                    var b = parseFloat($("#billetes{{$linea->id}}").val());     
                    var sum = m + b;
                    sum = sum.toFixed(2);
                    var mI = parseFloat($("#monedasI{{$linea->id}}").val());
                    var bI = parseFloat($("#billetesI{{$linea->id}}").val())       
                    var sumI = mI + bI;
                    sumI = sumI.toFixed(2)
                    var dif = sum - sumI;
                    dif = dif.toFixed(2);
                    $("#ltotal{{$linea->id}}").text(sum);
                    $("#totalR{{$linea->id}}").val(sum);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                    $("#ldif{{$linea->id}}:contains('-')").attr('style','color:red');
                });                

                $("#monedasI{{$linea->id}}").change(function() {   
                    var mI = parseFloat($("#monedasI{{$linea->id}}").val());
                    var bI = parseInt($("#billetesI{{$linea->id}}").val());        
                    var sumI = parseFloat(mI + bI);
                    var m = parseFloat($("#monedas{{$linea->id}}").val());
                    var b = parseInt($("#billetes{{$linea->id}}").val());        
                    var sum = m + b;
                    sum = sum.toFixed(2);
                    var dif = sum - sumI;
                    dif = dif.toFixed(2);
                    $("#ltotalI{{$linea->id}}").text(sumI);
                    $("#totalI{{$linea->id}}").val(sumI);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                    $("#ldif{{$linea->id}}:contains('-')").attr('style','color:red');

                });

                $("#billetesI{{$linea->id}}").change(function() {   

                    var mI = parseFloat($("#monedasI{{$linea->id}}").val());
                    var bI = parseFloat($("#billetesI{{$linea->id}}").val());        
                    var sumI = mI + bI;   
                    var m = parseFloat($("#monedas{{$linea->id}}").val());
                    var b = parseFloat($("#billetes{{$linea->id}}").val());        
                    var sum = m + b;
                    sum = sum.toFixed(2);
                    var dif = sum - sumI;
                    dif = dif.toFixed(2);
                    $("#ltotalI{{$linea->id}}").text(sumI);
                    $("#totalI{{$linea->id}}").val(sumI);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                    $("#ldif{{$linea->id}}:contains('-')").attr('style','color:red');

                });      
            });

            </script>
            @endforeach
            </tbody>   
            <tfoot>
                <tr>
                <td colspan=9></td>
                <td><label id="lTOTAL">{{ $plantilla['total'] }}</label>
                <input form="form_guardar" type="hidden" id="TOTALPlantilla" name="TOTALPlantilla" value="{{$plantilla['total']}}" style="width: 4em;" readonly="readonly"></td>
                <td colspan=2></td>
                <td><label id="lTOTALI">{{ $plantilla['totalI'] }}</label>
                <input form="form_guardar" type="hidden" id="TOTALPlantillaI" name="TOTALPlantillaI" value="{{$plantilla['totalI']}}" readonly="readonly"></td>
                <td>
                <label class="signo" id="ldiferencia">{{ $plantilla['diferencia'] }}</label>
                <input form="form_guardar" type="hidden" id="diferencia" name="diferencia" value="{{$plantilla['diferencia']}}" style="width: 4em;" readonly="readonly">
                </td>
                </tr>
                
            </tfoot>
        </table>
</form>
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
        </div>
    </div>
</div>
</div>
</div>
</div>


<script>
$(document).ready(function() {
    


    // the following will select all 'label' elements with class "calculado"
    // if the label element has a '-', it will assign a style red.

    $("label.signo:contains('-')").attr('style','color:red');

    $('.btn-validar').click(function(e){

        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');
        $('#verificado'+id).val(1);
        var form = $('#form_guardar');
        var url = form.attr('action').replace(':LINEA_ID', id);
        $('#billetes'+id).prop('disabled', false);
        var data = form.serialize();
        $.post(url, data, function(){
        });

        $('#bv'+id).prop('disabled',true);
        $('#bx'+id).prop('disabled',true);
        $('#bxx'+id).prop('disabled',true);
        $('#bl'+id).prop('disabled',true);
        $('#bc'+id).prop('disabled',true);
        $('#billetes'+id).prop('disabled', true);
        $('#monedas'+id).prop('disabled', true);        
        $('#billetesI'+id).prop('disabled', true);
        $('#monedasI'+id).prop('disabled', true);

        $(this).hide();
        $(this).next().show(); 
    });

    $('.btn-guardar').click(function(e){
        e.preventDefault();
        var form = $('#form_guardar');
        var url = form.attr('action').replace(':LINEA_ID','Algunas'); 
        $('.dinero').prop('disabled', false);//para que envie todos los datos
        $('.billetes').prop('disabled', false);//para que envie todos los datos
        $('.dineroI').prop('disabled', false);//para que envie todos los datos
        var data = form.serialize();
        $.post(url, data, function(){
        }).done(function(){
            alert('cambios guardados');
            $(location).attr("href", '/detalle/{{$plantilla->id}}');

        });
        // $(location).attr("href", '/control');
    });

    $('.btn-completar').click(function(e){
        e.preventDefault();
        if ($('#completado').prop('checked') == false) {
            alert('Tienes que marcar primero para completar la plantilla');
            return;
        }
        $('.btn-validar').hide();
        $('.btn-modificar').hide();
        $('.btn-guardar').hide();
        var form = $('#form_guardar');
        var url = form.attr('action').replace(':LINEA_ID','Todas'); 
        $('.dinero').prop('disabled', false);//para que envie todos los datos 
        $('.billetes').prop('disabled', false);//para que envie todos los datos 
        $('.dineroI').prop('disabled', false);//para que envie todos los datos 
        var data = form.serialize();
        $.post(url, data, function(){
        }).done(function(){
            $(location).attr("href", '/control');
        });

        // $('.dinero').prop('disabled', true);//bloqueo todos. 
        // creo q la linea anterior no hace falta pq vuelvo a control


    });

    //PENDIENTE: NO TIENE SENTIDO QUE PASE TODOS LOS DATOS CUANDO SOLO QUIERO CAMBIAR EL VERIFICADO. 
    $('.btn-modificar').click(function(e){

        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');
        // en este caso hay que quitar el disabled antes del post para que pueda enviar los inputs
        $('#bv'+id).prop('disabled', false);
        $('#bx'+id).prop('disabled', false);
        $('#bxx'+id).prop('disabled', false);
        $('#bl'+id).prop('disabled', false);
        $('#bc'+id).prop('disabled', false);
        $('#billetes'+id).prop('disabled', false);
        $('#monedas'+id).prop('disabled', false);
        $('#billetesI'+id).prop('disabled', false);
        $('#monedasI'+id).prop('disabled', false);
        $('#verificado'+id).val(0);
        var form = $('#form_guardar');
        var url = form.attr('action').replace(':LINEA_ID', id);

        var data = form.serialize();       
        $.post(url, data, function(){
        });

        $(this).hide();
        $(this).prev().show(); 
    });
//cuando se introducen los datos de las monedas
    $('.dinero').change(function(){
        var sum = 0;
        $("input[name^='totalR']").each(function() {
        var value = $(this).val();
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);}
        });
        sum = sum.toFixed(2);        
        $('#TOTALPlantilla').val(sum);
        $('#lTOTAL').text(sum);
        var TOTALI = $('#TOTALPlantillaI').val();
        var dif = parseFloat(sum - TOTALI).toFixed(2);
        $('#ldiferencia').text(dif);
        $('#diferencia').val(dif);

    });
//cuando se introducen los datos de la lectura
    $('.dineroI').change(function(){
        var sum = 0;
        $("input[name^='totalI']").each(function() {
            var value = $(this).val();
            // add only if the value is number
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        sum = sum.toFixed(2);
        $('#TOTALPlantillaI').val(sum);
        $('#lTOTALI').text(sum);
        var TOTALR = parseFloat($('#TOTALPlantilla').val());
        var dif = parseFloat(TOTALR - sum).toFixed(2);
        $('#ldiferencia').text(dif);
        $('#diferencia').val(dif);

    });
//cuando se introducen los billetes
    $('.billetes').change(function(){
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var sum = 0;
        var termina = '-'+id;

        var valuebv = $('input[name=bv'+termina+']').val()*5;
        var valuebx = $('input[name=bx'+termina+']').val()*10;
        var valuebxx = $('input[name=bxx'+termina+']').val()*20;
        var valuebl = $('input[name=bl'+termina+']').val()*50;
        var valuebc = $('input[name=bc'+termina+']').val()*100;
        
        sum = valuebv + valuebx + valuebxx + valuebl + valuebc;
        sum = parseInt(sum);

        // $('input[name$='+termina+']').each(function(){
        //     var value =$(this).val();
        //     if(!isNaN(value) && value.length !=0) {
        //         sum += parseFloat(value);
        //     }
        // });

        $('#billetes'+id).val(sum).change();

    });


});    

</script>
@endsection

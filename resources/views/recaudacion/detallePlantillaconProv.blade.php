@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
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

<form id="form_guardarLinea" action="{{route('guardarLinea',array('linea'=>':LINEA_ID','plantilla'=>$plantilla['id']))}}" method="POST"> 
{{csrf_field()}} 
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Máquina</th>
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
                    <input class="dinero" type="number" min="0" max="999" step="1" tabindex="" name="monedas{{$linea->id}}" pattern="/d*" id="monedas{{$linea->id}}" size="" placeholder="" align="" value={{$linea->monedas}} style="width: 3em;" @if($linea->verificado==1) disabled @endif>
                    </td>
            <!-- billetes -->
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="5" tabindex="" name="bv-{{$linea->id}}" pattern="/d*" id="bv{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bv}} style="width: 4em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="10" tabindex="" name="bx-{{$linea->id}}" pattern="/d*" id="bx{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bx}} style="width: 4em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="20" tabindex="" name="bxx-{{$linea->id}}" pattern="/d*" id="bxx{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bxx}} style="width: 4em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="50" tabindex="" name="bl-{{$linea->id}}" pattern="/d*" id="bl{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bl}} style="width: 4em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="billetes" type="number" min="0" max="999" step="100" tabindex="" name="bc-{{$linea->id}}" pattern="/d*" id="bc{{$linea->id}}" size="" placeholder="" align="" value={{$linea->bc}} style="width: 4em;" @if($linea->verificado==1) disabled @endif>
                    </td>
                    <td>
                    <input class="dinero" type="number" min="0" max="9999" step="5" tabindex="" name="billetes{{$linea->id}}" pattern="/d*" id="billetes{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetes}} style="width: 4em;" disabled readonly="true">
                    <!-- <input class="dinero" type="number" min="0" max="9999" step="5" tabindex="" name="billetes{{$linea->id}}" pattern="/d*" id="billetes{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetes}} style="width: 4em;" @if($linea->verificado==1) disabled @endif> -->
                    </td>
            <!-- fin billetes -->
                    <td>
                    <label id="ltotal{{$linea->id}}">{{ $linea->total }}</label>
                    <input class="dinerototalR" type="hidden" id="totalR{{$linea->id}}" name="totalR{{$linea->id}}" value={{$linea->total}} >
                    </td>
            <!-- aquí van las recaudaciones que marcan las máquinas -->
                    <td>
                    <input class="dineroI" type="number" min="0" max="999" step="1" tabindex="" name="monedasI{{$linea->id}}" pattern="/d*" id="monedasI{{$linea->id}}" size="" placeholder="" align="" value={{$linea->monedasI}} style="width: 3em;" @if($linea->verificado=='1') disabled @endif>
                    </td>
                    <td>
                    <input class="dineroI" type="number" min="0" max="9999" step="5" tabindex="" name="billetesI{{$linea->id}}" pattern="/d*" id="billetesI{{$linea->id}}" size="" placeholder="" align="" value={{$linea->billetesI}} style="width: 4em;" @if($linea->verificado=='1') disabled @endif>
                    </td>                    
            <!-- totales por linea y diferencia -->
                    <td>
                    <label id="ltotalI{{$linea->id}}">{{ $linea->totalI }}</label>
                    <input class="dinerototal" type="hidden" id="totalI{{$linea->id}}" name="totalI{{$linea->id}}" value={{$linea->totalI}} >
                    </td>
                    <td>
                    <label id="ldif{{$linea->id}}">{{ $linea->diferencia }}</label>
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
                    var m = parseInt($("#monedas{{$linea->id}}").val(), 10);
                    var b = parseInt($("#billetes{{$linea->id}}").val(), 10);        
                    var sum = m + b;
                    var mI = parseInt($("#monedasI{{$linea->id}}").val(), 10);
                    var bI = parseInt($("#billetesI{{$linea->id}}").val(), 10);        
                    var sumI = mI + bI;
                    var dif = sum - sumI;
                    $("#ltotal{{$linea->id}}").text(sum);
                    $("#totalR{{$linea->id}}").val(sum);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                });

                $("#billetes{{$linea->id}}").change(function() {   
                    var m = parseInt($("#monedas{{$linea->id}}").val(), 10);
                    var b = parseInt($("#billetes{{$linea->id}}").val(), 10);        
                    var sum = m + b;
                    var mI = parseInt($("#monedasI{{$linea->id}}").val(), 10);
                    var bI = parseInt($("#billetesI{{$linea->id}}").val(), 10);        
                    var sumI = mI + bI;
                    var dif = sum - sumI;
                    $("#ltotal{{$linea->id}}").text(sum);
                    $("#totalR{{$linea->id}}").val(sum);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                });                

                $("#monedasI{{$linea->id}}").change(function() {   
                    var mI = parseInt($("#monedasI{{$linea->id}}").val(), 10);
                    var bI = parseInt($("#billetesI{{$linea->id}}").val(), 10);        
                    var sumI = mI + bI;
                    var m = parseInt($("#monedas{{$linea->id}}").val(), 10);
                    var b = parseInt($("#billetes{{$linea->id}}").val(), 10);        
                    var sum = m + b;
                    var dif = sum - sumI;
                    $("#ltotalI{{$linea->id}}").text(sumI);
                    $("#totalI{{$linea->id}}").val(sumI);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                });

                $("#billetesI{{$linea->id}}").change(function() {   
                    var mI = parseInt($("#monedasI{{$linea->id}}").val(), 10);
                    var bI = parseInt($("#billetesI{{$linea->id}}").val(), 10);        
                    var sumI = mI + bI;
                    var m = parseInt($("#monedas{{$linea->id}}").val(), 10);
                    var b = parseInt($("#billetes{{$linea->id}}").val(), 10);        
                    var sum = m + b;
                    var dif = sum - sumI;
                    $("#ltotalI{{$linea->id}}").text(sumI);
                    $("#totalI{{$linea->id}}").val(sumI);
                    $("#ldif{{$linea->id}}").text(dif);
                    $("#diferencia{{$linea->id}}").val(dif);
                });      
            });

            </script>
            @endforeach
            </tbody>   
            <tfoot>
                <tr>
                <td colspan=9></td>
                <td><label id="lTOTAL">{{ $plantilla['totalprov'] }}</label>
                <input form="form_guardarLinea" type="hidden" id="TOTALPlantilla" name="TOTALPlantilla" value="{{$plantilla['totalprov']}}" style="width: 4em;" readonly="readonly"></td>
                <td colspan=2></td>
                <td><label id="lTOTALI">{{ $plantilla['totalprovI'] }}</label>
                <input form="form_guardarLinea" type="hidden" id="TOTALPlantillaI" name="TOTALPlantillaI" value="{{$plantilla['totalprovI']}}" readonly="readonly"></td>
                <td>
                <label id="ldiferencia">{{ $plantilla['diferenciaprov'] }}</label>
                <input form="form_guardarLinea" type="hidden" id="diferencia" name="diferencia" value="{{$plantilla['diferenciaprov']}}" style="width: 4em;" readonly="readonly">
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
    $('.btn-validar').click(function(e){

        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');
        $('#verificado'+id).val(1);
        var form = $('#form_guardarLinea');
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
        var form = $('#form_guardarLinea');
        var url = form.attr('action').replace(':LINEA_ID','Algunas'); 
        $('.dinero').prop('disabled', false);//para que envie todos los datos
        $('.billetes').prop('disabled', false);//para que envie todos los datos
        $('.dineroI').prop('disabled', false);//para que envie todos los datos
        var data = form.serialize();
        $.post(url, data, function(){
        });
        $(location).attr("href", '/control');
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
        var form = $('#form_guardarLinea');
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
        var form = $('#form_guardarLinea');
        var url = form.attr('action').replace(':LINEA_ID', id);

        var data = form.serialize();       
        $.post(url, data, function(){
        });

        $(this).hide();
        $(this).prev().show(); 
    });

    $('.dinero').change(function(){
        var sum = 0;
        $("input[name^='totalR']").each(function() {
        var value = $(this).val();
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);}
        });        

        $('#TOTALPlantilla').val(sum);
        $('#lTOTAL').text(sum);
        var TOTALI = $('#TOTALPlantillaI').val();
        var dif = sum - TOTALI;
        $('#ldiferencia').text(dif);
        $('#diferencia').val(dif);

    });

    $('.dineroI').change(function(){
        var sum = 0;
        $("input[name^='totalI']").each(function() {
            var value = $(this).val();
            // add only if the value is number
            if(!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        $('#TOTALPlantillaI').val(sum);
        $('#lTOTALI').text(sum);
        var TOTALR = $('#TOTALPlantilla').val();
        var dif = TOTALR - sum;
        $('#ldiferencia').text(dif);
        $('#diferencia').val(dif);

    });

    $('.billetes').change(function(){
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var sum = 0;
        var termina = '-'+id;
        $('input[name$='+termina+']').each(function(){
            var value =$(this).val();
            if(!isNaN(value) && value.length !=0) {
                sum += parseFloat(value);
            }
        });
        $('#billetes'+id).val(sum).change();

    });


});    

</script>
@endsection
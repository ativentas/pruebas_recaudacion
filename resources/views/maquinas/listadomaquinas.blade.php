@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">

    <div class="panel-heading"><h2>Listado Máquinas</h2>
        @include('layouts.alerts')
        <div class="row">
        <ol class="breadcrumb">
            <li class="active"><a href="{{ url('maquinas') }}">Listado</a></li>
            <li><a href="{{ url('maquinas/create') }}">Nueva Maquina</a></li>
        </ol>
        </div>           
    </div>

    <div class="panel-body">
        <div class="col-md-8 row">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="prueba">Máquina</th>
                    <th>Zona</th>
                    <th>Estanco</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
     
            <tbody>
            <?php $i = 1;?>
            @foreach($maquinas as $maquina)
                <tr class="maquinas" data-id={{$maquina->id}}>
                    <th scope="row">{{ $i++ }}</th>
                    <td class="nombre">{{ $maquina->nombre }}</td>
                    <td class="zona">{{ $maquina->zona }}</td>
                    <td class="estanco">{{ $maquina->estanco }}</td>
                    <td></td>
                    <td></td>
                    <td> 
                    <button data-activa="1" class="btn btn-success btn-xs btn-activar" type="button" value={{$maquina->id}} name="botonActivarMaquina" id="activar{{$maquina->id}}" @if($maquina->activa==1) style="display:none;" @endif></span>Reactivar
                    </button>
                    <button data-activa="0" class="btn btn-danger btn-xs btn-baja" type="button" value={{$maquina->id}} name="botonBajaMaquina" id="baja{{$maquina->id}}" @if($maquina->activa == 0) style="display:none;" @endif></span>Dar de baja
                    </button>                   
                    </td>
                    <td>
                    <a class="btn btn-info btn-xs btn-modificar" href="{{ route('maquinas.edit',$maquina->id) }}">Modificar</a>
                    </td>
                </tr>

            @endforeach
            </tbody>
   
            <tfoot>
                <tr><td></td></tr>         
            </tfoot>
        </table>
        <form id="form_modificarEstadoMaquina" action="{{route('maquinas.update',[':MAQUINA_ID'])}}" method="POST">
        <input id="estado" name="estado" type="text" value="" class="hidden">
        <input id="nombre" name="nombre" type="text" value="" class="hidden">
        <input id="zona" name="zona" type="text" value="" class="hidden">
        <input id="estanco" name="estanco" type="text" value="" class="hidden">
        {{csrf_field()}}
        {{ method_field('PUT') }}        
        </form>
        </div>
    </div>
</div>
</div>
</div>
</div>


<script>
$(document).ready(function() {

    $('.btn-activar').click(function(e){
        e.preventDefault();

        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var form = $('#form_modificarEstadoMaquina');
        var url = form.attr('action').replace(':MAQUINA_ID', id);
        $('#estado').val(1);
        var nombre = ($(".maquinas[data-id='"+ id +"']>.nombre").text());
        var zona = ($(".maquinas[data-id='"+ id +"']>.zona").text());
        var estanco = ($(".maquinas[data-id='"+ id +"']>.estanco").text());
        // $('form input:eq(1)').val(1);
        $('form input:eq(2)').val(nombre);
        $('form input:eq(3)').val(zona);
        $('form input:eq(4)').val(estanco);

        var data = form.serialize();
        $.post(url, data, function(){
        });
        $(this).hide();
        $(this).next().show(); 
    });

    $('.btn-baja').click(function(e){

        e.preventDefault();
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var form = $('#form_modificarEstadoMaquina');
        var url = form.attr('action').replace(':MAQUINA_ID', id);
        $('#estado').val(0);
        var nombre = ($(".maquinas[data-id='"+ id +"']>.nombre").text());
        var zona = ($(".maquinas[data-id='"+ id +"']>.zona").text());
        var estanco = ($(".maquinas[data-id='"+ id +"']>.estanco").text());
        // $('form input:eq(1)').val(0);
        $('form input:eq(2)').val(nombre);
        $('form input:eq(3)').val(zona);
        $('form input:eq(4)').val(estanco);
        var data = form.serialize();
        $.post(url, data, function(){
        });

        $(this).hide();
        $(this).prev().show(); 
    });

});    

</script>
@endsection

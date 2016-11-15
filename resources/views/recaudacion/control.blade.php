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

    <div class="panel-heading"><h2>Listado Semanas</h2>
       @include('layouts.alerts')            
        <div class="row">
                <ol class="breadcrumb">
                    <li class="active"><a href="{{ url('control') }}">Listado</a></li>
                    <li><a href="{{ url('seleccionar') }}">Nueva Recaudacion</a></li>
                </ol>
        </div>   
    </div>

    <div class="panel-body">
        <div class="col-md-12 row">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Sem.</th>
                    <th>Año</th>
                    <th>Zona</th>
                    <th>Desde</th>
                    <th>Hasta</th>
                    <th>Total</th>
                    @if (Auth::user()->isAdmin())
                    <th>Anterior</th>
                    <th>dif.</th>
                    @endif
                    <th></th>
                    <th></th>
                </tr>
            </thead>
 <form id="form_guardarEstadoPlantilla" action="{{route('modificarPlantilla', [':PLANTILLA_ID',':ARCHIVADO'])}}" method="POST">
{{csrf_field()}}        
            <tbody>
            @foreach($plantillas as $plantilla)
                <tr data-id="{{$plantilla->id}}" @if ($plantilla->archivado==0) style="color:red;" @endif>
                    <th> {{ $plantilla->semana }} </th>
                    <th> {{ $plantilla->year }} </th>
                    <th> {{ $plantilla->zona }} </th>
                    <td> {{ $plantilla->primerdia }} </td>
                    <td> {{ $plantilla->ultimodia }} </td>
                    <td id="total{{$plantilla->id}}"> {{ number_format($plantilla->total)}} </td>
                    @if (Auth::user()->isAdmin())
                    <td> {{ number_format($plantilla->totalAnterior)}} </td>
                    <td> {{ $plantilla->diferencia}}</td>
                    @endif
            <!-- boton Editar -->
                    <td>
                    <a id="Editar{{$plantilla->id}}" class="btn {{($plantilla->archivado==0 ? ' btn-success ' : ' btn-info ')}} btn-xs btn-editar" href="{{ route('detallePlantilla',$plantilla->id) }}" style="width:6em">{{($plantilla->archivado==0 ? 'Ver/Editar' : 'Ver')}}</a>
                    </td>                    
                    <td>
            <!-- Oculto el botón de archivar, mejor usar el checkbox -->
                    <!-- <button data-archivado="1" class="btn btn-success btn-xs btn-archivar" type="button" value={{$plantilla->id}} name="botonArchivar" id="archivar{{$plantilla->id}}" @if($plantilla->archivado==1) style="display:none;" @endif></span>Archivar
                    </button> -->
            <!-- boton Desbloquear -->
                    @if (Auth::user()->isAdmin())
                    <button data-bloqueado="0" class="btn btn-warning btn-xs btn-desbloquear" type="button" value={{$plantilla->id}} name="botonModificarLinea" id="modificar{{$plantilla->id}}" @if($plantilla->archivado==0) style="display:none;" @endif></span>Desbloq.
                    </button>
                    @endif                      
                    </td>
            <!-- almacena el estado -->
                    <input type="text" id="archivado{{$plantilla->id}}" name="archivado{{$plantilla->id}}" value="{{$plantilla->archivado}}" style=display:none;">
                </tr>
            @endforeach
            </tbody>
</form>
        </table>
        </div>
    </div>
</div>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    $('.btn-archivar').click(function(e){

        e.preventDefault();
        $(this).hide();
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var archivado = $(this).data('archivado');
        $('#archivado'+id).val(1);
        var form = $('#form_guardarEstadoPlantilla');
        var url = form.attr('action').replace(':PLANTILLA_ID', id).replace(':ARCHIVADO',archivado);
        var data = form.serialize();
        var jqxhr = $.post(url, data, function(){
        }).done(function(){
            $(location).attr("href", '/control');
        });

    });

    $('.btn-desbloquear').click(function(e){

        e.preventDefault();
        $(this).hide();
        var fila = $(this).parents('tr');
        var id = fila.data('id');
        var bloqueado = $(this).data('bloqueado');
        $('#archivado'+id).val(0);
        var form = $('#form_guardarEstadoPlantilla');
        var url = form.attr('action').replace(':PLANTILLA_ID', id).replace(':ARCHIVADO', bloqueado);
        var data = form.serialize();

        var jqxhr = $.post(url, data, function(){       
        }).done(function(){
            $('#Editar'+id).removeClass('btn-info').addClass('btn-success');
            $('#Editar'+id).text('Ver/Editar');
            $('[data-id='+id+']').attr('style','color:red');
        })

    });

});    

</script>
@endsection

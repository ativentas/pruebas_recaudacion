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

    <div class="panel-heading"><h2>Informes Ventas</h2>
        @include('layouts.alerts')
        <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('control') }}">Home</a></li>
            <li class="active">Informes</li>
        </ol>
        </div>           
    </div>

    <div class="panel-body">

        <form method="post" action="{{url('ventas/crearInforme')}}"" class="form-inline">
                {{ csrf_field() }}
        <div class="form-group">
            <label for="centro" class="control-label"></label>
            <select class="form-control" id="centro" name="centro">
                <option value="">Elige Estanco/Zona</option>
                @foreach ($estancos as $estanco)
                <option value={{$estanco->nombre}}>{{$estanco->nombre}}</option>
                @endforeach                
                @foreach ($zonas as $zona)
                <option value={{$zona->nombre}}>{{$zona->nombre}}</option>
                @endforeach
            </select>
            @if ($errors->has('centro'))
                <span class="help-block">{{$errors->first('centro')}}</span>
            @endif
        </div>
        <div class="form-group">
            <label for="maquina" class="control-label"></label>
            <select class="form-control" id="maquina" name="maquina">
                <option value="0">Todas las Máquinas</option>
<!--                 @foreach ($maquinas as $maquina)
                <option value={{$maquina->nombre}}>{{$maquina->nombre}}</option>
                @endforeach -->
            </select>
            @if ($errors->has('maquina'))
                <span class="help-block">{{$errors->first('maquina')}}</span>
            @endif
        </div>

        <div class="form-group">
            <label for="periodo" class="control-label"></label>
            <select class="form-control" id="periodo" name="periodo">
                <option value="">Elige Periodo</option>
                <option value="semanal">por semanas</option>
                <option value="mensual">por meses</option>
            </select>
            @if ($errors->has('periodo'))
                <span class="help-block">{{$errors->first('periodo')}}</span>
            @endif
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-default">Ver</button>
        </div>

        </form>

    </div>
</div>
</div>
</div>
</div>


<script>
$(document).ready(function() {

});    

</script>
@endsection

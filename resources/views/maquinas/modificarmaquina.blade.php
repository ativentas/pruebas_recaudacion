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

<div class="panel-heading"><h2>Modificar Máquina</h2>
   @include('layouts.alerts')
    <div class="row">
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('maquinas') }}">Listado</a></li>
        <li class="active">Modificar Maquina</li>
    </ol>
    </div>            
</div>

<div class="panel-body">

    <div class="row col-md-5">
        <form autocomplete="off" class="form-vertical" role="form" method="POST" action="{{route('maquinas.update',$maquina->id)}}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
            <div class="form-group{{$errors->has('nombre') ? ' has-error' : ''}}">
                <label for="nombre" class="control-label">Nombre Máquina</label>
                <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombre" value="{{$maquina->nombre}}">
                @if ($errors->has('nombre'))
                    <span class="help-block">{{$errors->first('nombre')}}</span>
                @endif
            </div>          
            
            <div class="form-group{{$errors->has('zona') ? ' has-error' : ''}}">
                <label for="zona" class="control-label"></label>
                <select class="form-control" id="zona" name="zona">
                    <option {{$maquina->zona ==''?' selected':''}} value="">Elige la Zona</option>
                    @foreach ($zonas as $zona)
                    <option {{$maquina->zona ==$zona->nombre ?' selected':''}} value={{$zona->nombre}}>{{$zona->nombre}}</option>
                    @endforeach
                </select>
                @if ($errors->has('zona'))
                    <span class="help-block">{{$errors->first('zona')}}</span>
                @endif  
            </div>            

            <div class="form-group{{$errors->has('estanco') ? ' has-error' : ''}}">
                <label for="estanco" class="control-label"></label>
                <select class="form-control" id="estanco" name="estanco">
                    <option {{$maquina->estanco ==''?' selected':''}} value="">¿A qué Estanco?</option>
                    @foreach ($estancos as $estanco)
                    <option {{$maquina->estanco == $estanco->nombre ?' selected':''}} value={{$estanco->nombre}}>{{$estanco->nombre}}</option>
                    @endforeach
                </select>
                @if ($errors->has('estanco'))
                    <span class="help-block">{{$errors->first('estanco')}}</span>
                @endif 
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Modificar</button>
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

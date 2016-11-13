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

<div class="panel-heading"><h2>Añadir Máquina</h2>
   @include('layouts.alerts')
    <div class="row">
    <ol class="breadcrumb">
        <li class="active"><a href="{{ url('maquinas') }}">Listado</a></li>
        <li class="active">Nueva Maquina</li>
    </ol>
    </div>             
</div>

<div class="panel-body">

    <div class="row col-md-5">
        <form autocomplete="off" class="form-vertical" role="form" method="post" action="{{route('maquinas.store')}}">

            <div class="form-group{{$errors->has('nombre') ? ' has-error' : ''}}">
                <label for="nombre" class="control-label">Nombre Máquina</label>
                <input type="text" autocomplete="off" name="nombre" class="form-control" id="nombre" value="{{Request::old('nombre') ?: ''}}">
                @if ($errors->has('nombre'))
                    <span class="help-block">{{$errors->first('nombre')}}</span>
                @endif
            </div>          
            
            <div class="form-group{{$errors->has('zona') ? ' has-error' : ''}}">
                <label for="zona" class="control-label"></label>
                <select class="form-control" id="zona" name="zona">
                    <option {{Request::old('zona')==''?' selected':''}} value="">Elige la Zona</option>
                    @foreach ($zonas as $zona)
                    <option {{Request::old('zona')==$zona->nombre ?' selected':''}} value={{$zona->nombre}}>{{$zona->nombre}}</option>
                    @endforeach
                </select>
                @if ($errors->has('zona'))
                    <span class="help-block">{{$errors->first('zona')}}</span>
                @endif  
            </div>            

            <div class="form-group{{$errors->has('estanco') ? ' has-error' : ''}}">
                <label for="estanco" class="control-label"></label>
                <select class="form-control" id="estanco" name="estanco">
                    <option {{Request::old('estanco')==''?' selected':''}} value="">¿A qué Estanco?</option>
                    @foreach ($estancos as $estanco)
                    <option {{Request::old('es')==$estanco->nombre ?' selected':''}} value={{$estanco->nombre}}>{{$estanco->nombre}}</option>
                    @endforeach
                </select>
                @if ($errors->has('estanco'))
                    <span class="help-block">{{$errors->first('estanco')}}</span>
                @endif 
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-default">Crear</button>
            </div>
            <br><br>
            <input type="hidden" name="_token" value="{{Session::token()}}">
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

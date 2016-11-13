@extends('layouts.app')

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">
    <div class="panel-heading"><h2>Seleccionar Zona</h2>
        @include('layouts.alerts')
        <div class="row">
                <ol class="breadcrumb">
                    <li><a href="{{ url('control') }}">Listado</a></li>
                    <li class="active">Nueva Recaudacion</li>
                </ol>
        </div>
    </div>

    <div class="panel-body">
        <div class="col-md-4 row">
        <form role="form" action="{{url('/recaudar')}}" method="post">
            {{ csrf_field() }}
            <div class="form-group{{$errors->has('fecha') ? ' has-error' : ''}}">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" id="fecha" value={{date('d-m-Y')}}>
            @if ($errors->has('fecha'))
            <span class="help-block">{{$errors->first('fecha')}}</span>
            @endif
            </div>
   
            <div class="form-group{{$errors->has('zona') ? ' has-error' : ''}}">
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

            <button type="submit" class="btn btn-default">Entrar</button>
        </form>
        </div>
    </div>
</div>
</div>
</div>
</div>
@endsection

@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
<script src="{{asset('js/numeral.js')}}"></script>
<script src="{{asset('js/es-ES.js')}}"></script>

<link href="{{asset('css/diferencias.css')}}" media="all" rel="stylesheet" type="text/css" />
@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">

<div class="panel-heading"><h2>Pagos Comisiones</h2>
    @include('layouts.alerts')
    <div class="row">
    <ol class="breadcrumb">
        <li><a href="{{ url('control') }}">Home</a></li>
        <li class="active">Pagos Comisiones</li>
    </ol>
    </div>           
</div>

<div class="panel-body">

    <form method="get" action="{{url('pagos_comisiones')}}"" class="form-inline">
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
        <button type="submit" class="btn btn-default">Filtrar</button>
    </div>
    </form>

    <div>
    <table class="st-table" style="undefined;"">
    <colgroup>
        <col style="width: 22px">
        <col class="ancho_maquina" style="width: 115px">
@foreach ($semanas as $semana)
        <col class="ancho_semana" style="width: 65px">
@endforeach    
    </colgroup>
    <tr>
        <th class="st-4und">#</th>
        <th class="st-4und">Maquina</th>
@foreach ($semanas as $semana)
        <th class="st-4und">{{$semana}}</th>
@endforeach 
    </tr>
    <?php $i = 1;?>

@foreach ($pagos as $id => $pago)
    <tr>         
        <td class="st-orden">{{ $i++ }}</td>
        <td class="st-maquina">{{$pago->maquina}}</td>
        <td class="st-pago">{{number_format($pago->s1,2,',','.')}}</td>
        <td class="st-pago">{{number_format($pago->s2,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s3,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s4,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s5,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s6,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s7,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s8,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s9,2,',','.')}}</td>
        <td class="st-">{{number_format($pago->s10,2,',','.')}}</td>
    

    </tr>
@endforeach
    </table>
    </div>
</div> <!-- Fin Panel body -->

</div>
</div>
</div>
</div>




<script>
$(document).ready(function() {

});    

</script>
@endsection

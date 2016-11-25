@extends('layouts.app')
<script src="https://code.jquery.com/jquery-3.1.1.min.js"
integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
crossorigin="anonymous">
</script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

@section('content')
<div class="container">
<div class="row">
<div class="col-md-10 col-md-offset-1">
<div class="panel panel-default">

    <div class="panel-heading"><h2>Informe Ventas Semanales {{$zona}}</h2>
        @include('layouts.alerts')
<!--         <div class="row">
        <ol class="breadcrumb">
            <li><a href="{{ url('control') }}">Home</a></li>
            <li><a href="{{ url('ventas') }}">Informes</a></li>
            <li class="active">Informe</li>
        </ol>
        </div>   -->         
    </div>
    <div id="grafico" class="" style="height: 400px"></div>
    <div class="panel-body">
        <div class="col-md-10 row">

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Semana</th>
                    <th>Año</th>
                    <th>De</th>
                    <th>Hasta</th>
                    <th>Total</th>
                    <th>Anterior</th>
                    <th></th>
                </tr>
            </thead>
       
            <tbody>
            @foreach($plantillas as $plantilla)
                <tr data-id="{{$plantilla->id}}">
                    <th> {{ $plantilla->semana }} </th>
                    <th> {{ $plantilla->year }} </th>
                    <td> {{ $plantilla->primerdia }} </td>
                    <td> {{ $plantilla->ultimodia }} </td>
                    <td id="total{{$plantilla->id}}"> {{ number_format($plantilla->totalR)}} </td>
                    <td> {{ number_format($plantilla->totalAnterior)}} </td>
            <!-- boton Editar -->
                    <td>
                    <a id="Editar{{$plantilla->id}}" class="btn {{($plantilla->archivado==0 ? ' btn-success ' : ' btn-info ')}} btn-xs btn-editar" href="{{ route('detallePlantilla',$plantilla->id) }}" style="width:7em" target="_blank">{{($plantilla->archivado==0 ? 'Ver/Editar' : 'Ver')}}</a>
                    </td>                    
                    <td>
                </tr>
            @endforeach
            </tbody>

        </table>
        </div>


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
<script type="text/javascript">
  var semanal = <?php echo $semanal; ?>;
  console.log(semanal);
  google.charts.load('current', {'packages':['corechart','bar']});
  google.charts.setOnLoadCallback(drawChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable(semanal);
    data.sort([{column: 0}]);
    var options = {
      title: 'Ventas Ultimas Semanas',
      curveType: 'function',
      legend: { position: 'bottom' }
    };
    var chart = new google.visualization.ColumnChart(document.getElementById('grafico'));
    chart.draw(data, options);
      }
</script>

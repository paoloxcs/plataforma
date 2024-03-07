@extends('layouts.app')
@section('content')
<div class="container">
	@if(session('msg-denny'))
	<div class="alert alert-danger alert-dismissible" role="alert">
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	  {{session('msg-denny')}}
	</div>
	@endif
  <ol class="breadcrumb">
    <li class="breadcrumb-item active">
      <i class="fa fa-list-ol"></i> Dashboard
    </li>
  </ol>
    <div class="row">
      <div class="col-xs-12 col-md-9">
        {{-- <div id="donutchart" style="width: 100%; height: 270px;"></div>
        <div id="donutchart2" style="width: 100%; height: 270px;"></div> --}}
        <div id="donutchart"></div>
        <div id="donutchart2"></div>
        <h4><span id="text-dinamyc"></span> <small>(en la Plataforma)</small> <i class="fa fa-arrow-down"></i></h4>
        <div class="table-responsive">
          <table style="font-size: 11px;" class="table table-hover table-striped table-condensed table-bordered">
            <thead>
              <th><button onclick="getLogs();" title="Actualizar Historial" class="btn btn-warning btn-sm"><i class="fa fa-history"></i></button></th>
              <th>Usuario</th>
              <th>Acción</th>
              <th>Fecha</th>
            </thead>
            <tbody id="logs">
            </tbody>
          </table>
        </div>
        <div class="row">
          <div class="col-xs-12 col-md-5">
            <div class="input-group custom-pagination"></div>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-3">
        <h4>Acceso rápido</h4>
        <ul class="list-group">
          <li class="list-group-item"><a href="{{route('subscribers.free')}}">Suscripción Gratis</a> <span class="badge">{{$users->where('role_id','=',7)->count()}}</span></li>
          <li class="list-group-item"><a href="{{route('subscribers.premium')}}">Suscripción Premium</a> <span class="badge">{{$users->where('role_id','=',2)->count()}}</span></li>
          <li class="list-group-item"><a href="{{route('clientes.index')}}">Clientes</a> <span class="badge">{{$users->where('role_id','=',5)->count()}}</span></li>
          @if(Auth()->user()->rolesSuscripcion())
            <li class="list-group-item"><a href="{{route('users.asignations')}}">Mi bandeja</a> <span class="badge">{{Auth()->user()->myAsignations->count()}}</span></li>
          @endif
        </ul>
      </div>

      
    </div>
    <hr>

@endsection

@section('extra_scripts')
<!--Load the AJAX API-->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
{{-- <script type="text/javascript">
    var donutchart = document.getElementById("donutchart");
    var donutchart2 = document.getElementById("donutchart2");
    donutchart.setAttribute("style", "width: 100%; height: 270px;");
    donutchart2.setAttribute("style", "width: 100%; height: 270px;");
            
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      google.charts.setOnLoadCallback(drawEjecutivos);
      function drawChart() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Roles');
          data.addColumn('number', 'Cantidad');
          data.addRows([
            @foreach($roles as $index => $role)
              ['{{$role->name}}', {{count($role->users)}}],
            @endforeach
              ]);
        

        var options = {
          title: 'Usuarios por cada Rol',
          tooltip: {trigger: 'selection'},
          pieHole: 0.2,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
      function drawEjecutivos() {
        var data = new google.visualization.DataTable();
          data.addColumn('string', 'Ejecuitivos');
          data.addColumn('number', 'Cantidad');
          data.addRows([
            @foreach($ejecutivos as $index => $eje)
              ['{{$eje->nombres}}', {{$eje->clientes->count()}}],
            @endforeach
              ]);
        

        var options = {
          title: 'Clientes de ejecutivos',
          tooltip: {trigger: 'selection'},
          pieHole: 0.2,
        };

        var chart = new google.visualization.PieChart(document.getElementById('donutchart2'));
        chart.draw(data, options);
      }
    </script> --}}
<script type="text/javascript">
  $(document).ready(function(){
    getLogs();
  });
  let props = {
    ruta: '',
    tbLogs : $("#logs"),
    title : $("#text-dinamyc"),
  }
  function getLogs() {
    props.ruta = '/panel/logs-data';
    props.title.text('Actualizando...');
    $.ajax({
      url: props.ruta,
      type: 'GET',
      dataType: 'JSON',
      timeout: 3000,
      success: res =>{
        props.tbLogs.empty();
         props.title.text('Ultimos 10 eventos');
        res.forEach(log =>{
          props.tbLogs.append(`
              <tr>
                <td><i class="fa fa-check"></i></td>
                <td><span title="${log.user.name} ${log.user.last_name}">${log.user.name} <small>(${log.user.role.name})</small></span> &nbsp;<i class="fa fa-arrow-right"></i></td>
                <td><p title="${log.user.name} ${log.body}">${getLimitText(log.body)}<p></td>
                <td>${dateFormatFull(log.created_at)}</td>
              </tr>
            `);
        });
        
      },
      error: error =>{
        console.log(error);
      }
    });
  }

  function getLimitText(str) {
    let str_limit = '';
    if(str.length > 70){
      str_limit = `${str.substr(0,70)}...`;
    }else{
      str_limit = str;
    }
    return str_limit;
  }

</script>
@endsection

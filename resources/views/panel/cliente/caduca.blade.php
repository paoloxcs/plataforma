@extends('layouts.app')
@section('titulo','Lista de Clientes por caducar')
@section('menu')
<li><a href="{{route('gestor_suscripcion')}}"><i class="fa fa-list" aria-hidden="true"></i> Gestor de Suscripción</a></li>
<li><a href="{{route('clientes.index')}}"><i class="fa fa-list" aria-hidden="true"></i> Lista de Clientes</a></li>
@endsection
@section('content')
<script>
	
	function buscar() {
		var text = $("#texto").val();
		var ruta = "{{url('searchClientcaduco')}}/"+text;
		$.get(ruta,function(res){
			$("#datos").empty();
			if ($(res).length > 0) {
			$(res).each(function(key,value){
				$("#datos").append("<tr><td>"+value.nombres+"</td><td>"+value.email+"</td><td>"+value.telefono+"</td><td>"+value.medio+"</td><td>"+value.password+"</td><td>"+value.caducidad+"</td><td>"+value.user_id+"</td><td>"+value.tipo+"</td><td><a href='/clientes/"+value.idsuscriptor+"/edit' class='btn btn-info btn-sm'>Editar</a></td></tr>");
			});
			}else{
				$("#datos").append("<span>Busqueda sin resultados</span>");
			}
		});
	}
</script>
<div class="container-fluid">
@include('alerts.success')
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Lista de Clientes</div>
		</div>
		<div class="panel-body">
			{{-- Inicio de modal --}}
				<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
				  <div class="modal-dialog modal-lg" role="document">
				  
				    <div class="modal-content">
				      <div class="modal-header">
				      	<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				      	       <h4 class="modal-title" id="gridSystemModalLabel">Búsquda dinámica</h4>
				      </div>
				      <div class="modal-body"> 
				      <form  id="formulario" method="POST">
						<div class="col-lg-12">
						      <input type="text" id="texto" onkeyup="buscar();" class="form-control" placeholder="Buscar por: Nombres, Correo o Teléfono">
						      
						  </div><!-- /.col-lg-12 -->
				      </form>	
				      <hr>
				      <div class="table-responsive">
				      	<table class="table table-condensed table-hover">
				      		<thead>
				      			<th>Nombres y Apellidos</th>
				      			<th>Email</th>
				      			<th>Teléfono</th>
				      			<th>Medio</th>
				      			<th>Contraseña</th>
				      			<th>Caducidad</th>
				      			<th>Suscrito por</th>
				      			<th>Tipo</th>
				      			<th>Control</th>
				      		</thead>
				      		<tbody id="datos">
				      			
				      		</tbody>
				      	</table>
				      </div>
				      </div>
				      <div class="modal-footer">  	
		      	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				      </div>
				    </div>
				    
				  </div>
				</div>
			{{-- Fin de modal --}}
			<div class="col-md-4 col-md-offset-6">
				
				<button type="button" class="btn btn-success" data-toggle="modal" data-target=".bs-example-modal-lg">Buscador <i class="fa fa-search" aria-hidden="true"></i></button>

			</div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Nombres y Apellidos</th>
						<th>Correo electrónico</th>
						<th>Teléfono</th>
						<th>Medio</th>
						<th>Contraseña</th>
						<th>F. Suscripción</th>
						<th>Caducidad</th>
						{{-- <th>Suscrito por</th> --}}
						<th>Ejecutivo</th>
						<th>Control</th>
					</thead>
					@foreach($clientes as $cliente)
					<tbody>
						<td>{{$cliente->visitante->nombres}}</td>
						<td>{{$cliente->visitante->email}}</td>
						<td>{{$cliente->visitante->telefono}}</td>
						@if($cliente->visitante->medio =="RC")
						<td class="danger">{{$cliente->visitante->medio}}</td>
						@elseif($cliente->visitante->medio =="TM")
						<td class="info">{{$cliente->visitante->medio}}</td>
						@else
						<td class="success">{{$cliente->visitante->medio}}</td>
						@endif
						
						<td>{{$cliente->password}}</td>
						<td>{{date("d/m/Y g:ia",strtotime($cliente->fecha_suscripcion))}}</td>
						<td>{{$cliente->caducidad}}</td>
						{{-- <td>{{$cliente->user->name}} {{$cliente->user->last_name}}</td> --}}
						<td>{{$cliente->ejecutivo->nombres}} {{$cliente->ejecutivo->apellidos}}</td>
						<td>
							<a href="{{route('clientes.edit',$cliente->idsuscriptor)}}" class="btn btn-info btn-sm">Editar</a>
							
							<a href="{{route('subscribers.destroy',$cliente->visitante->idvisitante)}}" onclick="return confirm('¿Está seguro de eliminar el registro?');" class="btn btn-danger btn-sm">Eliminar</a>
						</td>
					</tbody>
					@endforeach
				</table>
			</div>
			{!! $clientes->render()!!}
				
		</div>
	</div>
</div>
@endsection
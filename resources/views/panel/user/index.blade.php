@extends('layouts.app')
@section('titulo','Usuarios')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<i class="fa fa-list-ol"></i> Usuarios
		</li>
	</ol>
	@include('alerts.success')
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2 pull-right">
					<a href="{{route('users.create')}}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>
				</div>
			</div>
			
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Nombres y Apellidos</th>
						<th>Correo</th>
						<th>Rol</th>
						<th>Control</th>
					</thead>
					@foreach($users as $user)
						<tbody>
							<td>{{$user->fullName()}}</td>
							<td>{{$user->email}}</td>
							<td>{{$user->role}}</td>
							<td>
								<a href="{{route('users.edit',$user->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
								@if(Auth::User()->id != $user->id)
								<a href="{{route('users.destroy',$user->id)}}" onclick="return confirm('ADVERTENCIA\n¿Seguro de eliminar el registro?');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</a>
								@else
								<span>Sesión Activa</span>
								@endif
							</td>
						</tbody>
						
					@endforeach
				</table>
			</div>
			{!!$users->render('layouts.pagination')!!}
		</div>
	</div>
</div>
@endsection
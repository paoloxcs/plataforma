@extends('layouts.app')
@section('titulo','Usuarios en linea')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<i class="fa fa-list-ol"></i> Usuarios en Linea
		</li>
	</ol>
	@include('alerts.success')
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Nombres y Apellidos</th>
						<th>Correo</th>
						<th>Rol</th>
						<th>Control</th>
					</thead>
					@foreach($users as $user)
					@if($user->isOnline())
					<tbody>
						<td>{{$user->fullName()}}</td>
						<td>{{$user->email}}</td>
						<td>{{$user->role->name}}</td>
						<td>
						</td>
					</tbody>
					@endif
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>
@endsection
@extends('layouts.app')
@section('titulo','Ejecutivos')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<i class="fa fa-list-ol"></i> Ejecutivos
		</li>
	</ol>
	@include('alerts.success')
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="row">
				<div class="col-md-2 pull-right">
					<a href="{{route('ejecutivos.create')}}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Id</th>
						<th>Nombres y Apellidos</th>
						<th>Control</th>
					</thead>
					@foreach($ejecutivos as $eje)
					<tbody>
						<td>{{$eje->idejecutivo}}</td>
						<td>{{$eje->nombres}} {{$eje->apellidos}}</td>
						<td>
							<a href="{{route('ejecutivos.edit',$eje->idejecutivo)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
							<a href="{{route('ejecutivos.destroy',$eje->idejecutivo)}}" onclick="return confirm('ADVERTENCIA\n¿Seguro de eliminar el registro?');" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</a>
						</td>
					</tbody>
					@endforeach
				</table>
			</div>
			{!! $ejecutivos->render('layouts.pagination')!!}
		</div>
	</div>
</div>
@endsection
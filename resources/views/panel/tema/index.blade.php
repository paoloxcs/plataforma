@extends('layouts.app')
@section('titulo','Temas del Curso')
@section('content')
	<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading float-left">
			<div class="panel-title font-weight-bold h5">Curso: <span class=" text-primary"><a href="{{route('cursos')}}">{{$curso->titulo}}</a></span></div>
		</div>
		<div class="panel-body">
			<div class="col-md-1.5 col-md-offset-10 float-right">
				<button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-plus"></i> Nuevo tema</button>
			</div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<th>Id</th>
						<th>Descripción</th>
						<th>Fecha Registro</th>
						<th>Control</th>
					</thead>
					@foreach($temas as  $tema)
					<tbody>
						<td>{{$tema->id}}</td>
						<td>{{$tema->descripcion}}</td>
						<td>{{date("d/m/Y g:ia", strtotime($tema->created_at))}}</td>
						<td width="200">
							<a href="{{route('tema.editar',$tema->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
							<a href="{{route('tema.delete',$tema->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
						</td>
					</tbody>
								@endforeach
							</table>
						</div>
						{!! $temas->render() !!}
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
@include('panel.tema.create')
@endsection


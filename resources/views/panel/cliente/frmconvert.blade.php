@extends('layouts.app')
@section('titulo','Convertir a cliente')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="#" onclick="history.back();"><i class="fa fa-arrow-left"></i> Volver</a>
		</li>
		<li class="breadcrumb-item active">
			<i class="fa fa-pencil"></i> Convertir a cliente
		</li>
	</ol>
	<div class="panel panel-success">
		<div class="panel-body">
			<form action="{{route('convertoclient',$user->id)}}" method="POST">
			{{csrf_field()}}
			{{ method_field('PUT') }}

				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="row">
							<dic class="col-xs-12 col-md-6">
								<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
									<label for="nombres">Nombres</label>
									<input type="text" name="name" class="form-control" placeholder="Ingrese nombres" value="{{old('name',$user->name)}}" disabled>
									@if ($errors->has('name'))
									    <span class="help-block">
									        <strong>{{ $errors->first('name') }}</strong>
									    </span>
									@endif
								</div>
							</dic>
							<dic class="col-xs-12 col-md-6">
								<div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
									<label for="last_name">Apellidos</label>
									<input type="text" name="last_name" class="form-control" placeholder="Ingrese apellidos" value="{{old('last_name',$user->last_name)}}" disabled>
									@if ($errors->has('last_name'))
									    <span class="help-block">
									        <strong>{{ $errors->first('last_name') }}</strong>
									    </span>
									@endif
								</div>
							</dic>
						</div>
						<div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email">Correo electrónico</label>
							<input type="email" name="email" class="form-control" placeholder="Ingrese correo electrónico" value="{{old('email',$user->email)}}" disabled>
							@if ($errors->has('email'))
							    <span class="help-block">
							        <strong>{{ $errors->first('email') }}</strong>
							    </span>
							@endif
						</div>
						
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="row">
							
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="ejecutivo">Seleccione Ejecutivo</label>
									<select name="ejecutivo" id="ejecutivo" class="form-control">
										@foreach($ejecutivos as $eje)
											<option value="{{$eje->idejecutivo}}">{{$eje->nombres}} {{$eje->apellidos}}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="medio">Medio</label>
									<select name="medio" class="form-control">
										<option value="RC">RC</option>
										<option value="DA">DA</option>
										<option value="TM">TM</option>
									</select>
								</div>
							</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="ejecutivo">Empresa</label>
								<input type="text" name="empresa" class="form-control" placeholder="Nombre de empresa">
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="form-group">
						<button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
						<a href="#" class="btn btn-default" onclick="history.back();"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
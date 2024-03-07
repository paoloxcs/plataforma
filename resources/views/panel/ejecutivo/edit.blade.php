@extends('layouts.app')
@section('titulo','Editar registro')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item">
			<a href="{{route('ejecutivos.index')}}"><i class="fa falist-ol"></i> Ejecutivos</a>
		</li>
		<li class="breadcrumb-item active">
			<i class="fa fa-pencil"></i> Editar registro
		</li>
	</ol>
	
    {{-- JHED EJECUTIVO --}}
    @include('alerts.success')
    {{-- JHED EJECUTIVO --}}
    
	<div class="panel panel-primary">
		<div class="panel-body">
			<form method="POST" action="{{ route('ejecutivos.update',$ejecutivo->idejecutivo) }}">
			    {{ csrf_field() }}
			    {{ method_field('PUT')}}
			    <div class="row">
			        
					{{-- JHED EJECUTIVO --}}
                    <div class="col-xs-12 col-md-12">
                    <span>Actualizar los datos del ejecutivo por nombre y apellidos</span>
                   </div>
                   
			    	<div class="col-xs-12 col-md-6">
			    		<div class="form-group{{ $errors->has('nombres') ? ' has-error' : '' }}">
			    		    <label for="nombres" class="control-label">Nombres</label>

					        <input id="nombres" type="text" class="form-control" name="nombres" value="{{ old('nombres',$ejecutivo->nombres) }}"  autofocus>

					        @if ($errors->has('nombres'))
					            <span class="help-block">
					                <strong>{{ $errors->first('nombres') }}</strong>
					            </span>
					        @endif
			    		</div>
			    	</div>
			    	<div class="col-xs-12 col-md-6">
			    		<div class="form-group{{ $errors->has('apellidos') ? ' has-error' : '' }}">
			    		    <label for="apellidos" class="control-label">Apellidos</label>

					        <input id="apellidos" type="text" class="form-control" name="apellidos" value="{{ old('apellidos',$ejecutivo->apellidos) }}">

					        @if ($errors->has('apellidos'))
					            <span class="help-block">
					                <strong>{{ $errors->first('apellidos') }}</strong>
					            </span>
					        @endif
			    		</div>
			    	</div>
			    </div>
			    
			    
                {{-- JHED EJECUTIVO --}}
                <div class="row">
                    <div class="col-xs-12 col-md-12">
                    <span>Actualizar los datos del ejecutivo por correo electronico</span>
                   </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group{{ $errors->has('correo') ? ' has-error' : '' }}">
                            <label for="correo" class="control-label">Correo electronico</label>
                                <input id="correo" type="email" class="form-control" name="correo" value="{{ old('correo',$user->email) }}"   autofocus>

                                @if ($errors->has('correo'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('correo') }}</strong>
                                    </span>
                                @endif
                        </div>
                    </div> 
                </div>
                
			    <div class="row">
			    	<div class="col-md-12">
			    		<div class="form-group">
					        <button type="submit" class="btn btn-primary">
					            <i class="fa fa-save"></i> Guardar Cambios
					        </button>
					        <a href="javascript:history.back()" class="btn btn-default"><i class="fa fa-arrow-left"></i> Volver</a>
			    		</div>
			    	</div>
			    </div>
			    
			    
				<div class="row">
                    <div class="col-xs-12 col-md-12">
                        <span>* Nota: Para actualizar los datos de ejecutivos por nombres y apellidos, el campo correo electronico debe estar vacio</span>
                    </div>
                </div>
                
			</form>
		</div>
	</div>
</div>
@endsection
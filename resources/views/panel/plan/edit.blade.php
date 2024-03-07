@extends('layouts.app')
@section('titulo','Editar registro')
@section('content')
<div class="container">
	<ol class="breadcrumb">
	  <li>
	      <a href="{{route('planes.index')}}"><i class="fa fa-list-ol"></i> Planes</a>
	  </li>
	  <li class="breadcrumb-item active">
	    <i class="fa fa-pencil"></i> Editar registro
	  </li>
	</ol>
	<div class="panel panel-success">
	    <div class="panel-body">
	        <form action="{{route('planes.update',$plan->id)}}" method="POST" enctype="multipart/form-data">
	            {{ csrf_field() }}
	            {{ method_field('PUT') }}
	            <div class="row">
	                <div class="col-xs-12 col-md-6">
	                    
	                     <div class="form-group {{ $errors->has('descripcion_a') ? ' has-error' : '' }}">
	                        <label for="descripcion_a">Detalle Arquitectura</label>
	                        <textarea name="descripcion_a" class="form-control ckeditor">{{old('descripcion_a',$plan->descripcion_a)}}</textarea>
	                        @if ($errors->has('descripcion_a'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('descripcion_a') }}</strong>
	                            </span>
	                        @endif
	                    </div>

	                    <div class="form-group {{ $errors->has('descripcion_c') ? ' has-error' : '' }}">
	                        <label for="descripcion_c">Detalle Construcción</label>
	                        <textarea name="descripcion_c" class="form-control ckeditor">{{old('descripcion_c',$plan->descripcion_c)}}</textarea>
	                        @if ($errors->has('descripcion_c'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('descripcion_c') }}</strong>
	                            </span>
	                        @endif
	                    </div>

	                </div>
	                <div class="col-xs-12 col-md-6">
	                    <div class="row">

	                    	<div class="col-xs-12 col-md-12">
	                    	<div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
	                        <label for="name">Nombre</label>
	                        <input type="text" name="name" class="form-control" value="{{old('name',$plan->name)}}">
	                        @if ($errors->has('name'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('name') }}</strong>
	                            </span>
	                        @endif
	                    	</div>
	                    	</div>

	                        <div class="col-xs-12 col-md-4">
	                            <div class="form-group {{ $errors->has('precio') ? ' has-error' : '' }}">
	                                <label for="precio">Precio</label>
	                                <input type="number" name="precio" class="form-control" value="{{old('precio',$plan->precio)}}" disabled="">
	                                @if ($errors->has('precio'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('precio') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>
	                        <div class="col-xs-12 col-md-4">
	                            <div class="form-group {{ $errors->has('precio') ? ' has-error' : '' }}">
	                                <label for="promocion">Promocion</label>
	                                <input type="number" name="precio" class="form-control" value="{{old('promocion',$plan->promocion)}}" disabled="">
	                                @if ($errors->has('promocion'))
	                                    <span class="help-block">
	                                        <strong>{{ $errors->first('promocion') }}</strong>
	                                    </span>
	                                @endif
	                            </div>
	                        </div>

	                        <div class="col-xs-12 col-md-4">
	                        	<div class="form-group {{ $errors->has('moneda') ? ' has-error' : '' }}">
	                        		<label for="moneda">Moneda</label>
	                        		<select name="moneda" class="form-control" disabled="">
	                        			@if($plan->moneda == "PEN")
	                        			<option value="PEN" selected="">soles</option>
	                        			<option value="USD">Dólares</option>
	                        			@else
	                        			<option value="PEN">soles</option>
	                        			<option value="USD" selected="">Dólares</option>	
	                        			@endif
	                        		</select>
	                        	</div>
	                        </div>
	                     </div>
	                     <div class="row">
	                        <div class="col-xs-12 col-md-4">
	                        	<div class="form-group {{ $errors->has('status') ? ' has-error' : '' }}">
	                        		<label for="status">Estado</label>
	                        		<select name="status" class="form-control">
	                        			@if($plan->status == 1)
	                        			<option selected value="1">Activo</option>
	                        			<option value="0">Inactivo</option>
	                        			@else
	                        			<option value="1">Activo</option>
	                        			<option selected value="0">Inactivo</option>
	                        			@endif
	                        			
	                        		</select>
	                        	</div>
	                        </div>
	                    <div class="col-xs-12 col-md-8">
	                    <div class="form-group {{ $errors->has('int_meses') ? ' has-error' : '' }}">
	                        <label for="name">Intervalo de meses</label>
	                        <input type="number" min="1" name="int_meses" class="form-control" value="{{old('int_meses',$plan->meses)}}" readonly="readonly">
	                        @if ($errors->has('int_meses'))
	                            <span class="help-block">
	                                <strong>{{ $errors->first('int_meses') }}</strong>
	                            </span>
	                        @endif
	                    </div>

	                	</div>

                            {{-- CAMBIOS JHED --}}
							<div class="col-xs-12 col-md-12 {{ $errors->has('descripcion') ? ' has-error' : '' }}">
								<label for="descripcion">Detalle General</label>
								{{-- <textarea name="descripcion" class="form-control ckeditor" >{{old('descripcion',$plan->descripcion)}}</textarea> --}}
								<textarea name="descripcion" class="form-control" style="height: 20rem">{{old('descripcion',$plan->descripcion)}}</textarea>
								@if ($errors->has('descripcion'))
									<span class="help-block">
										<strong>{{ $errors->first('descripcion') }}</strong>
									</span>
								@endif
							</div>
							{{-- CAMBIOS JHED --}}

		                    <div class="col-xs-12 col-md-12 {{ $errors->has('descripcion_m') ? ' has-error' : '' }}">
		                        <label for="descripcion_m">Detalle Minería</label>
		                        <textarea name="descripcion_m" class="form-control ckeditor" >{{old('descripcion_m',$plan->descripcion_m)}}</textarea>
		                        @if ($errors->has('descripcion_m'))
		                            <span class="help-block">
		                                <strong>{{ $errors->first('descripcion_m') }}</strong>
		                            </span>
		                        @endif
		                    </div>
	                        <div class="col-xs-12 col-md-3" style="float:right;">
	                        	<br>
	                            <button type="submit" class="btn btn-primary">Actualizar</button>
	                        </div>    
	                    </div>
	                </div>
	            </div>
	        </form>
	        
	    </div>
	</div>
</div>
@endsection
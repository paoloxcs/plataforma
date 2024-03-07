@extends('layouts.admin')
@section('titulo')
Editar Editorial
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><span class="label label-default">Editar Editorial</span></h3>
    </div>
    <!-- /.col-lg-12 -->
    <div class="row">
    	<div class="col-lg-12">
      @include('lado-admin.alerts.errors')
    		<div class="panel panel-default">
    			<div class="panel panel-heading">
    				Formulario
    			</div>
    			<div class="panel panel-body">
    			<form action="{{route('editorial.update',$editorial->ideditorial)}}" method="POST">
                    {{ csrf_field()}}
                    {{ method_field('PUT')}}
    				<div class="form-group">
    				<label for="">Nombre Editorial</label>
    				<input type="text" class="form-control" name="nombre" value="{{$editorial->nombre}}"  autofocus>
    			   </div>
                   <div class="form-group">
                       <label for="">País</label>
                       <input type="text" name="pais" class="form-control" value="{{$editorial->pais}}">
                   </div>
    			   <div class="form-group">
    			   	<input type="submit" class="btn btn-primary" value="Guardar Cambios">
                    <a href="#" onclick="history.back()" class="btn btn-info">Cancelar</a>
    			   </div>
    			   </form>
    			</div>
    			
    		</div>
    	</div>
    </div>
</div>		
@endsection
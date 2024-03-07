@extends('layouts.admin')
@section('titulo')
Nuevo Editorial
@endsection
@section('content')
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"><span class="label label-default">Nuevo Editorial</span></h3>
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
    			<form action="{{route('editorial.store')}}" method="POST">
                    {{ csrf_field()}}
    				<div class="form-group">
    				<label for="">Nombre Editorial</label>
    				<input type="text" class="form-control" name="nombre" placeholder="Ingrese nuevo Editorial" autofocus>
    			   </div>
                   <div class="form-group">
                       <label for="">País</label>
                       <input type="text" name="pais" class="form-control" placeholder="Ingrese nombre de País">
                   </div>
    			   <div class="form-group">
    			   	<input type="submit" class="btn btn-primary" value="Guardar">
    			   </div>
    			   </form>
    			</div>
    			
    		</div>
    	</div>
    </div>
</div>		
@endsection
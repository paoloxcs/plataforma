@extends('layouts.admin')
@section('titulo')
Editoriales
@endsection
@section('content')
<div class="row">
   <div class="col-lg-12">
      <h3 class="page-header"><span class="label label-default">Lista de Editoriales</span></h3>
   </div>
<!-- /.col-lg-12 -->
	<div class="col-lg-12">
	@include('lado-admin.alerts.success')
	    <div class="panel panel-default">
	        <div class="panel-heading">
	            Tabla - Editoriales
	        </div>
	        <!-- /.panel-heading -->
	        <div class="panel-body">
	            <div class="table-responsive">
	                <table class="table table-condensed table-hover">
	                    <thead>
	                        <tr>
	                            <th>Id</th>
	                            <th>Nombre</th>
	                            <th>País</th>
	                            <th>Acción</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                    @foreach($editoriales as $editorial)
	                      <tr>
	                      	<td>{{$editorial->ideditorial}}</td>
	                        <td>{{$editorial->nombre}}</td>
	                        <td>{{$editorial->pais}}</td>
	                        <td>
	                        	<a href="{{route('editorial.edit',$editorial->ideditorial)}}" class="btn btn-info">Editar</a>
	                        	<a href="#" class="btn btn-danger">Eliminar</a>
	                        </td>
	                      </tr>
	                    @endforeach
	                    </tbody>
	                </table>
	            </div>
	            <!-- /.table-responsive -->
	           
	        </div>
	        <!-- /.panel-body -->
	    </div>
	    <!-- /.panel -->
	</div>
	<!-- /.col-lg-6 -->
</div>
@endsection
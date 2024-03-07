@extends('layouts.app')
@section('titulo','Patrocinadores del Curso')
@section('content')
	<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading float-left">
			<div class="panel-title font-weight-bold h5">Materiales: <a href="{{route('sponsors')}}"> {{$sponsor->nombre}}</a></div>
		</div>
		<div class="panel-body">
			 <div class="row">
              <div class="col-xs-12 col-md-6">
                
              </div>
              <div class="col-xs-12 col-md-6">
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-plus"></i> Nuevo Registro</button>
              </div>
          </div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed">
					<thead>
						<th>Id</th>
						<th>Nombre</th>
						<th>Peso</th>
						<th>Archivo</th>
						<th>control</th>
					</thead>
					@foreach($materiales as  $material)
					<tbody>
						<td>{{$material->id}}</td>
						<td>{{$material->doc_name}}</td>
						<td>{{$material->peso}}</td>
						<td>{{$material->url_doc}}</td>
						<td width="200">
							<a href="{{route('sponsormaterial.editar',$material->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
							<a href="{{route('sponsormaterial.delete',$material->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
						</td>
					</tbody>
								@endforeach
							</table>
						</div>
						{!! $materiales->render() !!}
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
@include('panel.sponsormateriales.create')
@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('curso.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection


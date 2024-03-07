@extends('layouts.app')
@section('titulo','Patrocinadores del Curso')
@section('content')
	<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading float-left">
			<div class="panel-title font-weight-bold h5">Cursos - Patrocinadores </div>
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
						<th>Curso</th>
						<th>Patrocinador</th>
						<th>Control</th>
					</thead>
					@foreach($sponsorcursos as  $sponsorcurso)
					<tbody>
						<td>{{$sponsorcurso->id}}</td>
						<td>{{$sponsorcurso->curso->titulo}}</td>
						<td>{{$sponsorcurso->sponsor->nombre}}</td>
						<td width="200">
							<a href="{{route('sponsorcurso.delete',$sponsorcurso->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
						</td>
					</tbody>
								@endforeach
							</table>
						</div>
						{!! $sponsorcursos->render() !!}
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
@include('panel.sponsorcurso.create')
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


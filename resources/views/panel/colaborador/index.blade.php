@extends('layouts.app')
@section('titulo','Colaboradores')
@section('content')
	<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading float-left">
			<div class="panel-title font-weight-bold h5">Colaboradores</div>
		</div>
		<div class="panel-body">
			 <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control"  aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                

                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-plus"></i> Nuevo Registro</button>

               
              </div>
          </div>
			<hr>
			<div class="table-responsive" id="contenedor">
				<table class="table table-condensed">
					<thead>
						<th>Id</th>
						<th>Nombre</th>
						<th>Logo</th>
						<th>Rubro</th>
						<th>Descripción</th>
						<th>Orden</th>
						<th>Acción</th>
					</thead>
					@foreach($colaboradores as  $colaborador)
					<tbody>
						<td>{{$colaborador->id}}</td>
						<td>
						<img class="img-responsive" width="90" src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" alt="">
						</td>
						<td>{{$colaborador->nombre}}</td>
						<td>{{$colaborador->rubro->nombrerubro}}</td>
						<td>{{$colaborador->descripcion}}</td>
						<td>{{$colaborador->orden}}</td>
						<td width="350">
							<a href="{{route('colaborador.editar',$colaborador->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
							<a href="{{route('colaborador.delete',$colaborador->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
						</td>
					</tbody>
								@endforeach
							</table>
						</div>
						{!! $colaboradores->render() !!}
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
@include('panel.colaborador.create')
@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('colaborador.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection


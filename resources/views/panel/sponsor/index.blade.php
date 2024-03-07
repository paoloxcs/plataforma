@extends('layouts.app')
@section('titulo','Patrocinadores del Curso')
@section('content')
	<div class="container">
	<div class="panel panel-default">
		<div class="panel-heading float-left">
			<div class="panel-title font-weight-bold h5">Patrocinadores</div>
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

                <a  class="btn btn-primary pull-right" href="{{route('sponsorcurso')}}" style=" margin-right:2%"> Cursos </a>
              </div>
          </div>
			<hr>
			<div class="table-responsive" id="contenedor">
				<table class="table table-condensed">
					<thead>
						<th>Id</th>
						<th>nombre</th>
						<th>Logo</th>
						<th>Web</th>
						<th>Control</th>
					</thead>
					@foreach($sponsors as  $sponsor)
					<tbody>
						<td>{{$sponsor->id}}</td>
						<td>{{$sponsor->nombre}}</td>
						<td>
						<img class="img-responsive" width="70" src="{{asset('imgCurso/'.$sponsor->url_logo)}}" alt="">
						</td>
						<td><a target="_blank" href="{{$sponsor->url_web}}">{{$sponsor->url_web}}</a></td>
						<td width="350">
							<a href="{{route('sponsor.editar',$sponsor->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
							<a href="{{route('sponsor.delete',$sponsor->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
							<a href="{{route('sponsorcontact',$sponsor->id)}}" class="btn btn-success btn-sm"><i class="fa fa-phone-square"></i>Contacto</a>
                    <a href="{{route('sponsormaterial',$sponsor->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i>Material</a>
						</td>
					</tbody>
								@endforeach
							</table>
						</div>
						{!! $sponsors->render() !!}
					</div>
					<div class="panel-footer">
					</div>
				</div>
			</div>
@include('panel.sponsor.create')
@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('sponsor.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection


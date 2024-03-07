@extends('layouts.app')
@section('titulo','clases')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> clases : <a href="{{route('cursos')}}">{{$curso->titulo}}</a>
      </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
          <div class="row">
              {{--<div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control"  aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>--}}
              <div class="col-xs-12 col-md-12">
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Nuevo registro</button>
              </div>
          </div>
          <hr>
          <div class="table-responsive" id="contenedor">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>Estado</th>
                          <th>Id</th>
                          <th>Título</th>
                          <th>portada</th>
                          <th>información</th>
                          <th>Fecha y Hora</th>
                          <th>Código Zoom</th>
                          <th>Código Video</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($clases as  $clase)
                  <tbody>
                    <tr>
                    @if($clase->estado==1)
		                <td><i class="fa fa-check"></i></td>
		                @else
						        <td><i class="fa fa-times"></i></td>
		                @endif
		                <td>{{$clase->id}}</td>
		                <td>{{$clase->titulo}}</td>
		                <td>
		                <img class="img-responsive" width="100" src="{{asset('imgCurso/'.$clase->url_portada)}}" alt="">
		            	</td>
		                <td>{{$clase->informacion}}</td>
		                <td>{{$clase->fecha}} Inicio: {{$clase->time}} Fin: {{$clase->time_exp}}</td>
                    <td>{{$clase->zoom_codigo_url}}</td>
                    <td>{{$clase->video_codigo}}</td>
                    <td>
		                <a  href="{{route('clase.editar',$clase->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
		                <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" href="{{route('clase.delete',$clase->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
		                
		                </td>
		              </tr>
                  </tbody>
                  @endforeach
                 
              </table>
          </div>
          <div class="row">
             <div class="col-xs-12 col-md-4">
                 <div class="input-group custom-pagination">
                  <!-- Render pagination here -->
                 </div>
              </div>
          </div>
        </div>
    </div>
    @include('panel.clase.create')
</div>

@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('clase.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection
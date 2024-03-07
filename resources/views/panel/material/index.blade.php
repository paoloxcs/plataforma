  @extends('layouts.app')
@section('titulo','materiales')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> materiales : <a href="{{route('cursos',$curso->id)}}">{{$curso->titulo}}</a>
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
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-sm"><i class="fa fa-plus"></i> Nuevo registro</button>
              </div>
          </div>
          <hr>
          <div class="table-responsive" id="contenedor">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th></th>
                          <th>Id</th>
                          <th>Nombre Documento</th>
                          <th>url_file</th>
                          <th>peso</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($materiales as  $material)
                  <tbody>
                    <tr>
		                <td><i class="fa fa-check"></i></td>
		                <td>{{$material->id}}</td>
		                <td>{{$material->nombre_documento}}</td>
		                <td>{{$material->url_file}}</td>
		                <td>{{$material->peso}}</td>
                    <td>
		                <a  href="{{route('material.editar',$material->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
		                <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" href="{{route('material.delete',$material->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
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
                  {{$materiales->render()}}
                 </div>
              </div>
          </div>
        </div>
    </div>
    @include('panel.material.create')
</div>

@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('material.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection
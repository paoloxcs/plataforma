@extends('layouts.app')
@section('titulo','Cursos')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> cursos
      </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
          {{-- <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control"  aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Nuevo registro</button>
              </div>
          </div> --}}

                <div class="row">
                    {{-- Filtrar por fecha Filtrar por estado --}}
                     <form action="{{ route('cursos') }}" class="row col-10" style="margin-right: 2rem ; margin-left: 2rem">

                        <div class="col-xs-12 col-md-4">
                            <p> Buscador:</p>
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3"><i class="fa fa-search"></i></span>
                                <input type="text" id="texto" class="form-control" aria-describedby="basic-addon3"
                                    placeholder="Escriba aquí">
                            </div>
                        </div>

                        <div class=" col-xs-12 col-md-2">
                            <p> Ordenar por:</p>

                            <select name="order" class="form-control">
                                <option value="new" @if (request('order') == 'new') selected @endif>Más nuevos</option>
                                <option value="old" @if (request('order') == 'old') selected @endif>Más antiguo
                                </option>
                            </select>
                        </div>

                        <div class=" col-xs-12 col-md-3">
                            <p> Ordenar por Rubro:</p> 
                            <select name="r" class="form-control">
                                <option value=" ">Seleccionar rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->idrubro }}"
                                        @if (request('r') == $rubro->idrubro) selected @endif>{{ $rubro->nombrerubro }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class=" col-xs-12 col-md-3" style="display: flex; flex-direction: column">
                            <div style="display: flex">
                                <button class="btn btn-success" style="margin: 2rem 2rem 0 0;flex: 1 1 0%;"> Aplicar
                                    filtro</button>
                                <a href="{{ route('cursos') }}" class="btn btn-danger" style="margin-top: 2rem"> <i
                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                            </div>
                            <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                                data-target=".bd-example-modal-lg" style="margin-top: 2rem"><i class="fa fa-plus"></i> Nuevo
                                registro</button>

                        </div>
                    </form>
                </div>
          <hr>
          <div class="table-responsive" id="contenedor">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>Estado</th>
                          <th>Id</th>
                          <th>Título</th>
                          <th>portada</th>
                          <th>Precio no Suscriptor</th>
                          <th>Precio Suscriptor</th>
                          <th>Rubro</th>
                          <th>Autor</th>
                          <th>Fecha</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($cursos as  $curso)
                  <tbody>
                       <tr>
                        @if($curso->estado==1)
                    <td><i class="fa fa-check"></i></td>
                    @else
            <td><i class="fa fa-times"></i></td>
                    @endif
                    <td>{{$curso->id}}</td>
                    <td>{{$curso->titulo}}</td>
                    <td>
                    <img class="img-responsive" width="100" src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="">
                  </td>
                    <td>S/. {{$curso->precio}}.00 <br>  $  {{$curso->precio_d}}.00</td>
                    <td>S/. {{$curso->promocion}}.00 <br>  $  {{$curso->promocion_d}}.00</td>

                    <td>{{$curso->rubro->nombrerubro}}</td>
                    <td>{{$curso->autor->nombre}}</td>

                   
                    {{-- <td>{{ $curso->fecha }}</td> --}}
                    @php
                        $date = new DateTime($curso->fecha);  
                    @endphp 
                    <td>{{$date->format('d/m/Y')}}</td>
                                    
                    <td width="250">
                    <a  href="{{route('curso.editar',$curso->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                    <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" href="{{route('curso.delete',$curso->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
                    <a href="{{route('temas',$curso->id)}}" class="btn btn-secondary btn-sm"><i class="fa fa-sitemap"></i> Temas</a>
                    <a href="{{route('clase',$curso->id)}}" class="btn btn-success btn-sm"><i class="fa fa-folder"></i> Clases</a>
                    {{--<a href="{{route('evaluacion',$curso->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i> Evaluación</a>--}}
                    <a href="{{route('material',$curso->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i>  Material</a>
                    <a href="{{route('encuesta_curso',$curso->id)}}"class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i>  Encuesta</a>
                    
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
                            {{ $cursos->appends(['order' => request('order'),'r' => request('r')])->render() }}
                 </div>
              </div>
          </div>
        </div>
    </div>
    @include('panel.curso.create')
</div>

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
@extends('layouts.app')
@section('titulo','encuesta')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Encuestas 
      </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
          <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control"  aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>
          </div>
          <hr>
          <div class="table-responsive" id="contenedor">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th></th>
                          <th>Nombres y apellidos</th>
                          <th>Correo Electrónico</th>
                          <th>Teléono</th>
                          <th>Curso</th>
                          <th>Encuesta</th>
                          <th>Acción</th>
                  </thead>
                
                  <tbody>
                      @foreach($encuestasu as  $enc)
                 
                                 
                                       <tr>
                                        <td><i class="fa fa-check"></i></td>
                                        
                                        <td>{{$enc->name}} {{$enc->last_name}}</td>
                                        <td>{{$enc->email}}</td>
                                        <td>{{$enc->phone_number}}</td>
                                        <td>{{$enc->tituloc}}</td>
                                        <td>{{$enc->titulo}}</td>

                                        <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal{{$loop->iteration}}">Encuesta</button>
                                         @include('panel.encuestasusers.create')  
                                        </td>
                                      </tr>


                      @endforeach
                    
                  </tbody>
                 
              </table>
          </div>
          <div class="row">
             <div class="col-xs-12 col-md-4">
                 <div class="input-group custom-pagination">
                  <!-- Render pagination here -->
                  {{$encuestasu->render()}}
                 </div>
              </div>
          </div>
        </div>
    </div>

</div>
  
@endsection
@section('extra_scripts')
<script>
   
    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('encuestas.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    });  

</script>
@endsection
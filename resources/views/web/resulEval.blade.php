@extends('layouts.front')
@section('titulo')
{{$evaluacion->titulo}}
@endsection
@section('content')
<div class="container">
  
  <hgroup>
    <div class="none">{{$a='construccion'}}</div> 
    <p class="text-right text-secondary">{{date('d/m/Y',strtotime($evaluacion_user->created_at))}}</p>
    <h2 class="text-center"><span  style="color:#007bff">{{$evaluacion->titulo}}</span> </h2>
    @if($evaluacion_user->total_buenas>$evaluacion_user->total_malas)
    <h5 class="text-center"><span style="color:green">APROBADO</span> </h5>
    @else
    <h5 class="text-center"><span style="color:red">DESAPROBADO</span> </h5>
    @endif

  </hgroup>
  
  <div class="row">
    <div class="col-xs-12 col-md-10 col-lg-10 mx-auto">
       <table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">Pregunta</th>
      <th scope="col">Opción</th>
      <th scope="col">Puntaje</th>
    </tr>
  </thead>
  <tbody>
    @foreach($cuestionario as $pregunta)
    <tr>
      <th scope="row">{{$loop->iteration}}</th>
      <td>{{$pregunta->pregunta}}</td>
     @if($evaluacion_user['respuesta'.$loop->iteration]==1)
      <td style="color:green;font-weight: 700">correcto</td>
     @else
     <td style="color:red;font-weight: 700">incorrecto</td>
     @endif
       @if($evaluacion_user['respuesta'.$loop->iteration]==1)
      <td style="font-weight: 700">1</td>
     @else
     <td style="font-weight: 700">0</td>
     @endif
    </tr>
    @endforeach
      <tr>
      <th scope="row"></th>
      <td></td>
      <td>Total</td>
      <td>{{$evaluacion_user->total_buenas}}</td>
    </tr>
    
  </tbody>
</table>
    </div>

    
</div>

  
@endsection
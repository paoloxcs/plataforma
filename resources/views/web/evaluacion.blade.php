@extends('layouts.front')
@section('titulo')
{{$evaluacion->titulo}}
@endsection
@section('content')
<div class="container">
  
  <hgroup>
    <div class="none">{{$a='construccion'}}</div> 
    <h2 class="text-center"><span  style="color:#007bff">{{$evaluacion->titulo}}</span> </h2>
  </hgroup>
  
  <div class="row">
    <div class="col-xs-12 col-md-10 col-lg-10 mx-auto">
        @if(! session('msg'))
      <form method="post" action="{{route('envcuestionario')}}">
         {{ csrf_field() }}
      <p >Responde las siguientes preguntas según tu criterio.</p>
      <br>
      <h4>Cuestionario</h4>
      <br><br>
      @foreach($cuestionario as $pregunta)
      <div>
      <label for="respuesta{{$loop->iteration}}" style="color:#007bff">Pregunta: {{$loop->iteration}}</label>
      <p><strong>{{$pregunta->pregunta}}</strong></p>

      <ol type="a" style="list-style:lower-latin;">
            <div class="none">{{$opcion=$loop->iteration}}</div>
             @if ($errors->has('respuesta'.$opcion))
                <span class="msg-error">
                    <strong style="color:red;">{{ $errors->first('respuesta'.$opcion) }}</strong>
                </span>
            @endif
        @foreach($respuestas as $respuesta)
          
        @if($pregunta->id == $respuesta->cuestionario_id)

        <li style="color: #666666;"><input  id="" type="radio" required="" name="respuesta{{$opcion}}" value="{{$respuesta->correcto}}">{{$respuesta->respuesta}}</li>
      
        @else
         
        @endif
        
        {{--<li><input id="" type="checkbox" name="opcion3[]" value="2">Casi nunca</li>
        <li><input id="" type="checkbox" name="opcion3[]" value="3">A veces</li>
        <li><input id="" type="checkbox" name="opcion3[]" value="4">Casi siempre</li>
        <li><input id="" type="checkbox" name="opcion3[]" value="5">Siempre</li>--}}
        @endforeach
        <input type="hidden" name="evaluacion_id" value="{{$evaluacion->id}}">
      </ol>
      <hr>
      </div>  
      @endforeach

      <button type="submit" class="btn btn-outline-primary" style="border-radius: 10px;">ENVIAR RESPUESTAS</button>
      <br>
      <br>


      </form>
          @endif
    </div>
    
  </div>

  
      

    
</div>

  
@endsection
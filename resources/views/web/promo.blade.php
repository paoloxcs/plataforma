@extends('layouts.front')
@section('titulo')
{{$promo->name}}
@endsection
@section('content')
<div class="none">{{$a=('construccion')}}</div>
<div class="container">
  <div class="row mt-3">
    <div class="col-xs-12 col-md-4">
      <img src="{{asset('posts/'.$promo->url_portada)}}" class="img-fluid" alt="">
      {{-- <img src="https://plataforma.constructivo.com/posts/{{$promo->url_portada}}" class="img-fluid" alt=""> --}}
    </div>
    <div class="col-xs-12 col-md-8">
       <div class="titulogenerico text-center"><h1>{{$promo->name}}</h1></div>
       <p>{!!$promo->descripcion!!}</p>


       <input type="hidden" id="fechafin" value="{{$promo->fecha_fin}}">
             <div class="fila mb-2">
               <div class="alineador"> Quedan sólo &nbsp; </div>
               <div id="counter" class="flexcentre"> </div>                     
            </div>

             @if($promo->estado == 1)
             <section class="mt-5 mb-4 text-center">
              <a class="btn btn-green btn-lg" href="{{route('plan',[$promo->plan->slug, $promo->id])}}" role="button">Suscribirme</a>
            </section>
             @endif

            {{--  @if(Auth::guest())
             <section class="mt-3">
               <a href="{{route('login')}}" class="greenbutton">Iniciar sesión</a>
               <a href="{{route('register')}}" class="goldenbutton">Crear cuenta gratis</a>
             </section>
             @else --}}
             
            {{--  @endif --}}
    </div>
  </div>
</div>
@endsection
@section('script-extra')
<script>
	$(document).ready(function(){

	  var date_end = $('#fechafin').val();
	  SetToView(date_end,'counter','¡La Promoción ha finalizado!');

	});

	//Funcion para obtener el tiempo restante para el evento
	//Parametro fecha de inicio del evento
	function getRemainTime(date_end){

	  var now = new Date(),
	    parts = date_end.split('-'),
	    remainTime    = (new Date(parts[0],parts[1] - 1,parts[2]) - now + 1000) / 1000,
	    remainSeconds = ('0' + Math.floor(remainTime % 60)).slice(-2),
	    remainMinutes = ('0' + Math.floor(remainTime / 60 % 60)).slice(-2),
	    remainHours   = ('0' + Math.floor(remainTime / 3600 % 24)).slice(-2),
	    remainDays    = Math.floor(remainTime / (3600 * 24));

	    return{
	      remainTime,
	      remainSeconds,
	      remainMinutes,
	      remainHours,
	      remainDays
	    }
	}

	function SetToView(date_end,element_id,messageFinal) {
	  var elemento = document.getElementById(element_id);


	  var timerUpdate = setInterval(function(){
	    var t = getRemainTime(date_end);

	   elemento.innerHTML = 
	       '<span class="promotimer">'+t.remainDays+' <i>Días</i></span>\
	        <span class="promotimer">'+t.remainHours+' <i>Hrs</i></span>\
	        <span class="promotimer">'+t.remainMinutes+' <i>Min</i></span>\
	        <span class="promotimer">'+t.remainSeconds+'<i>Seg</i></span>';

	    if(t.remainTime <= 1){
	      clearInterval(timerUpdate);
	      elemento.innerHTML = '<h4>'+messageFinal+'</h4>';
	    }

	  },1000);

	}
</script>
@endsection
@extends('layouts.front')
@section('titulo','SUPLEMENTO TECNICO')
@section('content')
  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 
    
    <section class="col-md-10 mx-auto">
      <div id="carouselExampleCaptions" class="carousel slide mt-5 mt-0-mob" data-bs-ride="carousel">
        <div class="carousel-indicators">
          @foreach($sliders as $slide)
            @if($loop->iteration==1)
              <div class="none">{{$active="active"}}</div>
            @else
              <div class="none">{{$active=""}}</div>
            @endif
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$loop->iteration - 1}}" class="{{$active}}" aria-current="true" aria-label="{{"Slide ".$loop->iteration}}"></button>
        @endforeach
          
        </div>

        <div class="carousel-inner">
          @foreach($sliders as $slide)
            @if($loop->iteration==1)
              <div class="none">{{$active="active"}}</div>
            @else
              <div class="none">{{$active="e"}}</div>
            @endif
          <div class="{{'carousel-item c-item '.$active}}">
             <a href="{{$slide->url}}">
              <img src="{{asset('imgRubro/'.$slide->img_desktop)}}" class=" w-100 none-mobile" alt="...">
              <img src="{{asset('imgRubro/'.$slide->img_phone)}}" class=" w-100 none-desktop" alt="...">
            </a>
            {{--<div class="carousel-caption d-none d-md-block text">
              <span class="p-rubro" style="text-transform: uppercase">{{$slide->rubro->nombrerubro}}</span>

             <h1 class="font-weight mt-3">{{$slide->titulo}}</h1>
            </div>--}}
          </div>
         @endforeach
        </div>  
      </div>
    </section>
    <section>

    </section>
    <section class="col-md-10 mx-auto row pbm-0 mt-5 mt-2-mob">
    	<h2 class="font-weight">Suplemento Técnico</h2>
      <section class="col-md-8 col-xs-12 ">
      	<div class="s-text ">
          <p>Constructivo cuenta con el Suplemento Técnico de presupuestos para obra, información especializada para armar un correcto presupuesto y organización de gastos en obra. </p> 
          <p>Dentro del suplemento se contemplarán lo siguiente:</p>
          <p><i class="fas fa-check check-b"></i> Alquiler de equipos.</p>
          <p><i class="fas fa-check check-b"></i> Costos de Mano y Jornales.</p>
          <p><i class="fas fa-check check-b"></i> Insumos de Provincia.</p>
          <p><i class="fas fa-check check-b"></i> Precios de insumos.</p>
          <p><i class="fas fa-check check-b"></i> Costos de construcción. </p>
          <p><i class="fas fa-check check-b"></i> Costos de terrenos.</p>
          <p><i class="fas fa-check check-b"></i> Índices Unificados.</p>
          <p><i class="fas fa-check check-b"></i> Precios unitarios: Pisos, Pinturas, Carpintería en aluminio y madera, Vidrios, Cielorrasos y mucho más.</p>
          <p>Además, el Suplemento de Constructivo cuenta con la ventaja de organizar la información en listas para su rápida descarga en formato .xlsx (Microsoft Excel).</p>
        </div>
	      	


      </section>
      <section class="col-md-4 col-xs-12 mt-5-mob">
      	<div class="card-suplemento">
      		<h4 class="text-center font-weight">¿TE GUSTARÍA LEER NUESTRO SUPLEMENTO?</h4>
      			<div class="bla mt-3">
	      			<img src="{{asset('images/calidad-premium.png')}}">
	      			<h2 class="font-weight pbm-0 text-center mt-3">¡SUSCRÍBETE</h2>
	      			<h4 class="font-weight pbm-0 text-center">
	      			hoy mismo!</h4>


	      		<a class="a-menu a-menu-b nav-link text-center mt-3"  href="{{route('planes','construccion')}}">SUSCRIBIRME</a>
	      		</div>

      	</div>
      </section>
    </section>


    

  </section>
@endsection
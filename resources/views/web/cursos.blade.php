@extends('layouts.front')
@section('titulo','Capacitación de '.$rubro->nombrerubro)
@section('content')
  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 
    
   <section class="col-md-10 mx-auto ">
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

        <div class="carousel-inner ">
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
    <section class="col-md-10 col-xs-12 mx-auto row pbm-0 mt-5 mt-2-mob">
      <h5 class="title-c font-weight">CURSOS</h5>
      <section class="col-md-2 col-xs-12">
        <h5 class="font-weight"><a href="{{route('getcursosP',$rubro->slug)}}" style="color:black;text-decoration: none"> Mostrar Todos </a></h5>

        <ul class="ul-left mt-5 mt-2-mob">
          <li class="active">
            <a href="" class="">{{$rubro->nombrerubro}}</a>
          </li>
            <li class="">
              <a href="{{route('getCursoV',$rubro->slug)}}#curso-vivo" class="">Cursos en vivo</a>
            </li>

            <li class="">
              <a href="{{route('getCursoR',$rubro->slug)}}#curso-rel" class="">Cursos realizados</a>
            </li>
        </ul>
        
      </section>
      <hr class="hr-mob-cur">
      <section class="col-md-10 col-xs-12">
        <h5 class="font-weight p-inline tt-uppercase">{{$rubro->nombrerubro}}</h5>
        {{--<h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>--}}

        <div class="col-md-12 row pbm-0 mt-5 mt-2-mob">
             @foreach($cursos as $curso)

               <section class="col-md-4 col-sm-12 card-curso card-curso-p mt-2-mob">
                  <div class="img">
                    <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                    @if($curso->fecha_culminacion >= date('Y-m-d'))
                    <span class="s-disponible s-proximamente">EN VIVO</span>
                    @else
                    <span class="s-disponible">REALIZADOS</span>

                    @endif
                  </div>
                  <div class="text text-info-curso">
                    <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h4 class="title font-weight">{{$curso->titulo}}</h4></a>
                    <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
                    <p>{!!substr($curso->descripcion,0,90)!!}. . . </p>
                    <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$curso->CountValoracion()}}</p>

                    @if($curso->fecha_culminacion >= date('Y-m-d'))
                      
                      <section class="s-button text-center">
                      <p class="text-center-mob"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO</a></p>
                     </section>

                    @else
                      <section class="s-button text-center">
                      <p class="text-center-mob"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO REALIZADO</a></p>
                     </section>


                    @endif
                  </div>
                  
                </section>
              
            @endforeach

            <div class="font-weight p-right mt-5 d-flex justify-content-center ">
                {{$cursos->render('layouts.pagination')}}
            </div>


        </div>
      </section>
    </section>






  </section>
@endsection
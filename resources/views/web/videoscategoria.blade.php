@extends('layouts.front')
@section('titulo','Capacitación de '.$categoria->nombrecategoria)
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
      <h5 class="title-c">CAPACITACIÓN</h5>
      {{-- JHED FRONT V2 --}}
      {{-- <section class="col-md-2 col-xs-12"> --}}
      <section class="col-md-3 col-xs-12"> 
        <h5 class="font-weight"><a href="{{'/videos/rubro/'.$categoria->rubro->slug}}" style="color:black;text-decoration: none"> Mostrar Todos </a></h5>

        <ul class="ul-left mt-5 mt-2-mob">
          <li class="active">
            <a href="" class="">{{$categoria->nombrecategoria}}</a>
          </li>
           {{-- Is_active_capacitacion --}}
            {{-- @foreach ($subcategorias as $scat)
                <li class="">
                    <a href="{{ route('videoSCat', $scat->slug) }}" class=""
                        style="width: 80%;position: relative;display: inline-block">{{ $scat->nombresubcategoria }}</a>
                    <span class="badge badge-secondary float-right"
                        style="background: #24db37;float:right;margin-top: 1%">{{ $scat->countVideos() }}</span>
                </li>
            @endforeach --}}
            @foreach ($subcategorias as $scat)
                <li class="">
                    <a href="{{ route('videoSCat', $scat->slug) }}" class=""
                        style="width: 80%;position: relative;display: inline-block">{{ $scat->nombresubcategoria }}</a>
                    <span class="badge badge-secondary float-right"
                        style="background: #24db37;float:right;margin-top: 1%">{{ $scat->countVideosActive() }}</span>
                </li>
            @endforeach
        </ul>
        
      </section>
      <hr class="hr-mob-cur">
      {{-- JHED FRONT V2 --}} 
      {{-- <section class="col-md-10 col-xs-12"> --}}
      <section class="col-md-9 col-xs-12">
        <h5 class="font-weight p-inline">{{$categoria->nombrecategoria}}</h5>
        {{--<h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>--}}

        <div class="col-md-12 row pbm-0 mt-5 mt-2-mob">
             @foreach($posts as $post)
               <section class="col-md-4 col-xs-12 mt-2-mob card-curso card-curso-p">
                <div class="img">
                  <a href="{{route('getvideo',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%">
                   {{-- TAG VIDEO --}}
                    @if (date('Y-m-d', strtotime($post->fecha . '+ 7 day')) >= date('Y-m-d'))
                        <span class="s-disponible s-proximamente">NUEVO</span>
                    @endif
                    {{-- TAG GRATUITO --}}
                    @if ($post->acceso == '0')
                        <span class="s-disponible s-proximamente"
                            style="background: #2436db;;color:#fff;font-size: 12px;padding: 4px 8px;font-weight: 700;">GRATUITO</span>
                    @endif
                  </a>
                   {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}</span>
                </div>
                <div class="text">
                  <a href="{{route('getvideo',$post->pslug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                  {{--<p>{!!substr($post->infoadd,0,75)!!}. . . </p>--}}
                  <p class="p-inline p-c-i"><i class="fas fa-clock"></i> {{$post->video->duracion}}</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{$post->CountVistas()}}</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>

                  <section class="s-button">
                      <p class="text-center-mob"><a href="{{route('getvideo',$post->pslug)}}" class="a-transparent-g">VER CAPACITACIÓN</a></p>
                  </section>
                </div>
                
              </section>
            @endforeach

            <div class="font-weight p-right mt-5 d-flex justify-content-center ">
                {{$posts->render('layouts.pagination')}}
            </div>


        </div>
      </section>
    </section>






  </section>
@endsection
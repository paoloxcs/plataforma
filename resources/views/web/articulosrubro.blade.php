@extends('layouts.front')
@section('titulo','Artículos de '.$rubro->nombrerubro)
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
      <h5 class="title-c font-weight">ARTÍCULOS</h5>
      {{-- <section class="col-md-2"> --}}
      <section class="col-md-3 col-xs-12 filter-articulorubro">
        <h5 class="font-weight"><a href="" style="color:black;text-decoration: none"> Mostrar Todos </a></h5>

        <ul class="ul-left mt-5 mt-2-mob">
          <li class="active">
            <a href="" class="">{{$rubro->nombrerubro}}</a>
          </li>
          @foreach($categorias as $cat)
            <li class="">
              <a href="{{route('articuloCat',$cat->slug)}}" class=""  style="width: 80%;position: relative;display: inline-block">{{$cat->nombrecategoria}}</a>
              <span class="badge badge-secondary float-right" style="background: #24db37;float:right;margin-top: 1%">{{$cat->countArticulos()}}</span>
            </li>
          @endforeach
        </ul>
        
      </section>
      <hr class="hr-mob-cur">
      {{-- <section class="col-md-10"> --}}
      <section class="col-md-9 col-xs-12">
        <h5 class="font-weight p-inline ">{{$rubro->nombrerubro}}</h5>
        {{--<h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>--}}

        <div class="col-md-12 row pbm-0 mt-5 mt-2-mob">
             @foreach($posts as $post)

               <section class="col-md-4 col-xs-12 mt-2-mob card-curso card-curso-p">
                  <div class="text text-info-curso">
                    <a href="{{route('getarticulo',$post->pslug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>
                    <a href="{{route('getarticulo',$post->pslug)}}" style="text-decoration:none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                    <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                    <p>{!!substr($post->infoadd,0,75)!!}. . . </p>
                    <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>
                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->CountVistas()}}</p>
                     <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads()->count()}}</p>

                    <section class="s-button text-center">
                     <p class="text-center-mob"><a href="{{route('getarticulo',$post->pslug)}}" class="a-transparent-g">VER</a></p>
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
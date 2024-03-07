@extends('layouts.front')
@section('titulo','Series de Capacitación')
@section('content')
<div class="none">{{$a=('construccion')}}</div>
<div class="container">
  <hgroup>
    <h1 class="title-custom text-center">Series</h1>
  </hgroup>
  <div class="row">
    <div class="col-xs-12 col-md-3 mb-3">
      <div class="menu-user">
        <h4 class="title text-center">Rubros</h4>
        <ul class="list-group">
          @foreach($rubros as $rubro)
          <li class="list-group-item">
             <a href="{{url('series/rubro/'.$rubro->slug)}}">{{$rubro->nombrerubro}} <span class="float-right badge badge-secondary">{{$rubro->countSeries()}}</span></a>
             <div class="none">{{$a=($rubro->slug)}}</div>
          </li>
          @endforeach
        </ul>
      </div>
      
    </div>
    <div class="col-xs-12 col-md-9">
      <ul class="serie-list">
        @foreach($posts as $serie)
          <li class="serie-item three">
            <a href="{{url('serie/'.$serie->slug)}}" class="serie-item-cover serie-player">
              <picture width="278" height="156">
                <img src="{{asset('posts/'.$serie->image)}}" alt="{{$serie->titulo}}">
               {{-- <img src="https://plataforma.constructivo.com/posts/{{$serie->image}}" alt=""> --}}
              </picture>
              <span class="play">
                <i class="fa fa-play"></i>
              </span>
              @if($serie->isNew())
              <span class="serie-metadata">
                  <span class="serie-metadata_new">Nuevo</span>
              </span>
              @endif
            </a>
            <ul class="serie-mini-states">
              <li class="serie-duration">
                <i class="fa fa-clock"></i> {{$serie->serie->duracion}}
              </li>
              <li class="views">
                {{$serie->clicks->count()}} Vistas
              </li>
            </ul>
            <div class="serie-item-details">
              <h3 class="serie-item-title">
                <a href="{{url('serie/'.$serie->slug)}}">{{$serie->titulo}}</a>
              </h3>
              <div class="mt-1 mb-1">
                <span class="tag-post">{{$serie->subcategoria->categoria->rubro->nombrerubro}}</span>
                 <div class="none">{{$a=($serie->subcategoria->categoria->rubro->slug)}}</div>
              </div>
              <div class="serie-author">
                  <div class="author-pic">
                    <img src="{{asset('posts/'.$serie->autor->imagen)}}" alt="">
                      {{-- <img src="https://plataforma.constructivo.com/posts/{{$serie->autor->imagen}}" alt=""> --}}
                  </div>
                  <strong class="author-name"><a href="{{url('videos/autor/'.$serie->autor->slug.'/'.$a)}}">{{$serie->autor->nombre}}</a></strong>
              </div>
              
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
    <!-- Paginador -->
    {{$posts->render('layouts.pagination')}}
    <!-- Paginador -->
  </div>
</div>

@endsection
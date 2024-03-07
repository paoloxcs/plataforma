
@extends('layouts.front')
@section('titulo','Videos de Capacitación')
@section('content')
<div class="none">{{$a=('construccion')}}</div>
<div class="container">
  <hgroup>
    <h1 class="title-custom text-center">Videos de Capacitación</h1>
  </hgroup>
  <div class="row">
    <div class="col-xs-12 col-md-3 mb-3">
      <div class="menu-user">
        <h4 class="title text-center">Rubros</h4>
        <ul class="list-group">
          @foreach($rubros as $rubro)
          <li class="list-group-item">
             <a href="{{url('videos/rubro/'.$rubro->slug)}}">{{$rubro->nombrerubro}} <span class="float-right badge badge-secondary">{{$rubro->countVideos()}}</span></a>
             <div class="none">{{$a=($rubro->slug)}}</div>
          </li>
          @endforeach
        </ul>
      </div>
      
    </div>
    <div class="col-xs-12 col-md-9">
      <ul class="video-list">
        @foreach($posts as $video)
          <li class="video-item three">
            <a href="{{url('video/'.$video->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('posts/'.$video->image)}}" alt="{{$video->titulo}}">
               {{-- <img src="https://plataforma.constructivo.com/posts/{{$video->image}}" alt=""> --}}
              </picture>
              <span class="play">
                <i class="fa fa-play"></i>
              </span>
              @if($video->isNew())
              <span class="video-metadata">
                  <span class="video-metadata_new">Nuevo</span>
              </span>
              @endif
            </a>
            <ul class="video-mini-states">
              <li class="video-duration">
                <i class="fa fa-clock"></i> {{$video->video->duracion}}
              </li>
              <li class="views">
                {{$video->clicks->count()}} Vistas
              </li>
            </ul>
            <div class="video-item-details">
              <h3 class="video-item-title">
                <a href="{{url('video/'.$video->slug)}}">{{$video->titulo}}</a>
              </h3>
              <div class="mt-1 mb-1">
                <span class="tag-post">{{$video->subcategoria->categoria->rubro->nombrerubro}}</span>
                 <div class="none">{{$a=($video->subcategoria->categoria->rubro->slug)}}</div>
              </div>
              <div class="video-author">
                  <div class="author-pic">
                    <img src="{{asset('posts/'.$video->autor->imagen)}}" alt="">
                      {{-- <img src="https://plataforma.constructivo.com/posts/{{$video->autor->imagen}}" alt=""> --}}
                  </div>
                  <strong class="author-name"><a href="{{url('videos/autor/'.$video->autor->slug.'/'.$a)}}">{{$video->autor->nombre}}</a></strong>
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
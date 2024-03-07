@extends('layouts.front')
@section('titulo')
{{$autor->nombre}}
@endsection
@section('content')

<div class="container">
  <div class="row autor-deta mt-3">
    <div class="col-xs-12 col-md-4 autor-image mb-3">
      <img src="{{asset('posts/'.$autor->imagen)}}" alt="" class="">
      {{-- <img src="https://plataforma.constructivo.com/posts/{{$autor->imagen}}" alt=""> --}}
    </div>
    <div class="col-xs-12 col-md-8 text-center">
      <h1>{{$autor->nombre}}</h1>
      <h5 class="nacionalidad">{{$autor->nacionalidad}}</h5>
      <p>{!! $autor->bio !!}</p>
    </div>
  </div>

  <hgroup>
    <h1 class="title-custom text-center">Videos del autor</h1>
  </hgroup>
  <div class="row mb-4">
    @if(count($autor->posts))
    <ul class="video-list">
      @foreach($autor->posts()->where('type','=','video')->get() as $post)
        <li class="video-item three">
          <a href="{{url('video/'.$post->slug)}}" class="video-item-cover video-player">
            <picture width="278" height="156">
              <img src="{{asset('posts/'.$post->image)}}" alt="{{$post->titulo}}">

             {{-- <img src="https://plataforma.constructivo.com/posts/{{$post->image}}" alt=""> --}}
            </picture>
            <span class="play">
              <i class="fa fa-play"></i>
            </span>
            @if($post->isNew())
            <span class="video-metadata">
                <span class="video-metadata_new">Nuevo</span>
            </span>
            @endif
          </a>
          <ul class="video-mini-states">
            <li class="video-duration">
              <i class="fa fa-clock"></i> {{$post->video->duracion}}
            </li>
            <li class="views">
              {{$post->clicks->count()}} Vistas
            </li>
          </ul>
          <div class="video-item-details">
            <h3 class="video-item-title">
              <a href="{{url('video/'.$post->slug)}}">{{$post->titulo}}</a>
            </h3>
            <div class="mt-1 mb-1">
              <span class="tag-post">{{$post->subcategoria->categoria->rubro->nombrerubro}}</span>
            </div>
            <div class="video-author">
                <div class="author-pic">
                  <img src="{{asset('posts/'.$post->autor->imagen)}}" alt="">
                    {{-- <img src="https://plataforma.constructivo.com/posts/{{$post->autor->imagen}}" alt=""> --}}
                </div>
                <strong class="author-name"><a href="{{url('videos/autor/'.$post->autor->slug.'/'.$a)}}">{{$post->autor->nombre}}</a></strong>
            </div>
            
          </div>
          
        </li>
      @endforeach
    </ul>
    @else

    @endif
   
  </div>   
</div>
@endsection
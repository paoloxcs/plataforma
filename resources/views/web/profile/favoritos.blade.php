@extends('layouts.front')
@section('titulo','Mis Favoritos')
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-5 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-9 view-text-blue">
      <h4 class="title">Mis favoritos</h4>
      <ul class="list-group list-art col-md-12">
        @foreach($favoritos as $fav)
        @if($fav->post->type =='video')
        <li class="list-group-item art-item">
          <div class="row d-flex">
            <div class="col-md-1 d-none d-lg-block art-item-img">
               <img src="{{asset('posts/'.$fav->post->image)}}" alt="{{$fav->post->titulo}}">
              {{-- <img src="https://plataforma.constructivo.com/posts/{{$fav->post->image}}" alt=""> --}}
            </div>
            <div class="col-xs-12 col-md-11 art-item-content">
              <div class="art-titulo">
                <a href="{{url('video/'.$fav->post->slug)}}">{{$fav->post->titulo}}</a>&nbsp;<span class="badge badge-secondary">Video</span>
              </div>
              <div class="art-metadata mt-3">
                <div class="art-autor">
                  <p>Por <a href="{{url('videos/autor/'.$fav->post->autor->slug)}}">{{$fav->post->autor->nombre}}</a></p>
                </div>
                <div class="art-actions">
                  <span><i class="fa fa-calendar"></i>{{date('d/m/Y',strtotime($fav->post->fecha))}}</span>
                  <span><i class="fa fa-eye"></i>{{$fav->post->clicks->count()}}</span>
                  <span><i class="fa fa-thumbs-up"></i>{{$fav->post->valoraciones->count()}}</span>
                </div>
              </div>
            </div>
          </div>
        </li>
        @else
        <li class="list-group-item art-item">
          <div class="row d-flex">
            <div class="col-md-1 d-none d-lg-block art-item-img">
              <img src="{{asset('images/pdf-icon.png')}}" alt="">
            </div>
            <div class="col-xs-12 col-md-11 art-item-content">
              <div class="art-titulo">
                <a href="{{url('articulo/'.$fav->post->slug)}}">{{$fav->post->titulo}}</a>&nbsp;<span class="badge badge-secondary">Artículo</span>
              </div>
              <div class="art-metadata mt-3">
                <div class="art-autor">
                  <p>Por <a href="{{url('articulos/autor/'.$fav->post->autor->slug)}}">{{$fav->post->autor->nombre}}</a></p>
                </div>
                <div class="art-actions">
                  <span><i class="fa fa-calendar"></i>{{date('d/m/Y',strtotime($fav->post->fecha))}}</span>
                  <span><i class="fa fa-download"></i>{{$fav->post->downloads->count()}}</span>
                  <span><i class="fa fa-thumbs-up"></i>{{$fav->post->valoraciones->count()}}</span>
                </div>
              </div>
            </div>
          </div>
        </li>
        @endif
        
        @endforeach
        
      </ul>
    </div>
  </div>
</div>
@endsection
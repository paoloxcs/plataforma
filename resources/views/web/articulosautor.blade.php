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
    <h1 class="title-custom text-center">Artículos del autor</h1>
  </hgroup>
  <div class="row mb-4">
   
    <ul class="list-group list-art col-md-12">
      @foreach($posts as $post)
      <li class="list-group-item art-item">
        <div class="row d-flex">
          <div class="col-md-1 d-none d-lg-block art-item-img">
            <img src="{{asset('images/pdf-icon.png')}}" alt="">
          </div>
          <div class="col-xs-12 col-md-11 art-item-content">
            <div class="art-titulo">
              <a href="{{url('articulo/'.$post->pslug)}}">{{$post->titulo}}</a> <span class="badge badge-warning">{{$post->subcategoria->categoria->rubro->nombrerubro}}</span>
              <div class="none">{{$a=($post->subcategoria->categoria->rubro->slug)}}</div>
            </div>
            <div class="art-metadata mt-3">
              <div class="art-autor">
                <p>Por <a href="{{url('articulos/autor/'.$post->autor->slug)}}">{{$post->autor->nombre}}</a></p>
              </div>
              <div class="art-actions">
                <span><i class="fa fa-calendar"></i>{{date('d/m/Y',strtotime($post->fecha))}}</span>
                <span><i class="fa fa-download"></i>{{$post->downloads->count()}}</span>
                <span><i class="fa fa-thumbs-up"></i>{{$post->valoraciones->count()}}</span>
              </div>
            </div>
          </div>
        </div>
      </li>
      @endforeach
    </ul>
  </div>
  <div class="row d-flex justify-content-center">
    <!-- Paginador -->
    {{$posts->render('layouts.pagination')}}
    <!-- Paginador -->
  </div>
        
</div>
@endsection
@extends('layouts.front')
@section('titulo','Artículos Técnicos')
@section('content')
<div class="container">
  <hgroup>
    <h1 class="title-custom text-center">Artículos Técnicos</h1>
  </hgroup>
<div class="row">          
  <div class="col-xs-12 col-md-3 mb-3">
    <div class="menu-user">
      <h4 class="title text-center">Rubros</h4>
      <ul class="list-group">
        @foreach($rubros as $rubro)
        <li class="list-group-item">
           <a href="{{url('articulos/rubro/'.$rubro->slug)}}">{{$rubro->nombrerubro}} <span class="float-right badge badge-secondary">{{$rubro->countArticulos()}}</span></a>
           <div class="none">{{$a=($rubro->slug)}}</div>
        </li>
        @endforeach
      </ul>
    </div>
    
  </div>
  <div class="col-xs-12 col-md-9">
    <ul class="list-group list-art col-md-12">
      @foreach($posts as $post)
      <li class="list-group-item art-item">
        <div class="row d-flex">
          <div class="col-md-1 d-none d-lg-block art-item-img">
            <img src="{{asset('images/pdf-icon.png')}}" alt="">
          </div>
          <div class="col-xs-12 col-md-11 art-item-content">
            <div class="art-titulo">
              <a href="{{url('articulo/'.$post->slug)}}">{{$post->titulo}}</a> <span class="badge badge-warning">{{$post->subcategoria->categoria->rubro->nombrerubro}}</span>
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
</div>
<div class="row d-flex justify-content-center mt-5">
  <!-- Paginador -->
  {{$posts->render('layouts.pagination')}}
  <!-- Paginador -->
</div>

</div>
@endsection
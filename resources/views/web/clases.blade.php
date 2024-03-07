@extends('layouts.front')
@section('titulo')
@if($slug =='construccion')
Clases sobre construcción
@elseif($slug == 'mineria')
clases sobre minería
@else
clases sobre arquitectura y diseño
@endif
@endsection
@section('content')
<div class="container">
  @if($slug =='construccion')
  <div class="none">{{$a='construccion'}}</div>
  @elseif($slug == 'mineria')
 <div class="none">{{$a='mineria'}}</div> 
  @else
  <div class="none">{{$a='arquitectura-y-diseno'}}</div>
  @endif

  <hgroup>
    <h2 class="title-custom text-center">CLASES DISPONIBLES</h2>
    <p class="text-center" style="margin-top:1%;">Unidades de "{{$curso->titulo}}"</p>


  </hgroup>
  <div class="row">
        @if($rubro->slug =='construccion')
          <div class="none">{{$a='construccion'}}</div>
          <h5 class="text-center mx-auto">CONSTRUCCIÓN</h5>

        @elseif($rubro->slug == 'mineria')
          <div class="none">{{$a='mineria'}}</div> 
          <h5 class="text-center mx-auto">MINERÍA</h5>
        @else
          <div class="none">{{$a='arquitectura-y-diseno'}}</div>
          <h5 class="text-center mx-auto">ARQUITECTURA Y DISEÑO</h5>
        @endif
        

     <div class="col-xs-12 col-md-12">
      <ul class="video-list ">
        @foreach($clases as $clase)
          <li class="video-item ">
            <a href="{{url('clase/'.$clase->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('imgCurso/'.$clase->url_portada)}}" alt="{{$clase->titulo}}">
               {{-- <img src="https://plataforma.constructivo.com/posts/{{$clase->image}}" alt=""> --}}
              </picture>
              {{--<span class="play">
                <i class="fa fa-play"></i>
              </span>--}}
              
            </a>
            <ul class="video-mini-states">
              <li class="video-duration">
               <strong><i  class="fas fa-tv" ></i></strong>  {{$clase->countMaterial()}} Materiales
              </li>
              {{--<li class="views">
               2 alumnos
              </li>--}}
            </ul>
            <div class="video-item-details">
              <h3 class="video-item-title">
                <a href="{{url('clase/'.$clase->slug)}}">{{$clase->titulo}}</a>
              </h3>
              <div class="mt-1 mb-1">
                <span class="tag-post">{{$clase->curso->rubro->nombrerubro}}</span>
                 <div class="none">{{$a=($clase->curso->rubro->slug)}}</div>
              </div>
              <div class="mt-1 mb-1">
                {{--<p class="precio">S/. {{$clase->precio}}.00</p>--}}
                <p class="promocion"> {{date('d-m-y',strtotime($clase->fecha))}}</p>
              </div>
              <div class="video-author">
                  <div class="author-pic">
                    <img src="{{asset('posts/'.$clase->curso->autor->imagen)}}" alt="">
                      {{-- <img src="https://plataforma.constructivo.com/posts/{{$clase->autor->imagen}}" alt=""> --}}
                  </div>
                  <strong class="author-name"><a href="{{url('videos/autor/'.$clase->curso->autor->slug)}}">{{$clase->curso->autor->nombre}}</a></strong>
              </div>
              
            </div>
          </li>
        @endforeach
      </ul>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
  
  </div>
</div>
@endsection
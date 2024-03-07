@extends('layouts.front')
@section('titulo','Revistas de Construcción, Minería y Arquitectura')
@section('content')
<div class="container">
  <hgroup>
    <h1 class="title-custom text-center">Ediciones recientes</h1>
  </hgroup>
  <div class="row">
    <ul class="revista-list d-flex justify-content-center flex-wrap">
        <li class="col-xs-12 col-md-4 col-lg-3">
          <div class="revista-item">
            <div class="revista-item-header">
              <div class="content-img">
                <a href="{{route('revistas',$mediorc->medio)}}">
                  {{-- <img src="https://plataforma.constructivo.com/revistas/{{$mediorc->perspectiva}}" alt=""> --}}
                  <img src="{{asset('revistas/'.$mediorc->perspectiva)}}" class="img-fluid" alt="">
                </a>
              </div>
            </div>
            <div class="revista-item-details">
              <h4 class="text-center"><strong>Edición {{$mediorc->nro}}</strong></h4>
              <p class="revista-fecha">{{$mediorc->fecha}} - {{$mediorc->año}}</p>
              <hr>
              <a href="{{route('revistas',$mediorc->medio)}}" class="btn btn-outline-blue btn-block">Ver todas</a>
            </div>
          </div>
        </li>
        <li class="col-xs-12 col-md-4 col-lg-3">
          <div class="revista-item">
            <div class="revista-item-header">
              <div class="content-img">
                <a href="{{route('revistas',$mediotm->medio)}}">
                  {{-- <img src="https://plataforma.constructivo.com/revistas/{{$mediotm->perspectiva}}" alt=""> --}}
                  <img src="{{asset('revistas/'.$mediotm->perspectiva)}}" class="img-fluid" alt=""> 
                </a>
              </div>
            </div>
            <div class="revista-item-details">
              <h4 class="text-center"><strong>Edición {{$mediotm->nro}}</strong></h4>
              <p class="revista-fecha">{{$mediotm->fecha}} - {{$mediotm->año}}</p>
              <hr>
              <a href="{{route('revistas',$mediotm->medio)}}" class="btn btn-outline-blue btn-block">Ver todas</a>
            </div>
          </div>
        </li>
        <li class="col-xs-12 col-md-4 col-lg-3">
          <div class="revista-item">
            <div class="revista-item-header">
              <div class="content-img">
                <a href="{{route('revistas',$medioda->medio)}}">
                  {{-- <img src="https://plataforma.constructivo.com/revistas/{{$medioda->perspectiva}}" alt=""> --}}
                  <img src="{{asset('revistas/'.$medioda->perspectiva)}}" class="img-fluid" alt="">  
                </a>
              </div>
            </div>
            <div class="revista-item-details">
              <h4 class="text-center"><strong>Edición {{$medioda->nro}}</strong></h4>
              <p class="revista-fecha">{{$medioda->fecha}} - {{$medioda->año}}</p>
              <hr>
              <a href="{{route('revistas',$medioda->medio)}}" class="btn btn-outline-blue btn-block">Ver todas</a>
            </div>
          </div>
        </li>
    </ul>
  </div>
</div>
@endsection
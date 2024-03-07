@extends('layouts.front')
@section('titulo')
Mis Intereses

@endsection
@section('content')
<div class="container">
 
  <hgroup>
    <h2 class="title-custom text-center">MIS INTERESES</h2>
    {{--<p class="text-center" style="margin-top:1%;">Certifícate con los cursos técnicos disponibles que tenemos para ti.</p>--}}


  </hgroup>
  <div class="row">
       
          {{--<h5 class="text-center mx-auto">ARQUITECTURA</h5>--}}

        

     <div class="col-xs-12 col-md-12">
      <ul class="video-list ">
        @foreach($cursos as $curso)
        @if(Auth()->user()->InteresCurso($curso->id))

         <li class="video-item three">
            
                <a href="{{url('curso/'.$curso->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="{{$curso->titulo}}">
               {{-- <img src="https://plataforma.constructivo.com/posts/{{$curso->image}}" alt=""> --}}
              </picture>
              {{--<span class="play">
                <i class="fa fa-play"></i>
              </span>--}}
              
               </a>

           
              @if(Auth()->user())
              
              <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{url('curso/'.$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
                {{--<span class="tag-post">{{$curso->rubro->nombrerubro}}</span>--}}
                 <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 <p style="font-size: 14px;">{!!substr($curso->descripcion,0,100)!!}. . . </p>

                  @if(Auth()->user()->SuscriptorCursos($curso->id))
                      <ul class="video-mini-states">
                    <li class="video-duration">
                             <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                            </li>


                      <li class="views" style="color:red">
                       Participando
                      </li>
                    </ul>
                        @else

                        <ul class="video-mini-states">
                    <li class="video-duration">
                             <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                            </li>
                    </ul>
                     @endif
                
              </div>


              @else
              {{--}} <ul class="video-mini-states">
            <li class="video-duration">
                    <strong><i  class="fas fa-tv" ></i></strong>  {{$curso->countClases()}} Clases
                    </li>


              <li class="views">
               {{$curso->countAlumnos()}}  alumnos
              </li>
            </ul>--}}
            <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{url('curso/'.$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
                {{--<span class="tag-post">{{$curso->rubro->nombrerubro}}</span>--}}
                 <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 <p style="font-size: 14px;">{!!substr($curso->descripcion,0,100)!!}. . . </p>

                 <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                
              </div>
               
                {{--<div class="mt-1 mb-1">
                <p class="precio">S/. {{$curso->precio}}.00</p>
                <p class="promocion">S/. {{$curso->promocion}}.00</p>
                </div>--}}
              

              {{--<div class="video-author">
                  <div class="author-pic">
                    <img src="{{asset('posts/'.$curso->autor->imagen)}}" alt="">
                  </div>
                  <strong class="author-name"><a href="{{url('videos/autor/'.$curso->autor->slug)}}">{{$curso->autor->nombre}}</a></strong>
              </div>--}}
              @endif
                 @if(Auth()->user())
              
                @else
                @endif


            </div>
          </li>
        @else
        @endif
        @endforeach
      </ul>
    </div>
  </div>
  <div class="row d-flex justify-content-center">
  
  </div>
</div>
@endsection
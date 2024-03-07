@extends('layouts.front')
@section('titulo')
Beneficios
@endsection
@section('content')


<div class="container">
 {{-- <br>
  <h2 class="text-center" style="font-weight: 700">BENEFICIOS</h2>
  <h5 class="text-center">Por la suscripción usted tiene el beneficio de elegir cualquiera de estos cursos totalmente gratis</h5>--}}
<div class="none">{{$curA=0}} </div>
@foreach($cursosA as $curso)
@if(Auth()->user()->SuscriptorCursos($curso->id))
@else
<div class="none">{{$curA=$curA+1}}</div>
@endif
@endforeach
@if($curA>0)
  <hgroup>
      <h2 class="title-custom text-center">CURSOS DE ARQUITECTURA</h2>
    </hgroup>
@endif
  <div class="row">
        

     <div class="col-xs-12 col-md-12">
      <ul class="video-list">
        @foreach($cursosA as $curso)
          @if(Auth()->user()->SuscriptorCursos($curso->id))
          @else

          <li class="video-item three">
            
                <a href="{{route('getbeneficio',$curso->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="{{$curso->titulo}}">
              </picture>
               </a>

           
              @if(Auth()->user())
              
              <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
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
            <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
                 <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 <p style="font-size: 14px;">{!!substr($curso->descripcion,0,100)!!}. . . </p>

                 <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                
              </div>
              @endif
                 @if(Auth()->user())
              
                @else
                @endif


            </div>
             <p class="text-center"><a style="padding: 2% 10%;font-weight: 700" href="{{route('getbeneficio',$curso->slug)}}"   class="btn btn-primary">Elegir</a></p>
          </li>
          @endif
        @endforeach
      </ul>
    </div>
  </div>
   <div class="row d-flex justify-content-center mt-3">
  </div> 


<div class="none">{{$curM=0}} </div>
@foreach($cursosM as $curso)
@if(Auth()->user()->SuscriptorCursos($curso->id))
@else
<div class="none">{{$curM=$curM+1}}</div>
@endif
@endforeach
@if($curM>0)
  <hgroup>
      <h2 class="title-custom text-center">CURSOS DE MINERÍA</h2>
    </hgroup>
@endif

  <div class="row">
        

     <div class="col-xs-12 col-md-12">
      <ul class="video-list">
        @foreach($cursosM as $curso)
        @if(Auth()->user()->SuscriptorCursos($curso->id))
        @else
          <li class="video-item three">
            
                <a href="{{route('getbeneficio',$curso->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="{{$curso->titulo}}">
              </picture>
               </a>

           
              @if(Auth()->user())
              
              <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
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
            <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
                 <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 <p style="font-size: 14px;">{!!substr($curso->descripcion,0,100)!!}. . . </p>

                 <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                
              </div>

              @endif


            </div>
             <p class="text-center"><a style="padding: 2% 10%;font-weight: 700" href="{{route('getbeneficio',$curso->slug)}}"   class="btn btn-primary">Elegir</a></p>
          </li>

          @endif
        @endforeach
      </ul>
    </div>
  </div>
   <div class="row d-flex justify-content-center mt-3">
  </div> 



<div class="none">{{$curC=0}} </div>
@foreach($cursosC as $curso)
@if(Auth()->user()->SuscriptorCursos($curso->id))
@else
<div class="none">{{$curC=$curC+1}}</div>
@endif
@endforeach
@if($curC>0)
  <hgroup>
      <h2 class="title-custom text-center">CURSOS DE CONSTRUCCIÓN</h2>
    </hgroup>
@endif

  <div class="row">
        

     <div class="col-xs-12 col-md-12">
      <ul class="video-list">
        @foreach($cursosC as $curso)
         @if(Auth()->user()->SuscriptorCursos($curso->id))
         @else
          <li class="video-item three">
            
                <a href="{{route('getbeneficio',$curso->slug)}}" class="video-item-cover video-player">
              <picture width="278" height="156">
                <img src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="{{$curso->titulo}}">
              </picture>
               </a>

           
              @if(Auth()->user())
              
              <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
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
            <div class="video-item-details">
              <h1 class="video-item-title" >
               
              <a style="font-size:20px;" href="{{route('getbeneficio',$curso->slug)}}">{{$curso->titulo}}</a>
           
                
              </h1>
              <div class="mt-1 mb-1">
                 <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 <p style="font-size: 14px;">{!!substr($curso->descripcion,0,100)!!}. . . </p>

                 <span style="font-size: 14px;color:#007bff;">{{date('d/m/Y',strtotime($curso->fecha))}} &nbsp;  {{$curso->time}}</span>
                
              </div>
              @endif
                 @if(Auth()->user())
              
                @else
                @endif


            </div>
             <p class="text-center"><a style="padding: 2% 10%;font-weight: 700" href="{{route('getbeneficio',$curso->slug)}}"   class="btn btn-primary">Elegir</a></p>
          </li> 
          @endif
        @endforeach
      </ul>
    </div>
  </div>
   <div class="row d-flex justify-content-center mt-3">
  </div> 

</div>
@endsection
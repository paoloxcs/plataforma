@extends('layouts.front')
@section('titulo')
{{$curso->titulo}}
@endsection
@section('content')
<div class="bg-response" id="mensajepago">
</div>
<div class="container" itemscope itemtype="http://schema.org/VideoObject">
  <div class="row mt-4">
    <div class="col-xs-12 col-md-8">
      <h2 class="titulo-curso">{{$curso->titulo}}</h2>
      <div class="embed-responsive embed-responsive-16by9"> 

        <img class="embed-responsive-item" src="{{asset('imgCurso/'.$curso->url_portada)}}" ></img>

      </div>

      <div class="preview-video">
         <div class="none">{{$a=($curso->rubro->slug)}}</div>
               



        <h4 class="text-weight title">Descripción</h4>
        <p class="mt-3">
          {!!$curso->descripcion!!}
        </p>

        <br>


        <h4 class="text-weight title">Temario</h4>
        <p class="mt-3">
          <ul>
            @foreach($temas as $tema)
            <li>{{$tema->descripcion}}</li>
            @endforeach
           
          </ul>
        </p>

        @if($comentarios->count() > 0)
        <br>
        <h4 class="text-weight title">Comentarios</h4>
        <br>
        @endif
          <div class="row row-cols-1 row-cols-md-2 ">
            @foreach($comentarios as $coment)
            @if($coment->curso_id == $curso->id)
            <div class="col-xs-6 col-sm-12 col-md-6 " style="margin-bottom: 4%;">
              <div class="card">
               
                <div class="card-body">
                  <div class="user-datos">

                    <div class="img-user">
                       @if($coment->user->url_foto != null)
                         <img src="{{asset('fotousers/'.$coment->user->url_foto)}}" alt="">
                       @else
                         <img  src="{{asset('fotousers/profile.png')}}" alt="">
                       @endif

                    </div>

                    <div class="name-user"><p>{{$coment->user->fullname()}}</p></div>
                  </div>
                  <p class="card-text comentario"><i class="far fa-comment-alt" style="color:#FF8000;"></i> {{$coment->texto}}</p>
                </div>
              </div>
            </div>
            @else
            @endif
            @endforeach

          
          </div>

           <br> 
      </div>


    </div>

    <div class="col-xs-12 col-md-4">
      <meta itemprop="thumbnail" content="{{$curso->url_portada}}" />
      <meta itemprop="thumbnailUrl" content="{{asset('imgCurso/'.$curso->url_portada)}}" />
      <meta itemprop="uploadDate" content="{{$curso->fecha}}" />

    
    @if($curso->fecha_culminacion>=date('Y-m-d'))
      
          <div class="preview-info mb-4">
                 
                  <h1 class="title-info" style="font-size: 35px">Obtener el beneficio</h1>
                   <h5>GRATIS</h5>
                  
                  <p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio  S/.  {{$curso->promocion}}.00</p>
                  <div class="mt-2-text-center">
                    <form action="{{route('postbeneficio')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="curso_id" value="{{$curso->id}}">
                    <button type="submit"   class="btn btn-dark">obtener</button>
                    </form>

                  </div>
          </div>



     
    @else
      
     

    @endif
      <h5 class="text-weight">Acerca del profesor</h5>
        
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <div class="card">
               
                <div class="card-body">
                  <div class="user-datos">
                    <div class="img-user">
                       @if($curso->autor->imagen != "")
                         <img src="{{asset('posts/'.$curso->autor->imagen)}}" alt="">
                       @else
                         <img  src="{{asset('fotousers/profile.png')}}" alt="">
                       @endif

                    </div>

                    <div class="name-user"><p>{{$curso->autor->nombre}}</p></div>
                  </div>
                  <p class="card-text comentario">{!!$curso->autor->bio!!}</p>
                 <p class="text-center"> <a href="{{url('videos/autor/'.$curso->autor->slug)}}" class="btn-autor">Ver</a></p>
                </div>
              </div>
            </div>
          
          </div>


          <h5 class="text-weight">Certifica tus habilidades</h5>
        
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <img src="{{asset('images/certificado.jpg')}}" width="100%;">
            </div>
          
          </div>


          <br>
        
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <div class="banner-suscriptor">
                <h5><strong>Vuélvete Premium y obtén descuentos en todos los cursos</strong></h5>
                <p>¡Además accede a videos de capacitaciones, artículos técnicos y mucho más!</p>
                <br>
                <a href="{{route('planes',$a)}}" >¡Quiero ser Premium!</a>
              </div>
            </div>
          
          </div>





      </div>




      {{--<h4>Este curso consta de {{$curso->countClases()}} clases</h4>
      <ul class="list-group curso_ul">
        <li class="list-group-item active">Contenido</li>
        @foreach($clases as $clase)
        <li class="list-group-item">{{$clase->titulo}}</li>
        @endforeach
      </ul>

      <div class="preview-info mb-4">
        <p class="subtitle mt-3" >Participa en este curso</p>
        <h1 class="title-info" style="font-size: 35px">S/. {{$curso->promocion}}.00</h1>
        <p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio real S/.  {{$curso->precio}}.00</p>
        <div class="mt-2-text-center">
          @if (!\Auth::guest()) 
          <button type="button" id="buyButton1"  class="btn btn-green">Comprar</buttom>
          
          @else
          <a href="{{route('login')}}" class="btn btn-green">Comprar</a>
          @endif

        </div>
      </div>--}}


      
      
    </div>
  </div>
</div>
@endsection
@section('script-extra')

@endsection
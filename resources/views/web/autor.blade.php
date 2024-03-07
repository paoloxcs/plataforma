@extends('layouts.front')
@section('titulo')
{{$autor->nombre}}
@endsection
@section('content')

<div class="container">
  <div class="row autor-deta mt-3">
    <div class="col-xs-12 col-md-6 autor-image mb-3">
      <img src="{{asset('posts/'.$autor->imagen)}}" alt="" class="" width="70%" style="border-radius: 60%;margin-left: 20%">
      {{-- <img src="https://plataforma.constructivo.com/posts/{{$autor->imagen}}" alt=""> --}}
    </div>
    <div class="col-xs-12 col-md-6 text-center">
      <h1 class="font-weight">{{$autor->nombre}}</h1>
      <h5  class="c-green font-weight">{{$autor->nacionalidad}}</h5>
      <p style="font-family: 'Open Sans', sans-serif!important;">{!! $autor->bio !!}</p>
    </div>
  </div>


    <section class="bg-white">
    
 
  <section class="col-md-12 mx-auto mt-5 s-clase-nav s-suplemento-nav ">
      <h5 class="font-weight text-center">SOBRE EL AUTOR</h5>
    {{--<p class=" text-center">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>--}}
      <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" >



      <li class="nav-item" role="presentation">
        <button class="nav-link active" style="text-transform: uppercase;" id="videosid-tab" data-bs-toggle="tab" data-bs-target="#videosid" type="button" role="tab" aria-controls="videosid" aria-selected="false">VIDEOS</button>
      </li>

      <li class="nav-item" role="presentation">
        <button class="nav-link" style="text-transform: uppercase;" id="cursosid-tab" data-bs-toggle="tab" data-bs-target="#seriesid" type="button" role="tab" aria-controls="seriesid" aria-selected="false">SERIES</button>
      </li>

      <li class="nav-item" role="presentation">
        <button class="nav-link" style="text-transform: uppercase;" id="cursosid-tab" data-bs-toggle="tab" data-bs-target="#cursosid" type="button" role="tab" aria-controls="cursosid" aria-selected="false">CURSOS</button>
      </li>

      <li class="nav-item" role="presentation">
        <button class="nav-link" style="text-transform: uppercase;" id="articulosid-tab" data-bs-toggle="tab" data-bs-target="#articulosid" type="button" role="tab" aria-controls="articulosid" aria-selected="false">ARTÍCULOS</button>
      </li>
    

      
    </ul>

    <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="videosid" role="tabpanel" aria-labelledby="videosid-tab">
     
      @if($videos->count()>0)  

            <section class=" col-md-12 mx-auto row pbm-0 swiper" >
              
                @foreach($videos as $post)
                
                   <section class="col-md-3 col-xs-12 card-curso card-curso-p ">
                    <div class="img">
                      <a href="{{route('getvideo',$post->slug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                       <span><a href="{{route('getvideo',$post->slug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>
                       <span class="s-disponible" style="background: #ffd813;color:black;font-size: 14px">{{$post->subcategoria->categoria->rubro->nombrerubro}}</span>
                    </div>
                    <div class="text">
                      <a href="{{route('getvideo',$post->slug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                      
                      <p>{!!substr($post->infoadd,0,75)!!}. . . </p>
                      <p class="p-inline p-c-i"><i class="far fa-eye"></i> {{$post->CountVistas()}}</p>
                      <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>

                      <section class="s-button">
                      <p class="text-center-mob"><a href="{{route('getvideo',$post->slug)}}" class="a-transparent-g">VER CAPACITACIÓN</a></p>
                  </section>
                    </div>
                    
                  </section>
                @endforeach
              
          
              {{--lass="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fas fa-chevron-right"></i></a></p>--}}


          </section>
      @else
          <h4 class="text-center mt-5">Por el momento no hay videos del autor, busque más tarde . . .</h4>
          <br>
          <br>
          <br>
        @endif


      </div>


       <div class="tab-pane fade" id="seriesid" role="tabpanel" aria-labelledby="seriesid-tab">
     
      @if($series->count()>0)  

            <section class=" col-md-12 mx-auto row pbm-0 swiper" >
              
                @foreach($series as $post)

                   <section class="col-md-3 col-xs-12 mt-2-mob card-curso card-curso-p">
                    <div class="img">
                      <a href="{{route('getserie',$post->slug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                       {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
                    </div>
                    <div class="text">
                      <a href="{{route('getserie',$post->slug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                      <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                     {{-- <p>{!!substr($post->infoadd,0,75)!!}. . . </p>--}}
                      <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$post->CountVistas()}}</p>
                      <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>

                      <section class="s-button">
                          
                      <p class="text-center-mob"><a href="{{route('getserie',$post->slug)}}" class="a-transparent-g">VER SERIE</a></p>
                      </section>
                    </div>
                    
                  </section>
                @endforeach
              
          
              {{--<p class="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fas fa-chevron-right"></i></a></p>--}}


          </section>
      @else
          <h4 class="text-center mt-5">Por el momento no hay series del autor, busque más tarde . . .</h4>
          <br>
          <br>
          <br>
        @endif


      </div>



      <div class="tab-pane fade" id="cursosid" role="tabpanel" aria-labelledby="cursosid-tab">
        @if($cursos->count()>0)
            <section class=" col-md-12 mx-auto row pbm-0 swiper" >
              
                
                @foreach($cursos as $curso)

                    <section class="col-md-3 col-xs-12 card-curso card-curso-p ">
                      <div class="img">
                        <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                        <span class="s-disponible" style="background: #ffd813;color:black;font-size: 14px">{{$curso->rubro->nombrerubro}}</span>
                      </div>
                      <div class="text">
                        <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h4 class="title font-weight">{{$curso->titulo}}</h4></a>
                        <p>{!!substr($curso->descripcion,0,75)!!}. . . </p>
                        <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
                        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$curso->CountValoracion()}}</p>

                        <section class="s-button">
                       <p class="text-center-mob"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO</a></p>
                  </section>
                      </div>
                      
                    </section>
                  
                  @endforeach
                  
              
          
             {{--}} <p class="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fas fa-chevron-right"></i></a></p>--}}


          </section>
        @else
          <h4 class="text-center mt-5">Por el momento no hay cursos del autor, busque más tarde . . .</h4>
          <br>
          <br>
          <br>
        @endif


      </div>

      <div class="tab-pane fade" id="articulosid" role="tabpanel" aria-labelledby="articulosid-tab">
        @if($articulos->count()>0) 
          <section class=" col-md-12 mx-auto row pbm-0 swiper" >
            
              @foreach($articulos as $post)
              <section class="col-md-3 col-xs-12 card-curso card-curso-p " >
                    <div class="text">
                      <a href="{{route('getarticulo',$post->slug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>

                      <a href="{{route('getarticulo',$post->slug)}}" style="text-decoration:none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                      <span class="p-rubro" style="text-transform: uppercase;">{{$post->subcategoria->categoria->rubro->nombrerubro}}</span>
                      <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                      <p>{!!substr($post->infoadd,0,75)!!}. . . </p>
                      <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>
                      <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->CountVistas()}}</p>
                       <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads()->count()}}</p>

                      <section class="s-button">
                    <p class="text-center-mob"><a href="{{route('getarticulo',$post->slug)}}" class="a-transparent-g">VER</a></p>
                  </section>
                    </div>
                    
                </section>
              @endforeach
           
        
          {{--}}  <p class="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fasfa-chevron-right"></i></a></p> --}}


        </section>
        @else
            <h4 class="text-center mt-5">Por el momento no hay artículos del autor, busque más tarde . . .</h4>
            <br>
            <br>
            <br>
        @endif


      </div>
    </div>

    
    </div>

    </section>
   </section>

  

   
   
  </div>   
</div>
@endsection
@section('script-extra')
    <script>
      var swiper = new Swiper('#swiper', {
        slidesPerView: 4,
        direction: getDirection(),
         autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
        navigation: {
          nextEl: '#swiper-button-next',
          prevEl: '#swiper-button-prev',
        },
      });

         function getDirection() {
        var windowWidth = window.innerWidth;
        var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

        return direction;
      }
    </script>
@endsection

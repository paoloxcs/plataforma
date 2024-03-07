@extends('layouts.front')
@section('titulo','Aprendizaje Online, Videos, Artículos, Suplemento técnico')
@section('content')
 
  

  <section class="col-md-12 row pbm-0 s-rubro-b">
    <section class="col-md-10 mx-auto">
      

      <h1 class="mt-5 mt-5-mob c-white font-weight tt-uppercase">¡HOLA, {{Auth()->user()->name}}!</h1>

      <section class="col-md-12 row pbm-0 mt-5 mt-5-mob">
        <h3 class="font-weight text-center c-white">CATEGORÍAS PRINCIPALES</h3>
        <section class="col-md-10 col-xs-9 mx-auto row pbm-0  mt-4" {{--id="swiper1"--}}>
          <section class="row">
              
          <div class="col-md-4 col-xs-12 mt-2-mob">
            <div class="c-tipo">
              <a href="rubro/arquitectura-y-diseno"><img src="{{asset('images/img-arquitectura.jpg')}}" width="100%"></a>
              <div class="text">
                <a href="rubro/arquitectura-y-diseno" class="td-none"><h5 class="c-green font-weight p-inline" style="color:#24db37;font-weight: 900">ARQUITECTURA Y DISEÑO</h5></a>
                <p class="left-green"><a href="rubro/arquitectura-y-diseno"><i class="fas fa-chevron-right" ></i></a></p>
              </div> 
            </div>
          </div>

          <div class="col-md-4 col-xs-12 mt-2-mob">
            <div class="c-tipo">
              <a href="rubro/construccion"><img src="{{asset('images/img-construccion.jpg')}}" width="100%"></a>
              <div class="text">
                <a href="rubro/construccion" class="td-none"><h5 class="c-green font-weight p-inline" style="color:#24db37;font-weight: 900">CONSTRUCCIÓN</h5></a>
                <p class="left-green"><a href="rubro/construccion"><i class="fas fa-chevron-right" ></i></a></p>
              </div> 
            </div>
          </div>

          <div class="col-md-4 col-xs-12 mt-2-mob">
            <div class="c-tipo">
              <a href="rubro/mineria"><img src="{{asset('images/img-mineria.jpg')}}" width="100%"></a>
              <div class="text">
                <a href="rubro/mineria" class="td-none"><h5 class="c-green font-weight p-inline" style="color:#24db37;font-weight: 900">MINERÍA</h5></a>
                <p class="left-green"><a href="rubro/mineria"><i class="fas fa-chevron-right" ></i></a></p>
              </div> 
            </div>
          </div>




          
          
          </section>
        </section>
      </section>
    </section>
    
  </section>
           
 

 
  <section class="bg-gris">
    
 
  <section class="col-md-10 mx-auto mt-5 s-clase-nav s-suplemento-nav ">
      <h5 class="font-weight text-center tt-uppercase">¿Qué te gustaría Aprender? </h5>
    <p class=" text-center">Aprende a tu ritmo, disfruta de todo el contenido que ofrece Plataforma Constructivo y lleva la información a donde desees</p>
      <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" >

      
      @foreach($rubros as $rubro)
      @if($loop->iteration==1)
      <div class="none">{{$active='active'}}</div>
      @else
      <div class="none">{{$active=''}}</div>
      @endif

      <li class="nav-item" role="presentation">
        <button class="{{'nav-link '.$active }}" style="text-transform: uppercase;" id="{{$rubro->slug.'-tab'}}" data-bs-toggle="tab" data-bs-target="{{'#'.$rubro->slug}}" type="button" role="tab" aria-controls="{{$rubro->slug}}" aria-selected="false">{{$rubro->nombrerubro}}</button>
      </li>
      @endforeach

      
    </ul>

    <div class="tab-content col-md-12 mt-5" id="myTabContent">
      @foreach($rubros as $rubro)
      @if($loop->iteration==1)
      <div class="none">{{$active='active'}}</div>
      @else
      <div class="none">{{$active=''}}</div>
      @endif
      <div class="{{'tab-pane fade show '.$active}}" id="{{$rubro->slug}}" role="tabpanel" aria-labelledby="{{$rubro->slug.'-tab'}}">
         
        <section class=" col-md-12 mx-auto row pbm-0 swiper" id="swiper">
          <section class="swiper-wrapper d-flex pbm-0-mob">
            @foreach($rubro->videos(6) as $post)
            <section class="col-md-3 col-xs-12  swiper-slide card-curso" >
              <div class="img">
                <a href="{{route('getvideo',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
              </div>
              <div class="text">
                <span class="p-rubro" style="text-transform: uppercase;">{{$rubro->nombrerubro}}</span>
                <a href="{{route('getvideo',$post->pslug)}}" style="text-decoration: none;"><p class="title">{{$post->titulo}}</p></a>
                <a href="{{route('getAutor',$post->auslug)}}" class="td-none"><p class="name-d"><span><i class="fas fa-user-tie"></i></span>&nbsp;&nbsp;{{$post->nombreautor}}</p></a>
              </div>
              
            </section>
            @endforeach
          </section>
      
          <p class="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fas fa-chevron-right"></i></a></p>


      </section>


      </div>

      @endforeach

    
    </div>

    </section>
   </section>
  

       


        

          @endsection
          @section('script-extra')
          <script>
      var swiper = new Swiper('#swiper', {
        slidesPerView: window.innerWidth <= 900 ? 1 : 4,
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

          var swiper1 = new Swiper('#swiper1', {
          slidesPerView: window.innerWidth <= 900 ? 1 : 3,
          autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
          navigation: {
            nextEl: '#swiper-button-next1',
            prevEl: '#swiper-button-prev1',
          },
        });


        var swiper2 = new Swiper('#swiper2', {
          slidesPerView: window.innerWidth <= 900 ? 1 : 4,
          autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
          navigation: {
            nextEl: '#swiper-button-next2',
            prevEl: '#swiper-button-prev2',
          },
        });


       
      var swiper3 = new Swiper("#swiper3", {
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
          el: "#swiper-pagination3",
          clickable: true,
        },
      });
    
       var swiper4 = new Swiper("#swiper4", {
        spaceBetween: 30,
        autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
          el: "#swiper-pagination4",
          clickable: true,
        },
      });


      function getDirection() {
        var windowWidth = window.innerWidth;
        var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

        return direction;
      }
    </script>
            
          <script type="text/javascript">
            $(document).ready(function(){
          /*    spinner.show();*/
            });
            
            $("#switch").on('click',function(){
                $("#morevids").toggle('slow');
                $("#switch").hide();
            });
          </script>

@endsection

@extends('layouts.front')
@section('titulo','Aprendizaje Online, Videos, Artículos, Suplemento técnico')
@section('content')
 
  


           
  {{--<section style="background-image: url({{asset('images/sliderprincipal.jpg')}});" class="col-md-12 banner-pri">
    <div class="text">
      <h1 class="font-weight">Capacítate en cualquier momento</h1>
      <p style="width:75%;">Accede a nuestras publicaciones de ingeniería y arquitectura, vídeos de capacitación y cientos de artículos técnicos</p>
      <br>
      <a class="a-transparent-g" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">CREAR CUENTA</a>
    </div>
  </section>--}}

  <div id="carouselExampleCaptions" class="carousel slide mt-2" data-bs-ride="carousel">
    <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
    {{--<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>

     <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 3"></button>--}}
  </div>

    <div class="carousel-inner">
      {{--<div class="carousel-item active banner-pri">
        <img src="{{asset('images/sliderprincipal.jpg')}}" class="d-block w-100" alt="...">
        <div class="text">
          <h1 class="font-weight">Capacítate en cualquier momento</h1>
          <p style="width:75%;">Accede a nuestras publicaciones de ingeniería y arquitectura, vídeos de capacitación y cientos de artículos técnicos</p>
          <br>
          <a class="a-transparent-g" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">CREAR CUENTA</a>
        </div>
      </div>--}}
      <div class="carousel-item active banner-pri">
        <img src="{{asset('images/Indexprincipal1.jpg')}}" class="d-block w-100 none-mobile" alt="...">
        <img src="{{asset('images/banner-pri-1.jpg')}}" class="d-block w-100 none-desktop" alt="...">
       <!-- <div class="text text-mob">
          <h1 class="font-weight text-center-mob">Tu futuro profesional a un clic de distancia </h1>
          <p style="" class="text-center-mob">Accede a nuestra plataforma de Ingeniería y Arquitectura y disfruta de cursos en vivo, videos de capacitación, artículos técnicos y revistas especializadas.</p>
          <br>
          <p class="text-center-mob"><a class="a-transparent-g" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">CREAR CUENTA</a></p>
        </div> -->
         {{-- CAMBIOS JHED --}}
        <div class="text text-mob text_banner_pri">
          <h1 class="font-weight text-center-mob">Tu futuro profesional a un clic de distancia </h1>
          <p style="" class="text-center-mob">Accede a nuestra plataforma de Ingeniería y Arquitectura y disfruta de cursos en vivo, videos de capacitación, artículos técnicos y revistas especializadas.</p>
          <br>
          <p class="text-center-mob"><a class="a-transparent-g" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">CREAR CUENTA</a></p>
        </div>
        {{-- CAMBIOS JHED --}}
      </div>
      {{--<div class="carousel-item">
        <a href="{{route('planes','construccion')}}"><img src="{{asset('images/Indexprincipal2.jpg')}}" class="d-block w-100" alt="..."></a>
      </div>--}}
      <div class="carousel-item banner-pri">
        <a href="{{route('planes','construccion')}}" class="none-mobile"><img src="{{asset('images/Indexprincipal3.jpg')}}" class=" w-100" alt="..."></a>

        <a href="{{route('planes','construccion')}}" class="none-desktop"><img src="{{asset('images/banner-pri-2.jpg')}}" class=" w-100" alt="..."></a>

      </div>
    </div>
    {{--<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleFade" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>--}}
    </button>
  </div>

 
  <section class="bg-gris">
    
 
  <section class="col-md-10 mx-auto mt-5 s-clase-nav s-suplemento-nav ">
      <h4 class="font-weight text-center tt-uppercase">¿Qué te gustaría Aprender? </h4>
    <p class=" text-center">Aprende a tu ritmo, disfruta de todo el contenido que ofrece Plataforma Constructivo y lleva la información a donde desees</p>
      <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist" >

      
      @foreach($rubros as $rubro)
      @if($loop->iteration==1)
      <div class="none">{{$active='active'}}</div>
      @else
      <div class="none">{{$active=''}}</div>
      @endif

      <li class="nav-item" role="presentation">
        <button class="{{'nav-link '.$active }}" style="text-transform: uppercase;" id="{{$rubro->slug.'-tab'}}" data-bs-toggle="tab" data-bs-target="{{'#'.$rubro->slug}}" type="button" role="tab" aria-controls="{{$rubro->slug}}" aria-selected="false" >
            {{ $rubro->nombrerubro }}
        </button>
      </li>
      @endforeach

      
    </ul>

            {{-- <div class="tab-content col-md-12 mt-5" id="myTabContent">
                @foreach ($rubros as $rubro)
                    @if ($loop->iteration == 1)
                        <div class="none">{{ $active = 'active' }}</div>
                    @else
                        <div class="none">{{ $active = '' }}</div>
                    @endif
                    <div class="{{ 'tab-pane fade show ' . $active }}" id="{{ $rubro->slug }}" role="tabpanel"
                        aria-labelledby="{{ $rubro->slug . '-tab' }}">

                        <section class=" col-md-12 mx-auto row pbm-0 swiper" id="swiper">
                            <section class="swiper-wrapper d-flex pbm-0">
                                @foreach ($rubro->videos(6) as $post)
                                    <section class="col-md-3 col-xs-12  swiper-slide card-curso card-curso-mob padding-1">
                                        <div class="img">
                                            <a href="{{ route('getvideo', $post->pslug) }}"><img
                                                    src="{{ asset('posts/' . $post->image) }}" width="100%"></a>
                                            xxx-- <span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>
                                        </div>
                                        <div class="text">
                                            <span class="p-rubro"
                                                style="text-transform: uppercase;">{{ $rubro->nombrerubro }}</span>
                                            <a href="{{ route('getvideo', $post->pslug) }}" style="text-decoration: none;">
                                                <p class="title">{{ $post->titulo }}</p>
                                            </a>
                                            <a href="{{ route('getAutor', $post->auslug) }}" class="td-none">
                                                <p class="name-d"><span><i
                                                            class="fas fa-user-tie"></i></span>&nbsp;&nbsp;{{ $post->nombreautor }}
                                                </p>
                                            </a>
                                        </div>

                                    </section>
                                @endforeach
                            </section>

                            <p class="text-center btn-slider mt-4 mt-2-mob"><a class="swiper-button-prev"
                                    id="swiper-button-prev" style="text-decoration: none;"><i
                                        class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a
                                    class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i
                                        class="fas fa-chevron-right"></i></a></p>

                        </section>
                    </div>
                @endforeach
            </div> --}}

            {{-- SWIPER CURSO RUBRO --}}
            @include('web.swiper-cursos-rubro')

    </section>
   </section>
  
  {{-- <section class="col-md-12 mt-5 mt-5-mob">
        <section class="col-md-10 mx-auto row pbm-0 s-b  padding-1">
          <section class="col-md-7 s-img-b pbm-0">
    
            <img src="{{asset('images/beneficios.jpg')}}"  style=" ">
            
          </section>
    
          <section class="col-md-5 text pbm-0">
              <h1 class="font-weight mt-5  mt-2-mob h1-40 text-center-mob" style="">Disfruta de los Beneficios qué te Ofrece Plataforma Constructivo:</h1>
              <section class="col-md-11">
                 <div class="swiper mySwiper" id="swiper4">
                  <div class="swiper-wrapper">
                    <section class="col-md-11 swiper-slide">
                     <section class="col-md-12 row mt-5 mt-2-mob">
                        <section class="col-md-2 col-xs-3">
                            <img class="" src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0" >
                          <p><span class="font-weight">A TU PROPIO RITMO: </span>Todo el contenido desde la comodidad de tu hogar, tiempo libre en tu oficina.</p>
    
                        </section>
                       
                      </section>
                      <section class="col-md-12 row mt-4">
                        <section class="col-md-2 col-xs-3">
                            <img src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0">
                         <p><span class="font-weight">CONTENIDO DESCARGABLE: </span>Descarga el contenido a tu dispositivo Móvil o PC para verlo sin conexión.</p>
    
                        </section>
                      </section>
                      <section class="col-md-12 row mt-4">
                        <section class="col-md-2 col-xs-3">
                            <img src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0">
                          <p><span class="font-weight">COMUNIDAD: </span>Aplica el contenido aprendido en tus propios proyectos profesionales.</p>
    
                        </section>
                      </section>
    
                  </section>
    
                  <section class="col-md-11 swiper-slide">
                     <section class="col-md-12 row mt-5 mt-2-mob">
                        <section class="col-md-2 col-xs-3">
                            <img src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0">
                          <p><span class="font-weight">EN CUALQUIER LUGAR: </span>Accede a todo el contenido desde tu PC, tablet o smartphone.</p>
                        </section>
                       
                      </section>
                      <section class="col-md-12 row mt-4">
                        <section class="col-md-2 col-xs-3">
                            <img src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0">
                          <p><span class="font-weight">APRENDE AÚN MÁS: </span>Comenta tus dudas, pide feedback y/o aporta soluciones.</p>
                        </section>
                      </section>
                      <section class="col-md-12 row mt-4">
                        <section class="col-md-2 col-xs-3">
                            <img src="{{asset("images/icon1.png")}}" width="85%"> 
                        </section>
                        <section class="col-md-10 col-xs-9 padding-l-0">
                          <p><span class="font-weight">MÁS CONTENIDO: </span>Capacítate según tus intereses y el orden de tu preferencia.</p>
                        </section>
                      </section>
    
                  </section>
    
                  </div>
                  <br><br>
                  <div class="swiper-pagination" id="swiper-pagination4"></div>
                </div>
                
    
          </section>
          
        </section>
      </section> --}}

    {{-- UP Swiper Beneficios --}}
    <section class="container mt-5 mb-5">
        <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 ">
            <div class="px-4 py-4 flex items-center justify-center">
                <img class="w-full sm:w-1/2 lg:w-full object-cover object-center"
                    src="{{ asset('images/beneficios.jpg') }}" style=" ">
            </div>

            @include('web.swiper-beneficios')

        </div>
    </section>

  <section class="col-md-12 mt-5-mob s-con ">
    <h3 class="text-center font-weight mt-5-mob">TE PRESENTAMOS LAS MARCAS  <span class="c-green">QUÉ CONFÍAN EN NOSOTROS</span> </h3>
    {{--<p class="text-center c-white">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed</p>--}}

    <section class="">
      
      <section class="col-md-8 pbm-0 mx-auto mt-5 ">

       {{--<a class="td-none swiper-button-next" id="swiper-button-next1"><p class="c-white text-right p-vermas">ver más <span class="c-green"><i class="fas fa-long-arrow-alt-right"></i></span></p></a>--}}

       {{-- <section class="col-md-12 row swiper" id="swiper">
                <section class="swiper-wrapper">
                    @foreach ($colaboradores as $colaborador)
                        <section class="col-md-3  img-l swiper-slide col-xs-12">
                            <img src="{{ asset('imgColaboradores/' . $colaborador->url_logo_w) }}" height="100px">
                        </section>
                    @endforeach

                </section>

            </section> --}}
            {{-- SWIPER COLAB --}}
            @include('web.swiper-colaboradores')

      </section>

    </section>
      
    </section>
  </section>



  <section class="col-md-12 mt-5-mob s-docentes">
    <div class="b-white">
      <section class="col-md-10 col-xs-12 mx-auto">
        <h4 class="font-weight mt-5 text-center-mob">APRENDE DE LOS MEJORES</h4>
        <p class="text-center-mob">Te presentamos a los profesionales que llevarán tu carrera al siguiente nivel.   </p>
      </section>
      
    </div>
    <div class="b-white-2"></div>

    
        {{-- <div class="div-docentes">

            <section class="col-md-12 row swiper pbm-0-mob" id="swiper2" style="width:100%!important;position: relative;">
                <section class=" swiper-wrapper pbm-0-mob">
                    @foreach ($autores as $autor)
                        @if ($autor->cursoR() != '[]')
                            <section class="col-md-3 col-xs-12 card-curso swiper-slide pbm-0-mob">
                                <a href="{{ route('getAutor', $autor->slug) }}">
                                    <div class="img img-background"
                                        style="background-image: url({{ asset('posts/' . $autor->imagen) }});width: 100%;height: 350px;">

                                        xxx<a href="{{ route('getAutor', $autor->slug) }}"><img
                                                src="{{ asset('posts/' . $autor->imagen) }}" width="100%"
                                                height="350px"></a>

                                    </div>
                                </a>
                                <div class="text">
                                    xxx<p class="subrayado"></p>
                                    <a href="{{ route('getAutor', $autor->slug) }}" class="td-none">
                                        <p class="title text-center font-weight">{{ $autor->nombre }}</p>
                                    </a>
                                    <p class="name-d text-center">{{ $autor->cargo }} - {{ $autor->nacionalidad }} </p>
                                    xxx@if ($autor->cursoR() != '[]')
                                        <p class=" text-center "><span
                                                class="p-rubro">{{ $autor->curso[0]->rubro->nombrerubro }}
                                    xxx@endif

                                    </span> </p>
                                </div>

                            </section>
                        @endif
                    @endforeach

                </section>

            </section>
            <p class="text-center btn-slider mt-4"><a class="swiper-button-prev" style="text-decoration: none;"
                    id="swiper-button-prev2"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a
                    class="swiper-button-next" style="text-decoration: none" id="swiper-button-next2"><i
                        class="fas fa-chevron-right"></i></a></p>

        </div> --}}

        <section class="swiper-autor-section">
            {{-- SWIPER AUTOR --}}
            @include('web.swiper-autor')
        </section>

  </section>
  

    {{-- <section class="col-md-12 s-p-testimonio">
        <section class="col-md-10 mx-auto row pbm-0 s-testimonio">
            <section class="col-md-6 col-xs-12 none-mobile img pbm-0">
                <img src="{{ asset('images/HomeSecundaria.jpg') }}" width="100%">
            </section>
            <section class="col-md-6 col-xs-12 text pbm-0">
                <section class="swiper" id="swiper3" style="position: relative;">
                    <section class="swiper-wrapper" style="position: relative;">

                        <section class="swiper-slide">
                            <h4 class="font-weight
                  text-center-mob mt-2-mob">TESTIMONIOS</h4>
                            <section class="col-md-12
                  row mt-5">
                                <section class="col-md-2">
                                    <p class="text-center-mob"><img class="none-mobile"
                                            src="{{ asset('images/img-test-yrma.jpg') }}" style="border-radius: 40%"
                                            width="99px"></p>
                                </section>
                                <section class="col-md-8">

                                </section>
                                <section class="col-md-2">
                                    <p class="text-center-mob"><img class="img-icon-test"
                                            src="{{ asset('images/Icon-awesome-quote-right.png') }}" width="100"></p>
                                </section>
                            </section>
                            <p class="c-green mt-5 mt-5-mob text-center-mob">"En los últimos años he llevado varios cursos
                                en la Plataforma Constructivo y mi experiencia ha sido muy buena.
                                Los cursos son detallados y los profesores tienen una amplia experiencia para transmitir sus
                                conocimientos, los cuales me han servido para crecer profesionalmente en mi ámbito laboral."
                            </p>
                            <p class="c-white text-center-mob">AYRMA ROJAS RIVA</p>

                        </section>


                        <section class="swiper-slide">
                            <h4 class="font-weight text-center-mob mt-2-mob">TESTIMONIOS</h4>
                            <section class="col-md-12 row mt-5">
                                <section class="col-md-2"> 
                                </section>
                                <section class="col-md-8">

                                </section>
                                <section class="col-md-2">
                                    <p class="text-center-mob"><img class="img-icon-test"
                                            src="{{ asset('images/Icon-awesome-quote-right.png') }}" width="100"></p>
                                </section>
                            </section>
                            <p class="c-green mt-5  text-center-mob">"Gracias a Plataforma Constructivo puedo disfrutar de
                                cursos interactivos, los cuales me ayudan día a día en mi crecimiento personal, además
                                presenta contenido interactivo el cual puedo llevarlo y reproducirlo en todas partes."</p>
                            <p class="c-white text-center-mob">ARTURO OJEDA</p>

                        </section>




                        <section class="swiper-slide">
                            <h4 class="font-weight text-center-mob mt-2-mob">TESTIMONIOS</h4>
                            <section class="col-md-12 row mt-5">
                                <section class="col-md-2"> 
                                </section>
                                <section class="col-md-8">

                                </section>
                                <section class="col-md-2">
                                    <p class="text-center-mob"><img class="img-icon-test"
                                            src="{{ asset('images/Icon-awesome-quote-right.png') }}"></p>
                                </section>
                            </section>
                            <p class="c-green mt-5 text-center-mob">"Plataforma Constructivo presenta una metodología de
                                aprendizaje fresca, con sus más de 25 cursos, puedo desempeñarme como profesional e ir
                                mejorando día a día."</p>
                            <p class="c-white text-center-mob">MOISES ROJAS</p>
                            <br><br><br><br>
                        </section>

                        <section class="swiper-slide">
                            <h4 class="font-weight text-center-mob mt-2-mob">TESTIMONIOS</h4>
                            <section class="col-md-12 row mt-5">
                                <section class="col-md-2"> 
                                </section>
                                <section class="col-md-8">

                                </section>
                                <section class="col-md-2">
                                    <p class="text-center-mob"><img class="img-icon-test"
                                            src="{{ asset('images/Icon-awesome-quote-right.png') }}"></p>
                                </section>
                            </section>
                            <p class="c-green mt-5 text-center-mob">Voy 2 meses en Plataforma Constructivo y simplemente me
                                fascina, gracias a su amplio catálogo puedo encontrar cursos series y capacitaciones muy
                                interesantes de Arquitectura y Diseño.</p>
                            <p class="c-white tt-uppercase text-center-mob">Ana María Torres</p>
                            <br><br><br><br>
                        </section>




                    </section>
                    <div class="swiper-pagination" style="position:absolute;bottom: 0;" id="swiper-pagination3"></div>
                </section>


            </section>
        </section>
    </section> --}}
    {{-- TESTIMONIO --}}
      @include('components.testimonio', [
        'fondo' => true,
    ])


  <section class="col-md-12 s-planes">
    <h1 class="text-center font-weight mt-5-mob">PLANES</h1>
    <p class="text-center">Nuestros planes de suscripción incluye por un solo pago todo el material de: Construcción, Minería y Arquitectura & Diseño. </p>
    <p class="text-center mt-5 d-flex justify-content-center"><a href="" class="a-personal">PERSONAL</a> <a class="a-personal a-empresa" href="{{route('empresas')}}">EMPRESA</a></p>

   {{-- CAMBIOS JHED --}}
     @include('components.planes-old')
     {{-- @include('components.planes-new') --}}
     {{-- CAMBIOS JHED --}}
 </section>


          {{--<div class="caracteristicas">
            <div class="caract">
                <div class="c-3">
                  <div class="icono_c">
                  <i class="far fa-folder-open"></i>                    
                  </div>
                  <div class="descripcion_C">
                  <h2>2.000 recursos en Línea</h2>
                  <p>Explora una amplia variedad de temas de actualidad</p>                    
                  </div>
                </div>
                <div class="c-3">
                  <div class="icono_c">
                  <i class="fas fa-chalkboard-teacher"></i>                 
                  </div>
                  <div class="descripcion_C">
                  <h2>Instructores expertos</h2>
                  <p>Encuentra el instructor adecuado para ti</p>                    
                  </div>
                </div>
                <div class="c-3">
                  <div class="icono_c">
                  <i class="fas fa-external-link-alt"></i>                 
                  </div>
                  <div class="descripcion_C">
                  <h2>Acceso de por vida</h2>
                  <p>Aprende a tu ritmo</p>                    
                  </div>
                </div>
            </div>
          </div>--}}

        

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
        slidesPerView: window.innerWidth <= 900 ? 1 : 4,
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

      var swiper5 = new Swiper('#swiper5', {
          slidesPerView: 1,
          
          autoplay: {
            delay: 2500,
            disableOnInteraction: false,
          },

        loop: true,
        loopFillGroupWithBlank: true,
          navigation: {
            nextEl: '#swiper-button-next5',
            prevEl: '#swiper-button-prev5',
          },
          on: {
            resize: function () {
            },
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

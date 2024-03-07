@extends('layouts.front')
@section('titulo')
Empresas
@endsection
@section('content')
{{-- <section class="col-md-12 banner-pri banner-empre banner-empresa" style=""> --}}
<section class="col-md-12 resp-banner-emp banner-pri banner-empresa d-flex">

  {{-- <section class="col-md-7 col-xs-10 row mx-auto" style="padding-top: 10%"> --}}
  <section class="col-md-8 col-xs-10 row mx-auto col-empresa align-items-center"> 
    <section class="col-md-6 col-xs-12 mt-5 col-xs-11">
      <h1 class="font-weight">Capacita a tu equipo  <span class="c-green font-weight">hoy mismo</span></h1>
      <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Obtén acceso ilimitado para tus colaboradores a vídeos de capacitaciones en construcción, arquitectura y minería, dictados por profesionales del sector.</p>

      <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Acceso y/o descarga de cientos de revistas especializadas en construcción, arquitectura y minería.</p>

      <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Descuentos en seminarios y cursos online en vivo para tus colaboradores con certificación, organizados por nosotros.</p>
    </section>

    <section class="col-md-6 col-xs-12 col-xs-12" id="banner-empre">
      <form class="form-suple form-empresa mt-4" action="{{route('empresasuscrip')}}" method="POST" enctype="multipart/form-data">

        {{ csrf_field() }}

        <div class="mb-3">
          
          <input type="text" class="form-control" name="nombre" placeholder="Nombre y Apellidos">
        </div>
        <div class="mb-3">
         
          <input type="email" class="form-control" name="email" placeholder="E-mail">
        </div>

        <div class="mb-3">
          
          <input type="text" class="form-control" name="telefono" placeholder="Celular (de preferencia con WhatsApp) ">
        </div>

        <div class="mb-3">
          
          <input type="text" class="form-control" name="empresa" placeholder="Empresa ">
        </div>

        {{--<div class="mb-3">
          <select class="form-select form-select-sm select-suple mt-4 form-control select-empresa-g" aria-label=".form-select-sm example">
                <option value="1">Construcción</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
        </div>--}}
        <div class="mb-3">
          <div class="col-md-12 row">
            <div class="col-md-9 mt-1">
              <p class="">Número de personas (mínimo 5)  </p>
            </div>
            <div class="col-md-3">
               <input type="number" class="form-control" name="nro_personas" min="5" required="" value="5" placeholder="5" style="color:black">
            </div>
          


          </div>
            
        </div>

        <div class="">
        <textarea class="form-control" placeholder="¿Qué objetivos tiene tu equipo?" name="objetivos" style="color:black"></textarea>
        </div>
        <div class="mt-3">
          
        <p class="text-center"><button class="a-menu a-menu-b" type="submit" style="text-decoration: none">EMPEZAR</button></p>
        
        </div>
      </form>
    </section>
  </section>
</section>


  <section class="col-md-12 bg-gris s-bene-mob"  >
    <section class="col-md-8 mx-auto row ">
      {{-- <div class="col-md-4 col-xs-12 col-xs-12 mt-5"> --}}
      <div class="col-md-12 mt-5">
        <h2 class="font-weight-mob text-center-mob"><span class="c-green">Beneficios </span> exclusivos para su empresa</h2>
        <p>Desarrolle el talento de su empresa con nuestros videos de capacitación, cursos, medios especializados y artículos técnicos para incrementar el desempeño de su equipo día a día:</p>
        
      </div> 
    {{-- <div class="col-md-7 row mx-auto"> 
        <div class="col-md-6 col-xs-12"> --}}
      {{-- <div class="col-md-7 col-xs-12 row mx-auto">  --}}
      <div class="col-12 row mx-auto"> 
        <div class="col-md-6 col-resp">
          <div class="div-bene-empre bg-gris-black mt-2-mob">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Capacita a tu equipo en temas específicos</p>
          <p>Ponemos a su disposición nuestra plataforma para hacer sesiones de aprendizaje en vivo. Capacitaciones con nuestros profesores sobre un tema especializado de su interés.
 </p>
            
          </div> 
          
          <div class="div-bene-empre bg-white mt-3 mt-2-mob">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Disfruta del contenido descargable</p>
          <p>Accede y/o descarga más de 100 revistas especializadas en arquitectura, construcción y minería.
 </p>
            
          </div>

          <div class="div-bene-empre bg-gris-black mt-2-mob mt-3">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Descuentos exclusivos para suscriptores: </p>
          <p>
            Descuentos en seminarios, talleres y cursos organizados por nosotros.
 </p>
            
          </div> 
        </div>

         {{-- <div class="col-md-6 col-xs-12"> --}}
        <div class="col-md-6 col-resp">
          <div class="div-bene-empre bg-white mt-5 mt-2-mob">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Beneficio de aprendizaje exclusivo</p>
          
          <p>Podrá acceder a un curso especializado Premium, (incluye los materiales y certificado) lo tendrá que completar durante el mes que escogió el curso.
 </p>
            
          </div> 
          
          <div class="div-bene-empre bg-gris-black mt-2-mob mt-3">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Videos de Capacitación</p>
          <p>
            Obtén acceso ilimitado a vídeos de capacitaciones dictados por profesionales del sector.
 </p>
            
          </div>

          <div class="div-bene-empre bg-white mt-3 mt-2-mob">
          <img src="{{asset('images/bene-empresa.png')}}">
          <p class="font-weight mt-3">Artículos actualizados</p>
          <p>Decenas de artículos técnicos especializados en nuestra biblioteca exclusiva para ti.
 </p>
            
          </div>
        </div>


         

          
        </div>
      </div>
    </section>
    
  </section>
  
  {{-- <section class="bg-white md-col-12">
        <section class="col-md-10 mx-auto row mt-5 mt-0-mob">
            <div class="col-md-6 col-xs-12 mt-3 none-mobile d-flex align-items-center">
                <img src="{{ asset('images/empresa-beneficio.jpg') }}" width="100%;">
            </div>
            <div class="col-md-6 col-xs-12 mt-5 mt-5-mob">
                <h2 class="font-weight text-center-mob">Con Plataforma Constructivo obtén los mejores beneficios</h2>
                <p class="text-center-mob">Gracias a nuestra plataforma en constante actualización, disfruta de diversas
                    novedades y disfruta de lo siguiente: </p>
                <div class="col-md-12 row mt-5">
                    <div class="col-md-6 col-xs-12 pbm-0">
                        <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Acceso ilimitado a vídeos de
                            capacitaciones en construcción, arquitectura y minería.</p>
                        <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Acceso y/o descarga de cientos de
                            revistas especializadas en construcción, arquitectura y minería.</p>
                        <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Descuentos en seminarios y cursos
                            online en vivo con certificación, organizados por nosotros.</p>

                        <p class="none-desktop"> <i class="fas fa-check c-green "></i> &nbsp; Decenas de artículos
                            técnicos especializados en nuestra biblioteca.
                        </p>
                        <p class="mt-4 text-center-mob"><a class="a-menu a-menu-b" href="#banner-empre"
                                style="text-decoration: none;">CAPACITA A TU EMPRESA</a></p>

                    </div>
                    <div class="col-md-6 col-xs-12 pbm-0 none-mobile">
                        <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Decenas de artículos técnicos
                            especializados en nuestra biblioteca.
                        </p>

                    </div>
                </div>



            </div>
        </section>


    </section> --}}
    {{-- SWIPER EMPRESA --}}
    <section class="container mt-5 bg-white">
        <section class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2" style="margin-bottom: 5%">
            <div class="px-4 py-1 flex items-center justify-center">
                <img class="w-full sm:w-1/2 lg:w-full object-cover object-center"
                    src="{{ asset('images/empresa-beneficio.jpg') }}" />
            </div>
            <div class="px-4 py-1 flex justify-center mt-5" style="flex-direction: column">
                <h2 class="font-weight text-center-mob">Con Plataforma Constructivo obtén los mejores beneficios</h2>
                <p class="text-center-mob">Gracias a nuestra plataforma en constante actualización, disfruta de diversas
                    novedades y disfruta de lo siguiente: </p>
                <div class="grid grid-cols-2 gap-3">
                    <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Acceso ilimitado a vídeos de
                        capacitaciones en construcción, arquitectura y minería.</p>
                    <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Acceso y/o descarga de cientos de
                        revistas especializadas en construcción, arquitectura y minería.</p>
                    <p class=""> <i class="fas fa-check c-green"></i> &nbsp; Descuentos en seminarios y cursos
                        online en vivo con certificación, organizados por nosotros.</p>
                    <p class=""> <i class="fas fa-check c-green"></i> Decenas de artículos técnicos
                        especializados en nuestra biblioteca.
                    </p>
                </div>

                <p class="mt-4 text-center-mob text-center">
                    <a class="a-menu a-menu-b px-4 py-2" href="#banner-empre" style="text-decoration: none;">CAPACITA A
                        TU EMPRESA</a>
                </p>
            </div>
        </section>
    </section>

  <section class="col-md-12 row pbm-0 mt-5 mx-auto s-e-p">
      <h4 class="text-center font-weight">QUIENES <span class="c-green">CONFIARON</span> EN NOSOTROS</h4>

     
        {{-- <section class="col-md-8 row pbm-0 mx-auto mt-5 swiper" id="swiper1">
            <section class="swiper-wrapper pbm-0">
                @foreach ($colaboradores as $colaborador)
                    <section class="col-md-3 col-xs-12 img-l img-l-mob swiper-slide">
                        <img src="{{ asset('imgColaboradores/' . $colaborador->url_logo) }}" height="100px">
                    </section>
                @endforeach
            </section>
        </section>

        <p class="text-center btn-slider mt-4 p-i-g"><a class="swiper-button-prev" style="text-decoration: none;"
                id="swiper-button-prev1"><i class="fas fa-chevron-left "></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a
                class="swiper-button-next" style="text-decoration: none" id="swiper-button-next1"><i
                    class="fas fa-chevron-right"></i></a></p> --}}

        @include('web.swiper-empresas')
      
    </section>


  <section class="bg-gris-black pbm-0 bg-testi-empre">
    <h5 class="font-weight c-white text-center mt-2-mob">TESTIMONIOS</h5>
    <section class="col-md-10 mx-auto row mt-5 mt-0-mob ">
       <section class="col-md-4 col-xs-12">
         <div class="div-testimonio">
           {{--<img src="{{asset('images/testi-user.png')}}" width="22%;">--}}
           <p>"Plataforma Constructivo me ayuda a capacitarme día a día, gracias a su completa interfaz puedo disfrutar videos desde la comodidad de mi cuarto."</p>
           <p class="text-center"><span class="c-green">Julio Alvarez</span></p>
         </div>
       </section> 
       <section class="col-md-4 col-xs-12">
         <div class="div-testimonio">
           {{--<img src="{{asset('images/testi-user.png')}}" width="22%;">--}}
           <p>"He adquirido el servicio y me siento muy satisfecho con lo aprendido, he descubierto nuevas variables de como desarrollar mi trabajo como profesional, ¡Me encanta!."</p>
           <p class="text-center"><span class="c-green">Rodrigo Alvarado</span></p>
         </div>
       </section>
       <section class="col-md-4 col-xs-12">
         <div class="div-testimonio">
           {{--<img src="{{asset('images/testi-user.png')}}" width="22%;">--}}
           <p>"Llevo 3 meses en Plataforma Constructivo y me siento muy satisfecho con los resultados los cursos en tiempo real son muy buenos, se aprende mucho."</p>
           <p class="text-center"><span class="c-green">Diego Guitierrez</span></p>
         </div>
       </section>
    </section>
  </section>
@endsection
 @section('script-extra')
          <script>

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




      function getDirection() {
        var windowWidth = window.innerWidth;
        var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

        return direction;
      }
    </script>
 
@endsection

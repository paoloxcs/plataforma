@extends('layouts.front')
@section('titulo','Acerca de nosotros')
@section('content')

<section class="col-md-12 banner-pri banner-empre banner-noso" style="">

  <section class="col-md-9 col-xs-12 row mx-auto" style="padding-top: 10%">
    <section class="col-md-6 col-xs-12">
      <h1 class="font-weight text-center-mob"></span> Mejora <span class="c-green font-weight">tu vida profesional</span> a través del aprendizaje.</h1>

      <div class="col-md-11 mx-auto row mt-4">
        <div class="col-md-1 col-xs-1">
          <p class="c-green"><i class="fas fa-check"></i></p>
        </div>
        <div class="col-md-11 col-xs-11">
          <p class="c-white">Videos de aprendizaje y capacitación.</p>
        </div>
        <div class="col-md-1 col-xs-1">
          <p class="c-green"><i class="fas fa-check"></i></p>
        </div>
        <div class="col-md-11 col-xs-11">
          <p class="c-white">Las mejores publicaciones especializadas.</p>
        </div>
        <div class="col-md-1 col-xs-1">
          <p class="c-green"><i class="fas fa-check"></i></p>
        </div>
        <div class="col-md-11 col-xs-11">
          <p class="c-white">Comunidad de artículos técnicos.</p>
        </div>
        <div class="col-md-1 col-xs-1">
          <p class="c-green"><i class="fas fa-check"></i></p>
        </div>
        <div class="col-md-11 col-xs-11">
          <p class="c-white">Suplemento Técnico.</p>
          <p class="mt-5">
            <a href="/planes-de-suscripcion/construccion" class="a-transparent-g">VER PLANES</a>
          </p>
        </div>

      </div>
     
    </section>
   
  </section>
  

</section>
<section class="bg-gris col-md-12">
  <section class="col-md-10 col-xs-12 mx-auto row">
    <section class="col-md-4 mt-5 none-mobile">
      <img src="{{asset('images/acerca-nosotros.jpg')}}" width="100%">
    </section>

      
    <section class="col-md-8 mt-5 mt-0-mob">
      <div class="col-md-12 pbm-0 padding-top-14 mt-2-mob">
      <h3 class="font-weight ">ACERCA DE NOSOTROS</h3>
      </div>
      <div class="col-md-12 row mt-4 mt-2-mob">

      <div class="col-md-6 col-xs-12 pbm-0-mob">

           <p class="">Plataforma Constructivo es la plataforma virtual de enseñanza y aprendizaje en ingeniería y arquitectura que conecta a profesionales y estudiantes con la mejor enseñanza profesional.</p>
      </div>
       <div class="col-md-6 col-xs-12 pbm-0-mob">
           <p class="">Está orientado a generar mayores oportunidades educativas e informativas a nivel nacional e internacional, ofreciendo información de calidad, estructurada y respaldada por profesionales, a través de una plataforma accesible e innovadora. Nuestra motivación es generar un impacto positivo en nuestros usuarios, reduciendo las brechas de información y generando mejores oportunidades en nuestro medio.
</p>
      </div>
        
      </div>
   
    </section>
  </section>

  <section class="col-md-8 mx-auto">
      
    <section class="col-md-11  bg-gris-black sec-suscribete">
      <img class="img-abs none-mobile" src="{{asset('images/suscribete-nosotros.jpg')}}" width="55%">
      <section class="col-md-6 col-xs-12">
        <h2 class="c-white font-weight mt-5 mt-0-mob ">Suscríbete ahora</h2>
        <p class="c-white">No dejes pasar la oportunidad de tener a tu disposición la PLATAFORMA CONSTRUCTIVO de Ingeniería y Arquitectura.Forma parte del gran grupo de profesionales que ya disfrutan de todos sus beneficios.
</p>
        <p class="mt-5">
              <a href="/planes-de-suscripcion/construccion" class="a-transparent-g">VER PLANES</a>
        </p>
        
      </section>
    </section>
  </section>

  <section class="col-md-10 mx-auto" style="padding: 5% 0;">
    <h3 class="font-weight text-center">ÚNETE A NUESTRA COMUNIDAD</h3>
    <div class="col-md-5 mx-auto">
      <p class="text-center padding-1">Podrá aprender y capacitarse en nuestra PLATAFORMA CONSTRUCTIVO de Ingeniería y Arquitectura, donde podrá ver nuestras publicaciones, videos de capacitación y leer cientos de artículos técnicos publicados por los principales profesionales del sector.</p>
    </div>

    <div class="col-md-12 row mt-5 flex-wrap mb-2 d-flex flex-wrap d-flex justify-content-center padding-1">
      <div class="col-md-3 col-xs-6 bg-white div-unete">
      
          <p class="text-center"><img src="{{asset('images/videos-nosotros.jpg')}}" width="40%"></p>
          <h5 class="font-weight text-center">Videos de aprendizaje y capacitación</h5>
       
      </div>
      <div class="col-md-3 col-xs-6 bg-white div-unete">
          <p class="text-center"><img src="{{asset('images/publicaciones-nosotros.jpg')}}" width="40%"></p>
          <h5 class="font-weight text-center">Las mejores publicaciones especializadas</h5>
     
      </div>
      <div class="col-md-3 col-xs-6 bg-white div-unete">
          <p class="text-center"><img src="{{asset('images/comunidad-nosotros.jpg')}}" width="40%"></p>
          <h5 class="font-weight text-center">Comunidad de artículos técnicos</h5>
      </div>
      <div class="col-md-3 col-xs-6 bg-white div-unete">
          <p class="text-center"><img src="{{asset('images/suplemento-nosotros.jpg')}}" width="40%"></p>
          <h5 class="font-weight text-center">Suplemento Técnico</h5>
      </div>
    </div>
    
  </section>
</section>

@endsection
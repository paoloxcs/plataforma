@extends('layouts.front')
@section('titulo','Contacto')
@section('content')

 
    <section class="col-md-12 banner-pri banner-empre banner-contact" >
 

  <section class="col-md-7 col-xs-12 row mx-auto" style="padding-top: 10%">
    <section class="col-md-6 col-xs-12">
      <h2><span class="c-green font-weight">¡Contáctanos</span> , estamos a un clic de distancia!</h2>
      <p class="c-white">Plataforma Constructivo está cerca de ti, en donde te encuentres y a la hora que lo necesites. Con gusto nuestros ejecutivos especializados atenderán tus dudas, recibirán tus comentarios y te brindarán el servicio que requieres. Ponemos a tu alcance el medio de comunicación más cómodo para ti.</p>

      <p class="p-inline p-c-i c-white"><span class="bg-g-i"><i class="fas fa-user"></i> </span>&nbsp;&nbsp;   +51 981 229 242</p>
      <p class="p-inline p-c-i c-white p-m-l"><span class="bg-g-i"><i class="fas fa-thumbs-up "></i> </span>&nbsp;&nbsp;info2@constructivo.com</p>

      <div class="cap-contact col-md-10 mx-auto row">
          <div class="col-md-3 mt-2 col-xs-2">
            <img src="{{asset('images/calidad-premium.png')}}" width="100%">
          </div>
          <div class="col-md-9 col-xs-10">
            <h4 class="font-weight">Capacítate en cualquier momento</h4>
            <a href="/planes-de-suscripcion/construccion" class="a-white">VER PLANES</a>
          </div>
      </div>
    </section>

    <section class="col-md-6 col-xs-12">
      <form class="form-suple mt-4 col-xs-12 padding-1" method="POST" action="{{route('contacto')}}">
        {{ csrf_field() }}

        <div class="mb-3">
          
          <input type="text" class="form-control" name="nombre" placeholder="Nombre y Apellidos" required="">
        </div>
        <div class="mb-3">
         
          <input type="email" class="form-control" name="correo" placeholder="E-mail" required="">
        </div>

        <div class="mb-3">
          
          <input type="text" class="form-control" name="telf" placeholder="Celular (de preferencia con WhatsApp) " required="">
        </div>

        <div class="">
        <textarea class="form-control" name="mensaje" placeholder="Mensaje . . ." required=""></textarea>
        </div>
        <div class="mt-3">
          
        <p class="text-center-mob"><button class="a-menu a-menu-b" type="submit" style="text-decoration: none">ENVIAR</button></p>
        </div>
      </form>
    </section>
  </section>
  

</section>
@endsection
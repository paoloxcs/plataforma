@extends('layouts.front')
@section('titulo','Planes de Suscripción')
@section('content')

<section class="col-md-10 mx-auto row mt-5">
  <section class="col-md-4">
    <img src="{{asset('images/preguntas-frecuentes.jpg')}}" width="100%">
  </section>
  <section class="bg-white col-md-7 mx-auto">

       <div class="temario" style="padding-bottom: 5%;">
          <h4 class="font-weight text-center">Preguntas Frecuentes</h4>
          <p class="text-center">Resolvemos tus dudas a un clic de distancia</p>

          <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  ¿Cómo se renueva la suscripción?
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;" >
                  
                  La suscripción tiene una duración de 6 ó 12 meses, según el plan que se haya elegido y se renueva automáticamente en el caso se haya pagado en línea. En el caso de hacerlo vía depósito/transferencia, debe hacerlo comunicándose con nosotros vía whatsapp al <a target="_blank" title="WhatsApp" href="https://api.whatsapp.com/send?phone=51981324180&amp;text=Hola,%20quisiera%20suscribirme%20a%20la%20plataforma%20mediante%20transeferencia%20">+51 981 324 180</a> o escribiéndonos un correo al  <a target="_blank"  href="mailto:info2@constructivo.com">info2@constructivo.com</a>. 

                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                  ¿Qué obtengo con la membresía?
                </button>
              </h2>
              <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">

                       Va a poder tener acceso ilimitado a todas nuestras publicaciones, así como descuentos y servicios exclusivos para la comunidad Premium.
                </div>
              </div>
            </div>
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                  ¿Hay tarifas especiales para equipos de trabajo?
                </button>
              </h2>
              <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                  Contamos con beneficios exclusivos para su empresa. Contáctenos para brindarle mayor información o ingrese aquí <a target="_blank"  href="{{route('empresas')}}">https://plataforma.constructivo.com/empresas</a>.
                </div>
              </div>
            </div>
             <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingFour">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                 ¿Cuánto tarda en activarse mi cuenta si pago con tarjeta de crédito/débito?
                </button>
              </h2>
              <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                 En caso de que utilice una tarjeta de crédito para pagar su suscripción, se activará inmediato. Recuerde que debe estar registrado primero para poder contratar uno de los planes. (el registro es gratuito).
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingFive">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFive" aria-expanded="false" aria-controls="flush-collapseFive">
                  ¿Qué pasa cuando cancelo la membresía?
                </button>
              </h2>
              <div id="flush-collapseFive" class="accordion-collapse collapse" aria-labelledby="flush-headingFive" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                Al cancelar su membresía, no podrá acceder a los beneficios de suscriptor premium. Su cuenta seguirá activa pero en este caso como un visitante.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingSix">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSix" aria-expanded="false" aria-controls="flush-collapseSix">
                  ¿Puedo comprar un plan antes de que se acabe mi suscripción?
                </button>
              </h2>
              <div id="flush-collapseSix" class="accordion-collapse collapse" aria-labelledby="flush-headingSix" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                En caso que haya realizado el pago vía depósito/transferencia, puede renovar su plan antes que finalice su periodo de suscripción. Para realizar esta gestión puede comunicarse a través de whatsapp <a target="_blank" title="WhatsApp" href="https://api.whatsapp.com/send?phone=51981324180&amp;text=Hola,%20quisiera%20renovar%20mi%20suscripci%C3%B3n%20">+51 981 324 180</a> o escribiendo un correo al <a target="_blank"  href="mailto:info2@constructivo.com">info2@constructivo.com</a>.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingSeven">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseSeven" aria-expanded="false" aria-controls="flush-collapseSeven">
                  ¿El cobro de la suscripción es automático?
                </button>
              </h2>
              <div id="flush-collapseSeven" class="accordion-collapse collapse" aria-labelledby="flush-headingSeven" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                Los cobros de las suscripciones se hacen automáticamente cuando se efectúa el pago en línea a través de tarjeta crédito/débito. Si existiese algún problema de cobro, le contactaremos de inmediato.
                No almacenamos los datos de su tarjeta, usamos proveedores externos para las transacciones y ellos almacenan la información de forma segura.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingEight">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseEight" aria-expanded="false" aria-controls="flush-collapseEight">
                  Ya he pagado, ¿qué pasos siguen?
                </button>
              </h2>
              <div id="flush-collapseEight" class="accordion-collapse collapse" aria-labelledby="flush-headingEight" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                 Después de efectuar el pago, recibirá un email con la confirmación. No invadimos tu privacidad ni tenemos acceso a tu contraseña. Aquí puedes leer nuestras políticas de privacidad: <a target="_blank" href="http://plataforma.constructivo.com/privacidad">https://plataforma.constructivo.com/privacidad</a>.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingNine">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseNine" aria-expanded="false" aria-controls="flush-collapseNine">
                ¿Cómo puedo cambiar el correo de ingreso?
                </button>
              </h2>
              <div id="flush-collapseNine" class="accordion-collapse collapse" aria-labelledby="flush-headingNine" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                Puedes cambiar el correo electrónico de ingreso a la plataforma desde la opción de Perfil, dentro del menú desplegable de opciones disponibles cuando inicia sesión.
                </div>
              </div>
            </div>

            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingTen">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTen" aria-expanded="false" aria-controls="flush-collapseTen">
                  ¿Qué pasa si renuevo mi membresía antes de la fecha de expiración?
                </button>
              </h2>
              <div id="flush-collapseTen" class="accordion-collapse collapse" aria-labelledby="flush-headingTen" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body"  style="font-family: 'Open Sans', sans-serif;">
                Si tiene una suscripción de membresía anual y antes de que expire lanzamos una promoción, puede migrar su plan a la promoción, para esta gestión puede comunicarse a través de whatsapp <a target="_blank" title="WhatsApp" href="https://api.whatsapp.com/send?phone=51981324180&amp;text=Hola,%20quisiera%20renovar%20mi%20suscripci%C3%B3n%20">+51 981 324 180</a> o escribiendo un correo al <a target="_blank"  href="mailto:info2@constructivo.com">info2@constructivo.com</a>.
                </div>
              </div>
            </div>
      </div>
  </section>
</section>


     <section class="col-md-12 s-planes">
    <h1 class="text-center font-weight">PLANES</h1>
    <p class="text-center">Te presentamos nuestros planes de suscripción, recuerda qué con un solo pago podrás acceder a todo el material de: Construcción, Minería y Arquitectura & Diseño </p>
    <p class="text-center mt-5"><a href="" class="a-personal">PERSONAL</a> <a class="a-personal a-empresa" href="{{route('empresas')}}">EMPRESA</a></p>

    <section class="col-md-8 row mx-auto">
      @foreach($planes as $plan)
      <section class="col-md-6 s-plan"> 
        <h3 class="font-weight" style="text-transform: uppercase">{{$plan->name}}</h3>
        <p class="font-weight pbm-0">Ahora</p>
        @if($plan->promocion>0)
        <div class="col-md-12 row pbm-0">
          <div class="col-md-4 pbm-0">
             <p class="c-green font-weight p-precio"><span>S/</span>{{$plan->promocion}}</p>
          </div>
          <div class="col-md-3 pbm-0 d-antes">
            <p class="p-antes">Antes</p>
            <p class="p-antes line-through">S/ {{$plan->precio}}</p>
          </div>
           <div class="col-md-5 pbm-0 d-antes" style="position: relative;">
            <a type="button" class="nav-link a-menu pbm-0 "  data-bs-toggle="modal" data-bs-target="#modal-planD" style="position:absolute;bottom: 20%;background: black;color:white;padding:1% 3%; "><i class="fas fa-dollar-sign" ></i> Ver Precio (Dólares)</a>
          </div>
        </div>
        @else

        <div class="col-md-12 row pbm-0">
          <div class="col-md-4 pbm-0">
             <p class="c-green font-weight p-precio"><span>S/</span>{{$plan->precio}}</p>
          </div>
          <div class="col-md-8 pbm-0 d-antes" style="position: relative;">
            <a type="button" class="nav-link a-menu pbm-0 "  data-bs-toggle="modal" data-bs-target="#modal-planD" style="position:absolute;bottom:20%;background: black;color:white;padding:1% 3%; "><i class="fas fa-dollar-sign"></i> Ver Precio (Dólares)</a>
          </div>
        </div>
        @endif
        <p class="p-rubro font-weight p-membresia">Membresía por {{$plan->meses}} meses</p>
        <section class="col-md-12 row pbm-0 mt-3 plan-item-features">
          
          {!!$plan->descripcion!!}
          
        </section>
        @if(!\Auth::guest())
        <p class="text-center mt-2"><a href="{{route('getPlan',$plan->slug)}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
        @else
        <p class="text-center mt-2"><a data-bs-toggle="modal" data-bs-target="#modal-login" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
        @endif
      </section>
      @endforeach

    </section>
  </section>


  <div class="modal fade" id="modal-planD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-xl modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:   15px">

      <div class="modal-body col-md-12 row pbm-0" >
        
        <section class="col-md-12 s-planes" style="border-radius:   15px">
           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:2%;top:2%"></button>

        <h1 class="text-center font-weight">PLANES</h1>
        <p class="text-center">Te presentamos nuestros planes de suscripción, recuerda qué con un solo pago podrás acceder a todo el material de: Construcción, Minería y Arquitectura & Diseño</p>

        <section class="col-md-12 row mx-auto">
          @foreach($planesD as $plan)
          <section class="col-md-6 s-plan"> 
            <h3 class="font-weight" style="text-transform: uppercase">{{$plan->name}}</h3>
            <p class="font-weight pbm-0">Ahora</p>
            @if($plan->promocion>0)
            <div class="col-md-12 row pbm-0">
              <div class="col-md-4 pbm-0">
                 <p class="c-green font-weight p-precio"><span>$</span>{{$plan->promocion}}</p>
              </div>
              <div class="col-md-8 pbm-0 d-antes">
                <p class="p-antes">Antes</p>
                <p class="p-antes line-through">$ {{$plan->precio}}</p>
              </div>
            </div>
            @else

            <div class="col-md-12 row pbm-0">
              <div class="col-md-4 pbm-0">
                 <p class="c-green font-weight p-precio"><span>$</span>{{$plan->precio}}</p>
              </div>
            </div>
            @endif
            <p class="p-rubro font-weight p-membresia">Membresía por {{$plan->meses}} meses</p>
            <section class="col-md-12 row pbm-0 mt-3 plan-item-features">
              
              {!!$plan->descripcion!!}
              
            </section>
            @if(!\Auth::guest())
            <p class="text-center mt-2"><a href="{{route('getPlan',$plan->slug)}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
            @else
            <p class="text-center mt-2"><a data-bs-toggle="modal" data-bs-target="#modal-login" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
            @endif
          </section>
          @endforeach

        </section>
      </section>

       
      </div>
    </div>
  </div>
</div>

    

@endsection
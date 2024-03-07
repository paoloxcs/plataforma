@extends('layouts.front')
@section('titulo')
{{$plan->name}}
@endsection
@section('content')
<div class="bg-response" id="mensajepago">
<section class="col-md-12 bg-gris" style="padding-bottom: 5%; ">
  <section class="col-md-10 col-xs-12 mt-4 mx-auto">

      <h2 class="font-weight text-center-mob">Confirmar tu compra</h2>
      <h5 class="text-center-mob">Ya puedes realizar tu compra</h5>
    <section class="col-md-12 row">
      <section class="col-md-6 col-xs-12 mt-3">

        <div class="card-cur-c bg-white col-md-11 col-xs-12 row ">
          <div class="none">{{$mesess="+ ". $plan->meses ." month"}}
            @if($plan->moneda=="PEN")
            {{$simbolo="S/"}}
            @else
            {{$simbolo="$"}}
            @endif

            @if($plan->promocion>0)
            {{$precio=$plan->promocion}}
            @else
            {{$precio=$plan->precio}}
            @endif

          </div>
          <div class="col-md-12 col-xs-12" style="padding: 2% 0 2% 2%;position: relative;">
            <h5 class="font-weight">{{$plan->name}}</h5>
           
            <p class="pm-b-0"><i class="fas fa-calendar-alt"></i> {{$simbolo}} {{$precio}} / por {{$plan->meses}} meses</p>
           
            
            <p class="c-gris" style="width: 80%">El siguiente pago se realizará el {{date('d-m-Y',strtotime ( $mesess , strtotime ( date('Y-m-d'))))}}. {{$plan->name}}.</p>
            <div class="price-card">
              
             
               <p class="p-price-c"><span>{{$simbolo}}</span>{{$precio}}</p>
                
            </div>
            
          </div>
        </div>

         <div class="card-cur-c bg-white col-md-11 col-xs-12 row  mt-2" style="padding-bottom: 1%!important">
          <div class="bg-white col-md-6 col-xs-12">
            <p class="text-center-mob">Pague aquí con:</p>
             @if (App::getLocale() == 'pen')
                <div class="d-flex justify-content-start gap-7 mt-3"
                    style="flex-wrap: wrap; row-gap: 0.75rem; column-gap: 1.25rem;">
                    <img class="sm:w-10 w-8" src="{{ asset('images/pagos/visa.png') }}"
                        alt="Imagen de pago">
                    <img class="sm:w-10 w-8" src="{{ asset('images/pagos/mastercard.png') }}"
                        alt="Imagen de pago">
                    <img class="sm:w-8 w-6" src="{{ asset('images/pagos/diners-club.png') }}"
                        alt="Imagen de pago">
                    <img class="sm:w-12 w-10" src="{{ asset('images/pagos/american-express.png') }}"
                        alt="Imagen de pago">
                </div>
            @else
                <div class="d-flex justify-content-start gap-10 mt-3">
                    <img class="w-20 lg:w-24" src="{{ asset('images/pagos/paypal.png') }}"
                        alt="Imagen de pago">
                </div>
            @endif
            <!-- <div class="col-md-12 col-xs-10 mx-auto d-flex flex-wrap">-->
            <!--            <div class="cardicon"><img src="{{asset('images/visa.png')}}" class="img-fluid" alt="Visa"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/mastercard.png')}}" class="img-fluid" alt="Mastercard"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/diners.png')}}" class="img-fluid" alt="Diners Club"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/american.png')}}" class="img-fluid" alt="American Express"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/unionpay.png')}}" class="img-fluid" alt="Union Pay"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/ripley.png')}}" class="img-fluid" alt="Ripley"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/cmr.png')}}" class="img-fluid" alt="Saga Falabella"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/oh.png')}}" class="img-fluid" alt="Tarjeta Oh!"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/cencosud.png')}}" class="img-fluid" alt="Cencosud"></div>-->
            <!--            <div class="cardicon"><img src="{{asset('images/presta.png')}}" class="img-fluid" alt="Presta"></div>-->
            <!--</div>-->
             {{-- <div class="col-md-12 col-xs-10 mx-auto d-flex flex-wrap">
              <div class="cardicon-pagoefectivo"><img src="{{asset('images/pagoefectivo.png')}}" class="img-fluid" alt="Visa"></div>
            </div> --}}
          </div>
          <div class="col-md-2">
            
          </div>
          <div class="bg-white col-md-4 col-xs-12">
             <p class="text-center-mob">Certificado de seguridad:</p>
             <div class="col-md-12 col-xs-6 mx-auto d-flex flex-wrap">
                        <div class="mx-auto col-md-6"><img src="/images/comodo-ssl.png" class="img-fluid" with="100%" alt="Visa"></div>
             </div>
            
          </div>
          
        </div>
        
        {{-- JHED INFO --}}
        <div class="card-cur-c bg-white col-md-11 col-xs-12 row  mt-2" style="padding: 2%!important">
          <div class="bg-white col-md-5 col-xs-12"> 
        @if (App::getLocale() == 'pen')
            <div class="d-flex justify-content-start gap-10 mt-3">
                <img class="sm:w-14 w-11" src="{{ asset('images/pagos/pagoefectivo.png') }}"
                    alt="Imagen de pago">
                <img class="sm:w-14 w-11" src="{{ asset('images/pagos/yape-1.png') }}"
                    alt="Imagen de pago">
            </div>
        @else
            <div class="d-flex justify-content-start gap-10 mt-3">
                <img class="sm:w-14 w-11" src="{{ asset('images/pagos/pagoefectivo.png') }}"
                    alt="Imagen de pago">
            </div>
        @endif
            <!--<div class="col-md-12 col-xs-12 mx-auto d-flex flex-wrap justify-pagoefectivo">-->
            <!--  <div class="cardicon-v2"><img src="{{asset('images/pagoefectivo.png')}}" class="img-fluid" alt="Pago Efectivo"></div>-->
            <!--  <div class="cardicon-v2"><img src="{{asset('images/yape.png')}}" class="img-fluid" alt="Yape"></div> -->
            <!--</div>-->
          </div> 
          <div class="bg-white col-md-7 col-xs-12">
             <div class="col-md-12 col-xs-12 mx-auto d-flex flex-wrap">
                <span class="text-info-pay">Todo pago mediante este medio debe ser notificado a 
                  <a class="text-decoration-none" href="mailto:info2@constructivo.com"><span>info2@constructivo.com</span></a>
                   o al whatsapp: 
                  <a class="text-decoration-none" href="tel:981324180"><span>981 324 180</span></a> 
                </span> 
             </div>            
          </div>          
        </div>
{{-- JHED INFO --}}



                        {{-- PLANES 2x1 --}}
                        <!-- @if (strpos($plan->slug, 'anual'))
                            <div class="memberships__promo pb-4">
                                <div class="card-cur-c  col-md-11 col-xs-12 row  mt-2" >
                                    <div class="two-for-one"><i class="fas fa-info-circle fa-plan-info"></i>
                                        <p class="text-plan lg:text-plan">
                                            <b>Así habilitas tu 2x1 en tu plan Anual:</b><br>
                                            Escríbenos a <a
                                                href="mailto:info2@constructivo.com"><b>info2@constructivo.com</b></a>
                                            adjuntando el voucher de compra y
                                            los datos de la otra persona que usará la cuenta. Nosotros nos encargaremos
                                            de otorgarle
                                            el acceso Premium en un plazo no mayor de 48 horas.<br>
                                            <b>Importante: las otras personas también deben tener una cuenta registrada
                                                en
                                                plataforma.</b>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        @endif -->

      </section>
      <section class="col-md-6 col-xs-12 mt-3">
        <div class="card-pago bg-white mt-2-mob" style="padding: 5% 5% 10% 5%;">

          {{--<div class="input-group mb-3" >
            <input type="text" class="form-control" placeholder="Código de descuento" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">APLICAR DESCUENTO</button>
          </div>--}}

          <div class="div-sub">
            <p>Subtotal</p>
            <p class="p-right">{{$simbolo}} {{$precio}}</p>
          </div>

          <div class="div-sub mt-2">
            <p>Descuento</p>
            <p class="p-right">{{$simbolo}} 00.00</p>
          </div>
          <hr>

          <div class="div-sub mt-2">
            <p>TOTAL</p>
            <p class="p-right">{{$simbolo}} {{$precio}}</p>
          </div>
          <hr>
          <p class="" style="font-size: 13px"><i class="fas fa-check check-b" style="font-size: 8px!important;"></i> Válida por {{$plan->meses}} meses, autorenovable por pago con tarjeta de crédito.</p>

          
      {{-- CARD PAGOS YAPE --}}
          <div class="mb-4">
            <h4 class="left mb-1">Elige un método de pago</h4>
            <span class="s-select-none s-color-text-light small s-mr-1 left mb-6">Selecciona una opción para realizar el pago</span>
          </div>
        @if (App::getLocale() == 'pen')
          <div class="bg-gray-50 dark:bg-ed-grey-700 w-full rounded-lg border-1 border-gray-200 dark:border-dark-bg-alt mb-4 cursor-pointer" id="card-deposito">
           
                <div class="d-flex align-items-center justify-content-between !flex-nowrap py-3 px-3 card-deposito">
                  <div class="d-flex align-items-center !flex-nowrap">
                    <input type="radio" class="cursor-pointer mr-2" id="radio_deposito" name="gift" readonly="">
                    <p class="text-gray-500 dark:text-dark-text font-semibold text-ed-smaller md:text-ed-small mb-0">Depósitos y transferencias</p>
                  </div>
                  <div class="d-flex justify-content-end align-items-center xs-grid xs-grid-cols-2 gap-1">
                    <img class="h-6 md-h-8" src="https://edteam-media.s3.amazonaws.com/cashboxes/pen/peru-yape-light.svg" alt="Imagen de pago">
                    {{-- <img class="h-6 md:h-8" src="https://edteam-media.s3.amazonaws.com/cashboxes/pen/peru-pago-efectivo-light.svg" alt="Imagen de pago"> --}}
                    {{-- <img class="h-6 md-h-8" src="https://edteam-media.s3.amazonaws.com/cashboxes/pen/peru-interbank-light.svg" alt="Imagen de pago"> --}}
                    <img class="h-6 md-h-8" src="https://edteam-media.s3.amazonaws.com/cashboxes/pen/peru-bcp-light.svg" alt="Imagen de pago">
                  </div>
                </div>
           
                <div class="mt-4 px-3 pb-3 body-card-deposito" id="body-card-deposito">
                  {{-- <form action="d-grid l-block row-gap s-gap-3 s-mb-0">
                    <div class="grid grid-cols-2 md-grid-cols-1 gap-3 mb-4">
                      <div class="!mb-0 input-form s-relative s-mb-3">
                        <label class="s-mb-1 s-weight-semibold small">No. de indentificación (DNI)</label>
                        <div class="s-relative s-cross-center">
                          <input type="number" class="form-control placeholder:text-gray-300 outline-none" placeholder="00 00 00 00 00" name="dni">
                        </div>
                      </div>
                      <div class="!mb-0 input-form s-relative s-mb-3">
                        <label class="s-mb-1 s-weight-semibold small">No. telefónico</label>
                        <div class="s-relative s-cross-center">
                          <input type="number" class="form-control placeholder:text-gray-300 outline-none" placeholder="957342643" name="phoneNumber">
                        </div>
                      </div>
                    </div>
                    <div class="m-cols-2 smaller mb-7">
                      <p class="mb-2"><b>Depósito en efectivo vía PagoEfectivo</b>
                        - Paga en BBVA, Interbank, Scotiabank, BanBif, Western Union, Tambo+, Kasnet, Full Carga, Red Digital, Comercio Niubiz Multiservicio, Money Gram, Caja Arequipa, Disashop, Banco de la nación, Caja Sullana, Caja de los Andes, Caja Trujillo, Banco Azteca, Caja del Santa, Caja Raíz.
                      </p>
                      <p class="mb-2"><b>Transferencias bancarias vía PagoEfectivo</b>
                        - Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa y Bancho Pichincha a través de la banca por internet o banca móvil en la opción de pago de servicios.
                      </p>
                      <p class="mb-6"><b>Transferencias vía Yape</b></p>
                      <div class="px-2 mb-6">
                        <img src="/images/payments/peru/centros-de-pago.png" alt="Métodos de pago de PagoEfectivo">
                        <img class="w-100 h-autp" src="https://app.ed.team/images/payments/peru/centros-de-pago.png" alt="Métodos de pago de PagoEfectivo">
                      </div>
                    </div>
                    <div class="px-3 py-1 border-1 border-yellow-300 bg-yellow-100 rounded mb-6">
                      <p class="text-yellow-800 mb-0 font-normal text-sm text-center">
                        Plataforma no guardará ninguna clase de información personal.
                      </p>
                    </div>
                    <button class="button full" type="submit">Continúa con tu compra</button>
                  </form> --}}
                </div>
 
          </div>
        @endif
        
          <div class="bg-gray-50 dark:bg-ed-grey-700 w-full rounded-lg border-1 border-gray-200 dark:border-dark-bg-alt mb-4 cursor-pointer" id="card-tarjeta">

            <div class="d-flex align-items-center justify-content-between !flex-nowrap py-3 px-3 card-tarjeta">
              <div class="d-flex align-items-center !flex-nowrap">
                <input type="radio" class="cursor-pointer mr-2" name="gift" id="radio_tarjeta" readonly="">
                <p class="text-gray-500 dark:text-dark-text font-semibold text-ed-smaller md:text-ed-small mb-0">Tarjeta de crédito/débito o Pago Efectivo</p>
              </div>
            <div class="d-flex justify-content-end items-center xs-grid xs-grid-cols-2 gap-1">
                <img class="h-6 md-h-8" src="{{ asset('images/svg-light-card-pay/visa-light.svg') }}"
                    alt="Imagen de pago">
                <img class="h-6 md-h-8"
                    src="{{ asset('images/svg-light-card-pay/mastercard-light.svg') }}"
                    alt="Imagen de pago">
                <img class="h-6 md-h-8"
                    src="{{ asset('images/svg-light-card-pay/americanexpress-light.svg') }}"
                    alt="Imagen de pago">
                <img class="h-6 md-h-8"
                    src="{{ asset('images/svg-light-card-pay/peru-pago-efectivo-light.svg') }}"
                    alt="Imagen de pago">
            </div>
            </div>

            <div class="mt-4 px-3 pb-3 body-card-tarjeta" id="body-card-tarjeta">
              <div class="m-cols-2 smaller mb-7">
                <p class="mb-2"><b>Transferencias bancarias vía PagoEfectivo</b>
                  - Paga en BBVA, BCP, Interbank, Scotiabank, BanBif, Caja Arequipa y Bancho Pichincha a través de la banca por internet o banca móvil en la opción de pago de servicios.
                </p>
              </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                  <label class="form-check-label" for="flexCheckDefault">
                  Acepto expresamente todos los Términos y Condiciones de Membresías Premium. Del mismo, modo acepto las Políticas y Avisos de Protección y Tratamiento de Datos Personales de Plataforma Constructivo.
                  </label>
                </div> 
                <a  class="btn-pago f-right" type="button" id="buyButton1"><i class="far fa-credit-card"></i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; REALIZAR PAGO</a>
            </div>
          </div>
     

           
        {{-- CARD PAGOS PAYPAL --}}
        @if (App::getLocale() == 'usd')
            <div class="bg-gray-50 dark:bg-ed-grey-700 w-full rounded-lg border-1 border-gray-200 dark:border-dark-bg-alt mb-4 cursor-pointer"
                id="card-paypal">

                <div
                    class="d-flex align-items-center justify-content-between !flex-nowrap py-3 px-3 card-paypal">
                    <div class="d-flex align-items-center !flex-nowrap">
                        <input type="radio" class="cursor-pointer mr-2" id="radio_paypal"
                            name="gift" readonly="">
                        <p
                            class="text-gray-500 dark:text-dark-text font-semibold text-ed-smaller md:text-ed-small mb-0">
                            Paypal</p>
                    </div>
                    <div
                        class="d-flex justify-content-end align-items-center xs-grid xs-grid-cols-2 gap-1">
                        <img class="h-6 md-h-8"
                            src="{{ asset('images/svg-light-card-pay/paypal-light.svg') }}"
                            alt="Imagen de pago">
                    </div>
                </div>

                <div class="mt-4 px-3 pb-3 body-card-paypal" id="body-card-paypal">
                    <div id="paypal-button-container"></div>
                </div>
            </div>
            {{-- <div class="smart-button-container">
                <div class="text-center">
                    <div id="paypal-button-container"></div>
                </div>
            </div> --}}
        @endif
                            
                            
          <br>
        </div>
        
      </section>
    </section>
  </section>
  
</section>

@endsection
@section('script-extra')
<!-- Incluyendo .js de Culqi Checkout-->
<script src="https://checkout.culqi.com/js/v3"></script>
<!-- Configurando el checkout-->
<script>

  Culqi.publicKey = 'pk_live_OhE2jDzFFYhPEkjy';
     // Culqi.publicKey = 'pk_test_sXUCiBUCfkPNteTd';
   
</script>
<script src="{{asset('js/waitMe.min.js')}}"></script>
<script src="{{asset('js/card_pago_susc.js')}}"></script>
 
<script>
    var moneyLocal = "{{ App::getLocale() }}";
    
    var precio =  "{{$precio}}";
    var simbolo =  "{{$simbolo}}";
    var planSlug = '{{$plan->slug}}';
    
    
    function saveYapeSuscCurso(form) {
    		event.preventDefault();
    		if(validateForm(form)){
    			spinner.show();  
          var rutaYape = "{{url('paySuscYape')}}"; 
    			let	token = '{{ csrf_token() }}',
    				data = $(form).serialize();
    			$.ajax({
    				url: rutaYape,
    				type: 'POST',
    				headers: {'X-CSRF-TOKEN': token},
    				data: data,
    				dataType: 'JSON',
    				success: data =>{
    					spinner.hide();
    					if(data.status == 200){ 
    						  toastr.success(data.message,'Exito');
                  $("#body-card-deposito").empty();
                  $("#body-card-deposito").append(`
                    <div class="px-2 w-full rounded-lg border-gray-200 mb-4 cursor-pointer">
                       
                      <div class="smaller">
                      
                        <p class="mb-2"><b>Escanea el QR desde tu celular</b></p>
                        <div class="flex flex-column justify-center items-center mb-4 px-3 border-1 border-blue-300 bg-blue-100 rounded text-center py-4">
                          <img src="{{asset('images/yape_ce.png')}}" width="200px" height="200px" class="text-center mb-2" alt="QR">
                          <p class="t5 s-mb-2 text-center">Págalo <span class="font-thin">desde tu billetera <br> digital favorita.</span></p>
                            <div class="w-36 flex flex-wrap gap-2">
                              <img src="https://prod.cds.pagoefectivo.g3c.pe/img/general/yape-cuadrado.png" alt="bank-1" class="w-7 h-7"> 
                            </div>
                                <p class="mt-2 mb-0 small">Telefono: <b>981 351 111</b></p>
                                <p class="mb-2 small">Nombre: <b>CE CORPORACIÓN DE EVENTOS SAC</b></p>
                        </div>
                      </div>
                      
                      <div class="smaller">
                      
                        <p class="mb-2"><b>Y Información de pago</b></p>
                        <div class="px-3 py-1 border border-blue-300 bg-blue-100 dark:bg-ed-grey-700 rounded text-center mb-4">
                          <div class="s-cross-center s-main-center s-mb-05">
                            <p class="s-font-semibold s-mb-0 s-mr-05 small">
                            Tu código que enviaras al vaucher de pago</p> 
                          </div>
                                <strong style="font-size:20px"><p class="t1 body-font s-mb-2">${data.codigo}</p></strong>
                                <p class="mb-2 small">Monto de pago: <b>${simbolo} ${precio}</b></p>
                        </div>
                      </div>
    
    
                    </div> `);
                    
                    // <p class="mb-0 small">Fecha límite de pago: <b>27 de octubre del 2022 - 18</b></p>
        
    					}
    
    					if(data.status == 422){
    						for (var error in data.errors){
    							toastr.error(data.errors[error][0],'Advertencia');
    						}
    					}
    
    					console.log(data);
    				},
    				error: error =>{
    					console.log(error);
    				}
    			});
    		}
    		
    }


  $('#buyButton1').on('click', function(e) {

      // Abre el formulario con las opciones de Culqi.settings
    //   Culqi.open();
    //   e.preventDefault();
    if(document.getElementById('flexCheckDefault').checked){
     
      Culqi.settings({
          title: 'SUSCRIPCIÓN',
          currency: '{{$plan->moneda}}',
          description: 'Suscripción - {{$plan->name}}',
          amount: ({{$precio}} * 100),
          order: '{{$orden->id}}',//JHED PREMIUN
      });


      // Abre el formulario con las opciones de Culqi.settings
      Culqi.open();
      e.preventDefault();
  

     }
     else{
      alert('¡Aceptar los términos y condiciones!');
      $('#texto').focus();
      return;
      
     }

  });
  

  /*Configurando el checkout*/
    //   Culqi.settings({
    //       title: 'SUSCRIPCIÓN',
    //       currency: '{{$plan->moneda}}',
    //       description: 'Suscripción - {{$plan->name}}',
    //       amount: ({{$precio}} * 100),
    //       order: '{{$orden->id}}',//JHED PREMIUN
    //   });

  function culqi() {

      if(Culqi.token) { // ¡Token creado exitosamente!

        $(document).ajaxStart(function(){
          run_waitMe();


        });
          
          var tokencsrf = '{{ csrf_token()}}';

          var datos = {
            tokenId : Culqi.token.id,
              planId : '{{$plan->id}}',

          };

          /*var email = Culqi.token.email;*/

          var ruta = "{{url('createcargo')}}";

          $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': tokencsrf},
            url : ruta,
            dataType: 'json',
            data: datos,
            success: function(data) {
              
              /*id_cargo=data.id;
              token_cargo=data.source.id;*/
              /*document.getElementById("token_cargo").value = token_cargo;
              console.log("id_cargo : "+data.id);
              console.log("token_cargo : "+data.source.id);*/

            //console.log(data);
        
            var result = "";
              

              if(data.constructor == String){
                  result = JSON.parse(data);
              }

              if(data.constructor == Object){
                  result = JSON.parse(JSON.stringify(data));
              }
               

              if(result.object === 'subscription'){
                //show_messagesucces();
               // agradecimiento();
                // location.href ='{{ url('checkout') }}'
                let urlC = '{{ url('checkout') }}';

                  $parametros = '';
                  $parametros += 'rec=' + data.id;
                  $parametros += '&';
                  $parametros += 'plan=' + '{{ $plan->slug }}';

                  if ($parametros.length > 0) {
                    urlC += '?' + $parametros;
                  }

                  window.location.href = urlC; 
              }
              


              if(result.object === 'error'){
                if (!result.user_message) {
                  show_message(result.merchant_message,'alert-warning','error');
                }else{
                  show_message(result.user_message,'alert-warning','error');
                }
                  console.log(result.merchant_message);
              }

            },
            error: function(error) {
              show_message(error,'alert-danger','error');
              console.log(error);
            }
          });
        }else if (Culqi.order) { //JHED PREMIUN
           // resultpe(JSON.stringify(Culqi.order.state));
           //Para efectuar el pago efectivo deve de cerrar la ventana -> sino efectua no se genera ?
             console.log("Order confirmada");
            //  console.log(Culqi.order); 
              location.href ='{{'https://plataforma.constructivo.com'}}';
            //  alert('Se ha elegido el metodo de pago en efectivo:' + Culqi.order); 
      } else if (Culqi.closeEvent){
        console.log(Culqi.closeEvent); 
      }else{ // ¡Hubo algún problema!
          // Mostramos JSON de objeto error en consola
          console.log(Culqi.error);
          console.log(Culqi.error.merchant_message);

          show_message(Culqi.error.user_message,'alert-danger','error');
      }
  }


function run_waitMe(){
  $('body').waitMe({
    effect: 'orbit',
    text: 'Procesando pago...',
    bg: 'rgba(255,255,255,0.7)',
    color:'#339954'
  });
}
        

function show_message(message,type_alert,estado){
  $('#mensajepago').empty();

  $("#mensajepago").append(`
      <div class="bg-content">
        <div class="col-xs-12 col-md-4 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="card-title text-center">Mensaje</div>
            </div>
            <div class="card-body">
              <div id="alert" class="alert ${type_alert} alert-dismissible" role="alert">
                ${message}
              </div>
            </div>
            <div class="card-footer">
            ${estado =='charge' ? '<a href="/profile/suscription" class="btn btn-success btn-block">Ver mi suscripción</a>' :'<a href="/planes-de-suscripcion/construccion" class="btn btn-secondary btn-block">Aceptar</a>'}
            </div>
          </div>
        </div>
      </div>
    `);
  
  $('body').waitMe('hide');
  $('.bg-response').show();
  
}

function show_messagesucces(){
  $('#mensajepago').empty();

  $("#mensajepago").append(`
      <div class="bg-content">
        <div class="col-xs-12 col-md-4 mx-auto">
          <div class="card">
            <div class="card-header">
              <div class="card-title text-center">Mensaje</div>
            </div>
            <div class="card-body">
              <div id="alert" class="alert  alert-dismissible" role="alert">
                Registro Exitoso
              </div>
            </div>
            <div class="card-footer">
            <a href="/profile/suscription" class="btn btn-success btn-block">Ver Suscripción</a>
            </div>
          </div>
        </div>
      </div>
    `);
  
  $('body').waitMe('hide');
  $('.bg-response').show();
  
}
function agradecimiento(){
  location.href ="http://localhost:8000/agradecimiento";
}

</script>

    @if (App::getLocale() == 'usd')
             Incluyendo .js de Paypal Checkout
            <script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}"></script>
             Incluyendo .js de Paypal Checkout
            <script>
                // initPayPalButton();

                // function initPayPalButton() {
                paypal.Buttons({
                    style: {
                        shape: 'pill',
                        color: 'gold',
                        layout: 'vertical',
                        label: 'paypal',
                    },
                    createOrder: function(data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: "{{ $precio }}"
                                }
                            }]
                        });
                    },
                    onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {
                            // console.log(orderData);
                            paypal_approve(orderData.purchase_units[0].payments.captures[0].id);
                        });
                    }
                }).render('#paypal-button-container');
                // }

                function paypal_approve(transaction_id) {
                    // $(document).ajaxStart(function() {
                    //     run_waitMe();
                    // });

                    var tokencsrf = '{{ csrf_token() }}';

                    var datosPaypal = {
                        transactionId: transaction_id,
                        plan_id: '{{ $plan->id }}',
                        simbolo: '{{ $simbolo }}',
                        precio_r: '{{ $precio }}', //precio_r
                        precio: '{{ $precio }}',
                        descuento: '{{ $precio }}', //descuento
                        // currency: '{{ App::getLocale() }}',
                        currency: '{{ $plan->moneda }}',
                    };

                    var rutaPaypal = "{{ url('suscripcionPaypalRecurrente') }}";

                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': tokencsrf
                        },
                        url: rutaPaypal,
                        dataType: 'json',
                        data: datosPaypal,
                        success: function(data) {
                            console.log(transaction_id);
                            if (data.status == 200) {
                                // location.href = '{{ url('checkout') }}';
                                location.href = '{{ route('new_checkout') }}';
                            }
                        },
                        error: function(error) {
                            show_message(error, 'alert-danger', 'error');
                            console.log(error);
                        }
                    });
                }
            </script>
        @endif
@endsection

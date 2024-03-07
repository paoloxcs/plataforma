@extends('layouts.front')
@section('titulo')
Confirmar tu compra
@endsection
@section('content')
<div class="bg-response" id="mensajepago">

<section class="col-md-12 bg-gris" style="padding-bottom: 5%; ">
  <section class="col-md-10 mt-4 mx-auto">

      <h2 class="font-weight text-center-mob">Confirmar tu compra</h2>
      <h5 class=" text-center-mob">Ya puedes realizar tu compra</h5>


    <section class="col-md-12 row">
      <section class="col-md-6 col-xs-12 mt-3">

        @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
          <div class="col-md-11">
            <div class="d_descuento_p col-xs-12 " style="width: 100%;">
              <div class="col-md-12 row mx-auto">
                <div class="col-md-4 col-xs-4 pbm-0">
                  <p class="c-white p-porcentaje pbm-0">{{$curso->porcentaje_d_v}}%</p>
                </div>
                <div class="col-md-8 col-xs-8 pbm-0">
                  <p class="c-white pbm-0">De descuento en el curso</p>
                  <p class="font-weight c-white pbm-0">Válido hasta el {{$dia_n}} de {{$mes}} {{$año_n}}</p>
                </div>
              </div>
              
            </div>
          </div>
        @endif
        

        <div class="card-cur-c bg-white col-md-11 mt-2 row card-curso" style="padding-bottom: 1%!important">
          <div class="col-md-4 img none-mobile" style="padding: 2% 0 2% 2%;">
            <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
              
          </div>
          <div class="col-md-8" style="padding: 2% 0 2% 2%;position: relative;">
            <a href="{{route('getcurso',$curso->slug)}}" class="td-none" style="color:black"><h5 class="font-weight">{{$curso->titulo}}</h5></a>
            <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p class="pm-b-0">{{$curso->autor->nombre}}</p></a>
            <p class="c-gris pm-b-0"></p>
            <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$curso->CountValoracion()}}</p>

            <div class="price-card">
              @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
              <p class="text-center pbm-0 p-antes p-antes-c" style="display: inline-block;">Antes: <span class="font-weight" style="text-decoration:line-through;">{{$simbolo}} {{$precio_r}}</span></p>
              @endif
              <p class="p-price-c" style="display: inline-block;"> <span>{{$simbolo}}</span>{{$precio}}</p>
            </div>
            
          </div>
        </div>
        <div class="card-cur-c bg-white col-md-11 row card-curso mt-2" style="padding-bottom: 1%!important">
          <div class="bg-white col-md-6 col-xs-12">
            <p class="text-center-mob">Pague aquí con:</p>
            @if (App::getLocale() == 'pen')
              <div class="d-flex justify-content-start gap-7 mt-3"  style="flex-wrap: wrap; row-gap: 0.75rem; column-gap: 1.25rem;">
                    <img class="sm:w-10 w-8" src="{{ asset('images/pagos/visa.png') }}" alt="Imagen de pago">
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
             <div class="col-md-12 d-flex flex-wrap">
                        <div class="mx-auto col-md-6 col-xs-4"><img src="/images/comodo-ssl.png" class="img-fluid" with="100%" alt="Visa"></div>
             </div>
            
          </div>
          
        </div>
       {{-- JHED INFO --}}
        <div class="card-cur-c bg-white col-md-11 col-xs-12 row card-curso  mt-2" style="padding: 2%!important">
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
            <!--<div class="col-md-12 col-xs-12 mx-auto d-flex flex-wrap justify-pagoefectivo">     -->
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
      </section>
      <section class="col-md-6 col-xs-12 mt-3 ">
        <div class="card-pago bg-white mt-2-mob" style="padding: 5% 5% 10% 5%;">

          {{--<div class="input-group mb-3" >
            <input type="text" class="form-control" placeholder="Código de descuento" aria-label="Recipient's username" aria-describedby="button-addon2">
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">APLICAR DESCUENTO</button>
          </div>--}}

          <div class="div-sub">
            <p>Subtotal</p>
            
             @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
              <p class="p-right">{{$simbolo}} {{$precio_r}}</p>
              @else
              <p class="p-right">{{$simbolo}} {{$precio}}</p>
              @endif
          </div>

          <div class="div-sub mt-2">
            <p>Descuento</p>
            @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
            <p class="p-right">{{$simbolo}} {{$descuento}}    </p>
            @else
            <p class="p-right">{{$simbolo}} 00   </p>
            @endif
          </div>
          <hr>

          <div class="div-sub mt-2">
            <p>TOTAL</p>
            <p class="p-right">{{$simbolo}} {{$precio}}</p>
          </div>

          
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
                  Acepto los <a href="/terminos" style="color:black">términos y condiciones</a>
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
<script src="https://checkout.culqi.com/js/v3"></script>
<!-- Configurando el checkout-->
<script>

 Culqi.publicKey = 'pk_live_OhE2jDzFFYhPEkjy';
 //Culqi.publicKey = 'pk_test_sXUCiBUCfkPNteTd';
</script>
<script src="{{asset('js/waitMe.min.js')}}"></script>
 
<script src="{{asset('js/card_pago_curso.js')}}"></script>

<script>
    var moneyLocal = "{{ App::getLocale() }}";
     
    var precio =  "{{$precio}}";
    var simbolo =  "{{$simbolo}}";
    var cursoid = '{{$curso->id}}'; 
    
     function saveYapeSuscCurso(form) {
    		event.preventDefault();
    		// if(validateForm(form)){
    			// spinner.show();  
          var rutaYape = "{{url('payCursoYape')}}"; 
    			let	token = '{{ csrf_token() }}',
    				data = $(form).serialize();
    			$.ajax({
    				url: rutaYape,
    				type: 'POST',
    				headers: {'X-CSRF-TOKEN': token},
    				data: data,
    				dataType: 'JSON',
    				success: data =>{
    					// spinner.hide();
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
    		// }
    		
    }
    
     $('#buyButton1').on('click', function(e) {
     /*Configurando el checkout*/
    //  if(document.getElementById('check').checked){
     if(document.getElementById('flexCheckDefault').checked){
     
      Culqi.settings({
          title: 'PARTICIPACIÓN',
          currency: '{{$moneda}}',
          description: 'Participación - {{$curso->titulo}}',
          amount: ({{$precio}} * 100),
          order: '{{$orden->id}}',
      });


      // Abre el formulario con las opciones de Culqi.settings
      Culqi.open();
      e.preventDefault();

       $moneda='{{$moneda}}';
       $pago='{{$precio}}'


     }
     else{
      alert('¡Aceptar los términos y condiciones!');
      $('#texto').focus();
      return;
      
     }

  });
  

 
  function culqi() {

      if(Culqi.token) { // ¡Token creado exitosamente!

        $(document).ajaxStart(function(){
          run_waitMe();
        });
          
          var tokencsrf = '{{ csrf_token()}}';

          var datos = {
            tokenId : Culqi.token.id,
              CursoId : '{{$curso->id}}',
              amount: $pago,
              currency: $moneda,
          };

          /*var email = Culqi.token.email;*/

          var ruta = "{{url('suscripcioncurso')}}";

          $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': tokencsrf},
            url : ruta,
            dataType: 'json',
            data: datos,
            success: function(data) {
              
              var result = "";

              if(data.constructor == String){
                  result = JSON.parse(data);
              }
              if(data.constructor == Object){
                  result = JSON.parse(JSON.stringify(data));
              }

              if(result.object === 'charge'){
                // location.href = '{{ 'http://localhost:8000/curso/success/card/' . $curso->slug }}';
                                 
              let urlC = '{{ url('checkout') }}';

              $parametros = '';
              $parametros += 'rec=' + data.id;
              $parametros += '&';
              $parametros += 'c_slug=' + '{{ $curso->slug }}';
              $parametros += '&';
              $parametros += 'moneda=' + '{{ $moneda }}';

              if ($parametros.length > 0) {
                urlC += '?' + $parametros;
              }

              window.location.href = urlC; 
                /*show_message(result.outcome.user_message,'alert-success','charge');
                console.log(result.outcome.merchant_message);*/
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
      }else if (Culqi.order) { 
           // resultpe(JSON.stringify(Culqi.order.state));
           //Para efectuar el pago efectivo deve de cerrar la ventana -> sino efectua no se genera ?
             console.log("Order confirmada");
              //console.log(Culqi.order); 
             location.href ='{{'https://plataforma.constructivo.com/curso/'.$curso->slug}}';
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
            ${estado =='charge' ? '<a href="/curso/card/{{$curso->slug}}/{{strtolower($moneda)}}" class="btn btn-success btn-block">Ver curso</a>' :'<a href="/curso/card/{{$curso->slug}}/{{strtolower($moneda)}}" class="btn btn-secondary btn-block">Aceptar</a>'}
            </div>
          </div>
        </div>
      </div>
    `);
  
  $('body').waitMe('hide');
  $('.bg-response').show();
  
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
                        cursoId: '{{ $curso->id }}',
                        cursoSlug: '{{ $curso->slug }}',
                        simbolo: '{{ $simbolo }}',
                        precio_r: "{{ ($curso->porcentaje_d_v > 0 && $curso->fecha_d_v >= date('Y-m-d')) ? $precio_r : $precio }}", //precio_r
                        precio: '{{ $precio }}',
                        descuento: "{{ ($curso->porcentaje_d_v > 0 && $curso->fecha_d_v >= date('Y-m-d')) ? $descuento : '00' }}",
                        currency: '{{ $moneda }}',
                    };

                    var rutaPaypal = "{{ url('suscripcionPaypalCurso') }}";

                    $.ajax({
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': tokencsrf
                        },
                        url: rutaPaypal,
                        dataType: 'json',
                        data: datosPaypal,
                        success: function(data) {
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
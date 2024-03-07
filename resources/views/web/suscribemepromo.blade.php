@extends('layouts.front')
@section('titulo')
Suscripción {{$plan->name}}
@endsection
@section('style-extra')
<link rel="stylesheet" href="{{asset('css/waitMe.min.css')}}">
@endsection
@section('content')
<div class="none">{{$a=('construccion')}}</div>
<div class="bg-response" id="mensajepago">
	
</div>
@if(session('message'))
<div class="bg-response" style="display: block;">
	<div class="bg-content">
		<div class="col-xs-12 col-md-4 mx-auto">
			<div class="card">
				<div class="card-header">
					<div class="card-title text-center">Mensaje</div>
				</div>
				<div class="card-body">
					<div class="alert alert-success alert-dismissible" role="alert">
					  <p>{{session('message')}}</p>
					</div>
				</div>
				<div class="card-footer">
					<a href="{{url('/')}}" class="btn btn-secondary btn-block">Gracias</a>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
<div class="container">
	<div class="col-xs-12 col-md-10 mx-auto mt-3">
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-2 mb-3 d-flex justify-content-center align-items-start">
						<img width="60" src="{{asset('images/membresia.png')}}" alt="">
					</div>
					<div class="col-md-10">
						<H4 class="plan-pay-name">Elegiste: {{$plan->name}}</H4>
						 @if($plan->promocion>0)
						 	@if($plan->moneda=="PEN")
						 	<span style="text-align:center;width:100%;color:#5C5C5C;font-weight: 700">Antes: <span style="text-decoration: line-through">S/. {{$plan->precio}}</span> soles</span>
				             <p class="plan-pay-precio">S/. {{$plan->promocion}} <span>Membresía por {{$plan->meses}} meses</span></p>
				             @else
				              <span style="text-align:center;width:100%;color:#5C5C5C;font-weight: 700">Antes: <span style="text-decoration: line-through">S/. {{$plan->precio}}</span> Dólares</span>
				             <p class="plan-pay-precio">$ {{$plan->promocion}} <span>Membresía por {{$plan->meses}} meses</span></p>
				             @endif
						 @else
						 
						 	@if($plan->moneda=="PEN")
				             <p class="plan-pay-precio">S/. {{$plan->precio}} <span>Membresía por {{$plan->meses}} meses</span></p>
				             @else
				             <p class="plan-pay-precio">$ {{$plan->precio}} <span>Membresía por {{$plan->meses}} meses</span></p>
				             @endif
						 @endif
						 
					</div>
				</div>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-xs-12 col-md-6 mb-4">
						<ul class="nav nav-tabs" id="myTab" role="tablist">
						  <li class="nav-item">
						    <a class="nav-link active" id="online-tab" data-toggle="tab" href="#online" role="tab" aria-controls="online" aria-selected="true">Pago en Linea</a>
						  </li>
						 <li class="nav-item">
						    <a class="nav-link" id="deposito-tab" data-toggle="tab" href="#deposito" role="tab" aria-controls="deposito" aria-selected="false">Deposito/Transferencia</a>
						  </li>
						</ul>

					  	<div class="tab-content" id="myTabContent">
					  	 <div class="tab-pane fade show active mt-5 text-center" id="online" role="tabpanel" aria-labelledby="online-tab">
					  	  			<p></p>
					  	  			@if($plan->promocion>0)
					  	  				@if($plan->moneda=="PEN")
							             <button type="button" id="buyButton1" class="btn btn-green btn-lg">PAGAR S/. {{$plan->promocion}}</button>
							             @else
							             <button type="button" id="buyButton1" class="btn btn-green btn-lg">PAGAR $ {{$plan->promocion}}</button>
							             @endif
							             <div class="none">{{$amount=$plan->promocion}}</div>
					  	  			@else
					  	  				@if($plan->moneda=="PEN")
							             <button type="button" id="buyButton1" class="btn btn-green btn-lg">PAGAR S/. {{$plan->precio}}</button>
							             @else
							             <button type="button" id="buyButton1" class="btn btn-green btn-lg">PAGAR $ {{$plan->precio}}</button>
							             @endif
							             <div class="none">{{$amount=$plan->precio}}</div>
					  	  			@endif
					  	  			

					  	  			<section class="pasarela">
					  	  			<h2 style="color: rgba(0,0,0,0.6)">Pague aquí con:</h2>
					  	  			<div class="col-md-12 d-flex flex-wrap">
					  	  				<div class="cardicon"><img src="{{asset('images/visa.png')}}" class="img-fluid" alt="Visa"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/mastercard.png')}}" class="img-fluid" alt="Mastercard"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/diners.png')}}" class="img-fluid" alt="Diners Club"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/american.png')}}" class="img-fluid" alt="American Express"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/unionpay.png')}}" class="img-fluid" alt="Union Pay"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/ripley.png')}}" class="img-fluid" alt="Ripley"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/cmr.png')}}" class="img-fluid" alt="Saga Falabella"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/oh.png')}}" class="img-fluid" alt="Tarjeta Oh!"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/cencosud.png')}}" class="img-fluid" alt="Cencosud"></div>
					  	  				<div class="cardicon"><img src="{{asset('images/presta.png')}}" class="img-fluid" alt="Presta"></div>
					  	  			</div>
				  			        </section>
				  			    <div class="row mt-4">
				  			    	<div class="col-md-6 mx-auto">
				  			    		<span style="color: rgba(0,0,0,0.6)">Certificado de seguridad:</span>
				  			    		<img class="img-fluid" width="150" src="/images/comodo-ssl.png" alt="">
				  			    	</div>
				  			    </div> 	  			
					  	  	
					  	  </div>
					  	  <div class="tab-pane fade mt-3" id="deposito" role="tabpanel" aria-labelledby="deposito-tab">
				  	  			<form action="{{route('solicitudeposito')}}" method="POST">
				  	  		    	{{ csrf_field() }}
				  	  		    	<input type="hidden" name="plan_id" value="{{$plan->id}}">
				  	  		    	<div class="row">
				  	  		    		<div class="col-md-12">
				  	  		    			<h4>Completar Información</h4>
				  	  		    			<div class="form-group {{ $errors->has('direccion') ? ' has-error' : '' }}">
				  	  		    				<label for="direccion">Dirección</label>
				  	  		    				<input type="text" name="direccion" class="form-control" placeholder="Av. ejemplo 234">
				  	  		    				@if ($errors->has('direccion'))
				  	  		    				    <span class="help-block">
				  	  		    				        <strong>{{ $errors->first('direccion') }}</strong>
				  	  		    				    </span>
				  	  		    				@endif
				  	  		    			</div>
				  	  		    			<div class="row">
				  	  		    				<div class="col-xs-12 col-md-6">
				  	  		    					<div class="form-group {{ $errors->has('dni') ? ' has-error' : '' }}">
				  	  		    						<label for="dni">N° de Documento</label>
				  	  		    						<input type="number" name="dni" class="form-control" placeholder="DNI">
				  	  		    						@if ($errors->has('dni'))
				  	  		    						    <span class="help-block">
				  	  		    						        <strong>{{ $errors->first('dni') }}</strong>
				  	  		    						    </span>
				  	  		    						@endif
				  	  		    					</div>
				  	  		    				</div>
				  	  		    				<div class="col-xs-12 col-md-6">
				  	  		    					<div class="form-group {{ $errors->has('telef') ? ' has-error' : '' }}">
				  	  		    						<label for="telef">Telf / Movil</label>
				  	  		    						<input type="number" name="telef" class="form-control" placeholder="Telf / Movil">
				  	  		    						@if ($errors->has('telef'))
				  	  		    						    <span class="help-block">
				  	  		    						        <strong>{{ $errors->first('telef') }}</strong>
				  	  		    						    </span>
				  	  		    						@endif
				  	  		    					</div>
				  	  		    				</div>
				  	  		    			</div>
				  	  		    			<div class="form-group">
				  	  		    				<button type="submit" id="saveInfo" class="btn btn-green btn-block">Continuar</button>
				  	  		    			</div>
				  	  		    		</div>
				  	  		    	</div>
				  	  		    </form>
    
					  	  </div>

						</div>
					</div>
					<div class="col-xs-12 col-md-6">

						<div class="row">
	  			        <div class="col-md-4 datasuscriptionicon text-center">
	  			          {{--<i class="suscriptionicono fas fa-play-circle"></i> --}}
	  			        </div>
	  			        <div class="col-md-8 datasuscriptioninfo">
	  			          <h2>Acceso a todo nuestro catálogo de videos de capacitación.</h2>
	  			          <li>Descarga o lee online todas nuestras revistas especializadas.</li>   
	  			          <li>Lee cientos de artículos especializados.</li>
	  			          <li>Descuentos en seminarios, talleres y cursos organizados por nosotros.</li>
	  			          
	  			        </div>
  			      		</div>

  			      		{{--<div class="row">
	  			        <div class="col-md-4 datasuscriptionicon text-center">                  
	  			          <i class="suscriptionicono fas fa-book-open"></i>
	  			        </div>
	  			        <div class="col-md-8 datasuscriptioninfo">
	  			          <h2>Disponibilidad total</h2>
	  			          <p>Descarga o lee online todas nuestras revistas especializadas.</p>
	  			        </div>
  			      		</div>--}}
  			      		<div class="row">
	  			        <div class="col-md-4 datasuscriptionicon text-center">                                    
	  			          {{--<i class="suscriptionicono fas fa-project-diagram"></i>     --}}        
	  			        </div>
	  			        <div class="col-md-8 datasuscriptioninfo">
	  			          <h2>Suplemento Técnico</h2>
	  			          <p>Encuentra costos y presupuestos de obras, análisis de precios unitarios, precios actualizados de materiales y mucho más.</p>
	  			        </div>
  			      		</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
@section('script-extra')
<!-- Incluyendo .js de Culqi Checkout-->
<script src="https://checkout.culqi.com/js/v3"></script>
<!-- Configurando el checkout-->
<script>

   {{-- Culqi.publicKey = 'pk_live_OhE2jDzFFYhPEkjy';--}}
     Culqi.publicKey = 'pk_test_sXUCiBUCfkPNteTd';
  
</script>
<script src="{{asset('js/waitMe.min.js')}}"></script>
<script>


	$('#buyButton1').on('click', function(e) {

	    // Abre el formulario con las opciones de Culqi.settings
	    Culqi.open();
	    e.preventDefault();

	});
	

	/*Configurando el checkout*/
	    Culqi.settings({
	        title: 'SUSCRIPCIÓN',
	        currency: '{{$plan->moneda}}',
	        description: 'Suscripción - {{$plan->name}}',
	        amount: ({{$amount}} * 100)
	    });

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
	            	agradecimiento();
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
						${estado =='charge' ? '<a href="/profile/suscription" class="btn btn-success btn-block">Ver mi suscripción</a>' :'<a href="/" class="btn btn-secondary btn-block">Aceptar</a>'}
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
@endsection

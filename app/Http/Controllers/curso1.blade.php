@extends('layouts.front')
@section('titulo')
{{$curso->titulo}}
@endsection
@section('content')
<div class="bg-response" id="mensajepago">
</div>
<div class="container" itemscope itemtype="http://schema.org/VideoObject">
  <div class="row mt-4">
    <div class="col-xs-12 col-md-8">
      <h2 class="titulo-curso">{{$curso->titulo}}</h2>
      <div class="embed-responsive embed-responsive-16by9"> 

        <img class="embed-responsive-item" src="{{asset('imgCurso/'.$curso->url_portada)}}" ></img>

      </div>

      <div class="preview-video">
        {{--<h1 class="title" itemprop="name">Acerca del Curso</h1>--}}
         <div class="none">{{$a=($curso->rubro->slug)}}</div>
                 {{--<div class="row mt-4">
                  <div class="col-xs-12 col-md-6">
                    <p>Inicia el &nbsp;<span><i class="fa fa-calendar"></i> <strong>{{date('d/m/Y',strtotime($curso->fecha))}}</strong></span></p>
            <p>Clases: <strong>{{$curso->countClases()}}</strong></p>
            
                    
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <ul class="list-group">
                      <li class="list-group-item"><span class="badge badge-secondary">{{$curso->countAlumnos()}}</span> Alumnos</li>
                      {{--<li class="list-group-item"><span class="badge badge-secondary"></span> Me gusta</li>
                      <li class="list-group-item"><span class="badge badge-secondary"></span>  Comentarios</li>--}}
                    {{--</ul>
                  </div>
                 </div>--}}
     
           @if(Auth()->user())
             @if(Auth()->user()->InteresCurso($curso->id))
                  <p class="text-center"><button style="font-size: 14px" type="button" title="Me interesa" disabled=" " class="btn btn-success mx-auto"><i class="fas fa-certificate"></i> Me interesa</button> </p>
                 

                  
              @else
                 <p class="text-center"><button style="font-size: 14px" type="button" title="Me interesa" onclick="saveInteres({{$curso->id}});" class="btn btn-success mx-auto"><i class="fas fa-certificate"></i> Me interesa</button>
              </p>

                 
              @endif

              
            @else
            @endif
         


        



        <h4 class="text-weight title">Descripción</h4>
        <p class="mt-3">
          {!!$curso->descripcion!!}
        </p>

        <br>


        <h4 class="text-weight title">Temario</h4>
        <p class="mt-3">
          <ul>
            @foreach($temas as $tema)
            <li>{{$tema->descripcion}}</li>
            @endforeach
           
          </ul>
        </p>
        @if($curso->beneficios)
           <br>
          <h4 class="text-weight title">Beneficios de Participación en el Curso:</h4>

           <p class="mt-3">
          {!!$curso->beneficios!!}
        </p>
        @else
        @endif
        


        @if($comentarios->count() > 0)
        <br>
        <h4 class="text-weight title">Comentarios</h4>
        <br>
        @endif
          <div class="row row-cols-1 row-cols-md-2 ">
            @foreach($comentarios as $coment)
            @if($coment->curso_id == $curso->id)
            <div class="col-xs-6 col-sm-12 col-md-6 " style="margin-bottom: 4%;">
              <div class="card">
               
                <div class="card-body">
                  <div class="user-datos">

                    <div class="img-user">
                       @if($coment->user->url_foto != null)
                         <img src="{{asset('fotousers/'.$coment->user->url_foto)}}" alt="">
                       @else
                         <img  src="{{asset('fotousers/profile.png')}}" alt="">
                       @endif

                    </div>

                    <div class="name-user"><p>{{$coment->user->fullname()}}</p></div>
                  </div>
                  <p class="card-text comentario"><i class="far fa-comment-alt" style="color:#FF8000;"></i> {{$coment->texto}}</p>
                </div>
              </div>
            </div>
            @else
            @endif
            @endforeach

          
          </div>

           <br> 
      </div>


    </div>

    <div class="col-xs-12 col-md-4">
      <meta itemprop="thumbnail" content="{{$curso->url_portada}}" />
      <meta itemprop="thumbnailUrl" content="{{asset('imgCurso/'.$curso->url_portada)}}" />
      <meta itemprop="uploadDate" content="{{$curso->fecha}}" />



      @if(Auth()->user())
              
        @if(Auth()->user()->SuscriptorCursos($curso->id))
                 
          @if(Auth()->user()->EvalCursos($evaluacion->id))
        
          @else      
          @endif
         
        @else

          
        @endif

      @else
      @endif

     {{-- <h4>Este curso consta de {{$curso->countClases()}} clases</h4>
            <ul class="list-group curso_ul">
              <li class="list-group-item active">Contenido</li>
              @foreach($clases as $clase)
              <li class="list-group-item">{{$clase->titulo}}</li>
              @endforeach
            </ul>--}}
    
    
    @if($curso->fecha_culminacion>=date('Y-m-d'))
       @if (!\Auth::guest()) 
          @if(Auth()->user()->isPremium())
                <div class="preview-info mb-4">
                  <h2>Precio del curso</h2>
                  @if($moneda=="PEN")
                  <h1 class="title-info" style="font-size: 35px">S/. {{$curso->promocion}}.00</h1>
                  <div class="none">{{$pago=$curso->promocion}}</div>
                  @else
                  <h1 class="title-info" style="font-size: 35px">$ {{$curso->promocion_d}}.00</h1>
                  <div class="none">{{$pago=$curso->promocion_d}}</div>
                  @endif
                 {{-- <p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio no suscriptor S/.  {{$curso->precio}}.00</p>--}}
                  <div class="mt-2-text-center">
                    
                     <button type="button" id="buyButton1"  class="btn btn-dark" >Comprar ahora</buttom>
                
                  </div>
                </div>
          @else
                 <div class="preview-info mb-4">
                  <h4 style="font-weight: 700">Por la compra de este curso</h4>
                  <h1 style="font-weight: 700">GRATIS</h1>
                  <p style="">1 año en la Plataforma Constructivo</p>
                  <h5>Precio del curso</h5>
                  @if($moneda=="PEN")
                  <h1 class="title-info" style="font-size: 25px">S/. {{$curso->precio}}.00</h1>

                  <div class="none">{{$pago=$curso->precio}}</div>
                  {{--<p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio suscriptor S/.  {{$curso->promocion}}.00</p>--}}
                  @else
                  <h1 class="title-info" style="font-size: 35px">$ {{$curso->precio_d}}.00</h1>

                  <div class="none">{{$pago=$curso->precio_d}}</div>
                 {{--<p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio suscriptor $  {{$curso->promocion_d}}.00</p>--}}
                  @endif
                  <div class="mt-2-text-center">
                    @if (!\Auth::guest()) 
                    <button type="button" id="buyButton1"  class="btn btn-dark" style="border-radius: 1px;font-weight: 700">Comprar ahora</buttom>
                    
                    @else
                    <a href="{{ url('/login?redirect_to='.url()->current()) }}" class="btn btn-dark" style="border-radius: 1px;font-weight: 700">Comprar ahora</a>
                    @endif
                    

                  </div>
                  <p style="font-size: 13px;margin-top: 1%">!Además accede a videos de capacitaciones, artículos técnicos y mucho más!</p>
          </div>
          @endif

      @else
          <div class="preview-info mb-4">
                  <h4 style="font-weight: 700">Por la compra de este curso</h4>
                  <h1 style="font-weight: 700">GRATIS</h1>
                  <p style="">1 año en la Plataforma Constructivo</p>
                  <h5>Precio del curso</h5>
                  @if($moneda=="PEN")
                  <h1 class="title-info" style="font-size: 25px">S/. {{$curso->precio}}.00</h1>

                  <div class="none">{{$pago=$curso->precio}}</div>
                  {{--<p class="subtitle mt-3" style="font-size: 15px;text-decoration: line-through; ">Precio suscriptor S/.  {{$curso->promocion}}.00</p>--}}
                {{--  <p class="subtitle mt-3" style="font-size: 15px; ">Precio suscriptor S/.  {{$curso->promocion}}.00</p>--}}
                  @else
                  <h1 class="title-info" style="font-size: 35px">$ {{$curso->precio_d}}.00</h1>

                  <div class="none">{{$pago=$curso->precio_d}}</div>
                 {{--<p class="subtitle mt-3" style="font-size: 15px; ">Precio suscriptor $  {{$curso->promocion_d}}.00</p>--}}
                  @endif
                  <div class="mt-2-text-center">
                    @if (!\Auth::guest()) 
                    <button type="button" id="buyButton1"  class="btn btn-dark" style="border-radius: 1px;font-weight: 700">Comprar ahora</buttom>
                    
                    @else
                    <a href="{{ url('/login?redirect_to='.url()->current()) }}" class="btn btn-dark" style="border-radius: 1px;font-weight: 700">Comprar ahora</a>
                    @endif
                    

                  </div>
                  <p style="font-size: 13px;margin-top: 1%">!Además accede a videos de capacitaciones, artículos técnicos y mucho más!</p>
          </div>



      @endif
    


          <div class="row d-flex justify-content-center mt-2 mb-2">
        <div class="col-xs-12 col-md-12 mx-auto">
          <div class="pay-methods-content">
            
            <div class="pay-methods-logos mx-auto">
              <img src="/images/visa.png" alt="Visa">
              <img src="/images/mastercard.png" alt="MasterCard">
              <img src="/images/diners.png" alt="Diners">
              <img src="/images/american.png" alt="Amex">
              <img src="/images/ripley.png" alt="Ripley">
              <img src="/images/cmr.png" alt="CMR">
            </div>
          </div>
        </div>
      </div>

      <br>
    @else
      
     <div class="none">{{ $pago=1000}}</div>

    @endif
      <h5 class="text-weight">Acerca del profesor</h5>
        
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <div class="card">
               
                <div class="card-body">
                  <div class="user-datos">
                    <div class="img-user">
                       @if($curso->autor->imagen != "")
                         <img src="{{asset('posts/'.$curso->autor->imagen)}}" alt="">
                       @else
                         <img  src="{{asset('fotousers/profile.png')}}" alt="">
                       @endif

                    </div>

                    <div class="name-user"><p>{{$curso->autor->nombre}}</p></div>
                  </div>
                  <p class="card-text comentario">{!!$curso->autor->bio!!}</p>
                 <p class="text-center"> <a href="{{url('videos/autor/'.$curso->autor->slug)}}" class="btn-autor">Ver</a></p>
                </div>
              </div>
            </div>
          
          </div>


          <h5 class="text-weight">Certifica tus habilidades</h5>
        
          <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <img src="{{asset('images/certificado.jpg')}}" width="100%;">
            </div>
          
          </div>


          <br>
         @if(Auth()->user())
          @if(Auth()->user()->ispremium())
          @else
            <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <div class="banner-suscriptor">
                <h5><strong>Vuélvete Premium y obtén descuentos en todos los cursos</strong></h5>
                <p>¡Además accede a videos de capacitaciones, artículos técnicos y mucho más!</p>
                <br>
                <a href="{{route('planes')}}" >¡Quiero ser Premium!</a>
              </div>
            </div>
          
          </div>
          @endif
         @else
           <div class="row row-cols-1 row-cols-md-2">
            <div class="col col-12 card-comentario">
              <div class="banner-suscriptor">
                <h5><strong>Vuélvete Premium y obtén descuentos en todos los cursos</strong></h5>
                <p>¡Además accede a videos de capacitaciones, artículos técnicos y mucho más!</p>
                <br>
                <a href="{{route('planes')}}" >¡Quiero ser Premium!</a>
              </div>
            </div>
          
          </div>
         @endif
        





      </div>


    </div>
  </div>
</div>
@endsection
@section('script-extra')
<script >
  var token = '{{ csrf_token() }}';
  function saveInteres(curso_id) {
    var ruta = '{{route('saveInterescurso')}}';

    $.ajax({
      url: ruta,
      type: 'POST',
      headers:{'X-CSRF-TOKEN': token},
      dataType: 'json',
      data:{
        curso_id: curso_id
      },
      success:function(data){
        console.log(data);
        location.reload();
      },
      error:function(data){
        console.log(data);
      }
    });
  }
 
</script>
<!-- Incluyendo .js de Culqi Checkout-->
<script src="https://checkout.culqi.com/js/v3"></script>
<!-- Configurando el checkout-->
<script>

  Culqi.publicKey = 'pk_live_OhE2jDzFFYhPEkjy';
     // Culqi.publicKey = 'pk_test_sXUCiBUCfkPNteTd';
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
          title: 'PARTICIPACIÓN',
          currency: '{{$moneda}}',
          description: 'Participación - {{$curso->titulo}}',
          amount: ({{$pago}} * 100)
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
              amount: '{{$pago}}',
              currency: '{{$moneda}}',
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
                show_message(result.outcome.user_message,'alert-success','charge');
                console.log(result.outcome.merchant_message);
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
            ${estado =='charge' ? '<a href="/curso/{{$curso->slug}}" class="btn btn-success btn-block">Ver curso</a>' :'<a href="/curso/{{$curso->slug}}" class="btn btn-secondary btn-block">Aceptar</a>'}
            </div>
          </div>
        </div>
      </div>
    `);
  
  $('body').waitMe('hide');
  $('.bg-response').show();
  
}

</script>
@endsection
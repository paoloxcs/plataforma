<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
     <meta name="facebook-domain-verification" content="f10t4osjihncxk2jsrse49p7lm550n" />
      
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plataforma virtual de enseñanza y aprendizaje en ingeniería y arquitectura que conecta a profesionales y estudiantes con la mejor enseñanza profesional.">
    <meta name="author" content="Pull Creativo Comunicaciones">
    <title>@yield('titulo') | {{ config('app.name', 'Laravel')}}</title>

    <!-- FONT AWESOME 5.15 -->
    <link rel="stylesheet" href="{{asset('fontawesome-5.15.4-web/css/all.css')}}">
    {{-- CAMBIOS JHED --}}
    <link rel="stylesheet" href="{{asset('css/responsive_estilos.css')}}">
    {{-- NAV NEW --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style_nav.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/style_nav_v2.css') }}">
    {{-- CAMBIOS JHED --}}
    {{-- SWIPER --}}
    <!-- <link
      rel="stylesheet"
      href="https://unpkg.com/swiper@7/swiper-bundle.min.css"
    /> -->
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css"
    />
    
    <!-- FONT FAMILY -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

  <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,900;1,900&display=swap" rel="stylesheet">
  
  <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    
    <link href="{{asset('css/estilos.css')}}" rel="stylesheet">


    <!-- Imagen - Favicon  -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/icono.png')}}" />

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130772048-1"></script>
    {{-- PAGOS YAPE --}}
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('vendor/toastr/build/toastr.min.css')}}">
    
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-130772048-1');
    </script>
    <!-- Google Analytics -->
    
    <!-- Google Search Console -->
	<meta name="google-site-verification" content="5bOYAL_lwAq7Rzj9JunhbJ7shT3SbyRvcAyHUcJsrnY" />
	<!-- Google Search Console -->
    
    
   <!-- Global site tag (gtag.js) - Google Ads: 986089827 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-986089827"></script>
    <script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', 'AW-986089827'); </script> 

    @yield('style-extra')  



  
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':

    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],

    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=

    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);

    })(window,document,'script','dataLayer','GTM-5F3CR76');</script>

    <!-- Meta Pixel Code -->
  <script>
    !function(f,b,e,v,n,t,s)
    {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};
    if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
    n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];
    s.parentNode.insertBefore(t,s)}(window, document,'script',
    'https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '685775116003655');
    fbq('track', 'PageView');
  </script>
  <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=685775116003655&ev=PageView&noscript=1"
  /></noscript>
  <!-- End Meta Pixel Code -->

  </head>
  <body>

    <div class="col-12 pbm-0">
      <div class="none">
        {{$a='construccion'}}
      </div>
      <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5F3CR76"

      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

           
      <!-- @if(!\Auth::guest()) 
        @if(Auth()->user()->isFree()) 
          <div class="alert  alert-dismissible fade show promo-plan pbm-0" role="alert">
            
            <p class="c-white">¡Disfruta de nuestra promoción! 30% dscto. En tu suscripción anual <a  class="a-promocion" href="{{route('planes','construccion')}}">OBTENER OFERTA</a> </p>

            <button style="color:white" type="button"  data-bs-dismiss="alert"><i class="fas fa-times"></i></button>
          </div>
        @endif
                
      @else 
        <div class="alert  alert-dismissible fade show promo-plan pbm-0" role="alert">
          
          <p class="c-white">¡Disfruta de nuestra promoción! 30% dscto. En tu suscripción anual <a  class="a-promocion" href="{{route('planes','construccion')}}">OBTENER OFERTA</a> </p>

          <button style="color:white" type="button"  data-bs-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      @endif -->
       {{-- CAMBIOS JHED --}}
      {{-- <p class="c-white">¡Disfruta de nuestra promoción! 30% dscto. En tu suscripción anual <a  class="a-promocion" href="{{route('planes','construccion')}}">OBTENER OFERTA</a> </p>    --}}
      @if(!\Auth::guest()) 
        @if(Auth()->user()->isFree()) 
          <div class="alert banner-plan-promo alert-dismissible fade show promo-plan pbm-0" role="alert">
            
                   <p class="c-white mb-1">Promoción por Verano 50% de descuento por 12 meses.</p>
                    <!--<p class="c-white mb-1 flex md:hidden">Oferta 50% por el Día del Padre</p>-->
                    
            <a  class="a-promocion text-center" href="{{route('planes','construccion')}}">OBTENER OFERTA</a> 

            <button style="color:white" type="button"  data-bs-dismiss="alert"><i class="fas fa-times"></i></button>
          </div>
        @endif
                
      @else 
        <div class="alert banner-plan-promo alert-dismissible fade show promo-plan pbm-0" role="alert">
          
                <p class="c-white mb-1">Promoción por Verano 50% de descuento por 12 meses.</p>
                <!--<p class="c-white mb-1 flex md:hidden">Oferta 50% por el Día del Padre</p>-->
                    
          <a  class="a-promocion text-center" href="{{route('planes','construccion')}}">OBTENER OFERTA</a> 

          <button style="color:white" type="button"  data-bs-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
      @endif
    
        {{-- NAV NEW --}}
        {{-- @include('components.navigation') --}}
        @include('components.navigation-v2')


        <div class="none">{{$url=Request::path()}}</div>

          <!-- CABECERA -->
          <!-- CONTENIDO -->
           <main class="m-none" role="main">
            @yield('content')

          </main>
        <!-- CONTENIDO -->
        <!-- FOOTER -->
        
        {{-- NAV NEW --}} 
        {{-- @include('components.menu-movil') --}}
        @include('components.menu-movil-v2')



<div class="modal fade" id="modal-login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-xl modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:   15px">
      <div class="modal-body col-md-12 row pbm-0" >
        <section class="col-md-5 pbm-0 none-mobile">
           <!--<img src="{{asset('images/img-create.png')}}" width="105%">-->
            {{-- Form Age_Profession --}}
                            <img class="pbm-0 img__Access"src="{{ asset('images/img-create.png') }}" width="105%">
        </section>
        <section class="col-md-7 col-xs-12 pbm-0 s-login">
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      
           <p class="text-center mt-5 mt-2-mob"><i class="fas fa-user" style="font-size: 30px" ></i></p>
           <h3 class="font-weight text-center mt-2">Bienvenido a Plataforma Constructivo</h3>
           {{--<p class="text-center">Disfruta la experiencia con nosotros</p> --}}
           {{--<a href="" class="btn-100 btn-f"><i class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Ingresar con Facebook</a>
            <a href="" class="btn-100 btn-g"><i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Ingresar con Google</a>
            <p class="font-weight text-center mt-3">o tambien</p>--}}
             <a href="{{ url('login/google') }}" class="btn-100 btn-g"><i
                                    class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Ingresar con Google</a>
                            <p class="font-weight text-center mt-3">o tambien</p>
            <form class="mt-5" method="POST" action="{{ route('login') }}"> 
              {{ csrf_field() }}
                      <!-- <div class="form-group">
                <input class="form-control btn-100 {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Correo eléctronico" value="{{old('email')}}" autofocus>
                 @if ($errors->has('email'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('email') }}</strong>
                   </span>
                @endif
              </div>
              <div class="form-group">
                <input class="form-control btn-100 {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" name="password" type="password" placeholder="Contraseña">
                 @if ($errors->has('password'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('password') }}</strong>
                   </span>
                @endif
              </div>
              <div class="form-group">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="form-check-input " type="checkbox" {{ old('remember') ? 'checked' : '' }}> Recordar contraseña</label>
                </div>
              </div> -->

            <div class="form-group">
                <input class="form-control btn-100 form-btn-login {{ $errors->has('email') ? ' is-invalid' : '' }}" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Correo eléctronico" value="{{old('email')}}" autofocus>
                 @if ($errors->has('email'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('email') }}</strong>
                   </span>
                @endif
            </div>
            <div class="form-group">
                <input class="form-control btn-100 form-btn-login {{ $errors->has('password') ? ' is-invalid' : '' }}" id="exampleInputPassword1" name="password" type="password" placeholder="Contraseña">
                 @if ($errors->has('password'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('password') }}</strong>
                   </span>
                @endif
            </div>
            <div class="form-group">
                <div class="form-check form-check-login">
                  <label class="form-check-label">
                    <input class="form-check-input " type="checkbox" {{ old('remember') ? 'checked' : '' }}> Recordar contraseña</label>
                </div>
            </div>

                <button type="submit" class="btn-100 btn-green mt-4">INICIAR SESIÓN</button>

            </form>

        <!-- <p class="text-center font-weight mt-5">¿Olvidaste tu contraseña? <a class="font-weight" type="button"  data-bs-toggle="modal" data-bs-target="#modal-recuperar"> Ingresa aquí</a></p>
            <hr>
            <p class="text-center"><a class="font-weight" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">Ó crea tu cuenta gratis</a></p> -->

              {{-- NEW NAV --}}
            <p class="text-center font-weight mt-5">¿Olvidaste tu contraseña? <a class="font-a-crear" type="button"  data-bs-toggle="modal" data-bs-target="#modal-recuperar"> Ingresa aquí</a></p>
            <hr>
            <p class="text-center"><a class="font-a-crear" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">Ó crea tu cuenta gratis</a></p>

        </section>
        {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}

       
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-recuperar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog  modal-dialog modal-dialog-centered" style="width:97%">
    <div class="modal-content" style="border-radius:   15px">
      <div class="modal-body col-md-12 row pbm-0" >

        <section class="col-md-12 pbm-0 s-login">
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <br>
           <p class="text-center"><i class="fas fa-user" style="font-size: 30px" ></i></p>
           <h3 class="font-weight text-center">Recuperar Contraseña</h3>
          {{-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur. </p> --}}
           @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
           @endif
            <form method="POST" action="{{ route('password.email') }}">
               {{ csrf_field() }} 

                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control  btn-100" name="email" value="{{ old('email') }}" required placeholder="Ingresa tu correo" autofocus placeholder="Correo electrónico">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
               </div>

                <button type="submit"class="btn-100 btn-green">ENVIAR LINK DE RECUPERACIÓN</button>

            </form>

            <br>
          

        </section>
        {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}

       
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-create" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog modal-xl modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:   15px">
      <div class="modal-body col-md-12 row pbm-0" >
        <section class="col-md-5 none-mobile pbm-0" style="margin:0">
               {{-- <img class=" pbm-0" src="{{asset('images/img-login.png')}}" width="100%"> --}}
                            {{-- Form Age_Profession --}}
                            <img class="pbm-0 img__Access" src="{{ asset('images/img-login.png') }}" width="100%">
        </section>
        <section class="col-md-6 mx-auto   col-xs-12 pbm-0 ">
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;top: 1%;right: 1%"></button>
      
           <p class="text-center mt-5 mt-2-mob"><i class="fas fa-user" style="font-size: 30px" ></i></p>
           <h3 class="font-weight text-center mt-5-mob ">Crea una cuenta</h3>
           {{--<p class="text-center">Lorem ipsum dolor sit amet, consectetur. </p> --}}
           {{--<a href="" class="btn-100 btn-f" style="width: 80%;margin-left: 10%"><i class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Regístrate con Facebook</a>
            <a href="" class="btn-100 btn-g" style="width: 80%;margin-left: 10%"><i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Regístrate con Google</a>
            <p class="font-weight text-center mt-4">o también</p>--}}
            <form action="{{route('register')}}" method="POST"> 
              {{ csrf_field() }}
           <!-- <div class="row col-md-12 pbm-0">
              <div class="form-group col-xs-12 col-md-6">
                  <input class="form-control btn-100 {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" aria-describedby="nameHelp" placeholder="Nombres" autofocus value="{{old('name')}}">
                   @if ($errors->has('name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('name') }}</strong>
                     </span>
                  @endif
              </div>
              <div class="form-group col-xs-12 col-md-6">
                  <input class="form-control btn-100 {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" aria-describedby="nameHelp" placeholder="Apellidos" value="{{old('last_name')}}">
                   @if ($errors->has('last_name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('last_name') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                <input class="form-control btn-100 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" aria-describedby="emailHelp" placeholder="Correo electrónico" value="{{old('email')}}">
                 @if ($errors->has('email'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('email') }}</strong>
                   </span>
                @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <input type="number" name="phone_number" class="form-control btn-100 {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="Telf. / Movil">
                   @if ($errors->has('phone_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('phone_number') }}</strong>
                     </span>
                  @endif
              </div>
              
              <div class="form-group col-xs-12 col-md-6">
                  <input id="password" type="password" class="form-control btn-100 {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña">
                   @if ($errors->has('password'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <input id="password-confirm" type="password" class="form-control btn-100" name="password_confirmation" placeholder="Confirmar contraseña">
                </div>

              <div class="form-group col-xs-12 col-md-6">
                  <select  name="pais" class="form-select form-select-sm select-suple btn-100 form-control btn-100 {{ $errors->has('pais') ? ' is-invalid' : '' }}" >
                  <option disabled="" selected="">País</option>
                  <option value="Argentina">Argentina</option>
                          <option value="Bolivia">Bolivia</option>
                          <option value="Chile">Chile</option>
                          <option value="Colombia">Colombia</option>
                          <option value="Ecuador">Ecuador</option>
                          <option value="México">México</option>
                          <option value="Perú">Perú</option>
                          <option value="Otro">Otro</option>
                </select>
                @if ($errors->has('pais'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('pais') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <select  name="medio" class="form-select form-select-sm select-suple btn-100 form-control btn-100 {{ $errors->has('medio') ? ' is-invalid' : '' }}" >
                    <option disabled="" selected="">Área de interés</option>
                    <option value="1">Construcción</option>
                    <option value="2">Arquitectura y Diseño</option>
                    <option value="3">Minería</option>
                </select>
                @if ($errors->has('medio'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('medio') }}</strong>
                     </span>
                  @endif
              </div>


                <button type="submit" class="btn-100 btn-green mt-2" style="width: 90%;margin-left: 5%">REGISTRARME</button> -->
           {{-- <div class="row col-md-12 pbm-0">
                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input
                                            class="form-control btn-100 form-btn-i {{ $errors->has('name') ? ' is-invalid' : '' }}"
                                            type="text" name="name" aria-describedby="nameHelp"
                                            placeholder="Nombres" autofocus value="{{ old('name') }}">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input
                                            class="form-control btn-100 form-btn-i {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                                            type="text" name="last_name" aria-describedby="nameHelp"
                                            placeholder="Apellidos" value="{{ old('last_name') }}">
                                        @if ($errors->has('last_name'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('last_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input
                                            class="form-control btn-100 form-btn-i {{ $errors->has('email') ? ' is-invalid' : '' }}"
                                            type="email" name="email" aria-describedby="emailHelp"
                                            placeholder="Correo electrónico" value="{{ old('email') }}">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input type="number" name="phone_number"
                                            class="form-control btn-100 form-btn-i {{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                                            placeholder="Telf. / Movil">
                                        @if ($errors->has('phone_number'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('phone_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>


                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <select name="pais"
                                            class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('pais') ? ' is-invalid' : '' }}">
                                            <option disabled="" selected="">País</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Bolivia">Bolivia</option>
                                            <option value="Chile">Chile</option>
                                            <option value="Colombia">Colombia</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="México">México</option>
                                            <option value="Perú" selected>Perú</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                        @if ($errors->has('pais'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('pais') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <select name="medio"
                                            class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('medio') ? ' is-invalid' : '' }}">
                                            <option disabled="" selected="">Área de interés</option>
                                            <option value="1">Construcción</option>
                                            <option value="2">Arquitectura y Diseño</option>
                                            <option value="3">Minería</option>
                                        </select>
                                        @if ($errors->has('medio'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('medio') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input id="password" type="password"
                                            class="form-control btn-100 form-btn-i {{ $errors->has('password') ? ' is-invalid' : '' }}"
                                            name="password" placeholder="Contraseña">
                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback">
                                                <strong>{{ $errors->first('password') }}</strong>
                                            </span>
                                        @endif
                                    </div>

                                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                                        <input id="password-confirm" type="password"
                                            class="form-control btn-100 form-btn-i " name="password_confirmation"
                                            placeholder="Confirmar contraseña">
                                    </div>
                                    <button type="submit" class="btn-100 btn-green mt-2"
                                        style="width: 90%;margin-left: 5%">REGISTRARME</button>
                                </div> --}}
                                <div class="row col-md-12 pbm-0">
                                    @include('components.form_registro')

                                    <button type="submit" class="btn-100 btn-green mt-2" id="btn_registro"
                                        style="width: 90%;margin-left: 5%">REGISTRARME</button>
                                </div>
                
            </form>

            <!-- <p class="text-center font-weight mt-2">¿Ya tienes cuenta? <a class="font-weight" type="button"  data-bs-toggle="modal" data-bs-target="#modal-login"> Ingresa aquí</a></p> -->

          {{-- NEW NAV --}}
            <p class="text-center font-weight mt-2">¿Ya tienes cuenta? <a class="font-weight font-a-crear" type="button"  data-bs-toggle="modal" data-bs-target="#modal-login"> Ingresa aquí </a></p>


        </section>
        {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}

       
      </div>
    </div>
  </div>
</div>




        <footer class="col-md-12 pbm-0">
          <div class="col-md-8 mx-auto row pbm-0 s-footer">
            <section class="col-md-4 col-xs-12">
              <p><a href="/"><img src="{{asset('images/logo-white.png')}}" class="img-logo"></a><img src=""></p>
              <p><a href=""><i class="fas fa-phone-alt color-n"></i>&nbsp;&nbsp;&nbsp;+51 981 324 180</a></p>
              <p><a href=""><i class="fas fa-envelope color-n"></i>&nbsp;&nbsp;&nbsp;info2@constructivo.com</a></p>
              <p><a href=""><i class="fas fa-map-marker-alt color-n" ></i>&nbsp;&nbsp;&nbsp;Marcos Dongo 223 - Pueblo Libre</a></p>
             {{-- FOOTER RUBRO --}}
                    {{-- <p class="font-weight">SÍGUENOS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        @if ($rubroSlug != '')
                            @if ($rubroSlug == 'mineria')
                                <a href="https://www.facebook.com/TECNOLOGIAMINERA/" target="_blank"><span
                                        class="s-fab s-footer"><i class="fab fa-facebook-f"></i></span></a>
                                &nbsp;
                                <a href="https://www.instagram.com/tecminera/" target="_blank"><span
                                        class="s-fab s-footer"><i class="fab fa-instagram"></i></span></a>
                            @elseif($rubroSlug == 'arquitectura-y-diseno')
                                <a href="https://www.facebook.com/dossierdearquitectura" target="_blank"><span
                                        class="s-fab s-footer"><i class="fab fa-facebook-f"></i></span></a>
                                &nbsp;
                                <a href="https://www.instagram.com/dossierarq/" target="_blank"><span
                                        class="s-fab s-footer"><i class="fab fa-instagram"></i></span></a>
                            @else
                                <a href="https://www.facebook.com/REVISTACONSTRUCTIVO" target="blank"><span
                                        class="s-fab s-footer"><i class="fab fa-facebook-f"></i></span></a>
                                &nbsp;
                                <a href="https://www.instagram.com/revista_constructivo/" target="blank"><span
                                        class="s-fab s-footer"><i class="fab fa-instagram"></i></span></a>
                            @endif
                        @else
                            <a href="https://www.facebook.com/PlataformaConstructivo/" target="blank"><span
                                    class="s-fab s-footer"><i class="fab fa-facebook-f"></i></span></a>

                        @endif
                    </p> --}}
            </section>
            <section class="col-md-4 col-xs-12">
              <h5 class="color-n font-weight">ACERCA DE</h5>
              <p><a href="/nosotros">Nosotros</a></p>
              <p><a href="/privacidad">Política de Privacidad</a></p>
              <p><a href="/terminos">Términos y Condiciones</a></p>
              <p><a href="/contacto">Contacto</a></p>
              <p><a href="/preguntas-frecuentes">Preguntas Frecuentes</a></p>
              <p><a href="http://librodereclamaciones.pullcreativo.com/index.php?m=plataforma-constructivo" target="_blank">Libro de Reclamaciones</a></p>
            </section>
                {{-- FOOTER RUBRO --}}
                <section class="col-md-4 col-xs-12">
                    <h5 class="color-n font-weight">CATEGORÍAS</h5>
                    <p>
                        <a href="/rubro/construccion">Construcción</a>

                        <span class="ml-2">
                            <a href="https://www.facebook.com/REVISTACONSTRUCTIVO" target="blank">
                                <span class=""><i class="fab fa-facebook-f"></i></span>
                            </a>
                            <a href="https://www.instagram.com/revista_constructivo/" target="blank">
                                <span class=" ml-2"><i class="fab fa-instagram"></i></span>
                            </a>
                        </span>
                    </p>
                    <p>
                        <a href="/rubro/mineria">Minería</a>

                        <span class="ml-2">
                            <a href="https://www.facebook.com/TECNOLOGIAMINERA/" target="_blank">
                                <span class=""><i class="fab fa-facebook-f"></i></span>
                            </a>
                            <a href="https://www.instagram.com/tecminera/" target="_blank">
                                <span class=" ml-2"><i class="fab fa-instagram"></i></span>
                            </a>
                        </span>
                    </p>
                    <p>
                        <a href="/rubro/arquitectura-y-diseno">Arquitectura y Diseño</a>

                        <span class="ml-2">

                            <a href="https://www.facebook.com/dossierdearquitectura" target="_blank">
                                <span class=""><i class="fab fa-facebook-f"></i></span>
                            </a>
                            <a href="https://www.instagram.com/dossierarq/" target="_blank">
                                <span class="ml-2"><i class="fab fa-instagram"></i></span>
                            </a>
                        </span>
                    </p>

                </section>
            <p class="text-center">© <?php echo date("Y"); ?> plataforma constructivo.Todos los derechos reservados</p>
          </div>
          

        </footer>
        
        <!-- FOOTER -->

          <!-- Bootstrap core JavaScript =========================== -->
           <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

          <!-- SWIPER -->
            <!-- <script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script> -->
            <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>


          <div class="btn-wssp">
             <a title="WhatsApp" href="https://api.whatsapp.com/send?phone=51981324180&text=Hola%20quisiera%20informaci%C3%B3n%20sobre%20">
              <img src="{{asset('images/wssp-icon.png')}}" width="100%">
             
            </a>
            
          </div>

          

        {{-- <script>            
              //  CAMBIOS JHED
              window.addEventListener('load', function() {  
                  
                  document.getElementById("icon_search_mobile").onclick = function() {  
                    // $('.cu-mineria').removeClass('d-none');
                    // $('.cu-mineria').addClass('d-none');
                    document.getElementById("section_search").style.display = "flex";
                  }; 
                  document.getElementById("icon_search").onclick = function() {  
                    // $('.cu-mineria').removeClass('d-none');
                    // $('.cu-mineria').addClass('d-none');
                    document.getElementById("section_search").style.display = "flex";
                  };  
                  document.getElementById("btn_close_search").onclick = function() {  
                    // $('.cu-mineria').removeClass('d-none');
                    // $('.cu-mineria').addClass('d-none');
                    document.getElementById("section_search").style.display = "none";
                  }; 
                    
              });
            //  CAMBIOS JHED
          </script> --}}
        {{-- NAV NEW --}}
        <script>
            window.onscroll = function() {
                handleOnScroll()
            };
            var open_modal = false;
            var openMenu = document.getElementById("modal-menu-mobil");
            var navRubro = document.getElementById("nav-rubros");

            function handleOnScroll() {
                if (document.documentElement.scrollTop > 80) {
                    navRubro.classList.add("sticky");
                    navRubro.classList.add("top-[60]");
                    navRubro.classList.add("z-[200]");
                } else {
                    navRubro.classList.remove("sticky");
                    navRubro.classList.remove("top-[60]");
                    navRubro.classList.remove("z-[200]");
                }
            }

            window.addEventListener('resize', function() {
                let anchoV1 = window.innerWidth;
                // console.log("width: ", anchoV1, "px");
                if (this.open_modal) {
                    if (anchoV1 >= 1365) {
                        this.open_modal = false;
                        openMenu.classList.add("fade");
                        openMenu.classList.remove("block");
                        openMenu.classList.add("hidden");
                        document.getElementsByTagName('html')[0].style.overflow = 'auto';
                    }
                    //  else {
                    //     document.getElementsByTagName('html')[0].style.overflow = 'auto';
                    // }
                }
                if (anchoV1 <= 1365) {
                    $('.s-m-rubro').addClass('hidden');
                }
            });


            function showModal() {
                if (this.open_modal) {
                    //Se cierra el menu
                    this.open_modal = false;
                    openMenu.classList.add("fade");
                    openMenu.classList.remove("block");
                    openMenu.classList.add("hidden");
                    document.getElementsByTagName('html')[0].style.overflow = 'auto'
                } else {
                    //Esta abriendo el menu
                    this.open_modal = true;
                    openMenu.classList.remove("hidden");
                    openMenu.classList.add("block");
                    openMenu.classList.remove("fade");
                    document.getElementsByTagName('html')[0].style.overflow = 'hidden'
                }

            };
        </script>
          <script> 
          
            // NAV NEW
            
            var openCategoria = false;

            document.addEventListener("click", function(e) {
                //obtiendo informacion del DOM para  
                var clic = e.target;
                if (clic == document.getElementById('a-m-categoria')) {
                    if (this.openCategoria) {
                        this.openCategoria = false;
                        $('.s-m-rubro').addClass('d-none');
                        $('.s-m-rubro').addClass('hidden');
                        document.getElementsByTagName('html')[0].style.overflow = 'auto';
                    } else {
                        this.openCategoria = true;
                        $('.s-m-rubro').removeClass('d-none');
                        $('.s-m-rubro').removeClass('hidden');
                        document.getElementsByTagName('html')[0].style.overflow = 'hidden';
                    }
                } else if (!document.getElementById('nav-cat-rubro').contains(e.target) && !document.getElementById(
                        'nav-item-rubro').contains(e.target) && !document.getElementById('items-rubros').contains(e
                    .target)) {
                    this.openCategoria = false;
                    $('.s-m-rubro').addClass('d-none');
                    $('.s-m-rubro').addClass('hidden');
                    document.getElementsByTagName('html')[0].style.overflow = 'auto';

                }
            }, false); 
            
            $('.li-rubro').hover(function(){
            
             $('.li-rubro').removeClass('li-r-active');
            $(this).addClass('li-r-active');
            
            });


            $('.li-r-c').hover(function(){
            


             $('.d-menu-r').addClass('d-none');
            $('.li-p-c').removeClass('li-p-active');

            $('.li-cu-c').addClass('li-p-active');
            $('.cu-construccion').removeClass('d-none');

            
            });

             $('.li-r-a').hover(function(){
            


             $('.d-menu-r').addClass('d-none');
            $('.li-p-a').removeClass('li-p-active');

            $('.li-cu-a').addClass('li-p-active');
            $('.cu-arquitectura').removeClass('d-none');

            
            });

            $('.li-r-m').hover(function(){
            


             $('.d-menu-r').addClass('d-none');
            $('.li-p-m').removeClass('li-p-active');

            $('.li-cu-m').addClass('li-p-active');
            $('.cu-mineria').removeClass('d-none');

            
            });




            $('.li-p-c').hover(function(){
            
             $('.li-p-c').removeClass('li-p-active');
            $(this).addClass('li-p-active');


            
            });

            $('.li-p-a').hover(function(){
            
             $('.li-p-a').removeClass('li-p-active');
            $(this).addClass('li-p-active');
            
            });

               $('.li-p-m').hover(function(){
            
             $('.li-p-m').removeClass('li-p-active');
            $(this).addClass('li-p-active');
            
            });


            $('.li-r-c').hover(function(){
            
            $('.m-rubros').addClass('d-none');
             $('#m-construccion').removeClass('d-none');
            
            
            });

            $('.li-r-a').hover(function(){
            
            $('.m-rubros').addClass('d-none');
             $('#m-arquitectura').removeClass('d-none');
            
            
            });

            $('.li-r-m').hover(function(){
            
            $('.m-rubros').addClass('d-none');
             $('#m-mineria').removeClass('d-none');
            
            
            });

            $('.li-r-m').hover(function(){
            
            $('.m-rubros').addClass('d-none');
             $('#m-mineria').removeClass('d-none');
            
            
            });



            //li - cursos -  de construccion


            $('.li-cu-c').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.cu-construccion').removeClass('d-none');
            });

            $('.li-ca-c').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ca-construccion').removeClass('d-none');
            });
            
            $('.li-re-c').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.re-construccion').removeClass('d-none');
            });


            $('.li-ar-c').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ar-construccion').removeClass('d-none');
            });

            $('.li-su-c').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.su-construccion').removeClass('d-none');
            });

            //li - cursos -  de mineria


            $('.li-cu-m').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.cu-mineria').removeClass('d-none');
            });

            $('.li-ca-m').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ca-mineria').removeClass('d-none');
            });
            
            $('.li-re-m').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.re-mineria').removeClass('d-none');
            });


            $('.li-ar-m').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ar-mineria').removeClass('d-none');
            });


            //li - cursos -  de arquitectura


            $('.li-cu-a').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.cu-arquitectura').removeClass('d-none');
            });

            $('.li-se-a').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.se-arquitectura').removeClass('d-none');
            });
            


            $('.li-ca-a').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ca-arquitectura').removeClass('d-none');
            });
            

            $('.li-re-a').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.re-arquitectura').removeClass('d-none');
            });


            $('.li-ar-a').hover(function(){
            
             $('.d-menu-r').addClass('d-none');

             $('.ar-arquitectura').removeClass('d-none');
            });


            //CATEGORIA_LI
            //NAV NEW 
           
            $('.a-m-categoria').hover(function() {
                // $('.s-m-rubro').removeClass('d-none');
                // $('.s-m-rubro').removeClass('hidden');
            }); 

            $('.s-m-rubro').hover(function() {

                // $('.s-m-rubro').removeClass('d-none');
                // $('.s-m-rubro').removeClass('hidden');
            });

            $('.m-none').hover(function() {

                // $('.s-m-rubro').addClass('d-none');
                // $('.s-m-rubro').addClass('hidden');
            });

             //BENEFICIOS PLANES
             //anual
             $('.l-b-c-a').hover(function(){
            
            $('.b-plan').addClass('d-none');
            $('.b-construccion-a').removeClass('d-none');
            
            });

            $('.l-b-a-a').hover(function(){
            
            $('.b-plan').addClass('d-none');
            $('.b-arquitectura-a').removeClass('d-none');
            
            });

            $('.l-b-m-a').hover(function(){
            console.log("m");
            $('.b-plan').addClass('d-none');
            $('.b-mineria-a').removeClass('d-none');
            
            });

            //semestral

              $('.l-b-c').hover(function(){
            
            $('.b-plan').addClass('d-none');
            $('.b-construccion').removeClass('d-none');
            
            });

            $('.l-b-a').hover(function(){
            
            $('.b-plan').addClass('d-none');
            $('.b-arquitectura').removeClass('d-none');
            
            });

            $('.l-b-m').hover(function(){
            console.log("m");
            $('.b-plan').addClass('d-none');
            $('.b-mineria').removeClass('d-none');
            
            });

               $('.li-be-n').hover(function(){
            
            $('.b-plan').addClass('d-none');
            //console.log("estoy");
            
            });

            $('.ul-li-be-n').blur(function(){
            
            $('.b-plan').addClass('d-none');
            console.log("noestoy");
            
            });

            $(document).ready(function(){

              /*Cerrar promocion*/
              $('#close-promo').click(function(){
                $('#box-promo').fadeOut();
              });
              /*Cerrar promocion*/

              {{-- MENSAJE CON EXITO --}}
              @if(Session::has('msg'))
                  toastr.success('{{session('msg')}}', '¡Genial!', {timeOut: 4000});
              @php
                session()->forget('msg');
              @endphp
              @endif
              {{-- MENSAJE CON EXITO --}}
              

              {{-- MENSAJE ALERTA --}}
              @if(Session::has('alerta'))
                  toastr.warning('{{session('alerta')}}', '¡Advertencia!', {timeOut: 4000});
              @php
                session()->forget('alerta');
              @endphp
              @endif
              {{-- MENSAJE ALERTA --}}
              

              {{-- MENSAJE ERROR --}}
              @if(Session::has('msg-error'))
                  toastr.warning('{{session('msg-error')}}', '¡Error!', {timeOut: 4000});
              @php
                session()->forget('msg-error');
              @endphp
              @endif
              {{-- MENSAJE ERROR --}}

            });
          </script>
          
          
           {{-- <script src="{{ asset('/vendor/ckeditor/ckeditor.js') }}"></script> --}}
           <script src="{{asset('vendor/toastr/build/toastr.min.js')}}"></script>
           <script src="{{asset('js/helpers.js')}}"></script>
          
          
          @yield('script-extra')

    </div>  
  </body>
</html>
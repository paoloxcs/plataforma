<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Plataforna de Constuctivo, videos de capacitación, artículos técnicos">
    <meta name="author" content="Pull Creativo Comunicaciones">
    <title>@yield('titulo') | {{ config('app.name', 'Laravel')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/estilos.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('vendor/toastr/build/toastr.min.css')}}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

    <!-- Imagen - Favicon  -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/icono.png')}}" />

    {{-- <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet"> --}}
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130772048-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-130772048-1');
    </script>
</head>
  <body>


<div class="container">
    <div class="col-xs-12 col-md-6 col-lg-4 mx-auto mt-3">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">Cambio de contraseña</div>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{old('email',$email)}}" required autofocus placeholder="Correo electrónico">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <input id="password" type="password" class="form-control" name="password" required placeholder="Nueva contraseña">

                            @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="Confirmar contraseña">

                            @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                            @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-blue btn-block">
                            Cambiar contraseña
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<body>
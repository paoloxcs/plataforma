<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titulo','Principal') | SGA</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/style-adm.css')}}">
    <link rel="stylesheet" href="{{asset('css/style-custom.css')}}">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{asset('vendor/toastr/build/toastr.min.css')}}">

    <!-- font-awesome -->
    <link rel="stylesheet" href="{{asset('font-awesome/css/font-awesome.css')}}">

    <!--JQuery -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <!-- Sweetalert -->
   {{--  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    
    @yield('extra_style')
    
</head>
<body>
    <div class="spinnerx" id="spinnerx">
        <div class="spinnerx-content">
            <span class="spinner"></span>
        </div>
    </div>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/panel') }}">
                    <i class="fa fa-home" aria-hidden="true"></i> Inicio 
                    </a>
                    
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Contenido<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('rubros.index')}}">Categorización</a></li>
                                {{-- <li><a href="{{route('categoria.index')}}">Categorías</a></li>
                                <li><a href="{{route('subcate.index')}}">Sub Categorías</a></li> --}}
                                <li><a href="{{route('autores.index')}}">Autores</a></li>
                                <li><a href="{{route('video.index')}}">Videos</a></li>
                                <li><a href="{{route('serie.index')}}">Series</a></li>
                                <li><a href="{{route('articulos.index')}}">Artículos</a></li>
                                <li><a href="{{route('events.index')}}">Eventos</a></li>
                                <li><a href="{{route('cursos')}}">Cursos</a></li>
                                @if (!\Auth::guest()) 
                                 @if(Auth()->user()->isAdmin() or Auth()->user()->isContentManager())
                                 <li><a href="{{route('sponsors')}}">Patrocinadores</a></li>
                                 @endif
                                 @endif
                                 @if (!\Auth::guest()) 
                                 @if(Auth()->user()->isAdmin() or Auth()->user()->isContentManager())
                                 <li><a href="{{route('colaboradores')}}">Colaboradores</a></li>
                                 @endif
                                @endif
                                <li><a href="{{route('encuestas')}}">Encuestas</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-users"></i> Suscriptores<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('subscribers.free')}}">Gratis</a></li>
                                <li><a href="{{route('subscribers.premium')}}">Premium</a></li>
                                <li><a href="{{ route('subscribers.premium_uni') }}">Universidad</a></li>
                                <li><a href="{{route('subscribers.recurrente')}}">Recurrente</a></li>
                                <li><a href="{{route('subscribers.cursos')}}">Cursos</a></li>
                                {{-- PAGO EFECTIVO --}}
                                <li><a href="{{route('subscribers.pago_efectivo')}}">Pago Efectivo</a></li>
                                
                                {{-- PAGOS YAPE --}}
                                <li><a href="{{route('subscribers.pago_yape')}}">Pago Yape</a></li>
                                
                                <li><a href="{{route('certificado')}}">Certificados</a></li>
                                {{-- <li><a href="{{route('subscribers.culqi')}}">Pago en Linea</a></li> --}}
                            </ul>
                        </li>
                        <li>
                            <a href="{{route('clientes.index')}}">Clientes</a>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-cog"></i> Administrar<span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{route('roles.index')}}">Roles</a></li>
                                <li><a href="{{route('users.index')}}">Usuarios</a></li>
                                <li><a href="{{route('ejecutivos.index')}}">Ejecutivos</a></li>
                                <li><a href="{{route('planes.index')}}">Planes</a></li>
                                <li><a href="{{route('promos.index')}}">Promociones</a></li>
                                <li><a href="{{route('culqi.cargos')}}">Transacciones</a></li>
                            </ul>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{route('notifications.index')}}">Notificaciones <span class="badge">{{countNotifications_noreaded()}}</span></a>
                        </li>
                        <li>
                            <a href="{{url('/')}}"><i class="fa fa-arrow-left"></i> Vista suscriptor</a>
                        </li>

                        
                        <li class="dropdown">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-user"></i> 
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Salir
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        
        @yield('content')
        <div class="meta-app">
            <p><strong>&copy; {{config('app.name')}}</strong> | versión <strong>{{config('app.version')}}</strong> | Developed by: JoseG</p>
        </div>
    </div>
    
    <!-- Scripts -->
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('/vendor/ckeditor/ckeditor.js') }}"></script>
    <script src="{{asset('vendor/toastr/build/toastr.min.js')}}"></script>
    <script src="{{asset('js/helpers.js')}}"></script>
    @yield('extra_scripts')

</body>
</html>

<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta name="facebook-domain-verification" content="f10t4osjihncxk2jsrse49p7lm550n" />

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description"
        content="Plataforma virtual de enseñanza y aprendizaje en ingeniería y arquitectura que conecta a profesionales y estudiantes con la mejor enseñanza profesional.">
    <meta name="author" content="Pull Creativo Comunicaciones">
    <title>@yield('titulo') | {{ config('app.name', 'Laravel') }}</title>

    <!-- FONT AWESOME 5.15 -->
    <link rel="stylesheet" href="{{ asset('fontawesome-5.15.4-web/css/all.css') }}">
    {{-- CAMBIOS JHED --}}
    <link rel="stylesheet" href="{{ asset('css/responsive_estilos.css') }}">
    {{-- NAV NEW --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/style_nav.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('css/style_nav_v2.css') }}">
    {{-- CAMBIOS JHED --}}

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css" />


    <!-- FONT FAMILY -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,900;1,900&display=swap"
        rel="stylesheet">

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">



    <!-- Imagen - Favicon  -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/icono.png') }}" />

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-130772048-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-130772048-1');
    </script>
    <!-- Google Analytics -->
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('vendor/toastr/build/toastr.min.css') }}">
    {{-- ALPINE --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    {{-- SCRIPT POPUT FORM --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>


    <!-- Global site tag (gtag.js) - Google Ads: 986089827 -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-986089827"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'AW-986089827');
    </script>

    @yield('style-extra')

    <style>
        body {
            background-image: url("{{ asset('images/universidad/bg.png') }}") !important;
            background-position: center;
            background-size: cover;
        }
    </style>

    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':

                    new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],

                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =

                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);

        })(window, document, 'script', 'dataLayer', 'GTM-5F3CR76');
    </script>

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '685775116003655');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=685775116003655&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <style>
        .h-3 {
            height: 3.5rem;
        }

        .text-medium {
            font-size: 18px !important;
        }

        .s-footer a:hover {
            color: #aec3e1 !important;
        }

        @media (min-width: 992px) {
            .h-3 {
                height: 4.5rem;
            }

            .mr-md-4 {
                margin-right: 2rem;
            }
        }
    </style>
</head>

<body>
    <div class="col-12 pbm-0">
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5F3CR76" height="0" width="0"
                style="display:none;visibility:hidden"></iframe></noscript>

        {{-- MENU --}}

        <section
            class="w-full mx-auto px-4 py-6 sm:px-6 lg:px-8 flex items-center h-16 justify-content-center top-0 z-[200] px-md-5">

            {{-- Logo --}}
            <div class="shrink-0 flex items-center ml-0 ml-md-4">
                <a href="/">
                    <img src="{{ asset('images/universidad/plataforma.png') }}" alt="Plataforma" class="h-3">
                </a>
            </div>
            {{-- Search --}}

            <div class="ml-auto mr-0 mr-md-4">
                <ul class="nav nav-pills nav_access_btn">
                    {{-- CAMBIOS JHED --}}
                    <a href="/">
                        <img src="{{ asset('images/universidad/ucal.png') }}" class="img-fluid h-3">
                    </a>
                </ul>
            </div>
        </section>

        <!-- CONTENIDO -->
        <main class="m-none" role="main">
            @yield('content')

        </main>

        <!-- FOOTER -->
        <footer class="col-md-12 px-0 py-4" style="background: #253450 ">
            <div class="col-md-8 mx-auto row pb-0 s-footer">
                <section class="col-md-6 col-xs-12 py-0 text-center">
                    <span class="text-white text-medium">
                        Llámanos al <i class="fas fa-phone-alt color-n px-2"></i>
                        <a href="tel:981324180" class=" text-medium">981 324 180</a>
                    </span>
                </section>
                <section class="col-md-6 col-xs-12 py-0 text-center">
                    <span class="text-white text-medium">
                        Escríbenos a
                        <a href="mailto:info2@constructivo.com" class=" text-medium">info2@constructivo.com</a>
                    </span>
                </section>

                <p class="text-center pt-4">
                    © <?php echo date('Y'); ?> Plataforma Constructivo. Todos los derechos reservados.
                </p>
            </div>


        </footer>

        <!-- FOOTER -->

        <!-- Bootstrap core JavaScript =========================== -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js"
            integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous">
        </script>

        <script>
            $(document).ready(function() {

                /*Cerrar promocion*/
                $('#close-promo').click(function() {
                    $('#box-promo').fadeOut();
                });
                /*Cerrar promocion*/

                {{-- MENSAJE CON EXITO --}}
                @if (Session::has('msg'))
                    toastr.success('{{ session('msg') }}', '¡Genial!', {
                        timeOut: 4000
                    });
                    @php
                        session()->forget('msg');
                    @endphp
                @endif
                {{-- MENSAJE CON EXITO --}}


                {{-- MENSAJE ALERTA --}}
                @if (Session::has('alerta'))
                    toastr.warning('{{ session('alerta') }}', '¡Advertencia!', {
                        timeOut: 4000
                    });
                    @php
                        session()->forget('alerta');
                    @endphp
                @endif
                {{-- MENSAJE ALERTA --}}


                {{-- MENSAJE ERROR --}}
                @if (Session::has('msg-error'))
                    toastr.warning('{{ session('msg-error') }}', '¡Error!', {
                        timeOut: 4000
                    });
                    @php
                        session()->forget('msg-error');
                    @endphp
                @endif
                {{-- MENSAJE ERROR --}}

            });
        </script>

        {{-- <script src="{{ asset('/vendor/ckeditor/ckeditor.js') }}"></script> --}}
        <script src="{{ asset('vendor/toastr/build/toastr.min.js') }}"></script>
        <script src="{{ asset('js/helpers.js') }}"></script>

        @yield('script-extra')

    </div>
</body>

</html>

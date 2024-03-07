@extends('layouts.front')
@section('titulo')
    Empresas
@endsection
@section('style-extra')
    <style>
        .bg-\[\#F4F4F4\] {
            background-color: rgb(244, 244, 244, 1);
        }

        .gap-8 {
            gap: 2rem;
        }

        .grid-flow-col {
            grid-auto-flow: column;
        }

        .auto-cols-auto {
            grid-auto-columns: auto;
        }

        .w-\[300\%\] {
            width: 300%;
        }

        .gap-6 {
            gap: 1.5rem;
        }

        .gap-4 {
            gap: 1rem !important;
        }

        .gap-5 {
            gap: 1.25rem;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .items-center {
            align-items: center;
        }

        .flex-col {
            flex-direction: column;
        }

        .flex {
            display: flex;
        }

        .grid {
            display: grid;
        }

        .mt-8 {
            margin-top: 2rem;
        }

        .mr-6 {
            margin-right: 2rem;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .py-8 {
            padding-bottom: 2rem;
            padding-top: 2rem;
        }

        .container-responsive {
            margin-left: 1rem;
            margin-right: 1rem;
            max-width: 1200px;
        }

        .max-w-\[370px\] {
            max-width: 370px;
        }

        .max-w-\[725px\] {
            max-width: 725px;
        }

        .text-black {
            color: rgb(0, 0, 0, 1);
        }

        .font-bold {
            font-weight: 700;
        }

        .font-normal {
            font-weight: 400;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .text-sm {
            font-size: .875rem;
            line-height: 1.25rem;
        }

        .border-black {
            border-color: #24db37 !important
        }

        .border {
            border-width: 1px;
        }

        .w-0 {
            width: 0;
        }

        .h-\[90\%\] {
            height: 90%;
        }

        .h-fit {
            height: -webkit-fit-content;
            height: -moz-fit-content;
            height: fit-content;
        }

        .h-6 {
            height: 1.5rem;
        }

        .h-9 {
            height: 2.25rem;
        }

        .min-w-9 {
            min-width: 2.25rem !important;
        }

        .font-semibold {
            font-weight: 600;
        }

        .w-\[483px\] {
            width: 483px;
        }

        .h-\[322px\] {
            height: 322px;
        }

        .hidden {
            display: none;
        }

        .min-w-\[288px\] {
            min-width: 288px;
        }

        .w-\[288px\] {
            width: 288px;
        }

        .min-w-\[220px\] {
            min-width: 220px;
        }

        .w-\[220px\] {
            width: 220px;
        }

        .min-w-\[188px\] {
            min-width: 188px;
        }

        .min-h-\[188px\] {
            min-height: 188px;
        }

        .w-\[188px\] {
            width: 188px;
        }

        .h-\[188px\] {
            height: 188px;
        }

        .lh-13 {
            line-height: 1.05rem !important;
        }

        .w-full {
            width: 100%;
        }

        .pb-\[100\%\] {
            padding-bottom: 100%;
        }

        .transition-all {
            transition-duration: .15s;
            transition-property: all;
            transition-timing-function: cubic-bezier(.4, 0, .2, 1);
        }

        .object-right {
            -o-object-position: right;
            object-position: right;
        }

        .object-cover {
            -o-object-fit: cover;
            object-fit: cover;
        }

        .rounded-md {
            border-radius: 0.375rem;
        }

        .h-full {
            height: 100%;
        }

        .left-0 {
            left: 0;
        }

        .top-0 {
            top: 0;
        }

        .inline-block {
            display: inline-block;
        }

        .icon-user-p span i {
            background: #24db37;
            color: #fff;
            padding: 8px;
            border-radius: 50%;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .shadow {
            --tw-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);
            box-shadow: var(--tw-ring-offset-shadow, 0 0 #0000), var(--tw-ring-shadow, 0 0 #0000), var(--tw-shadow);
        }

        .text-green-400 {
            color: #198754;
        }

        .text-green {
            color: #24db37;
        }

        .border-button {
            border: 2px solid #24db37;
        }

        .mr-3 {
            margin-right: 0.75rem;
        }

        .ml-3 {
            margin-left: 0.75rem;
        }

        .-mr-3 {
            margin-right: -0.75rem;
        }

        .-ml-3 {
            margin-left: -0.75rem;
        }

        /* ANIMATED */
        .animate-grid {
            /* animation: grid-translate 40s linear infinite normal; */
            animation: 35s grid-translate infinite linear;
        }

        .animated-pause:hover {
            animation-play-state: paused
        }

        .div-track {
            perspective: 100px;
        }

        .article-track {
            transition: transform .5s;
        }

        .article-track:hover {
            transform: translateZ(5px);
        }

        .slick-business .article-track {
            margin: 0 15px;
        }

        .slick-arquitectura-y-diseno .div-track,
        .slick-construccion .div-track,
        .slick-mineria .div-track {
            margin: 0 5px;
        }

        .text-base {
            font-size: .85rem;
            line-height: 1.5rem;
        }

        .carrusel-rubro .slick-next,
        .carrusel-rubro .slick-prev,
        .carrusel-rubro .slick-next:hover,
        .carrusel-rubro .slick-prev:hover {
            background-color: #fff !important;
        }

        .carrusel-business .slick-next,
        .carrusel-business .slick-prev,
        .carrusel-business .slick-next:hover,
        .carrusel-business .slick-prev:hover {
            background-color: #fff !important;
        }

        .carrusel-rubro .slick-prev:before,
        .carrusel-rubro .slick-next:before {
            font-weight: 800;
            font-size: 35px;
        }

        .carrusel-business .slick-prev:before,
        .carrusel-business .slick-next:before {
            font-weight: 800;
            font-size: 35px;
        }

        .carrusel-rubro .slick-next:before,
        .carrusel-business .slick-next:before {
            content: "\f054";
            color: #24db37;
            font-family: "Font Awesome 5 Free";
            /* font-weight: 300 */
        }

        .carrusel-rubro .slick-prev:before,
        .carrusel-business .slick-prev:before {
            content: "\f053";
            color: #24db37;
            font-family: "Font Awesome 5 Free";
            /* font-weight: 300; */
        }

        .slick-prev {
            left: 0px;
        }

        .slick-next {
            right: -5px;
        }

        @keyframes grid-translate-lg {
            0% {
                transform: translateX(5%);
            }

            100% {
                transform: translateX(-125%);
            }
        }

        @keyframes grid-translate-md {
            0% {
                transform: translateX(5%);
            }

            100% {
                transform: translateX(-125%);
            }
        }

        @keyframes grid-translate {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(calc(-250px * 6));
            }
        }

        @media (min-width: 768px) {

            /* ANIMATED */
            .animate-grid-md {
                -webkit-animation: grid-translate-md 40s linear infinite normal;
                animation: grid-translate-md 40s linear infinite normal;
            }

            .md\:w-\[250\%\] {
                width: 250%;
            }

            .md\:w-\[75\%\] {
                width: 75%;
            }

            .slick-arquitectura-y-diseno .div-track,
            .slick-construccion .div-track,
            .slick-mineria .div-track {
                margin: 0 7px;
            }

            .md\:lh-16 {
                line-height: 1.35rem !important;
            }
        }

        @media (min-width: 992px) {


            .md\:min-w-\[288px\] {
                min-width: 288px;
            }

            .md\:w-\[288px\] {
                width: 288px;
            }

            .md\:min-w-\[280px\] {
                min-width: 280px;
            }

            .md\:w-\[280px\] {
                width: 280px;
            }

            .md\:min-w-\[265px\] {
                min-width: 265px;
            }

            .md\:w-\[265px\] {
                width: 265px;
            }

            .md\:min-w-\[188px\] {
                min-width: 188px;
            }

            .md\:w-\[188px\] {
                width: 188px;
            }
        }


        @media (min-width: 1150px) {

            /* ANIMATED */
            .animate-grid-lg {
                -webkit-animation: grid-translate-lg 60s linear infinite normal;
                animation: grid-translate-lg 60s linear infinite normal;
            }

            .lg\:w-\[125\%\] {
                width: 125%;
            }

            .lg\:w-\[75\%\] {
                width: 75%;
            }

            .lg\:h-9 {
                height: 2.25rem;
            }

            .lg\:min-w-9 {
                min-width: 2.25rem !important;
            }

            .lg\:gap-20 {
                gap: 5rem;
            }

            .lg\:gap-6 {
                gap: 1.5rem !important;
            }

            .lg\:py-16 {
                padding-bottom: 4rem;
                padding-top: 4rem;
            }

            .lg\:grid-cols-3 {
                grid-template-columns: repeat(3, minmax(0, 1fr));
            }

            .lg\:mt-16 {
                margin-top: 4rem;
            }

            .lg\:w-\[370px\] {
                width: 370px;
            }

            .lg\:text-xl {
                font-size: 1.25rem;
                line-height: 1.75rem;
            }

            .lg\:text-lg {
                font-size: 1.125rem;
                line-height: 1.75rem;
            }

            .lg\:text-base {
                font-size: 1rem;
                line-height: 1.5rem;
            }
        }

        @media (min-width: 1200px) {
            .container-responsive {
                margin-left: auto;
                margin-right: auto;
                max-width: 1150px;
            }
        }

        @media (min-width: 1500px) {
            .container-responsive {
                max-width: 1400px;
            }
        }
    </style>
@endsection
@section('content')
    {{-- BANNER --}}
    <section class="col-md-12 resp-banner-emp banner-pri banner-empresa flex">
        <section class="col-md-8 col-xs-10 row mx-auto col-empresa align-items-center">
            <section class="col-md-6 col-xs-12 mt-5 col-xs-11">
                <h1 class="font-weight">Capacita a tu equipo <span class="c-green font-weight">hoy mismo</span></h1>
                <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Obtén acceso ilimitado para tus
                    colaboradores
                    a vídeos de capacitaciones en construcción, arquitectura y minería, dictados por profesionales del
                    sector.</p>

                <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Acceso y/o descarga de cientos de revistas
                    especializadas en construcción, arquitectura y minería.</p>

                <p class="c-white"> <i class="fas fa-check c-green"></i> &nbsp; Descuentos en seminarios y cursos online en
                    vivo para tus colaboradores con certificación, organizados por nosotros.</p>
            </section>

            <section class="col-md-6 col-xs-12 col-xs-12" id="banner-empre">
                <form class="form-suple form-empresa mt-4" action="{{ route('empresasuscrip') }}" method="POST"
                    enctype="multipart/form-data">

                    {{ csrf_field() }}

                    <div class="mb-3">

                        <input type="text" class="form-control" name="nombre" placeholder="Nombre y Apellidos">
                    </div>
                    <div class="mb-3">

                        <input type="email" class="form-control" name="email" placeholder="E-mail">
                    </div>

                    <div class="mb-3">

                        <input type="text" class="form-control" name="telefono"
                            placeholder="Celular (de preferencia con WhatsApp) ">
                    </div>

                    <div class="mb-3">

                        <input type="text" class="form-control" name="empresa" placeholder="Empresa ">
                    </div>

                    {{-- <div class="mb-3">
                        <select class="form-select form-select-sm select-suple mt-4 form-control select-empresa-g"
                            aria-label=".form-select-sm example">
                            <option value="1">Construcción</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>
                    </div> --}}

                    <div class="mb-3">
                        <div class="col-md-12 row">
                            <div class="col-md-9 mt-1">
                                <p class="">Número de personas (mínimo 5) </p>
                            </div>
                            <div class="col-md-3">
                                <input type="number" class="form-control" name="nro_personas" min="5" required=""
                                    value="5" placeholder="5" style="color:black">
                            </div>



                        </div>

                    </div>

                    <div class="">
                        <textarea class="form-control" placeholder="¿Qué objetivos tiene tu equipo?" name="objetivos" style="color:black"></textarea>
                    </div>
                    <div class="mt-3">

                        <p class="text-center"><button class="a-menu a-menu-b" type="submit"
                                style="text-decoration: none">EMPEZAR</button></p>

                    </div>
                </form>
            </section>
        </section>
    </section>

    {{-- CAPACITAR A TU EMPRESA --}}
    <div class="bg-white">
        <div class="container-responsive py-8 lg:py-16 flex flex-col">
            <h2 class="text-center text-black font-bold lg:text-[32px] text-[24px]">¿Por qué capacitar a tu empresa?</h2>
            <p class="text-center text-black font-normal text-base lg:text-lg mt-6"> Mejorar la productividad de tu equipo
                es uno de los principales objetivos</p>
            <div class="mt-4 lg:mt-16 d-grid lg:grid-cols-3 mx-auto justify-between gap-8 lg:gap-20">
                <div class="d-flex flex-col justify-content-center align-items-center gap-6 lg:w-[370px] max-w-[370px]">
                    <img class="w-50" src="{{ asset('images/empresas/icon-1.png') }}" alt="">
                    <h3 class="text-lg lg:text-xl font-bold text-black text-center">INCREMENTO DE HABILIDADES</h3>
                    <p class="text-sm lg:text-base font-normal text-black text-center"> Aprender nuevas herramientas y
                        metodologías y conocer nuestros avances amplían el panorama del profesional para afrontar nuevos
                        desafíos </p>
                </div>
                <div class="d-flex flex-col justify-content-center align-items-center gap-6 lg:w-[370px] max-w-[370px]">
                    <img class="w-50" src="{{ asset('images/empresas/icon-2.png') }}" alt="">
                    <h3 class="text-lg lg:text-xl font-bold text-black text-center">EXPERIENCIA PROFESIONAL</h3>
                    <p class="text-sm lg:text-base font-normal text-black text-center"> Recoger información de diferentes
                        fuentes le permite al profesional tener diversas perspectivas para llegar a la solución de los
                        problemas </p>
                </div>
                <div class="d-flex flex-col justify-content-center align-items-center gap-6 lg:w-[370px] max-w-[370px]">
                    <img class="w-50" src="{{ asset('images/empresas/icon-3.png') }}" alt="">
                    <h3 class="text-lg lg:text-xl font-bold text-black text-center">MUNDO TECNOLÓGICO</h3>
                    <p class="text-sm lg:text-base font-normal text-black text-center"> La industria de la construcción se
                        renueva cada año, por ello se tiene que estar en la misma sintonía para poder competir, rendir y
                        producir </p>
                </div>
            </div>
        </div>
    </div>

    {{-- BENEFICIOS --}}
    <div class="bg-white">
        <div class="container-responsive py-8 lg:py-16 flex flex-col">
            <h2 class="text-center text-black font-bold lg:text-[32px] text-[24px]">
                <span class="c-green">Beneficios</span> exclusivos para su empresa
            </h2>
            <p class="text-center text-black font-normal text-base lg:text-lg mt-6">
                Desarrolle el talento de su empresa con nuestros videos de capacitación, cursos, medios especializados y
                <br>
                artículos técnicos para incrementar el desempeño de su equipo día a día:
            </p>
            <div class="mt-8 lg:mt-16 grid lg:grid-cols-3 mx-auto justify-between gap-8 lg:gap-20">
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Capacita a tu equipo en temas específicos
                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Ponemos a su disposición nuestra plataforma para hacer sesiones de aprendizaje en vivo.
                            Capacitaciones con nuestros profesores sobre un tema especializado de su interés.
                        </p>
                    </div>
                </div>
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Beneficio de aprendizaje exclusivo
                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Podrá acceder a un curso especializado Premium, (incluye los materiales y certificado) lo tendrá
                            que completar durante el mes que escogió el curso.
                        </p>
                    </div>
                </div>
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Disfruta del contenido descargable
                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Accede y/o descarga más de 100 revistas especializadas en arquitectura, construcción y minería.
                        </p>
                    </div>
                </div>
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Videos de Capacitación
                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Obtén acceso ilimitado a vídeos de capacitaciones dictados por profesionales del sector.
                        </p>
                    </div>
                </div>
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Descuentos exclusivos para suscriptores:
                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Descuentos en seminarios, talleres y cursos organizados por nosotros.
                        </p>
                    </div>
                </div>
                <div class="flex text-black justify-center h-fit gap-6 lg:w-[370px] max-w-[370px]">
                    <div class="flex flex-col gap-5 items-center justify-center">
                        <img class="h-9 min-w-9 img-fluid" src="{{ asset('images/empresas/icon-benef.png') }}"
                            alt="">
                        <div class="border border-black h-[90%] w-0"></div>
                    </div>
                    <div class="flex flex-col gap-4 -mt-[6px]">
                        <h3 class="font-semibold text-lg lg:text-xl">
                            Artículos actualizados


                        </h3>
                        <p class="font-normal text-sm lg:text-base">
                            Decenas de artículos técnicos especializados en nuestra biblioteca exclusiva para ti.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- CONOCE --}}
    <div class="bg-white">
        <div class="container-responsive py-8 lg:py-8 flex flex-col">
            <h2 class="text-center text-black font-bold lg:text-[32px] text-[24px]">
                Con Plataforma Constructivo obtén los mejores beneficios
            </h2>
            <p class="text-center text-black font-normal text-base lg:text-lg mt-6">
                Gracias a nuestra plataforma en constante actualización, disfruta de diversas novedades y disfruta de lo
                siguiente:
            </p>
            <div class="flex mt-4 lg:mt-16 items-center gap-16 mx-auto">
                <img class="w-[483px] h-[322px] hidden lg:block mr-6"
                    src="{{ asset('images/empresa-beneficio.jpg') }}" />
                <div class="flex flex-col gap-4 lg:gap-6 max-w-[725px]">
                    <div class="flex flex-col gap-1 text-sm lg:text-lg font-normal text-black">
                        {{-- <p>Detalles del plan:</p> --}}
                        <div class="flex gap-4">
                            <i class="fas fa-check c-green"></i>
                            <p>
                                Acceso ilimitado a vídeos de capacitaciones en <span class="font-semibold">construcción,
                                    arquitectura y minería.</span>
                            </p>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-check c-green"></i>
                            <p>
                                Acceso y/o descarga de cientos de revistas especializadas en construcción, arquitectura y
                                minería.
                            </p>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-check c-green"></i>
                            <p>
                                Descuentos en seminarios y cursos online en vivo con certificación, organizados por
                                nosotros.
                            </p>
                        </div>
                        <div class="flex gap-4">
                            <i class="fas fa-check c-green"></i>
                            <p>
                                Decenas de artículos técnicos especializados en nuestra biblioteca.
                            </p>
                        </div>
                        <div class="flex gap-4 justify-center">
                            <p class="mt-4 text-center-mob text-center">
                                <a class="a-menu a-menu-b px-4 py-2" href="#banner-empre" style="text-decoration: none;">
                                    CAPACITA A TU EMPRESA
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ¿QUÉ TE GUSTARÍA APRENDER? --}}
    <section class="bg-white">
        <section class="col-md-10 mx-auto mt-5 s-clase-nav s-suplemento-nav py-4">
            <h2 class="text-center text-black font-bold lg:text-[32px] text-[24px]">
                ¿Qué te gustaría Aprender?
            </h2>
            <p class="text-center text-black font-normal text-base lg:text-lg mt-6">
                Aprende a tu ritmo, disfruta de todo el contenido que ofrece Plataforma Constructivo y
                lleva la información a donde desees
            </p>

            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                @foreach ($rubros as $rubro)
                    @if ($loop->iteration == 1)
                        <div class="none">{{ $active = 'active' }}</div>
                    @else
                        <div class="none">{{ $active = '' }}</div>
                    @endif
                    <li class="nav-item " role="presentation">
                        <button class="{{ 'nav-link ' . $active }}" style="text-transform: uppercase;"
                            id="{{ $rubro->slug . '-tab' }}" data-bs-toggle="tab"
                            data-bs-target="{{ '#' . $rubro->slug }}" type="button" role="tab"
                            aria-controls="{{ $rubro->slug }}" aria-selected="false"
                            onclick="sliderRubro{{ $rubro->idrubro }}()">
                            <span class="font-bold"> {{ $rubro->nombrerubro }}</span>
                        </button>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content  mt-3 pb-3" id="myTabContent">
                {{-- SLIDER RUBRO --}}
                @foreach ($rubros as $rubro)
                    @if ($loop->iteration == 1)
                        <div class="none">{{ $active = 'active' }}</div>
                    @else
                        <div class="none">{{ $active = '' }}</div>
                    @endif
                    <div class="{{ 'tab-pane fade show ' . $active }}" id="{{ $rubro->slug }}" role="tabpanel"
                        aria-labelledby="{{ $rubro->slug . '-tab' }}">
                        <div class="swiper">
                            <div class="slide-content-{{ $rubro->slug }}">
                                <div class="card-wrapper swiper-wrapper ">
                                    @foreach ($rubro->videos(6) as $post)
                                        <div class="div-track swiper-slide">
                                            <div class="w-full md:min-w-[265px] md:w-[265px] article-track">
                                                <div class="relative w-full h-0 overflow-hidden pb-[120%] rounded-lg">
                                                    <a href="{{ route('getvideo', $post->pslug) }}">
                                                        <div class="block overflow-hidden absolute inset-0 m-0">
                                                            <img src="{{ asset('posts/' . $post->image) }}"
                                                                alt="{{ $post->titulo }}" title="{{ $post->titulo }}"
                                                                class="w-full rounded-md h-full object-cover object-right absolute top-0 left-0 transition-all"
                                                                style="background-position: 0% 0%;">
                                                        </div>
                                                    </a>
                                                </div>
                                                <div class="mt-2">
                                                    <h2 class="p-rubro inline-block text-uppercase"
                                                        title=" {{ $rubro->nombrerubro }}">
                                                        {{ $rubro->nombrerubro }}
                                                    </h2>
                                                    <a href="{{ route('getvideo', $post->pslug) }}"
                                                        style="text-decoration: none;">
                                                        <h2 class="text-base font-semibold lg:text-base text-black lh-13 md:lh-16"
                                                            title=" {{ $post->titulo }}">
                                                            {{ $post->titulo }}
                                                        </h2>
                                                    </a>
                                                    <a href="{{ route('getAutor', $post->auslug) }}" class="td-none">
                                                        <p class="icon-user-p text-base lg:text-lg">
                                                            <span class="mr-3">
                                                                <i class="fas fa-user-tie"></i>
                                                            </span>{{ $post->nombreautor }}
                                                        </p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="flex w-100 justify-center pt-4">
                                <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                                    <button
                                        class="swiper-btn-prev bg-white -ml-3 flex justify-center items-center w-10 h-10 rounded-full shadow text-green-400 rounded-full">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>

                                <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                                    <button
                                        class="swiper-btn-next bg-white -mr-3 flex justify-center items-center w-10 h-10 rounded-full shadow text-green-400 rounded-full">
                                        <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6">
                                            <path fill-rule="evenodd"
                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </section>

    {{-- TESTIMONIO --}}

    @include('components.testimonio', [
        'fondo' => false,
    ])

    {{-- SWIPER EMPRESA --}}
    {{-- <section class="col-md-12 row pbm-0 mt-5 mx-auto s-e-p">
        <h4 class="text-center font-weight">QUIENES <span class="c-green">CONFIARON</span> EN NOSOTROS</h4>
        @include('web.swiper-empresas')
    </section> --}}

    {{-- SWIPER EMPRESA --}}
    <div class="bg-white">
        <div class="container py-8 lg:py-16 flex flex-col">
            <h2 class="text-center text-black font-bold lg:text-[32px] text-[24px]">
                QUIENES <span class="c-green">CONFIARON</span> EN NOSOTROS
            </h2>

            {{-- SLIDER colaborador --}}
            <div class="relative mt-16">

                <div class="swiper">
                    <div class="slide-content-colaborador">
                        <div class="card-wrapper swiper-wrapper">
                            @foreach ($colaboradores as $colaborador)
                                <div class="div-track swiper-slide">
                                    <div
                                        class="flex flex-col justify-center items-center article-track min-h-[188px] h-[188px]">
                                        <article
                                            class="rounded-md font-medium w-full md:min-w-[188px] md:w-[188px] transition-all ">
                                            <div class="relative w-full h-0 pb-0 rounded-md">
                                                <img src="{{ asset('imgColaboradores/' . $colaborador->url_logo) }}"
                                                    alt="{{ $colaborador->nombre }}" title="{{ $colaborador->nombre }}"
                                                    class="w-full rounded-md h-full object-cover object-right absolute top-0 left-0 transition-all">
                                            </div>
                                        </article>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                        <div class="swiper-pagination-colaborador"></div>
                    </div>
                </div>

                {{-- <div class="slick-business carrusel-business px-4">
                    @foreach ($colaboradores as $colaborador)
                        <div class="div-track">
                            <div class="flex flex-col justify-center items-center article-track min-h-[188px] h-[188px]">
                                <article class="rounded-md font-medium min-w-[188px] w-[188px] transition-all ">
                                    <div class="relative w-full h-0 pb-0 rounded-md">
                                        <img src="{{ asset('imgColaboradores/' . $colaborador->url_logo) }}"
                                            alt="{{ $colaborador->nombre }}" title="{{ $colaborador->nombre }}"
                                            class="w-full rounded-md h-full object-cover object-right absolute top-0 left-0 transition-all">
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endforeach
                </div> --}}
            </div>
        </div>
    </div>
@endsection
@section('script-extra')
    <script>
        $(document).ready(function() {
            // SLIDER colaborador
            var swiper_colaborador = new Swiper(".slide-content-colaborador", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                centerSlide: 'true',
                // fade: 'true',
                grabCursor: 'true',
                // pagination: {
                //   el: ".swiper-pagination-colaborador",
                //   clickable: true,
                //   dynamicBullets: true,
                // },
                // navigation: {
                //   nextEl: ".swiper-button-next",
                //   prevEl: ".swiper-button-prev",
                // },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 5,
                        spaceBetween: 16,
                    },
                    1280: {
                        slidesPerView: 6,
                        spaceBetween: 16,
                    },
                },
            });

            slider1()
        })

        function sliderRubro1() {
            setTimeout(() => {
                slider1()
            }, 400);
        }

        function sliderRubro2() {
            setTimeout(() => {
                slider2()
            }, 400);
        }

        function sliderRubro3() {
            setTimeout(() => {
                slider3()
            }, 400);
        }
        // SLIDER RUBRO
        function slider1() {
            var swiper_arquitectura_y_diseno = new Swiper(".slide-content-arquitectura-y-diseno", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                grabCursor: 'true',
                // pagination: {
                //   el: ".swiper-pagination-colaborador",
                //   clickable: true,
                //   dynamicBullets: true,
                // },
                navigation: {
                    nextEl: ".swiper-btn-next",
                    prevEl: ".swiper-btn-prev",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                },
            });
        }

        function slider2() {
            var swiper_construccion = new Swiper(".slide-content-construccion", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                grabCursor: 'true',
                // pagination: {
                //   el: ".swiper-pagination-colaborador",
                //   clickable: true,
                //   dynamicBullets: true,
                // },
                navigation: {
                    nextEl: ".swiper-btn-next",
                    prevEl: ".swiper-btn-prev",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 16,
                    },
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                },
            });
        }

        function slider3() {
            var swiper_mineria = new Swiper(".slide-content-mineria", {
                slidesPerView: 1,
                spaceBetween: 0,
                loop: true,
                grabCursor: 'true',
                // pagination: {
                //   el: ".swiper-pagination-colaborador",
                //   clickable: true,
                //   dynamicBullets: true,
                // },
                navigation: {
                    nextEl: ".swiper-btn-next",
                    prevEl: ".swiper-btn-prev",
                },
                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1,
                        spaceBetween: 0,
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 8,
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 8,
                    },
                    1024: {
                        slidesPerView: 3,
                        spaceBetween: 16,
                    },
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 16,
                    },
                },
            });
        }
    </script>

    <script>
        // var swiper1 = new Swiper('#swiper1', {
        //     slidesPerView: window.innerWidth <= 900 ? 1 : 4,
        //     autoplay: {
        //         delay: 2500,
        //         disableOnInteraction: false,
        //     },

        //     loop: true,
        //     loopFillGroupWithBlank: true,
        //     navigation: {
        //         nextEl: '#swiper-button-next1',
        //         prevEl: '#swiper-button-prev1',
        //     },
        // });

        function getDirection() {
            var windowWidth = window.innerWidth;
            var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

            return direction;
        }
    </script>
@endsection

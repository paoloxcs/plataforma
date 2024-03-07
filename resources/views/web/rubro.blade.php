@extends('layouts.front')
@section('titulo', $rubro->nombrerubro)
@section('style-extra')
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}">
@endsection
@section('content')
    <section class="col-md-12 row pbm-0 s-rubro-b">
        <section class="col-md-10 mx-auto pbm-0">
            <div id="carouselExampleCaptions" class="carousel slide mt-5 mt-0-mob" data-bs-ride="carousel">
                <div class="carousel-indicators">
                    @foreach ($sliders as $slide)
                        @if ($loop->iteration == 1)
                            <div class="none">{{ $active = 'active' }}</div>
                        @else
                            <div class="none">{{ $active = '' }}</div>
                        @endif
                        <button type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide-to="{{ $loop->iteration - 1 }}" class="{{ $active }}" aria-current="true"
                            aria-label="{{ 'Slide ' . $loop->iteration }}"></button>
                    @endforeach

                </div>

                <div class="carousel-inner">
                    @foreach ($sliders as $slide)
                        @if ($loop->iteration == 1)
                            <div class="none">{{ $active = 'active' }}</div>
                        @else
                            <div class="none">{{ $active = 'e' }}</div>
                        @endif
                        <div class="{{ 'carousel-item c-item ' . $active }}">
                            <a href="{{ $slide->url }}">

                                <img src="{{ asset('imgRubro/' . $slide->img_desktop) }}" class=" w-100 none-mobile"
                                    alt="">
                                <img src="{{ asset('imgRubro/' . $slide->img_phone) }}" class=" w-100 none-desktop"
                                    alt="...">

                            </a> 
                        </div>
                    @endforeach
                </div>
            </div>

            <h2 class="mt-5 c-white font-weight padding-1 text-center-mob">¡Alcanza tus metas profesionales!</h2>
            <p class="c-white padding-1 text-center-mob p-rubro-text">Accede a nuestra plataforma diseñada para llevar tu
                conocimiento al siguiente nivel y disfruta de todo el contenido de Plataforma Constructivo.</p>

            <section class="col-md-12 row pbm-0 mt-5"> 
                @include('web.swiper-contenido') 
            </section>
        </section>

    </section>
    {{-- UP Swiper Contenido --}} 
    <section class="container mt-3">
        <section class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2 pb-3 {{ $class }}">
            <div class="mt-5 mt-5-mob text  padding-1">
                <h1 class="mt-5 mt-0-mob text-center-mob font-weight-mob">Capacítate en {{ $rubro->nombrerubro }}</h1>
                <p class=" text-center-mob">Gracias a nuestro amplio catálogo de cursos y videos interactivos, podrás ser
                    un profesional en crecimiento el cual podrá disfrutar además de diversos beneficios exclusivos, los
                    cuales mencionaremos a continuación: </p>
                <p class="mt-4"></p>
                @if ($rubro->slug == 'arquitectura-y-diseno')
                    <a href="{{ route('serieRubro', $rubro->slug) }}" class="td-none">
                        <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight c-green">SERIES
                                DE ARQUITECTURA Y DISEÑO: </span>Amplie su conocimiento con los mejores profesionales de
                            arquitectura y diseño.</p>
                    </a>
                @endif
                <a href="{{ route('getcursosP', $rubro->slug) }}" class="td-none">
                    <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight  c-green">CURSOS
                            DISPONIBLES: </span>Certifícate con los cursos especializados disponibles que tenemos para ti.
                    </p>
                </a>

                <a href="{{ route('videoRubro', $rubro->slug) }}" class="td-none">
                    <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight c-green">VIDEOS DE
                            CAPACITACIÓN: </span>Estás a un clic de aprender algo nuevo. Encuentra aquí nuestros vídeos de
                        capacitación.</p>
                </a>

                <a href="{{ route('revistas', $medio) }}" class="td-none">
                    <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight c-green">REVISTAS
                            DIGITALES: </span>Ten acceso a TODAS las ediciones de las revistas especializadas más
                        importantes del país.</p>
                </a>

                <a href="{{ route('articuloRubro', $rubro->slug) }}" class="td-none">
                    <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight c-green">ARTÍCULOS
                            TÉCNICOS: </span> Lee decenas de artículos técnicos en nuestra biblioteca exclusiva para ti.</p>
                </a>

                {{-- <a href="" class="td-none"></a><p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight">PRÓXIMOS EVENTOS:</span>Obtenga grandes beneficios y acceso a promociones al suscribirse a la plataforma.</p></a> --}}


                @if ($rubro->slug == 'construccion')
                    <a href="{{ route('suplementos') }}" class="td-none">
                        <p class="p-check"><i class="fas fa-check check-b"></i> <span class="font-weight c-green">SUPLEMENTO
                                TÉCNICO: </span>En la revista Constructivo editamos
                            desde hace más de 24 años el suplemento técnico del sector construcción.</p>
                    </a>
                @endif



            </div>
            {{-- CAMBIOS JHED --}}
            {{-- <section class="col-md-6 mt-5 web-beneficio none-mobile"> --}}
            <div class="px-4 py-4 hidden md:flex items-center justify-center">
                <img class="w-full sm:w-1/2 lg:w-full object-cover object-center"
                    src="{{ asset('imgRubro/' . $rubro->img_beneficio) }}">
            </div>
            {{-- </section> --}}
            {{-- CAMBIOS JHED --}}
        </section>

    </section>
    <section class="col-md-12 ">
        <section class="bg-white col-md-10 mx-auto">


            <section class="col-md-12 mx-auto mt-5 s-clase-nav s-suplemento-nav ">
                <h5 class="font-weight text-center tt-uppercase">SOBRE {{ $rubro->nombrerubro }}</h5> 
                <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">


                    @if ($rubro->slug == 'arquitectura-y-diseno')
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" style="text-transform: uppercase;" id="seriesid-tab"
                                data-bs-toggle="tab" data-bs-target="#seriesid" type="button" role="tab"
                                aria-controls="seriesid" aria-selected="false">SERIES</button>
                        </li>
                        <div class="none">{{ $activeR = '' }}</div>
                        <div class="none">{{ $activeR1 = '' }}</div>
                    @else
                        <div class="none">{{ $activeR = 'active' }}</div>
                        <div class="none">{{ $activeR1 = 'show active' }}</div>
                    @endif


                    <li class="nav-item " role="presentation">
                        <button class="nav-link {{ $activeR }}" style="text-transform: uppercase;" id="videosid-tab"
                            data-bs-toggle="tab" data-bs-target="#videosid" type="button" role="tab"
                            aria-controls="videosid" aria-selected="false">VIDEOS</button>
                    </li>


                    <li class="nav-item" role="presentation">
                        <button class="nav-link" style="text-transform: uppercase;" id="cursosid-tab"
                            data-bs-toggle="tab" data-bs-target="#cursosid" type="button" role="tab"
                            aria-controls="cursosid" aria-selected="false">CURSOS</button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" style="text-transform: uppercase;" id="articulosid-tab"
                            data-bs-toggle="tab" data-bs-target="#articulosid" type="button" role="tab"
                            aria-controls="articulosid" aria-selected="false">ARTÍCULOS</button>
                    </li>



                </ul>

                <div class="tab-content mt-5-mob" id="myTabContent">


                    @if ($rubro->slug == 'arquitectura-y-diseno')
                        <div class="tab-pane fade show active" id="seriesid" role="tabpanel"
                            aria-labelledby="seriesid-tab"> 

                            {{-- SWIPER SVCA --}}
                            <div class="swiper">
                                <div class="mt-4 mb-4">
                                    <div class="slide-content-rubro">
                                        <div class="card-wrapper swiper-wrapper">
                                            @foreach ($series as $post)
                                                <div class="card card-curso-p padding-1 swiper-slide"
                                                    style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125);">
                                                    <div class="img ">
                                                        <a href="{{ route('getserie', $post->pslug) }}">
                                                            <img src="{{ asset('posts/' . $post->image) }}"
                                                                width="100%" class="carad-img">
                                                        </a>
                                                    </div>

                                                    <div class="card-body pb-0" style="align-items: start">
                                                        <a href="{{ route('getserie', $post->pslug) }}" class="td-none">
                                                            <h4 class="title font-weight leading-6">{{ $post->titulo }}
                                                            </h4>
                                                        </a>
                                                        <a href="{{ route('getAutor', $post->autor->slug) }}"
                                                            class="td-none">
                                                            <p class=" icon-user-p"><span><i
                                                                        class="fas fa-user-tie"></i></span>
                                                                &nbsp;{{ $post->autor->nombre }}</p>
                                                        </a>

                                                        <div class="flex">
                                                            <p class="p-inline p-c-i"><i class="fas fa-user"></i>
                                                                {{ $post->CountVistas() }}</p>
                                                            <p class="p-inline p-c-i p-m-l"><i
                                                                    class="fas fa-thumbs-up "></i>
                                                                {{ $post->CountValoracion() }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-white text-center bt-0">
                                                        <p class="text-center-mob" style=""><a
                                                                href="{{ route('getserie', $post->pslug) }}"
                                                                class="a-transparent-g">VER SERIE</a></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                                            <div class="swiper-pagination-autor"></div>
                                        </div>
                                    </div>

                                    <div class="flex w-100 justify-center">
                                        <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                                            <button
                                                class="swiper-btn_rubro-prev bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-left w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                                            <button
                                                class="swiper-btn_rubro-next bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-right w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="tab-pane fade {{ $activeR1 }}" id="videosid" role="tabpanel"
                        aria-labelledby="videosid-tab">

                        @if ($videos->count() > 0) 

                            {{-- SWIPER SVCA --}}
                            <div class="swiper">
                                <div class="mt-4 mb-4">
                                    <div class="slide-content-rubro">
                                        <div class="card-wrapper swiper-wrapper">
                                            @foreach ($videos as $post)
                                                <div class="card card-curso-p card-curso padding-1 swiper-slide"
                                                    style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125);">
                                                    <div class="img ">
                                                        <a href="{{ route('getvideo', $post->pslug) }}">
                                                            <img src="{{ asset('posts/' . $post->image) }}"
                                                                width="100%" class="carad-img">
                                                        </a>
                                                        
                                                            {{-- TAG GRATUITO --}}
                                                            @if ($post->acceso == '0')
                                                                <span class="s-disponible s-proximamente"
                                                                    style="right: 4%;left: unset; background: #2436db">GRATUITO</span>
                                                            @endif
                                                    </div>

                                                    <div class="card-body pb-0" style="align-items: start">
                                                        <a href="{{ route('getvideo', $post->pslug) }}" class="td-none">
                                                            <h4 class="title font-weight leading-6">{{ $post->titulo }}
                                                            </h4>
                                                        </a>
                                                        <a href="{{ route('getAutor', $post->autor->slug) }}"
                                                            class="td-none">
                                                            <p class="icon-user-p"><span><i
                                                                        class="fas fa-user-tie"></i></span>
                                                                &nbsp;{{ $post->autor->nombre }}</p>
                                                        </a>

                                                        <div class="flex">
                                                            <p class="p-inline p-c-i"><i class="fas fa-user"></i>
                                                                {{ $post->CountVistas() }}</p>
                                                            <p class="p-inline p-c-i p-m-l"><i
                                                                    class="fas fa-thumbs-up "></i>
                                                                {{ $post->CountValoracion() }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-white text-center bt-0">
                                                        <p class="text-center-mob" style=""><a
                                                                href="{{ route('getvideo', $post->pslug) }}"
                                                                class="a-transparent-g">VER CAPACITACIÓN</a></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                                            <div class="swiper-pagination-autor"></div>
                                        </div>
                                    </div>

                                    <div class="flex w-100 justify-center">
                                        <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                                            <button
                                                class="swiper-btn_rubro-prev bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-left w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                                            <button
                                                class="swiper-btn_rubro-next bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-right w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <h4 class="text-center mt-5">Por el momento no hay videos del rubro, busque más tarde . . .
                            </h4>
                            <br>
                            <br>
                            <br>
                        @endif


                    </div>

                    <div class="tab-pane fade" id="cursosid" role="tabpanel" aria-labelledby="cursosid-tab">
                        @if ($cursos->count() > 0) 
                             {{-- SWIPER SVCA --}}
                            <div class="swiper">
                                <div class="mt-4 mb-4">
                                    <div class="slide-content-rubro">
                                        <div class="card-wrapper swiper-wrapper">
                                            @foreach ($cursos as $curso)
                                                <div class="card card-curso-p padding-1 swiper-slide"
                                                    style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125);">
                                                    <div class="img ">
                                                        <a href="{{ route('getcurso', $curso->slug) }}">
                                                            <img src="{{ asset('imgCurso/' . $curso->url_portada) }}"
                                                                width="100%" class="carad-img">
                                                        </a>
                                                    </div>

                                                    <div class="card-body pb-0" style="align-items: start">
                                                        <a href="{{ route('getcurso', $curso->slug) }}" class="td-none">
                                                            <h4 class="title font-weight leading-6">{{ $curso->titulo }}
                                                            </h4>
                                                        </a>
                                                        <a href="{{ route('getAutor', $curso->autor->slug) }}"
                                                            class="td-none">
                                                            <p class="icon-user-p"><span><i
                                                                        class="fas fa-user-tie"></i></span>
                                                                &nbsp;{{ $post->autor->nombre }}</p>
                                                        </a>

                                                        <div class="flex">
                                                            <p class="p-inline p-c-i"><i class="fas fa-user"></i>
                                                                {{ $curso->countAlumnos() }}</p>
                                                            <p class="p-inline p-c-i p-m-l"><i
                                                                    class="fas fa-thumbs-up "></i>
                                                                {{ $curso->CountValoracion() }}</p>
                                                        </div>
                                                    </div>

                                                    <div class="card-footer bg-white text-center bt-0">
                                                        <p class="text-center-mob" style=""><a
                                                                href="{{ route('getcurso', $curso->slug) }}"
                                                                class="a-transparent-g">VER CURSO</a></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                                            <div class="swiper-pagination-autor"></div>
                                        </div>
                                    </div>

                                    <div class="flex w-100 justify-center">
                                        <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                                            <button
                                                class="swiper-btn_rubro-prev bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-left w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                                            <button
                                                class="swiper-btn_rubro-next bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-right w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <h4 class="text-center mt-5">Por el momento no hay cursos del rubro, busque más tarde . . .
                            </h4>
                            <br>
                            <br>
                            <br>
                        @endif


                    </div>

                    <div class="tab-pane fade" id="articulosid" role="tabpanel" aria-labelledby="articulosid-tab">
                        @if ($articulos->count() > 0)
                            {{-- <section class=" col-md-12 mx-auto row pbm-0 swiper swiper-slide" id="swiper">
                                <section class="swiper-wrapper d-flex pbm-0-mob">
                                @foreach ($articulos as $post)
                                <section class="col-md-3 col-xs-12 card-curso card-curso-p padding-1 swiper-slide">
                                <div class="text">
                                    <a href="{{route('getarticulo',$post->pslug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>
                                    <a href="{{route('getarticulo',$post->pslug)}}" style="text-decoration:none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                                    <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                                    <p>{!!substr($post->infoadd,0,75)!!}. . . </p>
                                    <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p>
                                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->CountVistas()}}</p>
                                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads()->count()}}</p>

                                    
                                    <section class="s-button">
                                    <p class="text-center-mob"><a href="{{route('getarticulo',$post->pslug)}}" class="a-transparent-g">VER</a></p>
                                </section>

                                </div>
                                
                                </section>

                                @endforeach
                                </section>
                            
                                <p class="text-center btn-slider mt-4"><a  class="swiper-button-prev" id="swiper-button-prev" style="text-decoration: none;"><i class="fas fa-chevron-left"></i></a> &nbsp;&nbsp;&nbsp;&nbsp;<a class="swiper-button-next" id="swiper-button-next" style="text-decoration: none;"><i class="fas fa-chevron-right"></i></a></p>


                            </section> --}}

                            {{-- SWIPER SVCA --}}
                            <div class="swiper">
                                <div class="mt-4 mb-4">
                                    <div class="slide-content-rubro">
                                        <div class="card-wrapper swiper-wrapper">
                                            @foreach ($articulos as $post)
                                                <div class="card card-curso-p padding-1 swiper-slide"
                                                    style=" border-radius: 0%;border: 1px solid rgba(0,0,0,.125);">
                                                    <div class="text">
                                                        <a href="{{ route('getarticulo', $post->pslug) }}">
                                                            <img src="{{ asset('images/pdf-a.png') }}" class="img-pdf">
                                                        </a>
                                                    </div>

                                                    <div class="card-body pb-0" style="align-items: start">
                                                        <p><span class="s-clock" style="margin-left: -10px"><i
                                                                    class="fas fa-calendar-alt"></i>
                                                                {{ date('d/m/Y', strtotime($post->paper->fechaimp)) }}</span>
                                                        </p>
                                                        <p>{!! substr($post->infoadd, 0, 80) !!}. . . </p>
                                                        <div class="flex">
                                                            <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i>
                                                                {{ $post->CountValoracion() }}</p>
                                                            <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i>
                                                                {{ $post->CountVistas() }}</p>
                                                            <p class="p-inline p-c-i p-m-l"><i
                                                                    class="fas fa-download"></i>
                                                                {{ $post->downloads()->count() }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer bg-white text-center bt-0">
                                                        <p class="text-center-mob" style=""><a
                                                                href="{{ route('getarticulo', $post->pslug) }}"
                                                                class="a-transparent-g">VER ARTICULO</a></p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                                            <div class="swiper-pagination-autor"></div>
                                        </div>
                                    </div>

                                    <div class="flex w-100 justify-center">
                                        <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                                            <button
                                                class="swiper-btn_rubro-prev bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-left w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                                            <button
                                                class="swiper-btn_rubro-next bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                                                <svg viewBox="0 0 20 20" fill="currentColor"
                                                    class="chevron-right w-6 h-6">
                                                    <path fill-rule="evenodd"
                                                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @else
                            <h4 class="text-center mt-5">Por el momento no hay artículos del rubro, busque más tarde . . .
                            </h4>
                            <br>
                            <br>
                            <br>
                        @endif


                    </div>
                </div>

                    {{-- Eliminar un div --}}
                    {{-- </div> --}} 
            </section>
        </section>
    </section>
    {{-- AFUERA --}}
    <section class="col-md-10 row pbm-0 mt-5 mt-5-mob mx-auto s-e-p {{ $class }}">
        <h4 class="text-center font-weight mt-5 mt-0-mob mt-5-mob">EMPRESAS QUE PROMUEVEN LA CAPACITACIÓN</h4>
        <h4 class="text-center font-weight">EN EL SECTOR <span class="c-green" style="text-transform: uppercase">DE
                LA {{ $rubro->nombrerubro }}</span></h4>


            {{-- SWIPER SECTOR --}}
            @include('web.swiper-sector-colab')

    </section>
    {{-- UP Swiper Contenido --}}
    @if ($rubro->slug == 'construccion')
        {{-- <section class="col-md-8 row pbm-0 mt-5 mt-0-mob mx-auto s-e-p" style="padding-bottom: 5%">
            <section class="col-md-5 col-xs-12">
                <img src="{{ asset('images/suplementos.png') }}" width="100%">
            </section>
            <section class="col-md-7 col-xs-12">
                <h4 class="text-center font-weight mt-5 mt-0-mob none-mobile">SUPLEMENTO TÉCNICO</h4>
                <p class="text-center mt-2-mob" style="font-size: 20px;">En la revista Constructivo editamos desde hace
                    más de 24 años el suplemento técnico del sector construcción. En él se puede encontrar información
                    específica sobre los costos y presupuestos de obras, análisis de precios unitarios, precios por
                    partidas, de materiales y mucho más.</p>
                <p class="mt-4 text-center"><a href="{{ route('suplementos') }}" class="a-transparent-g">IR</a></p>
            </section>
        </section> --}}
        <section class="container mt-5">
            <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-1 lg:grid-cols-2" style="margin-bottom: 5%">
                <div class="px-4 py-1 flex items-center justify-center">
                    <img class="w-full sm:w-1/2 lg:w-full object-cover object-center"
                        src="{{ asset('images/suplementos.png') }}" style=" ">
                </div>
                <div class="px-4 py-1 flex justify-center" style="flex-direction: column">
                    <h4 class="text-center font-weight mt-5 mt-0-mob hidden lg:block">SUPLEMENTO TÉCNICO</h4>
                    <p class="text-center mt-2-mob" style="font-size: 20px;">En la revista Constructivo editamos desde
                        hace
                        más de 24 años el suplemento técnico del sector construcción. En él se puede encontrar información
                        específica sobre los costos y presupuestos de obras, análisis de precios unitarios, precios por
                        partidas, de materiales y mucho más.</p>
                    <p class="mt-4 text-center"><a href="{{ route('suplementos') }}" class="a-transparent-g">IR</a></p>
                </div>
            </div>
        </section>
    @endif
    {{-- CAMBIOS JHED --}}
    <div class="{{ $class }}">
        @include('web.planesSection');
    </div>
    {{-- CAMBIOS JHED --}}
@endsection
@section('script-extra')

    <!-- Swiper JS -->
    <script src="{{ asset('swiper/js/script.js') }}"></script>
    <script>
        var swiper = new Swiper('#swiper', {
            slidesPerView: window.innerWidth <= 900 ? 1 : 4,
            navigation: {
                nextEl: '#swiper-button-next',
                prevEl: '#swiper-button-prev',
            },

        });


        var swiper1 = new Swiper('#swiper1', {
            slidesPerView: window.innerWidth <= 900 ? 1 : 6,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            loop: true,
            loopFillGroupWithBlank: true,
            navigation: {
                nextEl: '#swiper-button-next1',
                prevEl: '#swiper-button-prev1',
            },
        });

        function getDirection() {
            var windowWidth = window.innerWidth;
            var direction = window.innerWidth <= 760 ? 'vertical' : 'horizontal';

            return direction;
        }
    </script>
@endsection

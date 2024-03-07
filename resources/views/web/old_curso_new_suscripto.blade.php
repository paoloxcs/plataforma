@extends('layouts.front')

@section('titulo')
    {{ $curso->titulo }}
@endsection

@section('content')

    <div class="none">{{ $a = $curso->rubro->slug }}</div>

    {{-- <section class="col-md-10 mx-auto row pbm-0"> --}}

    <section class="max-w-7xl mx-auto sm:px-6 lg:px-9 md:px-7 spx-2 mt-12">

        <section class="grid lg:grid-cols-3 gap-12 pbm-0">
            <section class="lg:col-span-2 order-2 lg:order-1 py-4">

                <div class="d-title">

                    {{-- Etiquetas Span --}}
                     <div class="d-flex">
                         <p><span class="p-rubro" style="text-transform: uppercase;">{{ $rubro->nombrerubro }}</span></p>

                         @if ($curso->fecha_culminacion >= date('Y-m-d'))
                             <p>
                                 <span class="s-vivo mx-2">EN VIVO</span>
                             </p>
                         @else
                             <p>
                                 <span class="s-realizado mx-2">REALIZADOS</span>
                             </p>
                         @endif
                     </div>


                    <h3 class="title-cur font-weight">{{ $curso->titulo }}</h3>



                    <a href="{{ route('getAutor', $curso->autor->slug) }}" class="td-none">
                        <p class="p-inline p-c-i"><i class="fas fa-user-tie "></i> {{ $curso->autor->nombre }}</p>
                    </a>

                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{ $curso->countAlumnos() }}</p>

                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up"></i> {{ $curso->CountValoracion() }}</p>



                    <p class="p-inline p-c-i p-m-l"> <span class="s-disponibles">DISPONIBLES</span></p>



                </div>

                {{-- WEB CURSO PORTADA --}}
                {{-- <div class="none-mobile"> --}}
                <div class="hidden lg:block">

                    @if ($curso->fecha_culminacion < date('Y-m-d') and $curso->url_video_preview != '')
                        <div class="d-img mt-4 embed-responsive embed-responsive-16by9">

                            <iframe class="embed-responsive-item"
                                src="https://player.vimeo.com/video/{{ $curso->url_video_preview }}" webkitallowfullscreen
                                mozallowfullscreen allowfullscreen></iframe>

                        </div>
                    @else
                        <div class="d-img mt-4">

                            <img src="{{ asset('imgCurso/' . $curso->url_portada) }}" width="100%">

                        </div>
                    @endif

                </div>

                {{-- MOBILE CURSO PORTADA --}}

                {{-- <div class="none-desktop"> --}}
                <div class="block lg:hidden mt-4">

                    <div class="none">{{ $class = 0 }}</div>

                    @foreach ($clases as $clase)
                        @if ($clase->zoom_codigo_url != '' and $clase->video_codigo == '')
                            <div class="none">{{ $class = $class + 1 }}</div>

                            @if ($clase->fecha == date('Y-m-d') and $clase->time <= date('H:i:s'))
                                <div class="none">{{ $url = $clase->zoom_codigo_url }}</div>
                            @else
                                <div class="none">{{ $url = route('getclase', $clase->slug) }}</div>
                            @endif

                            <section class="card-curso mt-5-mob card__cursoIcon px-0"
                                style="padding-bottom: 0px!important;">

                                <div class="img">

                                    <a href="{{ $url }}"><img
                                            src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%"></a>

                                    <span><a href="{{ $url }}" class="a-icon"><i
                                                class="fas fa-play-circle"></i></a></span>

                                </div>

                                <div class="text" style="padding: 0">



                                    <a class="td-none" href="{{ $url }}">
                                        <h5 class="mt-3 font-weight">{{ $clase->titulo }}</h5>
                                    </a>

                                    <a class="td-none" href="{{ route('getAutor', $curso->autor->slug) }}">
                                        <p class="font-weight">{{ $curso->autor->nombre }}</p>
                                    </a>

                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p> --}}

                                    <hr>

                                    {{-- <span>No has completado ninguna unidad del curso</span> --}}

                                    <div class="col-md-12 row pbm-0 mt-3">

                                        <div class="col-md-8 pbm-0 mx-auto">

                                            <p><a class="nav-link a-menu nav-a-class text-center"
                                                    href="{{ $url }}">INGRESAR A CURSO</a></p>

                                        </div>

                                    </div>

                                </div>

                            </section>
                        @endif
                    @endforeach



                    @if ($class < 1)
                        <section class="card-curso mt-5-mob card__cursoIcon" style="padding-bottom: 0px!important;;">

                            <div class="img">

                                <a href="{{ route('getclase', $clase1->slug) }}"><img
                                        src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%"></a>

                                <span><a href="{{ route('getclase', $clase1->slug) }}" class="a-icon"><i
                                            class="fas fa-play-circle"></i></a></span>

                            </div>

                            <div class="text" style="padding: 0">

                                <a class="td-none" href="{{ route('getclase', $clase1->slug) }}">
                                    <h5 class="mt-3 font-weight">{{ $clase1->titulo }}</h5>
                                </a>

                                <a class="td-none" href="{{ route('getAutor', $curso->autor->slug) }}">
                                    <p class="font-weight">{{ $curso->autor->nombre }}</p>
                                </a>

                                {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p> --}}

                                <hr>

                                {{-- <span>No has completado ninguna unidad del curso</span> --}}

                                <div class="col-md-12 row pbm-0 mt-3">

                                    <div class="col-md-8 pbm-0 mx-auto">

                                        <p><a class="nav-link a-menu nav-a-class text-center"
                                                href="{{ route('getclase', $clase1->slug) }}">INGRESAR A CURSO</a></p>

                                    </div>

                                </div>

                            </div>

                        </section>
                    @endif

                </div>

                {{-- <div class="col-md-12 mx-auto mt-1  mt-5-mob none-desktop">

                    <h4 class="text-center font-weight">Acerca del autor</h4>

                    <div class="col-md-9 col-xs-12 row mx-auto">

                        <div class="col-md-4 col-xs-3">

                            <img style="border-radius: 50%" src="{{ asset('posts/' . $curso->autor->imagen) }}"
                                width="100%">

                        </div>

                        <div class="col-md-8 col-xs-9">

                            <h5>{{ $curso->autor->nombre }}</h5>

                            <a href="{{ route('getAutor', $curso->autor->slug) }}" class="a-menu a-menu-b td-none">VER
                                PERFIL</a>

                        </div>



                    </div>

                </div> --}}

                {{-- MOBILE --}}

                {{-- INFO DE CURSO --}}
                <div class="descripción mt-4 mt0-mob">

                    {{-- <p>{!!$curso->descripcion!!}</p> --}}

                    {{-- <h4 class="font-weight c-green"> --}}
                    <h4 class="font-weight mt-4">Descripción

                        <div class="border__cursosText"></div>
                    </h4>

                    <p>{!! $curso->descripcion !!}</p>



                    @if ($curso->objetivos)
                        {{-- <h4 class="font-weight c-green mt-4"> --}}
                        <h4 class="font-weight mt-4">Objetivos

                            <div class="border__cursosText"></div>
                        </h4>

                        <p>{!! $curso->objetivos !!}</p>
                    @endif



                    @if ($curso->publico)
                        {{-- <h4 class="font-weight c-green mt-4"> --}}
                        <h4 class="font-weight mt-4">¿A quién está dirigido?

                            <div class="border__cursosText"></div>
                        </h4>

                        <p>{!! $curso->publico !!}</p>
                    @endif

                </div>

                {{-- TEMARIO DE CURSO --}}
                <div class="temario">

                    <h4 class="font-weight">Temario del curso

                        <div class="border__cursosText"></div>
                    </h4>

                    {{-- }} <p>Lorem ipsum dolor sit amet, consectetur adipiscing eli  adipiscing eli</p> --}}

                    <div class="accordion accordion-flush" id="accordionFlushExample">

                        @foreach ($clases as $clase)
                            <div class="d-none">

                                @if ($loop->iteration == 2)
                                    {{ $show = 'show' }}
                                @else
                                    {{ $show = '' }}
                                @endif

                                {{ $collapse = '' }}

                                {{ $false = 'true' }}

                            </div>



                            <div class="accordion-item">

                                <h2 class="accordion-header" id="{{ 'flush-heading' . $clase->id }}">

                                    <button style="color:black" class="{{ 'accordion-button font-weight ' . $collapse }}"
                                        type="button" data-bs-toggle="collapse"
                                        data-bs-target="{{ '#flush-collapse' . $clase->id }}"
                                        aria-expanded="{{ $false }}"
                                        aria-controls="{{ 'flush-collapse' . $clase->id }}">

                                        <i class="fas fa-angle-double-down"></i> &nbsp;&nbsp;&nbsp;{{ $clase->titulo }}

                                    </button>

                                </h2>

                                <div id="{{ 'flush-collapse' . $clase->id }}"
                                    class="{{ 'accordion-collapse collapse ' . $show }}"
                                    aria-labelledby="{{ 'flush-heading' . $clase->id }}"
                                    data-bs-parent="#accordionFlushExample">

                                    <div class="accordion-body">

                                        <p>{!! $clase->informacion !!}</p>

                                        {{-- CAMBIOS JHED --}}
                                        {{-- @if ($curso->fecha_culminacion <= date('Y-m-d')) --}}
                                        @if ($curso->fecha_culminacion <= date('Y-m-d') || $clase->video_codigo != null)
                                            <p class="text-center mt-4"><a href="{{ route('getclase', $clase->slug) }}"
                                                    class="a-transparent-g" href=""><i class="fas fa-eye"></i> VER
                                                    MATERIAL</a></p>
                                        @endif

                                    </div>

                                </div>

                            </div>
                        @endforeach



                    </div>

                </div>

                {{-- INFO DE AUTOR --}}
                {{-- <div class="col-md-12 mx-auto mt-1  mt-5-mob none-desktop"> --}}
                <div class="col-md-12 mx-auto mt-1 mt-5-mob py-2">
                    <h4 class="text-start font-weight pb-2">Acerca del autor
                        <div class="border__cursosText"></div>
                    </h4>
                    {{-- <div class="col-md-9 col-xs-12 row mx-auto"> --}}
                    <div class="col-md-9 col-xs-12 row">
                        <div class="col-md-4 col-xs-3">
                            <img style="border-radius: 50%" src="{{ asset('posts/' . $curso->autor->imagen) }}"
                                width="80%">
                        </div>
                        <div class="col-md-8 col-xs-9 d-flex justify-content-center flex-column align-items-start">
                            <h5>{{ $curso->autor->nombre }}</h5>
                            <a href="{{ route('getAutor', $curso->autor->slug) }}" class="a-menu a-menu-b td-none">VER
                                PERFIL</a>
                        </div>

                    </div>
                </div>


                {{-- VALORACIONES --}}
                <div class="valoraciones mt-5">

                    <h4 class="font-weight">Valoraciones</h4>

                    <div class="col-md-11 mx-auto row pbm-0 mt-4">

                        <div class="col-md-4 div-valoraciones">

                            <p class="p-grand c-green"><i class="fas fa-thumbs-up"></i> {{ $curso->CountValoracion() }}
                            </p>

                            <p class="pbm-0 font-weight">Rating del curso</p>

                        </div>

                        <div class="col-md-4 div-valoraciones">

                            <p class="p-grand c-green"><i class="fas fa-user"></i> {{ $curso->countAlumnos() }}</p>

                            <p class="pbm-0 font-weight">Alumnos</p>

                        </div>

                        <div class="col-md-4 div-valoraciones">

                            <p class="p-grand c-green"><i class="fas fa-comment"></i> {{ count($comentarios) }}</p>

                            <p class="pbm-0 font-weight">Comentarios</p>

                        </div>

                    </div>

                </div>

                {{-- CERTIFICADO --}}
                 @if ($curso->fecha_culminacion >= date('Y-m-d'))
                <div class="col-md-12 bg-gris-black row mt-4" style="padding: 3% 2%;">

                    <div class="col-md-7" style="padding: 3% 2%;">

                        <h5 class="font-weight c-white">Certificado del curso</h5>

                        <p>Al terminar el curso obtén un certificado emitido por Plataforma Constructivo que avale tus
                            nuevos
                            conocimientos y úsalo para diferenciarte a nivel internacional.</p>

                    </div>

                    <div class="col-md-5">

                        @if ($curso->certificado != '')
                            <img src="{{ asset('imgCurso/' . $curso->certificado) }}" width="100%">
                        @else
                            <img src="{{ asset('images/certificado.jpg') }}" width="100%">
                        @endif

                    </div>



                </div>
                 @endif

                {{-- COMENTARIO --}}
                <div class="valoraciones mt-5 none-mobile" style="padding-bottom: 5%;">

                    <h4 class="font-weight">Comentarios</h4>



                    <div class="col-md-11 mx-auto row pbm-0 mt-4">

                        @if (count($comentarios) > 0)
                            @foreach ($comentarios as $coment)
                                <div class="row col-md-12 mt-3">

                                    <div class="col-md-1 pbm-0 ">



                                        @if ($coment->user->url_foto != null)
                                            <img src="{{ asset('fotousers/' . $coment->user->url_foto) }}" class="br-50"
                                                width="80%">
                                        @else
                                            <img src="{{ asset('fotousers/profile.png') }}" class="br-50"
                                                width="80%">
                                        @endif

                                    </div>

                                    <div class="col-md-11 pbm-0">

                                        <h6 class="font-weight mt-2" style="text-transform: none;">
                                            {{ $coment->user->fullname() }}</h6>

                                        <p style="margin-bottom:  0">{{ $coment->texto }}</p>

                                        <p class=" c-green pbm-0"> <a type="button" data-bs-toggle="modal"
                                                data-bs-target="#modal-responder{{ $coment->id }}"
                                                class="c-green td-none font-weight"
                                                style="margin-top: -10px">Responder</a>
                                        </p>

                                    </div>

                                </div>



                                @foreach ($respuestas as $resp)
                                    @if ($resp->comentario_id == $coment->id)
                                        <div class="row col-md-12 mt-3">

                                            <div class="col-md-1 pbm-0 ">

                                            </div>

                                            <div class="col-md-1 pbm-0 ">

                                                @if ($resp->user->url_foto != null)
                                                    <img src="{{ asset('fotousers/' . $resp->user->url_foto) }}"
                                                        class="br-50" width="80%">
                                                @else
                                                    <img src="{{ asset('fotousers/profile.png') }}" class="br-50"
                                                        width="80%">
                                                @endif

                                            </div>

                                            <div class="col-md-10 pbm-0">

                                                <h6 class="font-weight mt-2" style="text-transform: none;">
                                                    {{ $resp->user->fullname() }}</h6>

                                                <p style="margin-bottom:  0">{{ $resp->texto }}</p>



                                            </div>

                                        </div>
                                    @endif
                                @endforeach







                                <div class="modal fade" id="modal-responder{{ $coment->id }}" tabindex="-1"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">

                                    <div class="modal-dialog modal-dialog modal-md modal-dialog modal-dialog-centered">

                                        <div class="modal-content" style="border-radius:   15px">

                                            <div class="modal-body col-md-12 row pbm-0">

                                                <section class="col-md-12 pbm-0 s-login" style="  padding:  1% 3%">

                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>

                                                    <div class="col-md-12 row">

                                                        <div class="col-md-2 pbm-0 mt-4">

                                                            @if (Auth()->user()->url_foto != null)
                                                                <img src="{{ asset('fotousers/' . Auth()->user()->url_foto) }}"
                                                                    width="70%">
                                                            @else
                                                                <img src="{{ asset('fotousers/profile.png') }}"
                                                                    width="70%">
                                                            @endif

                                                        </div>

                                                        <div class="col-md-10 pbm-0">

                                                            <h6 class="font-weight mt-2">Responder a
                                                                {{ $coment->user->fullname() }}</h6>



                                                            <textarea class="form-control" placeholder="Ingrese su respuesta . . ." id="respuesta{{ $coment->id }}"
                                                                style="height: 100px"></textarea>



                                                            <p class=" mt-3"><a class="a-menu a-menu-b"
                                                                    style="text-decoration: none" type="button"
                                                                    onclick="saveRespuesta({{ $coment->id }});">RESPONDER</a>
                                                            </p>

                                                        </div>

                                                    </div>



                                                </section>

                                                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}





                                            </div>

                                        </div>

                                    </div>

                                </div>
                            @endforeach
                        @else
                            <p>No hay comentarios para esta publicación. Sé el primero en comentar.</p>
                        @endif





                        <div class="row col-md-12 mt-2">

                            <div class="col-md-1 pbm-0">

                                @if (Auth()->user()->url_foto != null)
                                    <img src="{{ asset('fotousers/' . Auth()->user()->url_foto) }}" class="br-50"
                                        width="80%">
                                @else
                                    <img src="{{ asset('fotousers/profile.png') }}" class="br-50" width="80%">
                                @endif

                            </div>

                            <div class="col-md-11 pbm-0">

                                <h6 class="font-weight mt-2">ESCRIBE UNA VALORACION</h6>

                                <form>

                                    <textarea class="form-control" placeholder="Valoración . . ." id="texto" style="height: 100px"></textarea>



                                    <p class="mt-2 font-weight">¿Recomiendas este curso? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;





                                        <span class="s-coment" style="cursor:pointer"><a type="button"
                                                onclick="saveLike({{ $curso->id }});"><i class="fas fa-thumbs-up"></i>
                                                SI</a></span>

                                        <span class="s-coment" style="cursor:pointer"><a type="button"
                                                onclick="saveNotLike({{ $curso->id }});"><i
                                                    class="fas fa-thumbs-down"></i> NO</a></span>
                                    </p>













                                    <a class="a-menu a-menu-b" style="text-decoration: none" type="submit"
                                        id="comentar">COMENTAR</a>



                                </form>









                            </div>

                        </div>



                    </div>

                </div>

            </section>

            {{-- <section class="col-md-4 col-xs-12 col-card-plan s-bene-mob"> --}}
            <section class="order-2 lg:order-2 col-card-plan s-bene-mob hidden lg:block">

                <div class="sticky top-28 pb-16">
                    {{-- <div class="col-md-12 mx-auto mt-1  mt-5-mob none-mobile"> --}}
                    <div class="col-md-12 mx-auto mt-1 hidden mt-5-mob">

                        <h4 class="text-center font-weight">Acerca del autor</h4>

                        <div class="col-md-9 col-xs-12 row mx-auto">

                            <div class="col-md-4 col-xs-3">

                                <img style="border-radius: 50%" src="{{ asset('posts/' . $curso->autor->imagen) }}"
                                    width="100%">

                            </div>

                            <div class="col-md-8 col-xs-9">

                                <h5>{{ $curso->autor->nombre }}</h5>

                                <a href="{{ route('getAutor', $curso->autor->slug) }}"
                                    class="a-menu a-menu-b td-none">VER
                                    PERFIL</a>

                            </div>



                        </div>

                    </div>

                    {{-- INGRESAR CURSO --}}
                    <div class="none-mobile">

                        <div class="none">{{ $class = 0 }}</div>

                        @foreach ($clases as $clase)
                            @if ($clase->zoom_codigo_url != '' and $clase->video_codigo == '')
                                <div class="none">{{ $class = $class + 1 }}</div>

                                @if ($clase->fecha == date('Y-m-d') and $clase->time <= date('H:i:s'))
                                    {{-- <div class="none">{{$url=$clase->zoom_codigo_url}}</div> --}}
                                    @if ($clase->time_exp <= date('H:i:s'))
                                        <div class="none">{{ $url = route('getclase', $clase->slug) }}</div>
                                    @else
                                        <div class="none">{{ $url = $clase->zoom_codigo_url }}</div>
                                    @endif
                                @else
                                    <div class="none">{{ $url = route('getclase', $clase->slug) }}</div>
                                @endif

                                <section class="card-curso mt-5-mob card__cursoIcon px-0">

                                    <div class="img">

                                        <a href="{{ $url }}"><img
                                                src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%"></a>

                                        <span><a href="{{ $url }}" class="a-icon"><i
                                                    class="fas fa-play-circle"></i></a></span>

                                    </div>

                                    <div class="text" style="padding: 0">



                                        <a class="td-none" href="{{ $url }}">
                                            <h5 class="mt-3 font-weight">{{ $clase->titulo }}</h5>
                                        </a>

                                        <a class="td-none" href="{{ route('getAutor', $curso->autor->slug) }}">
                                            <p class="font-weight">{{ $curso->autor->nombre }}</p>
                                        </a>

                                        {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p> --}}

                                        <hr>

                                        {{-- <span>No has completado ninguna unidad del curso</span> --}}

                                        <div class="col-md-12 row pbm-0 mt-3">

                                            <div class="col-md-8 pbm-0 mx-auto">

                                                {{-- <p><a class="nav-link a-menu nav-a-class text-center" href="{{$url}}">INGRESAR A CURSO</a></p> --}}
                                                <p><a class="nav-link a-menu text-center nav-a-cursos"
                                                        href="{{ $url }}">
                                                        INGRESAR A CURSO
                                                    </a>
                                                </p>


                                            </div>



                                        </div>



                                    </div>



                                </section>
                            @endif
                        @endforeach



                        @if ($class < 1)
                            <section class="card-curso mt-5-mob card__cursoIcon px-0">

                                <div class="img">

                                    <a href="{{ route('getclase', $clase1->slug) }}"><img
                                            src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%"></a>

                                    <span><a href="{{ route('getclase', $clase1->slug) }}" class="a-icon"><i
                                                class="fas fa-play-circle"></i></a></span>

                                </div>

                                <div class="text" style="padding: 0">



                                    <a class="td-none" href="{{ route('getclase', $clase1->slug) }}">
                                        <h5 class="mt-3 font-weight">{{ $clase1->titulo }}</h5>
                                    </a>

                                    <a class="td-none" href="{{ route('getAutor', $curso->autor->slug) }}">
                                        <p class="font-weight">{{ $curso->autor->nombre }}</p>
                                    </a>

                                    {{-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p> --}}

                                    <hr>

                                    {{-- <span>No has completado ninguna unidad del curso</span> --}}

                                    <div class="col-md-12 row pbm-0 mt-3">

                                        <div class="col-md-8 pbm-0 mx-auto">

                                            {{-- <p><a class="nav-link a-menu nav-a-class text-center" href="{{route('getclase',$clase1->slug)}}">INGRESAR A CURSO</a></p> --}}

                                            <p><a class="nav-link a-menu nav-a-class text-center"
                                                    href="{{ route('getclase', $clase1->slug) }}">INGRESAR A CURSO</a></p>


                                        </div>



                                    </div>



                                </div>



                            </section>
                        @endif

                    </div>
                </div>

            </section>

        </section>



    @endsection

    @section('script-extra')
        <script>
            //funcion para guardar like

            var token = '{{ csrf_token() }}';

            function saveLike(curso_id) {

                var ruta = '{{ route('savelikecurso') }}';



                $.ajax({

                    url: ruta,

                    type: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': token
                    },

                    dataType: 'json',

                    data: {

                        curso_id: curso_id

                    },

                    success: function(data) {

                        console.log(data);

                        location.reload();

                    },

                    error: function(data) {

                        console.log(data);

                    }

                });

            }



            function saveNotLike(curso_id) {







                location.reload();



            }





            $('#comentar').click(function() {

                var texto = $('#texto').val();

                var curso_id = {{ $curso->id }};

                var ruta = '{{ route('savecomentcurso') }}';

                if (!texto) {

                    alert('¡Escribe un comentario!');

                    $('#texto').focus();

                    return;

                }

                $.ajax({

                    url: ruta,

                    type: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': token
                    },

                    dataType: 'json',

                    data: {

                        texto: texto,

                        curso_id: curso_id

                    },

                    success: function(data) {

                        console.log(data);

                        location.reload();

                    },

                    error: function(data) {

                        console.log(data);

                    }

                });



            });

            //funcion para guardar respuesta

            function saveRespuesta(coment_id) {



                var textores = $('#respuesta' + coment_id).val();

                var ruta = '{{ route('saverespuestacurso') }}';

                if (!textores) {

                    alert('¡Escribe una respuesta!');

                    $('#respuesta' + coment_id).focus();

                    return;

                }

                $.ajax({

                    url: ruta,

                    type: 'POST',

                    headers: {
                        'X-CSRF-TOKEN': token
                    },

                    dataType: 'json',

                    data: {

                        textores: textores,

                        coment_id: coment_id

                    },

                    success: function(data) {

                        console.log(data);

                        location.reload();

                    },

                    error: function(data) {

                        console.log(data);

                    }

                });



            }
        </script>
    @endsection

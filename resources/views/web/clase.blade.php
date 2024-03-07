@extends('layouts.front')

@section('titulo')

{{$clase->titulo}}

@endsection

@section('content')

  <section class="col-md-12 bg-gris-black  pbm-0" style="padding-bottom: 4% ">

        {{-- TAB TITLE --}}
        <section class="col-md-10 mx-auto col-xs-12 padding-1 mt-2-mob">
            <br>
            <br>
            <span class="p-rubro tt-uppercase">{{ $clase->curso->rubro->nombrerubro }}</span>
            <h2 class="mt-2 c-white font-weight">{{ $clase->titulo }}</h2>
            <p class="p-inline c-white"> {{ $clase->curso->autor->nombre }}</p>
            <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{ $clase->curso->countAlumnos() }}</p>
            <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up"></i> {{ $clase->curso->CountValoracion() }}</p>
        </section>
        {{-- TAB TITLE --}}

        {{-- TAB MODULOS --}}
        <section class="col-md-10 mx-auto mt-5 s-clase-nav mt-2-mob">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home"
                        type="button" role="tab" aria-controls="home" aria-selected="true">Sesiones</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button"
                        role="tab" aria-controls="profile" aria-selected="false">Descargar Material</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button"
                        role="tab" aria-controls="contact" aria-selected="false">Comentarios</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="certificado-tab" data-bs-toggle="tab" data-bs-target="#certificado"
                        type="button" role="tab" aria-controls="certificado" aria-selected="false">Certificado</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="encuesta-tab" data-bs-toggle="tab" data-bs-target="#encuesta"
                        type="button" role="tab" aria-controls="encuesta" aria-selected="false">Encuesta</button>
                </li>
                {{-- sponsor --}}
                @if($curso->Sponsors()>0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="sponsor-tab" data-bs-toggle="tab" data-bs-target="#sponsor" type="button"
                        role="tab" aria-controls="sponsor" aria-selected="false">Patrocinadores</button>
                </li>
                @endif
            </ul>

            <div class="tab-content col-md-6 col-xs-12 padding-1" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">

                    
                    <div class="temario mt-5 mt-2-mob" style="">

                        <div class="accordion accordion-flush accordion-clase" id="accordionFlushExample">

                            @foreach ($clases as $class)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-heading{{ $class->id }}">
                                        <button class="accordion-button collapsed font-weight" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapse{{ $class->id }}"
                                            aria-expanded="false" aria-controls="flush-collapse{{ $class->id }}">
                                            {{ $class->titulo }} @if ($class->id == $clase->id)
                                                (Reproduciendo)
                                            @endif
                                        </button>
                                    </h2>
                                    <div id="flush-collapse{{ $class->id }}" class="accordion-collapse collapse"
                                        aria-labelledby="flush-heading{{ $class->id }}"
                                        data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body c-white">
                                            <p class="c-white">{!! $class->informacion !!}</p>

                                            <p class="text-center mt-4"><a href="{{ route('getclase', $class->slug) }}"
                                                    class="a-transparent-g"><i class="fas fa-eye" aria-hidden="true"></i>  VER VIDEO </a></p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- New TAB VIDEO --}}
                        <!-- <section class="col-md-7 col-xs-12 mx-auto">
                            <br>
                            @if ($clase->video_codigo != '')
                                <div class="embed-responsive embed-responsive-16by9">
                                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{{ $clase->video_codigo }}"
                                        webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                </div>
                            @else
                                <img src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%;">

                                <div class="portada  pbm-0" id="portada">
                                    <div id="cuenta" class="cuenta">

                                    </div>
                                </div>

                                <main class="btn-reunion pmb-0">

                                    <p class="text-center"><a class="nav-link a-menu a-menu-b a-ir" href="{{ $clase->zoom_codigo_url }}" style="display: inline">IR A LA SESIÓN</a></p>

                                </main>
                            @endif 
                        </section> -->
                        {{-- New TAB VIDEO --}}
                    </div>


                </div>

                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    @if ($materiales->count() > 0)
                    <section class="mt-5 mt-2-mob">
                        @foreach ($materiales as $art)
                            <section class="col-md-12 row s-descarga mt-2-mob">
                                <div class="col-md-1 col-xs-1">
                                    @if ($art->tipo == 'pdf')
                                        <img style="background: white" src="{{ asset('images/pdf-icon.png') }}"
                                            width="100%"></a>
                                    @elseif($art->tipo == 'xls')
                                        <img style="background: white" src="{{ asset('images/excel-icon.png') }}"
                                            width="100%"></a>
                                    @elseif($art->tipo == 'docx')
                                        <img style="background: white" src="{{ asset('images/word-icon.png') }}"
                                            width="100%"></a>
                                    @else
                                        <img style="background: white" src="{{ asset('images/file-icon.png') }}"
                                            width="100%"></a>
                                    @endif
                                </div>
                                <div class="col-md-11 col-xs-11">
                                    <a href="{{ asset('pdfCurso/' . $art->url_file) }}"
                                        download="{{ $art->nombre_documento }}" class="td-none">
                                        <p class="p-inline  c-white"> {{ $art->nombre_documento }}</p>
                                        <p class="p-inline c-white f-right"><i class="fas fa-download c-white"></i></p>
                                    </a>
                                </div>

                            </section>
                        @endforeach

                    </section>
                    @else
                        <p class="py-3">Por el momento no hay materiales para este curso, busque más tarde . . .</p>
                    @endif


                </div>
                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                    <div class="valoraciones mt-2">


                        <div class="col-md-12 mx-auto row pbm-0 s-coment-clase">
                            @if (count($comentarios) > 0)
                                @foreach ($comentarios as $coment)
                                    <div class="row col-md-12 mt-4 mt-2-mob">
                                        <div class="col-md-1 col-xs-1 pbm-0 mt-2">
                                            @if ($coment->user->url_foto != null)
                                                <img src="{{ asset('fotousers/' . $coment->user->url_foto) }}"
                                                    width="80%" style="border-radius: 50%">
                                            @else
                                                <img src="{{ asset('fotousers/profile.png') }}" width="80%"
                                                    style="border-radius: 50%">
                                            @endif
                                        </div>
                                        <div class="col-md-11 col-xs-11 pbm-0">
                                            <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">
                                                {{ $coment->user->fullname() }}</h5>

                                            <p style="margin-bottom: 0">{{ $coment->texto }}</p>

                                            <a type="button" data-bs-toggle="modal"
                                                data-bs-target="#modal-responder{{ $coment->id }}">
                                                <p class="p-inline p-c-i pbm-0 c-green" style="color: #24db37!important;">
                                                    <i style="color: #24db37!important;" class="fas fa-comments"></i>
                                                    Responder</p>
                                            </a>

                                        </div>
                                    </div>
                                    @foreach ($respuestas as $resp)
                                        @if ($resp->comentario_id == $coment->id)
                                            <div class="row col-md-12 mt-4">
                                                <div class="col-md-1 col-xs-1 pbm-0 mt-2">
                                                </div>
                                                <div class="col-md-1 col-xs-1 pbm-0 mt-2">
                                                    @if ($coment->user->url_foto != null)
                                                        <img src="{{ asset('fotousers/' . $resp->user->url_foto) }}"
                                                            width="80%" style="border-radius: 50%">
                                                    @else
                                                        <img src="{{ asset('fotousers/profile.png') }}" width="80%"
                                                            style="border-radius: 50%">
                                                    @endif
                                                </div>
                                                <div class="col-md-10 col-xs-10 pbm-0">
                                                    <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">
                                                        {{ $resp->user->fullname() }}</h5>

                                                    <p style="margin-bottom: 0">{{ $resp->texto }}</p>

                                                </div>
                                            </div>
                                        @endif
                                    @endforeach

                                    <div class="modal fade pbm-0-mob" id="modal-responder{{ $coment->id }}"
                                        tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog modal-md modal-dialog modal-dialog-centered">
                                            <div class="modal-content" style="border-radius:   15px">
                                                <div class="modal-body col-md-12 row pbm-0">
                                                    <section class="col-md-12 pbm-0 s-login" style="  padding:  1% 3%">
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                        <div class="col-md-12 row">
                                                            <div class="col-md-2 col-xs-2 pbm-0 mt-4">
                                                                @if (Auth()->user()->url_foto != null)
                                                                    <img src="{{ asset('fotousers/' . Auth()->user()->url_foto) }}"
                                                                        width="70%">
                                                                @else
                                                                    <img src="{{ asset('fotousers/profile.png') }}"
                                                                        width="70%">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-10 col-xs-10 pbm-0">
                                                                <h6 class="font-weight mt-2"
                                                                    style="color:black!important;">Responder a
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
                            {{-- <div class="row col-md-12 mt-4">
              <div class="col-md-1 pbm-0 mt-2">
                <img src="{{asset('images/img-coment.png')}}" width="80%">
              </div>
              <div class="col-md-11 pbm-0">
                <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">NOMBRE DEL USUARIO</h5>
                <span>Hace 7 meses</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>

               <p class="p-inline p-c-i"><i class="fas fa-thumbs-up"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-comments"></i> Responder</p>

              </div>
            </div> --}}



                            <div class="row col-md-12 mt-4">
                                <div class="col-md-1 col-xs-1 pbm-0 mt-2">
                                    @if (Auth()->user()->url_foto != null)
                                        <img src="{{ asset('fotousers/' . Auth()->user()->url_foto) }}" width="80%">
                                    @else
                                        <img src="{{ asset('fotousers/profile.png') }}" width="80%">
                                    @endif
                                </div>
                                <div class="col-md-11 col-xs-11 pbm-0">
                                    <h5 class="font-weight mt-2">ESCRIBE UNA VALORACION</h5>
                                    <form>
                                        <textarea style="color:white!important" id="texto" class="form-control ta-c-c" placeholder="Valoración . . ."
                                            style="height: 100px"></textarea>

                                        <p class="mt-2 font-weight c-white">¿Recomiendas este curso?
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="s-coment c-white"><a
                                                    type="button" onclick="saveLike({{ $curso->id }});"
                                                    class="c-white" style="color:white"><i
                                                        class="fas fa-thumbs-up c-white"></i> SI</a></span> <span
                                                class="s-coment c-white"><a type="button"
                                                    onclick="saveNotLike({{ $curso->id }});" class="c-white"
                                                    style="color:white"><i class="fas fa-thumbs-down c-white"></i>
                                                    NO</a></span></p>

                                        <a class="a-menu a-menu-b" style="text-decoration: none" type="submit"
                                            id="comentar">COMENTAR</a>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="tab-pane fade" id="certificado" role="tabpanel" aria-labelledby="certificado-tab">

                    @if (Auth()->user()->SolicitudCertificado($curso->id))
                        <div class="mt-1 mb-1 mx-auto col-md-7 col-xs-7">
                            <p class="text-center c-green font-weight" style="color:#24db37!important;">Datos registrados,
                                culminado el curso se lo enviaremos al correo registrado.</p>

                            @if ($curso->certificado != '')
                                <img src="{{ asset('imgCurso/' . $curso->certificado) }}" width="100%">
                            @else
                                <img src="{{ asset('images/certificado.jpg') }}" width="100%">
                            @endif

                        </div>
                    @else
                        <h5 class="c-white mt-5 mt-2-mob font-weight">DATOS PARA EL CERTIFICADO</h5>
                        <p class="c-white">Llene el formulario con tus datos para generar el certificado</p>

                        <form class="" action="{{ route('savecertificado') }}" method="POST"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <label class="form-label c-white mt-4">Correo electrónico</label>
                            <input type="email" class="form-control input-cert" name="email"
                                placeholder="postmaster@constructivo.com" value="{{ Auth()->user()->email }}" required>

                            <label class="form-label c-white mt-4">Nombre Completo</label>
                            <input type="text" class="form-control input-cert" name="nombres"
                                placeholder="Nombre completo . . ." value="{{ Auth()->user()->fullName() }}" required>

                            <label class="form-label c-white mt-4">N° Teléfono
                            </label>
                            <input type="text" class="form-control input-cert" name="celular"
                                value="{{ Auth()->user()->phone_number }}" required>

                            <input type="hidden" name="curso_id" value="{{ $curso->id }}">
                            <br>
                            <button class="a-menu a-menu-b" style="text-decoration: none" type="submit">SOLICITAR
                                CERTTIFICADO</button>

                        </form>
                    @endif

                </div>

                <div class="tab-pane fade" id="encuesta" role="tabpanel" aria-labelledby="encuesta-tab">
                    @if ($encuestas->count() > 0)
                        @foreach ($encuestas as $encuesta)
                            @if (Auth()->user()->EncuestaCurso($encuesta->curso_id, $encuesta->id) > 0)
                                <div class="col-xs-12 col-md-12" style="margin-bottom: 5%;">
                                    <h5 class="text-center c-white font-weight mt-5">{{ $encuesta->titulo }}</h5>
                                    <p class="text-center"> Gracias por responder la encuesta </p>
                                    <p class="text-center"><i style="color:#24db37;font-size: 45px"
                                            class="fas fa-check-circle"></i></p>

                                </div>
                            @else
                                <div class="col-xs-12 col-md-12" style="">
                                    <h5 class="text-center c-white font-weight mt-5" style="">
                                        {{ $encuesta->titulo }}</h5>
                                 <!-- encuesta_user -->
                                    <form class="" id="msform" enctype="multipart/form-data">
                                        {{ csrf_field() }}
                                    <table class="table encuesta_table mt-4 pbm-0">
                                        <thead>
                                            <tr>
                                                <th scope="col" rowspan="2">PREGUNTAS</th>
                                                <th scope="col" colspan="5" class="escala" style="padding:0.2%">
                                                    ESCALA DE IMPORTANCIA</th>
                                            </tr>
                                            <tr>
                                                <th scope="col">No me gustó</th>
                                                <th scope="col">Me gustó</th>
                                                <th scope="col">Me gustó mucho</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!--<form class="" action="{{ route('encuesta_user') }}" method="POST"-->
                                            <!--    enctype="multipart/form-data">-->
                                            <!--    {{ csrf_field() }}-->
                                                <input type="hidden" name="encuesta_id" value="{{ $encuesta->id }}">
                                                @foreach ($preguntas as $pregunta)
                                                    @if ($pregunta->encuesta_id == $encuesta->id)
                                                        @if ($pregunta->tipo_respuesta == 0)
                                                            <tr>
                                                                <th>{{ $pregunta->pregunta }}</th>
                                                                <td><input class="medium" type="radio"
                                                                        name="pregunta{{ $pregunta->id }}x"required
                                                                        value="1"></td>
                                                                <td><input class="medium" type="radio"
                                                                        name="pregunta{{ $pregunta->id }}x"required
                                                                        value="2"></td>
                                                                <td><input class="medium" type="radio"
                                                                        name="pregunta{{ $pregunta->id }}x"required
                                                                        value="3"></td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach

                                                @foreach ($preguntas as $pregunta)
                                                    @if ($pregunta->encuesta_id == $encuesta->id)
                                                        @if ($pregunta->tipo_respuesta == 1)
                                                            <tr>
                                                                <th>{{ $pregunta->pregunta }}</th>
                                                                <td colspan="4" class="textarea_encuesta">
                                                                    <textarea style="color:white!important" name="respuesta{{ $pregunta->id }}x" required="" width="100%"></textarea>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endif
                                                @endforeach

 

                                                <tr>
                                                    <th style="border:0px solid red!important;"></th>
                                                    <th colspan="5" style="border:0px solid red!important;"><button
                                                            type="submit" class="a-menu a-menu-b" id="enviar"
                                                            style="text-decoration: none;display:block;width:100%">ENVIAR
                                                            ENCUESTA</button></th>
                                                </tr>
                                                
                                        </tbody>
                                    </table>
                                </form>

                                </div>
                            @endif
                        @endforeach
                    @else
                        <p>Por el momento no hay encuestas para este curso, busque más tarde . . .</p>
                    @endif 
                </div>
           
           
           
                {{-- sponsor --}}
                @if($curso->Sponsors()>0)
                    <div class="tab-pane fade" id="sponsor" role="tabpanel" aria-labelledby="sponsor-tab">
    
                        <div class="row">
                            @foreach ($curso->sponsor() as $item)
                                @php
                                    $sponsor = App\Sponsor::where('id', $item->sponsor_id)->first();
                                    $sponsor_contacts = App\SponsorContact::where('sponsor_id', $sponsor->id)->first();
                                    $sponsor_materials = App\SponsorMaterial::where('sponsor_id', $sponsor->id)->first();
                                @endphp
                               <div class="col-3 d-flex justify-content-center align-items-center cursor-pointer"
                                        onclick='modalPatrocinador("{{ $sponsor->nombre }}","{{ $sponsor->url_web }}", "{{ $sponsor_contacts ? $sponsor_contacts->nombre : '' }}"
                                , "{{ $sponsor_contacts ? $sponsor_contacts->email : '' }}"
                                , "{{ $sponsor_materials ? $sponsor_materials->doc_name : '' }}"
                                , " {{ $sponsor_materials ? asset('pdfCurso/' . $sponsor_materials->url_doc) : '' }}" )'>

                                    <img class="img-fluid" width="70"
                                        src="{{ asset('imgCurso/' . $sponsor->url_logo) }}" alt="">
                                </div>
                            @endforeach
                        </div>
    
    
                        <div class="pop-patrocinador modal fade show" style="background-color: rgba(0, 0, 0, 0.5);">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius:15px;border:none">
                                    <div class="modal-body col-md-12 row pbm-0">
                                        <button type="button" class="close-pop" onclick="closePatrocinador()">
                                            <svg width="32" height="32" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="m13.414 12 4.293-4.293a.999.999 0 1 0-1.414-1.414L12 10.586 7.707 6.293a.999.999 0 1 0-1.414 1.414L10.586 12l-4.293 4.293a.999.999 0 1 0 1.414 1.414L12 13.414l4.293 4.293a.997.997 0 0 0 1.414 0 .999.999 0 0 0 0-1.414L13.414 12Z"
                                                    fill="white"></path>
                                            </svg>
                                        </button>
                                        <section
                                            class="col-md-10 col-xs-12 pbm-0 order-1 d-flex flex-column justify-content-center px-4 py-4"
                                            id="div-patrocinador">
                                        </section>
                                    </div>
                                </div>
                            </div>
                        </div>
    
    
                    </div>
                @endif
                
           
            </div>

        </section>
        {{-- TAB MODULOS --}}
        
        {{-- TAB VIDEO --}}
        <section class="col-md-7 col-xs-12 mx-auto">
            <br>
            @if ($clase->video_codigo != '')
                <div class="embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{{ $clase->video_codigo }}"
                        webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                </div>
            @else
                <img src="{{ asset('imgCurso/' . $clase->url_portada) }}" width="100%;">

                <div class="portada  pbm-0" id="portada">
                    <div id="cuenta" class="cuenta">

                    </div>
                </div>

                <main class="btn-reunion pmb-0">

                    <p class="text-center"><a class="nav-link a-menu a-menu-b a-ir" href="{{ $clase->zoom_codigo_url }}" style="display: inline">IR A LA SESIÓN</a></p>

                </main>
            @endif 
        </section>
        {{-- TAB VIDEO --}}

  </section>





  <section class="bg-white">

{{-- JHED FRONT V2 --}}
        {{-- <section class="col-md-10 mx-auto row pbm-0 mt-5 mt-2-mob padding-1"> --}}
        <section class="col-md-10 mx-auto row pbm-0 mt-5-web mt-10-mob padding-1">

          <h5 class="font-weight p-inline ">CURSOS RELACIONADOS</h5>

          @foreach($cursosrel as $cur)



               <section class="col-md-3 col-xs-12 card-curso card-curso-p">

                  <div class="img">

                    <a href="{{route('getcurso',$cur->slug)}}"><img src="{{asset('imgCurso/'.$cur->url_portada)}}" width="100%"></a>

                    @if($cur->fecha_culminacion >= date('Y-m-d'))

                    <span class="s-disponible s-proximamente">EN VIVO</span>

                    @else

                    <span class="s-disponible">REALIZADOS</span>



                    @endif

                  </div>

                  <div class="text">

                    <a href="{{route('getcurso',$cur->slug)}}" class="td-none"><h4 class="title font-weight">{{$cur->titulo}}</h4></a>

                    <a href="{{route('getAutor',$cur->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$cur->autor->nombre}}</p></a>

                    <p>{!!substr($cur->descripcion,0,75)!!}. . . </p>

                    <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$cur->countAlumnos()}}</p>

                    <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$cur->CountValoracion()}}</p>



                    <p class="mt-4"><a href="{{route('getcurso',$cur->slug)}}" class="a-transparent-g">VER CURSO</a></p>

                  </div>

                  

                </section>

              

            @endforeach



    </section>

  </section>

@endsection

@section('script-extra')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.js">
    </script>
    <script>
        // encuesta_user
        $(document).ready(function() {
            $("#enviar").click(function(e) {
                var $thisForm = $(this).parents("form");
                $thisForm.validate({
                    errorPlacement: function(error, element) {
                        $('span.error').remove();
                        if (element.is(":radio")) {
                            // error.appendTo('#radio');
                            $('<span class="error text-white pt-2 form-control-feedback">* Seleccione las opciones de la encuesta.</span>')
                                .appendTo('#radio');
                        } else {
                            element.after(
                                '<span class="error form-control-feedback">Este campo es obligatorio.</span>'
                            );
                        }

                    },
                    submitHandler: function() {
                        enviarForm($thisForm);
                        return false;
                    }
                })
            })
        })

        function enviarForm(form) {
            console.log("enviando datos...");
            var params = form.serialize();
            const $enviar = document.getElementById("enviar");
            loadbtn($enviar);
            console.log(params);
            $.ajax({
                type: 'POST',
                url: "{{ route('encuesta_user') }}",
                data: params,
                dataType: 'json',
                success: function(data) {
                    if (data.rpta == "ok") {
                        // location.reload();
                        location.href = "{{ route('getcurso', $curso->slug) }}";
                    } else {
                        toastr.error(
                            'Hubo un error con su registro. Inténtelo nuevamente.');
                        unloadbtn($enviar);
                    }
                },
                error: function(data) {
                    unloadbtn($enviar);
                }
            });
        }

        function loadbtn($btn) {
            $($btn).attr("disabled", "disabled");
            $($btn).attr("oldtext", $($btn).html());
            $($btn).empty();
            $($btn).append(
                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span><span class="sr-only">Loading...</span>'
            );
        }

        function unloadbtn($btn) {
            $($btn).empty();
            $($btn).html($($btn).attr("oldtext"));
            $($btn).removeAttr("disabled");
        }
    </script>

<script>

  //funcion para guardar like

  var token = '{{ csrf_token() }}';


        function modalPatrocinador(nombre, url, nameUser, correoUser, docName, docUrl) {
            $('.pop-patrocinador').fadeIn('slow');
           var section_material = '';
            var section_contacto = '';
            if (docName != '') {
                section_material = `
                <div class="col-10 py-2">
                    <h3>Material:</h3> 
                    <a href="${docUrl}" target="_blank">${docName}</a>
                </div>`
            }
            if (correoUser != '') {
                section_contacto = `
                    <div class="col-10 py-2">
                    <h3>Contacto:</h3> 
                    [${nameUser}] <a href="mailto:${correoUser}" target="_blank">${correoUser}</a>
                </div>`
            }
            $('#div-patrocinador').empty()
            $('#div-patrocinador').append(`
            <h3 class="font-weight text-start mt-2">
                ${nombre}
            </h3>
            <hr>
            <div class="col-10 py-2">
                <h3>Visitar Web:</h3> 
                <a href="${url}" target="_blank">${url}</a>
            </div>
           ${section_contacto}
           ${section_material}
            `)
        }

        function closePatrocinador() {
            $('.pop-patrocinador').fadeOut('slow');
        }
        
  function saveLike(curso_id) {

    var ruta = '{{route('savelikecurso')}}';



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

 

 function saveNotLike(curso_id) {

    



   

        location.reload();

     

  }





 $('#comentar').click(function(){

    var texto = $('#texto').val();

    var curso_id = {{$curso->id}};

    var ruta = '{{route('savecomentcurso')}}';

    if (!texto) {

      alert('¡Escribe un comentario!');

      $('#texto').focus();

      return;

    }

    $.ajax({

      url: ruta,

      type: 'POST',

      headers:{'X-CSRF-TOKEN':token},

      dataType:'json',

      data:{

        texto: texto,

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



  });

  //funcion para guardar respuesta

  function saveRespuesta(coment_id) {

    

    var textores = $('#respuesta'+coment_id).val();

    var ruta = '{{route('saverespuestacurso')}}';

    if (!textores) {

      alert('¡Escribe una respuesta!');

      $('#respuesta'+coment_id).focus();

      return;

    }

    $.ajax({

      url: ruta,

      type: 'POST',

      headers:{'X-CSRF-TOKEN':token},

      dataType:'json',

      data:{

        textores: textores,

        coment_id: coment_id

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

 <script src="{{asset('js/simplyCountdown.min.js')}}"></script>

  <script >

    simplyCountdown('#cuenta', {

      year: {{date('Y',strtotime($clase->fecha))}}, // required

      month: {{date('m',strtotime($clase->fecha))}}, // required

      day: {{date('d',strtotime($clase->fecha))}}, // required

      hours: {{date('H',strtotime($clase->time))}} - 5 , // Default is 0 [0-23] integer

      minutes: {{date('i',strtotime($clase->time))}}, // Default is 0 [0-59] integer

      seconds: 0, // Default is 0 [0-59] integer

      words: { //words displayed into the countdown

        days: 'Día',

        hours: 'Hora',

        minutes: 'Minuto',

        seconds: 'Segundo',

        pluralLetter: 's'

      },

      plural: true, //use plurals

      inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds

      inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true

      // in case of inline set to false

      enableUtc: true, //Use UTC as default

      onEnd: function() {

        document.getElementById('portada').classList.add('oculta');

        return; 

      }, //Callback on countdown end, put your own function here

      refresh: 1000, // default refresh every 1s

      sectionClass: 'simply-section', //section css class

      amountClass: 'simply-amount', // amount css class

      wordClass: 'simply-word', // word css class

      zeroPad: false,

      countUp: false

    });

  </script>

  <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>

@endsection


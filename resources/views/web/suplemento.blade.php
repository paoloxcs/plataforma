@extends('layouts.front')
@section('titulo','Suplemento Técnico')
@section('content')
  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 
    
    <section class="col-md-10 col-xs-12 mx-auto">
      <div id="carouselExampleCaptions" class="carousel slide mt-5 mt-0-mob" data-bs-ride="carousel">
        <div class="carousel-indicators">
          @foreach($sliders as $slide)
            @if($loop->iteration==1)
              <div class="none">{{$active="active"}}</div>
            @else
              <div class="none">{{$active=""}}</div>
            @endif
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="{{$loop->iteration - 1}}" class="{{$active}}" aria-current="true" aria-label="{{"Slide ".$loop->iteration}}"></button>
        @endforeach
          
        </div>

        <div class="carousel-inner">
          @foreach($sliders as $slide)
            @if($loop->iteration==1)
              <div class="none">{{$active="active"}}</div>
            @else
              <div class="none">{{$active="e"}}</div>
            @endif
          <div class="{{'carousel-item c-item '.$active}}">
            <a href="{{$slide->url}}">
              <img src="{{asset('imgRubro/'.$slide->img_desktop)}}" class=" w-100 none-mobile" alt="...">
              <img src="{{asset('imgRubro/'.$slide->img_phone)}}" class=" w-100 none-desktop" alt="...">
            </a>
            {{--<div class="carousel-caption d-none d-md-block text">
              <span class="p-rubro" style="text-transform: uppercase">{{$slide->rubro->nombrerubro}}</span>

             <h1 class="font-weight mt-3">{{$slide->titulo}}</h1>
            </div>--}}
          </div>
         @endforeach
        </div>  
      </div>
    </section>
    <section>

    </section>
    <section class="col-md-10 mx-auto row pbm-0 mt-5 mt-5-mob">
      <section class="col-md-12 col-lg-7">
        <h2 class="font-weight text-center-mob">SUPLEMENTO TÉCNICO</h2>
        <p class=" text-center-mob">Este suplemento es desarrollado por BLACKSA Consultores. desarrolladores de software para la construcción.</p>
        <p  class=" text-center-mob text-primary" style="font-weight: 800;">LOS PRECIOS DE ESTE SUPLEMENTO SON REFERENCIALES
PRECIOS NO INCLUYEN IGV</p>
         {{-- <p class=" text-center-mob text-primary" style="font-weight: 800;">ESTIMADOS SUSCRIPTORES, ESTAMOS MIGRANDO
            A UNA NUEVA PLATAFORMA
            PARA ENTREGARLES
            UN MEJOR SUPLEMENTO TÉCNICO, ESTOS CAMBIOS SE VERÁN REFLEJADOS PAULATINAMENTE EN NUESTRAS SIGUIENTES DOS
            EDICIONES. AGRADECEMOS SU COMPRENSIÓN Y ESTAMOS SEGUROS QUE ESTA NUEVA PLATAFORMA SERÁ DE GRAN BENEFICIO
            PARA USTEDES.</p>
        <p class=" text-center-mob text-primary" style="font-weight: 800;">LOS PRECIOS DE ESTE SUPLEMENTO SON
            REFERENCIALES Y ES IMPORTANTE QUE CONSULTEN
            CON SUS PROVEEDORES DE OBRA</p> --}}
        <p class=" text-center-mob">Consultas a <a href="mailto:precios@blacksa.com">precios@blacksa.com</a></p>
        
      </section>
      <section class="col-md-12 col-lg-5">
        <div class="suple row col-md-12 pbm-0 mt-5-mob">
          <div class="col-md-5 col-xs-5 pbm-0 bg-gris-black-0" style="padding:2% 15%">
            <img src="{{asset('revistas/'.$edicion->perspectiva)}}" width="90px">
          </div>
          <div class="col-md-7 col-xs-7 bg-white pbm-0 text-suple">
          {{-- <p><span class="s-edicion">EDICIÓN {{$edicion->nro}}</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> {{$edicion->fecha}} {{$edicion->año}}</span></p> --}}
                        <p class="mb-0">
                            <span class="s-edicion">EDICIÓN {{ $edicion->nro }}</span>
                        </p>
                        <p>
                            <span class="s-clock">
                                <i class="fas fa-calendar-alt"></i> {{ $edicion->fecha }} {{ $edicion->año }}
                            </span>
                        </p>
            

            <form action="{{route('changesuplemento')}}" method="GET">
              <select class="form-select form-select-sm select-suple mt-4" aria-label=".form-select-sm example" onchange="this.form.submit()" name="edicion" id="edicion">
                @foreach($ediciones as $edi)
                  @if($edi->nro == $edicion->nro)
                  <option selected value="{{$edi->nro}}">Edición {{$edi->nro}}</option>
                  @else
                  <option value="{{$edi->nro}}">Edición {{$edi->nro}}</option>
                  @endif
                @endforeach
              </select>
            </form>
          </div>


        </div>
      </section>


      <section class="col-md-12 mx-auto mt-5 mt-2-mob s-clase-nav s-suplemento-nav">
      
      <ul class="nav nav-tabs ul-suplemento" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Precios de presupuestos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Análisis de precios</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Especificaciones Técnicas de Grupos</button>
      </li>
      
    </ul>

    {{-- <div class="tab-content col-md-6 col-xs-12" id="myTabContent"> --}}
    <div class="tab-content col-md-12 col-lg-9 col-xl-6 col-xs-12" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      
          <section class="mt-5">
          @foreach($suplemento as $suple)
              @if($suple->idtiposuplemento == 1)
                 <section class="col-md-12 mt-2-mob row s-descarga s-descarga-white">
                  <div class="col-md-1 col-xs-1">
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}"><img src="{{asset('images/excel-a.png')}}" width="100%"></a>
                  </div>
                  <div class="col-md-11 col-xs-11">
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora" class="td-none"><p class="p-inline  "> {{$suple->nombre}}</p></a>
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora"><p class="p-inline  f-right"><i class="fas fa-download "></i></p></a>
                  </div>
                  
                </section>
              @endif
          @endforeach
           
          
        </section>


      </div>

      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 
        <section class="mt-5">

            @foreach($suplemento as $suple)
                @if($suple->idtiposuplemento == 2)
                   <section class="col-md-12 mt-2-mob row s-descarga s-descarga-white">
                    <div class="col-md-1 col-xs-1">
                      <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}"><img src="{{asset('images/excel-a.png')}}" width="100%"></a>
                    </div>
                    <div class="col-md-11 col-xs-11">
                      <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora" class="td-none"><p class="p-inline  "> {{$suple->nombre}}</p></a>
                      <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora"><p class="p-inline  f-right"><i class="fas fa-download "></i></p></a>
                    </div>
                    
                  </section>
                @endif
            @endforeach
        </section>
       

      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
          <section class="mt-5">

           @foreach($suplemento as $suple)
              @if($suple->idtiposuplemento == 3)
                 <section class="col-md-12 mt-2-mob row s-descarga s-descarga-white">
                  <div class="col-md-1 col-xs-1">
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}"><img src="{{asset('images/word-a.png')}}" width="100%"></a>
                  </div>
                  <div class="col-md-11 col-xs-11">
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora" class="td-none"><p class="p-inline  "> {{$suple->nombre}}</p></a>
                    <a href="{{url('downloadsumplemento/'.$suple->nroedicion.'/'.$suple->ruta)}}" data-toggle="tooltip" data-placement="bottom" title="Descargar ahora"><p class="p-inline  f-right"><i class="fas fa-download "></i></p></a>
                  </div>
                  
                </section>
              @endif
          @endforeach
          
        </section>

      </div>

    
    </div>

    </section>





    </section>
      
  </section>
@endsection
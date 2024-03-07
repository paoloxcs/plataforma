@extends('layouts.front')
@section('titulo')
{{$curso->titulo}}
@endsection
@section('content')
<div class="none">{{$a=($curso->rubro->slug)}}</div>
 
  <section class="col-md-10 mx-auto row pbm-0">
    <section class="col-md-8 col-xs-12">
      <div class="d-title">
        <p><span class="p-rubro" style="text-transform: uppercase;">{{$rubro->nombrerubro}}</span></p>
        <h3 class="title-cur font-weight">{{$curso->titulo}}</h3>

        <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p class="p-inline p-c-i"><i class="fas fa-user-tie "></i> {{$curso->autor->nombre}}</p></a>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up"></i> {{$curso->CountValoracion()}}</p>

        <p class="p-inline p-c-i p-m-l"> <span class="s-disponibles">DISPONIBLES</span></p>
        
      </div>
      @if($curso->fecha_culminacion < date('Y-m-d') and $curso->url_video_preview!="")
        <div class="d-img mt-4 embed-responsive embed-responsive-16by9">                            
            <iframe class="embed-responsive-item" src="https://player.vimeo.com/video/{{$curso->url_video_preview}}" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
          </div>
      @else
        <div class="d-img mt-4">
          <img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"> 
        </div>
      @endif

      <div class="col-md-12 mx-auto mt-1  mt-5-mob none-desktop">
           <h4 class="text-center font-weight">Acerca del autor</h4>
           <div class="col-md-9 col-xs-12 row mx-auto">
            <div class="col-md-4 col-xs-3">
              <img style="border-radius: 50%" src="{{asset('posts/'.$curso->autor->imagen)}}" width="100%">
            </div>
            <div class="col-md-8 col-xs-9">
              <h5>{{$curso->autor->nombre}}</h5>
              <a href="{{route('getAutor',$curso->autor->slug)}}" class="a-menu a-menu-b td-none">VER PERFIL</a>
            </div>
             
           </div>
        </div>
      

      

      <div class="descripción mt-4">
        
        

        
        <h4 class="font-weight c-green mt-4">Descripción</h4>
        <p>{!!$curso->descripcion!!}</p>

        @if($curso->objetivos)
        <h4 class="font-weight c-green mt-4">Objetivos</h4>
        <p>{!!$curso->objetivos!!}</p>
        @endif

        @if($curso->publico)
        <h4 class="font-weight c-green mt-4">¿A quién está dirigido?</h4>
        <p>{!!$curso->publico!!}</p>
        @endif

      </div>

      <div class="temario">
        <h4 class="font-weight">Temario del curso</h4>
        {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing eli  adipiscing eli</p>--}}

        <div class="accordion accordion-flush" id="accordionFlushExample">
          @foreach($clases as $clase)
            
            <div class="d-none">
              @if($loop->iteration==2)
                {{$show="show"}}
              @else
                {{$show=""}}
              @endif
              {{$collapse=""}} 
            {{$false="true"}}
          </div>
            
            <div class="accordion-item">
              <h2 class="accordion-header" id="{{'flush-heading'.$clase->id}}">
                <button style="color:black" class="{{'accordion-button font-weight '.$collapse}}" type="button" data-bs-toggle="collapse" data-bs-target="{{'#flush-collapse'.$clase->id}}" aria-expanded="{{$false}}" aria-controls="{{'flush-collapse'.$clase->id}}">
                  <i class="fas fa-angle-double-down" style="padding:0 5px 0 0"></i> {{$clase->titulo}}
                </button>
              </h2>
              <div id="{{'flush-collapse'.$clase->id}}" class="{{'accordion-collapse collapse '.$show}}" aria-labelledby="{{'flush-heading'.$clase->id}}" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  <p>{!!$clase->informacion!!}</p>

                  
                </div>
              </div>
          </div>
          @endforeach

        </div>
      </div>
      <div class="none-desktop">
      @if($curso->fecha_culminacion<=date('Y-m-d'))
        @if($curso->precio_c!=NULL)
            @if (!\Auth::guest()) 
              @if(Auth()->user()->isPremium())

                  <div class="card-suplemento  mt-3" id="card-suplemento">
                        <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                          <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                             
                      @if($descuento>0)
                      <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                      </span></p>
                      @endif

                      <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                      

                      <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                      Solo para suscriptores</span></p>

                            




                            <p class="text-center mt-2"><a href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                     
                        
                          </div>


                    </div>
                

              @else
                
                  <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                      <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                        <div class="bla mt-3">
                          <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                           
                    @if($descuento>0)
                    <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    </span></p>
                    @endif

                    <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                    

                    <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                    Solo para suscriptores</span></p>

                          



                        @if(!\Auth::guest())
                          <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{route('planes',$curso->rubro->slug)}}" style="cursor:pointer">COMPRAR CURSO</a>
                        @else

                          <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.route('planes',$curso->rubro->slug))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                   
                        @endif
                        </div>


                  </div>
                  

                 <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>

              @endif
            @else
              <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                  <div class="bla mt-3">
                    <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>

                    
                    @if($descuento>0)
                    <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    </span></p>
                    @endif

                    <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                    

                    <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                    Solo para suscriptores</span></p>

                    



                  @if(!\Auth::guest())
                    <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
                  @else

                    <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                             
                  @endif
                  </div>


            </div>
           
            <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>
                  

            @endif
        @endif
      @else
         @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
          <div class="d_descuento_p col-xs-12 mt-4">
          <div class="col-md-12 row mx-auto">
            <div class="col-md-4 col-xs-4 pbm-0">
              <p class="c-white p-porcentaje pbm-0">{{$curso->porcentaje_d_v}}%</p>
            </div>
            <div class="col-md-8 col-xs-8 pbm-0">
              <p class="c-white pbm-0">De descuento en el curso</p>
              <p class="font-weight c-white pbm-0">Válido hasta el {{$dia_n}} de {{$mes}} {{$año_n}}</p>
            </div>
          </div>
          
        </div>
        
        
        <div class="card-suplemento mt-3 mt-2-mob" id="card-suplemento">
            <h4 class="text-center font-weight">Obtén tu membresía para acceder a los dscto de este curso</h4>
              <div class="bla mt-3">
                <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">S/ {{$curso->precio}}</span></p>
                <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$precio_d_f_s}}</h2>
                <p class="text-center pbm-0"><a type="button"  data-bs-toggle="modal" data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>

                <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>
                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">S/ {{$curso->promocion}}</span></p>
                <p class="text-center pbm-0 font-weight"><span class="p-sus">S/ {{$promocion_d_p_s}}<span></span></p>
                @if($curso->rubro->slug=="arquitectura-y-diseno")
                          <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                          @endif
                          
                          @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                          <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                          @endif




              @if(!\Auth::guest())
                <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
              @else

                <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                         
              @endif
              </div>


        </div>
            {{-- CAMBIOS JHED --}}
          @include('web.card-pay')
            @if($curso->fecha_culminacion >= date('Y-m-d'))
              @include('web.form-curso')
            {{-- @else
              <span class="s-disponible">REALIZADOS</span> --}}
            @endif
          {{-- CAMBIOS JHED --}}
        @else
          <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
            <h4 class="text-center font-weight">Obtén tu membresía para acceder a los dscto de este curso</h4>
              <div class="bla mt-3">
                <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                
                <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->precio}}</h2>
                <p class="text-center pbm-0"><a type="button"  data-bs-toggle="modal" data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>

                <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>
                
                <p class="text-center pbm-0 font-weight"><span class="p-sus">S/ {{$curso->promocion}}<span></span></p>
                @if($curso->rubro->slug=="arquitectura-y-diseno")
                          <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                          @endif
                          
                          @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                          <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                          @endif




              @if(!\Auth::guest())
                <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
              @else

                <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                         
              @endif
              </div>


          </div>
          {{-- CAMBIOS JHED --}}
          @include('web.card-pay')
            @if($curso->fecha_culminacion >= date('Y-m-d'))
              @include('web.form-curso')
            {{-- @else
              <span class="s-disponible">REALIZADOS</span> --}}
            @endif
          {{-- CAMBIOS JHED --}}
        @endif
        @if($curso->rubro->slug=="arquitectura-y-diseno")
        <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>
        @endif
      @endif
    </div>


      @if($curso->beneficios)
        <div class="descripción mt-4">
          <h4 class="font-weight c-green mt-4">Beneficios</h4>
          <p>{!!$curso->beneficios!!}</p>
        </div>
        
      @endif

      <div class="valoraciones mt-5">
        <h4 class="font-weight">Valoraciones</h4>
        <div class="col-md-11 mx-auto row pbm-0 mt-4">
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-thumbs-up"></i> {{$curso->CountValoracion()}}</p>
            <p class="pbm-0 font-weight">Rating del curso</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
            <p class="pbm-0 font-weight">Alumnos</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-comment"></i> {{count($comentarios)}}</p>
            <p class="pbm-0 font-weight">Comentarios</p>
          </div>
        </div>
      </div>

      <div class="col-md-12 bg-gris-black row mt-4 " style="padding: 3% 2%;">
        <div class="col-md-7" style="padding: 3% 2%;">
          <h5 class="font-weight c-white">Certificado del curso</h5>
          <p>Al terminar el curso obtén un certificado emitido por Plataforma Constructivo que avale tus nuevos conocimientos y úsalo para diferenciarte a nivel internacional.</p>
        </div>
        <div class="col-md-5" >
          @if($curso->certificado!="")
          <img src="{{asset('imgCurso/'.$curso->certificado)}}" width="100%">
          @else
          <img src="{{asset('images/certificado.jpg')}}" width="100%">
          @endif
        </div>
        
      </div>
      <div class="s-bene-mob none-desktop">
        
      </div>

      <div class="valoraciones mt-5 none-mobile" style="padding-bottom: 5%;">
        <h4 class="font-weight">Comentarios</h4>

        <div class="col-md-11 mx-auto row pbm-0 mt-4">
          @if(count($comentarios) > 0)
            @foreach($comentarios as $coment)

            <div class="row col-md-12 mt-3">
              <div class="col-md-1 pbm-0 " >
                
                @if($coment->user->url_foto != null)
                  <img src="{{asset('fotousers/'.$coment->user->url_foto)}}" class="br-50" width="80%">
                @else
                 <img src="{{asset('fotousers/profile.png')}}" class="br-50" width="80%">
                @endif
              </div>
              <div class="col-md-11 pbm-0">
                <h6 class="font-weight mt-2" style="text-transform: none;">{{$coment->user->name}}</h6>
                <p style="margin-bottom:  0"  >{{$coment->texto}}</p>
                <p class=" c-green pbm-0"> <a type="button"   data-bs-toggle="modal" data-bs-target="#modal-responder{{$coment->id}}" class="c-green td-none font-weight" style="margin-top: -10px"  >Responder</a></p>
              </div>
            </div>

            <div class="modal fade" id="modal-responder{{$coment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog modal-md modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:   15px">
                <div class="modal-body col-md-12 row pbm-0" >
                  <section class="col-md-12 pbm-0 s-login" style="  padding:  1% 3%"  >
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="col-md-12 row">
                        <div class="col-md-2 pbm-0">
                            <img src="{{asset('images/user-coment.png')}}" width="70%">
                        </div>
                        <div class="col-md-10 pbm-0">
                          <h6 class="font-weight mt-2">Responder  a {{$coment->user->name}}</h6>
               
                          <textarea class="form-control" placeholder="Respuesta . . ." id="floatingTextarea2" style="height: 100px"></textarea>

                          
                          @if(!\Auth::guest())
                          <p class=" mt-3"><a class="a-menu a-menu-b" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#modal-suscri">RESPONDER</a> </p>
                          @else
                          <p class=" mt-3"><a class="a-menu a-menu-b" style="text-decoration: none" href="{{url('/login?redirect_to='.route('getcurso',$curso->slug))}}">RESPONDER</a> </p>      
                          @endif
                        </div>    
                      </div>   

                  </section>
                  {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}

                 
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
              <img src="{{asset('images/user-coment.png')}}" class="br-50" width="80%">
            </div>
            <div class="col-md-11 pbm-0">
              <h6 class="font-weight mt-2">ESCRIBE UNA VALORACION</h6>
              <form>
                 <textarea class="form-control" placeholder="Valoración . . ." id="floatingTextarea2" style="height: 100px"></textarea>

                 <p class="mt-2 font-weight">¿Recomiendas este curso? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                  @if(!\Auth::guest())

                    <span class="s-coment" style="cursor:pointer"><a data-bs-toggle="modal" data-bs-target="#modal-suscri"><i class="fas fa-thumbs-up"></i> SI</a></span>
                    <span class="s-coment" style="cursor:pointer"><a data-bs-toggle="modal" data-bs-target="#modal-suscri"><i class="fas fa-thumbs-down"></i> NO</a></span></p>
                  @else

                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getcurso',$curso->slug))}}"><i class="fas fa-thumbs-up"></i> SI</a></span>
                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getcurso',$curso->slug))}}"><i class="fas fa-thumbs-down"></i> NO</a></span></p>         
                  @endif
                 

                 
                @if(!\Auth::guest())
                    <a class="a-menu a-menu-b" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#modal-suscri">COMENTAR</a>
                @else
                     <a class="a-menu a-menu-b" style="text-decoration: none;cursor:pointer" href="{{url('/login?redirect_to='.route('getcurso',$curso->slug))}}">COMENTAR</a>         
                @endif
              </form>

              <div class="modal fade" id="modal-suscri" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-sm modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius:   15px">
                    <div class="modal-body col-md-12 row pbm-0" >
                      <section class="col-md-12 pbm-0 s-login">
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>


                           <h4 class="modal-title text-center text-danger font-weight-bold" id="exampleModalLabel font-weight" style="font-weight: 700">¡ ADVERTENCIA !</h4>
                           <hr>

                           <h5 class="text-center">Si desea escribir una valoración, debe estar <span class="font-weight">suscrito </span>en el curso.  </h5>

                      </section>
                     
                    </div>
                    <div class="modal-footer text-center">
                      <p class="text-center"> <a href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" class="btn btn-outline-success font-weight" data-dismiss="modal" >Suscribirme</a>

                        <a type="button"  data-bs-dismiss="modal"  class="btn btn-outline-danger font-weight" style="margin-top: 5%">Seguir en la página</a></p>
                        
                      </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
          
        </div>
      </div>




      



        <div class="modal fade" id="modal-precioD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog modal-xs modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius:   20px">

              <div class="modal-body col-md-12 row pbm-0" >
                <section class="col-md-12  pbm-0" style="width:100%">

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="position:absolute;right:2%;top:2%"></button>

                  <div class="card-suplemento mt-3 mt-5-mob" style="margin-top: 0!important ">
                      <h4 class="text-center font-weight">Obtén tu membresía para acceder a los dscto. de este curso</h4>
                        @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
                          <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                            <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">$ {{$curso->precio_d}}</span></p>
                            <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">$ </span>&nbsp;&nbsp;{{$precio_d_f_d}}</h2>
                            

                            <h5 class="text-center pbm-0 font-weight mt-3">Precio suscriptor </h5>
                            <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">$ {{$curso->promocion_d}}</span></p>
                            <h5 class="text-center pbm-0 font-weight mt-2"> <span class="p-sus">$ {{$promocion_d_p_d}}<span></span></h5>

                            @if($curso->rubro->slug=="arquitectura-y-diseno")
                            <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                            @endif
                            
                            @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                            <p class="mt-3  text-center-mob text-center">Incluye 1 año en la Plataforma Constructivo</p>
                            @endif



                          
                           @if(!\Auth::guest())
                            <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'usd')}}" style="cursor:pointer">COMPRAR CURSO</a>
                          @else

                            <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'usd'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                     
                          @endif
                          </div>
                        @else
                          <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                            
                            <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">$ </span>&nbsp;&nbsp;{{$curso->precio_d}}</h2>
                            

                            <h5 class="text-center pbm-0 font-weight mt-3">Precio suscriptor </h5>
                            
                            <h5 class="text-center pbm-0 font-weight"> <span class="p-sus">$ {{$curso->promocion_d}}<span></span></h5>

                            @if($curso->rubro->slug=="arquitectura-y-diseno")
                            <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                            @endif
                            
                            @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                            <p class="mt-3  text-center-mob text-center">Incluye 1 año en la Plataforma Constructivo</p>
                            @endif



                          
                           @if(!\Auth::guest())
                            <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'usd')}}" style="cursor:pointer">COMPRAR CURSO</a>
                          @else

                            <p class="text-center mt-2"><a href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'usd'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                     
                          @endif
                          </div>

                        @endif
                        

                        <div class="col-md-12 pbm-0 row mt-3">
                          <div class="col-md-2 col-xs-2">
                            <img src="{{asset('images/icon-1.png')}}" width="105%">
                          </div>
                          <div class="col-md-10 col-xs-10">
                            <p class="font-weight"> Cursos 100% Online.  </p>
                          </div>
                        </div>

                        <div class="col-md-12 pbm-0 row mt-3">
                          <div class="col-md-2 col-xs-2">
                            <img src="{{asset('images/icon-2.png')}}" width="105%">
                          </div>
                          <div class="col-md-10 col-xs-10">
                            <p class="font-weight"> Pago 100% seguro, gracias a  nuestra pasarela de pago.
                          </p>
                          </div>
                        </div>

                  </div>
                </section>
               
              </div>
            </div>
          </div>
        </div>


    </section>
    <section class="col-md-4 col-xs-12 col-card-plan s-bene-mob none-mobile">

      <div class="col-md-12 mx-auto mt-1 none-mobile  mt-5-mob">
           <h4 class="text-center font-weight">Acerca del autor</h4>
           <div class="col-md-9 col-xs-12 row mx-auto">
            <div class="col-md-4 col-xs-3">
              <img style="border-radius: 50%" src="{{asset('posts/'.$curso->autor->imagen)}}" width="100%">
            </div>
            <div class="col-md-8 col-xs-9">
              <h5>{{$curso->autor->nombre}}</h5>
              <a href="{{route('getAutor',$curso->autor->slug)}}" class="a-menu a-menu-b td-none">VER PERFIL</a>
            </div>
             
           </div>
        </div>
      @if($curso->fecha_culminacion<=date('Y-m-d'))
        @if($curso->precio_c!=NULL)
            @if (!\Auth::guest()) 
              @if(Auth()->user()->isPremium())

                  <div class="card-suplemento  mt-3" id="card-suplemento">
                        <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                          <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                             
                      @if($descuento>0)
                      <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                      </span></p>
                      @endif

                      <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                      

                      <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                      Solo para suscriptores</span></p>

                            




                            <p class="text-center mt-2"><a href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                     
                        
                          </div>


                    </div>
                

              @else
                
                  <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                      <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                        <div class="bla mt-3">
                          <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                           
                    @if($descuento>0)
                    <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    </span></p>
                    @endif

                    <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                    

                    <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                    Solo para suscriptores</span></p>

                          



                        @if(!\Auth::guest())
                          <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{route('planes',$curso->rubro->slug)}}" style="cursor:pointer">COMPRAR CURSO</a>
                        @else

                          <p class="text-center mt-2"><a  href="{{url('/login?redirect_to='.route('planes',$curso->rubro->slug))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                                   
                        @endif
                        </div>


                  </div>
                  

                 <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>
                  
                  


              @endif
            @else
              <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                  <div class="bla mt-3">
                    <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>

                    
                    @if($descuento>0)
                    <p class="text-center pbm-0 font-weight"><span class="p-sus">{{$descuento}}% Dscto. <span style="font-size: 17px; text-decoration: line-through">S/. {{$curso->precio_c}}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> 
                    </span></p>
                    @endif

                    <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->promocion_c}}</h2>
                    

                    <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar" style="font-size:18px">
                    Solo para suscriptores</span></p>

                    



                  @if(!\Auth::guest())
                    <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
                  @else

                    <p class="text-center mt-2"><a  href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                             
                  @endif
                  </div>


            </div>

            <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>
                  

            @endif
        @endif
      @else
        @if($curso->porcentaje_d_v>0 and $curso->fecha_d_v>=date('Y-m-d'))
          <div class="d_descuento_p col-xs-12 mt-4">
          <div class="col-md-11 row mx-auto">
            <div class="col-md-4 col-xs-4 pbm-0">
              <p class="c-white p-porcentaje pbm-0">{{$curso->porcentaje_d_v}}%</p>
            </div>
            <div class="col-md-8 col-xs-8 pbm-0">
              <p class="c-white pbm-0">De descuento en el curso</p>
              <p class="font-weight c-white pbm-0">Válido hasta el {{$dia_n}} de {{$mes}} {{$año_n}}</p>
            </div>
          </div>
          
        </div>
        
        
        <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
            <h4 class="text-center font-weight">Obtén tu membresía para acceder a los dscto de este curso</h4>
              <div class="bla mt-3">
                <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">S/ {{$curso->precio}}</span></p>
                <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$precio_d_f_s}}</h2>
                <p class="text-center pbm-0"><a type="button"  data-bs-toggle="modal" data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>

                <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>
                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight" style="text-decoration:line-through;">S/ {{$curso->promocion}}</span></p>
                <p class="text-center pbm-0 font-weight"><span class="p-sus">S/ {{$promocion_d_p_s}}<span></span></p>
                @if($curso->rubro->slug=="arquitectura-y-diseno")
                          <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                          @endif
                          
                          @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                          <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                          @endif




              @if(!\Auth::guest())
                <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
              @else

                <p class="text-center mt-2"><a  href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                         
              @endif
              </div>


        </div>
      {{-- CAMBIOS JHED --}}
          @include('web.card-pay')
            @if($curso->fecha_culminacion >= date('Y-m-d'))
              @include('web.form-curso')
            {{-- @else
              <span class="s-disponible">REALIZADOS</span> --}}
            @endif
          {{-- CAMBIOS JHED --}}
        @else
          <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
            <h4 class="text-center font-weight">Obtén tu membresía para acceder a los dscto de este curso</h4>
              <div class="bla mt-3">
                <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                
                <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;"><span class="s-simbolo">S/</span>&nbsp;&nbsp;{{$curso->precio}}</h2>
                <p class="text-center pbm-0"><a type="button"  data-bs-toggle="modal" data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>

                <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>
                
                <p class="text-center pbm-0 font-weight"><span class="p-sus">S/ {{$curso->promocion}}<span></span></p>
                @if($curso->rubro->slug=="arquitectura-y-diseno")
                          <p class="text-center pbm-0"><a href="{{route('planes',$rubro->slug)}}" class="v-dolar v-planes">Ver nuestros planes</a></p>
                          @endif
                          
                          @if($curso->rubro->slug=="construccion" or $curso->rubro->slug=="mineria" )
                          <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                          @endif




              @if(!\Auth::guest())
                <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{url('/curso/card/'.$curso->slug.'/'.'pen')}}" style="cursor:pointer">COMPRAR CURSO</a>
              @else

                <p class="text-center mt-2"><a  href="{{url('/login?redirect_to='.url('/curso/card/'.$curso->slug.'/'.'pen'))}}" class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR CURSO</a></p>
                         
              @endif
              </div>


          </div>
             {{-- CAMBIOS JHED --}}
          @include('web.card-pay')
            @if($curso->fecha_culminacion >= date('Y-m-d'))
              @include('web.form-curso')
            {{-- @else
              <span class="s-disponible">REALIZADOS</span> --}}
            @endif
          {{-- CAMBIOS JHED --}}
        @endif

        @if($curso->rubro->slug=="arquitectura-y-diseno")
        <div class="card-suplemento mt-3 mt-5-mob card-suplemento" >
                      <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos los cursos</h5>
                        <div class=" mt-3">
                          <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de capacitaciones, publicaciones y mucho más!</p>

                          <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion" class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase" style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>
                                   
                       
                        </div>


                  </div>
        @endif
      @endif
        


  

    

    </section>


  </section>

@endsection
@section('script-extra')

<script>
 


  function collidesWith (element1, element2) 
  {
   var Element1 = {}; 
   var Element2 = {}; 

   Element1.top = $(element1).offset().top; 
   Element1.left = $(element1).offset().left; 
   Element1.right = Number($(element1).offset().left) + Number($(element1).width()); 
   Element1.bottom = Number($(element1).offset().top) + Number($(element1).height()); 
   Element2.top = $(element2).offset().top; Element2.left = $(element2).offset().left; 
   Element2.right = Number($(element2).offset().left) + Number($(element2).width()); 
   Element2.bottom = Number($(element2).offset().top) + Number($(element2).height()); 

  if (Element1.right > Element2.left && Element1.left < Element2.right && Element1.top < Element2.bottom && Element1.bottom > Element2.top) {  } }






 </script>

 
@endsection 
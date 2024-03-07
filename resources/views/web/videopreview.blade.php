@extends('layouts.front')
@section('titulo')
VIDEO: {{$post->titulo}}
@endsection
@section('content')
<div class="none"></div>
  <section class="col-md-10 mx-auto row pbm-0">
    <section class="col-md-8 col-xs-12">
      <div class="d-title">
        <p>
            
          {{-- TAG VIDEO --}}
          @if(date("Y-m-d",strtotime($post->fecha."+ 7 day")) >= date('Y-m-d')) 
              <span class="s-disponible s-proximamente" style="background: #ff1313;color:#fff;font-size: 12px;padding: 4px 8px;font-weight: 700;">NUEVO</span>  
          @endif
           {{-- TAG GRATUITO --}}
        @if ($post->acceso == '0')
            <span class="s-disponible s-proximamente"
                style="background: #2436db;;color:#fff;font-size: 12px;padding: 4px 8px;font-weight: 700;">GRATUITO</span>
        @endif
            <span class="p-rubro tt-uppercase">{{$post->subcategoria->categoria->rubro->slug}}</span>
        </p>
        <h3 class="title-cur font-weight">{{$post->titulo}}</h3>

        <p class="p-inline p-c-i"><i class="fas fa-user-tie "></i> <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none" style="color:black">{{$post->autor->nombre}}</a></p>
        
        {{-- TAG VIDEO --}}
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-calendar"></i> {{$post->fecha}}</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-clock"></i> {{$post->video->duracion}}</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{$post->CountVistas()}}</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$post->CountValoracion()}}</p></p>
        
      </div>
       
      <div class="col-md-12">

       <iframe src="https://player.vimeo.com/video/{{$post->video->url_preview}}" class="embed-responsive-item" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>
       
      </div>                           
          


      <div class="descripcion mt-4" style="font-size:16px">
        <h5>{!!$post->infoadd!!}</h5>

        
      </div>

      <div class="col-md-12 mx-auto mt-4 mt-2-mob none-desktop">
           <h4 class="text-center font-weight">Acerca del autor</h4>
           <div class="col-md-9 col-xs-11 row mx-auto">
            <div class="col-md-4 col-xs-3">
              <img style="border-radius: 50%" src="{{asset('posts/'.$post->autor->imagen)}}" width="100%">
            </div>
            <div class="col-md-8 col-xs-8">
              <h5>{{$post->autor->nombre}}</h5>
              <a href="{{route('getAutor',$post->autor->slug)}}" class="a-menu a-menu-b td-none">VER PERFIL</a>
            </div>
             
           </div>
        </div>
     

      <div class="valoraciones mt-5">
        <h4 class="font-weight">Valoraciones</h4>
        <div class="col-md-11 mx-auto row pbm-0 mt-4">
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-thumbs-up"></i> {{$post->valoraciones->count()}} </p>
            <p class="pbm-0 font-weight">Rating del curso</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-user"></i> {{$post->clicks->count()}}</p>
            <p class="pbm-0 font-weight">Alumnos</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-comment"></i> {{$post->comentarios->count()}}</p>
            <p class="pbm-0 font-weight">Comentarios</p>
          </div>
        </div>
      </div>

      <div class="valoraciones mt-5 none-mobile" style="padding-bottom: 5%;">
        <h4 class="font-weight">Comentarios</h4>

        <div class="col-md-11 mx-auto row pbm-0 mt-4">
          @if(count($post->comentarios) > 0)
            @foreach($post->comentarios()->orderBy('id','desc')->get() as $coment)

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
                          <p class=" mt-3"><a class="a-menu a-menu-b" style="text-decoration: none" href="{{url('/login?redirect_to='.route('getvideo',$post->slug))}}">RESPONDER</a> </p>      
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

                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getvideo',$post->slug))}}"><i class="fas fa-thumbs-up"></i> SI</a></span>
                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getvideo',$post->slug))}}"><i class="fas fa-thumbs-down"></i> NO</a></span></p>         
                  @endif
                 

                 
                @if(!\Auth::guest())
                    <a class="a-menu a-menu-b" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#modal-suscri">COMENTAR</a>
                @else
                     <a class="a-menu a-menu-b" style="text-decoration: none;cursor:pointer" href="{{url('/login?redirect_to='.route('getvideo',$post->slug))}}">COMENTAR</a>         
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

                           <h5 class="text-center">Si desea escribir una valoración, debe tener una suscripción <span class="font-weight">Premium </span>.  </h5>

                      </section>
                     
                    </div>
                    <div class="modal-footer text-center">
                      <p class="text-center"> <a href="{{route('planes',$post->subcategoria->categoria->rubro->slug)}}" class="btn btn-outline-success font-weight"  >Suscribirme</a>

                        <a type="button"  data-bs-dismiss="modal"  class="btn btn-outline-danger font-weight" style="margin-top: 5%">Seguir en la página</a></p>
                        
                      </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
          
        </div>
      </div>


      <br>
      <br>
    </section>
    <section class="col-md-4 col-xs-12 col-card-plan s-bene-mob">
      <div class="col-md-12 mx-auto mt-4 mt-2-mob none-mobile">
           <h4 class="text-center font-weight">Acerca del autor</h4>
           <div class="col-md-9 col-xs-10 row mx-auto">
            <div class="col-md-4 col-xs-3">
              <img style="border-radius: 50%" src="{{asset('posts/'.$post->autor->imagen)}}" width="100%">
            </div>
            <div class="col-md-8 col-xs-8">
              <h5>{{$post->autor->nombre}}</h5>
              <a href="{{route('getAutor',$post->autor->slug)}}" class="a-menu a-menu-b td-none">VER PERFIL</a>
            </div>
             
           </div>
        </div>

      <div class="card-suplemento mt-3 mt-0-mob">
      		<h4 class="text-center font-weight">¿QUIERES VER LA CAPACITACIÓN COMPLETA?</h4>
      			<div class="bla mt-3">
	      			<img src="{{asset('images/calidad-premium.png')}}">
	      			<h2 class="font-weight pbm-0 text-center mt-3">¡CAPACÍTATE</h2>
	      			<h4 class="font-weight pbm-0 text-center">
	      			hoy mismo!</h4>


	      		<a class="a-menu a-menu-b nav-link text-center mt-3" href="{{route('planes',$post->subcategoria->categoria->rubro->slug)}}">VER PLANES</a>
	      		</div>

      	</div>
        
    </section>
  </section>
@endsection

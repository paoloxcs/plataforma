@extends('layouts.front')
@section('titulo','ARTICULO: '.$post->titulo)


@section('content')
<div class="none"></div>
  <section class="col-md-10 col-xs-12 mx-auto row pbm-0">
    <section class="col-md-8 col-xs-12">
      <div class="d-title">
        <p><span class="p-rubro tt-uppercase">{{$post->subcategoria->categoria->rubro->slug}}</span></p>
        <h3 class="title-cur font-weight">{{$post->titulo}}</h3>

       <p class="p-inline p-c-i"><i class="fas fa-user-tie "></i>  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none" style="color:black">{{$post->autor->nombre}}</a></p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> {{$post->CountVistas()}}</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up"></i> {{$post->CountValoracion()}}</p>

        <p class="p-inline p-c-i p-m-l"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</p>
        
      </div>
      <div class="d-img mt-4">
        <img src="{{asset('posts/'.$post->image)}}" width="100%"> 
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
                          <p class=" mt-3"><a class="a-menu a-menu-b" style="text-decoration: none" href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}">RESPONDER</a> </p>      
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

                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}"><i class="fas fa-thumbs-up"></i> SI</a></span>
                      <span class="s-coment" style="cursor:pointer"><a href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}"><i class="fas fa-thumbs-down"></i> NO</a></span></p>         
                  @endif
                 

                 
                @if(!\Auth::guest())
                    <a class="a-menu a-menu-b" style="text-decoration: none" data-bs-toggle="modal" data-bs-target="#modal-suscri">COMENTAR</a>
                @else
                     <a class="a-menu a-menu-b" style="text-decoration: none;cursor:pointer" href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}">COMENTAR</a>         
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


    </section>
    <section class="col-md-4 mt-5 mt-0-mob col-card-plan col-xs-12 s-bene-mob" >
      
          <div class="col-md-12 mx-auto mt-5 mt-0-mob mt-2-mob none-mobile" >
               <h4 class="text-center font-weight mt-5 mt-0-mob">Acerca del autor</h4>
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

      <div class="mt-5 mt-0-mob" >
        <p class="mt-5 mt-2-mob">{{$post->infoadd}}</p>


      
        <div class="col-md-12 row">
          {{--<div class="col-md-3">
            <a class="nav-link a-menu a-menu-b"  type="button"   data-bs-toggle="modal" data-bs-target="#modal-login"></i> DESCARGA  </a>
          </div>--}}
          <div class="col-md-12">
            <p class="mt-2 font-weight">¿Recomiendas este artículo? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="s-coment">

              @if(!\Auth::guest())
               <a  type="button"   data-bs-toggle="modal" data-bs-target="#modal-suscri"><i class="fas fa-thumbs-up"></i> SI</a></span> <span class="s-coment">

              <a type="button"   data-bs-toggle="modal" data-bs-target="#modal-suscri"><i class="fas fa-thumbs-down"></i> NO</a></span></p> 

              <a data-bs-toggle="modal" data-bs-target="#modal-suscri" class="td-none" style="cursor:pointer"><p class="text-center mt-4"><span class=" a-menu a-menu-b" style="font-size: 18px"><i class="fas fa-download"></i>  LEER ARTÍCULO AQUÍ  </span></p></a>

             @else

             
               <a  type="button"   href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}"><i class="fas fa-thumbs-up"></i> SI</a></span> <span class="s-coment">

              <a type="button"   href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}"><i class="fas fa-thumbs-down"></i> NO</a></span></p> 

              <a href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}" class="td-none" style="cursor:pointer"><p class="text-center mt-4"><span class=" a-menu a-menu-b" style="font-size: 18px"><i class="fas fa-download"></i>  LEER ARTÍCULO AQUÍ  </span></p></a>
              
             @endif

          </div>
        </div>
      </div>

      <div class="col-md-12 mx-auto mt-5 mt-5-mob mt-2-mob none-desktop" >
               <h4 class="text-center font-weight mt-5 mt-0-mob">Acerca del autor</h4>
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
     
        
        @if(!\Auth::guest())
          <div class="card-suplemento mt-5">
            <h4 class="text-center font-weight">¿QUIERES VER EL ARTÍCULO COMPLETO?</h4>
              <div class="bla mt-3">
                <img src="{{asset('images/calidad-premium.png')}}">
                <h2 class="font-weight pbm-0 text-center mt-3">¡CAPACÍTATE</h2>
                <h4 class="font-weight pbm-0 text-center">
                hoy mismo!</h4>


            

                
                  <a class="a-menu a-menu-b nav-link text-center mt-3" href="{{route('planes',$post->subcategoria->categoria->rubro->slug)}}">VER PLANES</a>
               
              </div>

          </div>
        @else
          <div class="card-suplemento mt-5">
           <h4 class="text-center font-weight">¿QUIERES VER EL ARTÍCULO COMPLETO?</h4>
              <div class="bla mt-3">
                <img src="{{asset('images/calidad-premium.png')}}">
                <h2 class="font-weight pbm-0 text-center mt-3">¡REGÍSTRATE</h2>
                <h4 class="font-weight pbm-0 text-center">
                hoy mismo!</h4>


            

                
                  <a class="a-menu a-menu-b nav-link text-center mt-3" type="button"  href="{{url('/login?redirect_to='.route('getarticulo',$post->slug))}}">REGISTRARME</a>
               
              </div>

          </div>        
        @endif

        
    </section>
  </section>
@endsection
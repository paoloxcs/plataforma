@extends('layouts.front')
@section('titulo','ARTICULO: '.$post->titulo)


@section('content')
<div class="none"></div>
  <section class="col-md-10 col-xs-12 mx-auto row pbm-0">
    <section class="col-md-8 col-xs-12">
      <div class="d-title mt-2-mob">
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
                <h6 class="font-weight mt-2" style="text-transform: none;">{{$coment->user->fullname()}}</h6>
                <p style="margin-bottom:  0"  >{{$coment->texto}}</p>
                <p class=" c-green pbm-0"> <a type="button"   data-bs-toggle="modal" data-bs-target="#modal-responder{{$coment->id}}" class="c-green td-none font-weight" style="margin-top: -10px"  >Responder</a></p>
              </div>
            </div>

             @foreach($coment->respuestas as $resp)
              @if($resp->comentario_id == $coment->id)
                <div class="row col-md-12 mt-3">
                  <div class="col-md-1 pbm-0 " >
                   </div> 
                   <div class="col-md-1 pbm-0 " >  
                    @if($resp->user->url_foto != null)
                      <img src="{{asset('fotousers/'.$resp->user->url_foto)}}" class="br-50" width="80%">
                    @else
                     <img src="{{asset('fotousers/profile.png')}}" class="br-50" width="80%">
                    @endif
                  </div>
                  <div class="col-md-10 pbm-0">
                    <h6 class="font-weight mt-2" style="text-transform: none;">{{$resp->user->fullname()}}</h6>
                    <p style="margin-bottom:  0"  >{{$resp->texto}}</p>
                    
                  </div>
                </div>
              @endif
             @endforeach



            <div class="modal fade" id="modal-responder{{$coment->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog modal-md modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:   15px">
                <div class="modal-body col-md-12 row pbm-0" >
                  <section class="col-md-12 pbm-0 s-login" style="  padding:  1% 3%"  >
                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      <div class="col-md-12 row">
                        <div class="col-md-2 pbm-0 mt-4">
                            @if(Auth()->user()->url_foto != null)
                              <img src="{{asset('fotousers/'.Auth()->user()->url_foto)}}" width="70%">
                            @else
                             <img src="{{asset('fotousers/profile.png')}}" width="70%">
                            @endif
                        </div>
                        <div class="col-md-10 pbm-0">
                          <h6 class="font-weight mt-2">Responder  a {{$coment->user->fullname()}}</h6>
               
                          <textarea class="form-control" placeholder="Ingrese su respuesta . . ." id="respuesta{{$coment->id}}" style="height: 100px"></textarea>

                          <p class=" mt-3"><a class="a-menu a-menu-b" style="text-decoration: none" type="button" onclick="saveRespuesta({{$coment->id}});">RESPONDER</a> </p>
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
              @if(Auth()->user()->url_foto != null)
                  <img src="{{asset('fotousers/'.Auth()->user()->url_foto)}}" class="br-50" width="80%">
              @else
                  <img src="{{asset('fotousers/profile.png')}}" class="br-50" width="80%">
              @endif
            </div>
            <div class="col-md-11 pbm-0">
              <h6 class="font-weight mt-2">ESCRIBE UNA VALORACION</h6>
              <form>
                 <textarea class="form-control" placeholder="Valoración . . ." id="texto" style="height: 100px"></textarea>

                 <p class="mt-2 font-weight">¿Recomiendas este artículo? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
               

                    <span class="s-coment" style="cursor:pointer"><a type="button" onclick="saveLike({{$post->idpost}});"><i class="fas fa-thumbs-up"></i> SI</a></span>
                    <span class="s-coment" style="cursor:pointer"><a type="button" onclick="saveNotLike({{$post->idpost}});"><i class="fas fa-thumbs-down"></i> NO</a></span></p>

                 
                 

                 
                
                    <a class="a-menu a-menu-b" style="text-decoration: none"  type="submit" id="comentar">COMENTAR</a>
               
              </form>

              


            </div>
          </div>
          
        </div>
      </div>


    </section>
    <section class="col-md-4 mt-5 mt-0-mob col-card-plan col-xs-12 s-bene-mob">

       <div class="col-md-12 mx-auto mt-5 mt-0-mob mt-2-mob none-mobile"  >
           <h4 class="text-center font-weight">Acerca del autor</h4>
           <div class="col-md-8 row mx-auto">
            <div class="col-md-4">
              <img style="border-radius: 50%" src="{{asset('posts/'.$post->autor->imagen)}}" width="100%">
            </div>
            <div class="col-md-8">
              <h5>{{$post->autor->nombre}}</h5>
              <a href="{{route('getAutor',$post->autor->slug)}}" class="a-menu a-menu-b td-none">VER PERFIL</a>
            </div>
             
           </div>
        </div>


      <div class="mt-5 mt-5 mt-0-mob">
        <p class="mt-5 mt-2-mob">{{$post->infoadd}}</p>

      
        <div class="col-md-12 row">
          {{--<div class="col-md-3">
            <a class="nav-link a-menu a-menu-b"  type="button"   data-bs-toggle="modal" data-bs-target="#modal-login"></i> DESCARGA  </a>
          </div>--}}
          <div class="col-md-12">
            {{-- JHED FRONT V2 --}}
                 <p class="mt-2 font-weight">¿Recomiendas este artículo? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
                    <div class="text-center">
                      <span class="s-coment" style="cursor:pointer"><a type="button" onclick="saveLike({{$post->idpost}});">
                        <i class="fas fa-thumbs-up"></i> SI</a>
                      </span>
                      <span class="s-coment" style="cursor:pointer"><a type="button" onclick="saveNotLike({{$post->idpost}});">
                        <i class="fas fa-thumbs-down"></i> NO</a>
                      </span>
                    </div>
                  </p>
            <a href="{{route('downloadarticulo',$post->idpost)}}" title="Descargar" class="td-none" style="cursor:pointer"><p class="text-center mt-4"><span class=" a-menu a-menu-b" style="font-size: 18px"><i class="fas fa-download"></i>  LEER ARTÍCULO AQUÍ </span></p></a>
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

     
      {{--<div class="card-suplemento mt-5">
          <h4 class="text-center font-weight">¿QUIERES VER EL ARTÍCULO COMPLETO?</h4>
            <div class="bla mt-3">
              <img src="{{asset('images/calidad-premium.png')}}">
              <h2 class="font-weight pbm-0 text-center mt-3">¡REGÍSTRATE</h2>
              <h4 class="font-weight pbm-0 text-center">
              hoy mismo!</h4>


            <a class="a-menu a-menu-b nav-link text-center mt-3" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">REGISTRARME</a>
            </div>

        </div>--}}
    </section>
  </section>
@endsection
@section('script-extra')
<script>
  //funcion para guardar like
  var token = '{{ csrf_token() }}';
  function saveLike(post_id) {
    var ruta = '{{route('savelikepost')}}';

    $.ajax({
      url: ruta,
      type: 'POST',
      headers:{'X-CSRF-TOKEN': token},
      dataType: 'json',
      data:{
        post_id: post_id
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

  function saveNotLike(post_id) {
    

   
        location.reload();
     
  }
  //funcion para marcar como favorito
  function saveMarker(post_id) {
    var ruta = '{{route('savemarker')}}';
    $.ajax({
      url: ruta,
      type: 'POST',
      headers:{'X-CSRF-TOKEN': token},
      dataType: 'json',
      data:{
        post_id: post_id
      },
      success:function(data){
        console.log(data);
        alert('¡Artículo marcado como favorito!');
        location.reload();
      },
      error:function(data){
        console.log(data);
      }
    });
  }
  //funcion para guardar comentario
  $('#comentar').click(function(){
    var texto = $('#texto').val();
    var post_id = {{$post->idpost}};
    var ruta = '{{route('savecoment')}}';
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
        post_id: post_id
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
    var ruta = '{{route('saverespuesta')}}';
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
@endsection
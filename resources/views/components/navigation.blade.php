  {{-- CAMBIOS JHED --}}
      <section class="none-desktop menu-mobile mt-2 col-md-12 row pbm-0 ">
        <section class="col-sm-1">
          <a type="button"   data-bs-toggle="modal" data-bs-target="#modal-menu"><span class="s-m-icon"><i class="i-con-m fas fa-bars"></i></span></a>
        </section>
        <section class="col-sm-4">
          <a href="/"><img src="{{asset('images/logo.png')}}"  width="105px" style="margin-top:7px;margin-left: 12px"></a>
        </section>
        <section class="col-sm-2">
         
        </section>
        <!-- <section class="col-sm-1">
          <a href="/search"><span class=""><i class="i-con-m fas fa-search"></i></span></a>
        </section> -->
         {{-- CAMBIOS JHED --}}
        <section class="col-sm-1">
          {{-- New Buscador --}}
          <div style="cursor: pointer;"><span id="icon_search_mobile" ><i class="i-con-m fas fa-search"></i></span></div>
        </section>
        {{-- CAMBIOS JHED --}}
        <section class="col-sm-4 ">
          

           @if(Auth::guest())
            <a class="nav-link a-menu a-menu-b m-none text-center" type="button"  data-bs-toggle="modal" data-bs-target="#modal-login">ENTRAR</a>
            @else

            <li class="dropdown nav-item m-none" style="background: white;color:black;list-style: none;padding:0%;">
              <a class="  nav-link a-menu tt-uppercase" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style=" color:black;padding:0%;">
                <i class="fas fa-user"></i > &nbsp; HOLA, {{ Auth::user()->name }} &nbsp;<i style="color:#24db37;font-size: 22px"class="fas fa-caret-down"></i>
              </a>

              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item font-weight" href="{{route('getmicuenta')}}" style="border-bottom: #d5d6db 1px solid;">Mi cuenta</a></li>
                <li>
                <li><a class="dropdown-item font-weight" href="{{route('getmiscursosp')}}" style="border-bottom: #d5d6db 1px solid;">Mis cursos</a></li>
                <li>
                    {{-- JHED EJECUTIVO --}}
                @if(show_btnEjecutivo())
                  <li><a class="dropdown-item font-weight" href="{{route('executive.index')}}" style="border-bottom: #d5d6db 1px solid;">Panel Ejecutivo</a></li>
                @endif
                {{-- JHED EJECUTIVO --}}
                @if(show_btnPanel())
                      <a class="dropdown-item font-weight"  style="border-bottom: #d5d6db 1px solid;" href="{{url('/panel')}}"> Ir a Panel</a>
                    @endif
                </li>
                  <a href="{{ route('logout') }}" class="dropdown-item font-weight"
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                        Cerrar sesión
                   </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                </li>
              </ul>
            </li >
            @endif
        </section>

      </section>


         <!-- <section class="col-md-10 row pbm-0 s-menu mx-auto none-mobile">
        <section class="col-md-2">
          <a href="/"><img src="{{asset('images/logo.png')}}" class="img-logo"></a>
        </section>
        <section class="col-md-4"> -->
        {{-- CAMBIOS JHED --}}
      <section class="col-md-12 row pbm-0 s-menu mx-auto none-mobile mb-3">
        <section class="col-md-2 d-flex justify-content-center align-items-top" style="margin-left: 20px;margin-right: -20px;">
          <a href="/"><img src="{{asset('images/logo.png')}}" class="img-logo"></a>
        </section>
        <section class="col-md-5">
        {{-- CAMBIOS JHED --}}
          <ul class="nav nav-pills mt-2">
            {{--<li class="nav-item dropdown" >
              <a class="nav-link a-menu" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">CATEGORÍAS&nbsp; &nbsp;<i class="fas fa-caret-down"></i></a>
              <ul class="dropdown-menu">
                <p class="text-center font-weight">¿Qué quieres aprender?</p>
                <li class="li-menu"><a class="dropdown-item" href="/construccion">CONSTRUCCIÓN</a></li>
                <li class="li-menu"><a class="dropdown-item" href="/construccion">ARQUITECTURA Y DISEÑO</a></li>
                <li class="li-menu"><a class="dropdown-item" href="/construccion">MINERÍA</a></li>
              
              </ul>
            </li>--}}

            <li class="nav-item">
              {{-- LINK CATEGORIA --}}
              <span class="nav-link a-menu a-m-categoria cursor-pointer" href="">CATEGORÍAS&nbsp; &nbsp;<i class="fas fa-caret-down"></i></span>
            </li>
            <li class="nav-item">
              <a class="nav-link a-menu a-menu-nav m-none" href="{{route('planes',$a)}}">PLANES</a>
            </li>
            

            <li class="nav-item" style="font-weight: 14px">
              <a class="nav-link a-menu a-menu-nav m-none" href="{{route('empresas')}}">PARA EMPRESAS</a>
            </li>
          </ul>
        </section>
       <!-- <section class="col-md-3 m-none">

                <form class="" action="{{url('search')}}" method="GET">
                  {{ csrf_field() }}
                  <div class="input-group mb-3 mt-2 i-buscador">
                      <input type="text" class="form-control" name="text" placeholder="Buscar . . ." >
                      <button class="btn" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                   
                  </div>
               </form>
            </section> -->
        
        <!-- <section class="col-md-3">
           <ul class="nav nav-pills mt-2"> -->
        {{-- CAMBIOS JHED --}}
        <section class="col-md-5 d-flex justify-content-end">
           <ul class="nav nav-pills nav_access_btn">
            <li class="nav-item">
              <div style="cursor: pointer;"><span id="icon_search"  class="form-control i-buscador" style="border-radius: 25px"><i class="i-con-m fas fa-search" style="margin-top: 4px;"></i></span></div>
            </li> 
         {{-- CAMBIOS JHED --}}    
            @if(Auth::guest())
              <li class="nav-item">
                <a class="nav-link a-menu m-none" type="button"   data-bs-toggle="modal" data-bs-target="#modal-login"><i class="fas fa-user"></i> &nbsp;&nbsp;INGRESAR</a>
              </li>
              <li class="nav-item" style="font-weight: 14px">
                <a class="nav-link a-menu a-menu-b m-none" type="button"  data-bs-toggle="modal" data-bs-target="#modal-create">CREAR CUENTA</a>
              </li>
            @else

            <li class="dropdown nav-item m-none" style="background: white;color:black">
              <a class="  nav-link a-menu tt-uppercase" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false" style=" color:black;">
                <i class="fas fa-user"></i > &nbsp; HOLA, {{ Auth::user()->name }} &nbsp;<i style="color:#24db37;font-size: 22px"class="fas fa-caret-down"></i>
              </a>

              <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <li><a class="dropdown-item font-weight" href="{{route('getmicuenta')}}" style="border-bottom: #d5d6db 1px solid;">Mi cuenta</a></li>
                <li>
                <li><a class="dropdown-item font-weight" href="{{route('getmiscursosp')}}" style="border-bottom: #d5d6db 1px solid;">Mis cursos</a></li>
                <li>
                {{-- JHED EJECUTIVO --}}
                @if(show_btnEjecutivo())
                  <li><a class="dropdown-item font-weight" href="{{route('executive.index')}}" style="border-bottom: #d5d6db 1px solid;">Panel Ejecutivo</a></li>
                @endif
                {{-- JHED EJECUTIVO --}}
                @if(show_btnPanel())
                      <a class="dropdown-item font-weight"  style="border-bottom: #d5d6db 1px solid;" href="{{url('/panel')}}"> Ir a Panel</a>
                    @endif
                </li>
                  <a href="{{ route('logout') }}" class="dropdown-item font-weight"
                    onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">
                        Cerrar sesión
                   </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                </li>
              </ul>
            </li >
            @endif


           
          </ul>
        </section>
      </section>
      
      {{-- CAMBIOS JHED --}}
      {{-- Cuerpo Buscador --}}
      <section class="bg-white col-md-12 justify-content-center align-items-center col-xs-12 mx-auto" style="position: absolute;z-index:100;display:none" id="section_search">
       <div class="col-md-4 col-sm-8 mt-0">
        <button id="btn_close_search" style="display:flex;color:rgb(255, 8, 8);margin-left: auto;background: transparent;border: none;" type="button"><i class="fas fa-times"></i></button>
        <form class="" action="{{url('search')}}" method="GET">
          {{ csrf_field() }}
          <div class="input-group mb-3 mt-2 i-buscador">
              <input type="text" class="form-control" name="text" placeholder="Buscar . . ." >
              <button class="btn" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
            
          </div>
        </form>
       </div>
      </section> 
      {{-- CAMBIOS JHED --}}
      
      <section class="col-md-8 mx-auto bg-white row s-m-rubro d-none pbm-0 none-mobile" style="padding-top:0!important;margin-top:0; z-index:2000!important">
        <section class="col-md-3 s-aprender pbm-0" style="padding-top:0!important;margin-top:0; ">
          <h6 class="font-weight text-center">¿QUÉ QUIERES APRENDER?</h6>

          <a href="{{route('getRubro','construccion')}}" class="li-rubros li-rubro mt-3 li-r-c li-r-active">CONSTRUCCIÓN <i class="fas fa-angle-right"></i></a>
          <a href="{{route('getRubro','mineria')}}" class="li-rubros li-rubro li-r-m">MINERÍA <i class="fas fa-angle-right"></i></a>
          <a href="{{route('getRubro','arquitectura-y-diseno')}}" class="li-rubros li-rubro li-r-a">ARQUITECTURA Y DISEÑO <i class="fas fa-angle-right"></i></a> 

        </section>
        <section class="col-md-2">

          <div class="s-aprender m-rubros m-construccion" id="m-construccion">
            <h5 class="mt-4"></h5>

            <a href="{{route('getcursosP','construccion')}}" class="li-rubros li-post li-p-c mt-3 li-p-active li-cu-c">CURSOS <i class="fas fa-angle-right"></i></a>
            <a href="/videos/rubro/construccion" class="li-rubros li-post li-p-c li-ca-c">CAPACITACION<i class="fas fa-angle-right"></i></a>
            <a href="/revistas/RC" class="li-rubros li-post li-p-c li-re-c ">REVISTAS <i class="fas fa-angle-right"></i></a>
            <a href="/articulos/rubro/construccion" class="li-rubros li-post li-p-c li-ar-c">ARTÍCULOS <i class="fas fa-angle-right"></i></a>
            <a href="/suplemento-tecnico" class="li-rubros li-post li-p-c li-su-c">SUPLEMENTO <i class="fas fa-angle-right"></i></a>
       
          </div>

          <div class="s-aprender m-rubros d-none" id="m-mineria">
            <h5 class="font-weight text-center mt-4"></h5>

            <a href="{{route('getcursosP','mineria')}}" class="li-rubros li-post li-p-m mt-3 li-p-active li-cu-m">CURSOS <i class="fas fa-angle-right"></i></a>
            <a href="/videos/rubro/mineria" class="li-rubros li-post li-p-m li-ca-m">CAPACITACION<i class="fas fa-angle-right"></i></a>
            <a href="/revistas/TM" class="li-rubros li-post li-p-m li-re-m">REVISTAS <i class="fas fa-angle-right"></i></a>
            <a href="/articulos/rubro/mineria" class="li-rubros li-post li-p-m li-ar-m">ARTÍCULOS <i class="fas fa-angle-right"></i></a>
       
          </div>

           <div class="s-aprender m-rubros d-none" id="m-arquitectura">
            <h5 class="font-weight text-center mt-4"></h5>

            <a href="{{route('getcursosP','arquitectura-y-diseno')}}" class="li-rubros li-post li-p-a mt-3 li-p-active li-cu-a">CURSOS <i class="fas fa-angle-right"></i></a>
            <a href="/series/rubro/arquitectura-y-diseno" class="li-rubros li-post li-p-a li-se-a">SERIES<i class="fas fa-angle-right"></i></a>
            <a href="/videos/rubro/arquitectura-y-diseno" class="li-rubros li-post li-p-a li-ca-a">CAPACITACION<i class="fas fa-angle-right"></i></a>
            <a href="/revistas/DA" class="li-rubros li-post li-p-a li-re-a">REVISTAS <i class="fas fa-angle-right"></i></a>
            <a href="/articulos/rubro/arquitectura-y-diseno" class="li-rubros li-post li-p-a li-ar-a">ARTÍCULOS <i class="fas fa-angle-right"></i></a>

            
       
          </div>
           
        </section>
        <section class="col-md-7 bg-gris">

              

          <div class="col-md-12 d-menu-r row cu-construccion  c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMOS CURSOS</h5>
              @foreach($cursosC as $curso)
              
              <section class="col-md-6 card-curso card-curso-p">
              <div class="img">
                <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                @if($curso->fecha_culminacion >= date('Y-m-d'))
                    <span class="s-disponible s-proximamente">EN VIVO</span>
                    @else
                    <span class="s-disponible">REALIZADOS</span>

                    @endif
              </div>
              <div class="text">
                <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h5 class="title font-weight">{{$curso->titulo}}</h5></a>
               <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
              </div>
              
            </section>

            @endforeach
          </div>

          <div class="col-md-12 d-menu-r row ca-construccion d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS CAPACITACIONES</h5>
              @foreach($videosC as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="img">
                  <a href="{{route('getvideo',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                   {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
                </div>
                <div class="text">
                  <a  href="{{route('getvideo',$post->pslug)}}" class="td-none"><h5 class="title font-weight">{{$post->titulo}}</h5></a>
                  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                </div>
                
              </section>
              @endforeach

          </div>

          <div class="col-md-12 row d-menu-r re-construccion d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS REVISTAS</h5>
              @foreach($revistasC as $revista)
                <section class="col-md-6 card-curso card-revista card-curso-p">
                  <div class="img bg-gris-black-0" style="">
                    <a href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}"><img src="{{asset('revistas/'.$revista->perspectiva)}}" ></a>
                    <span class="s-disponible">DISPONIBLES</span>
                  </div>
                  <div class="text">
                    <p><span class="s-edicion"> <a  href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}" class="td-none" style="color:white">EDICIÓN {{$revista->nro}}</a></span> <span class="s-clock"><i class="fas fa-calendar-alt">&nbsp;&nbsp;</i>{{$revista->fecha}}</span></p>
                  </div>
                  
                </section>
              @endforeach
          </div>

          <div class="col-md-12 row d-menu-r ar-construccion d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMOS ARTÍCULOS</h5>
              @foreach($articulosC as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="text">
                  <a href="{{route('getarticulo',$post->pslug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>
                  <a href="{{route('getarticulo',$post->pslug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                  <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                  <p>{!!substr($post->infoadd,0,65)!!}. . . </p>
                  <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> </i> {{$post->valoraciones->count()}}</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->clicks->count()}}</p>
                   <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads->count()}}</p>

                  
                </div>
                
              </section>

            @endforeach

          </div>    

          <div class="col-md-12 row su-construccion d-menu-r d-none c-c-active">
              <h5 class="font-weight mt-2">SUPLEMENTO</h5>

              <section class="col-md-8 mx-auto">
                <div class="card-suplemento">
                  <a href="{{route('suplementos')}}"><img style="border-radius: 15px" src="{{asset('images/SuplementoConstructivo.jpg')}}" width="100%"></a>

                </div>
            </section>

          </div>


          {{--MINERIA--}}

          <div class="col-md-12 d-menu-r row cu-mineria d-none c-c-active">
                <h5 class="font-weight mt-2">ÚLTIMOS CURSOS</h5>

               @foreach($cursosM as $curso)
              
              <section class="col-sm-6 card-curso ">
              
            
              <div class="img">
                <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                @if($curso->fecha_culminacion >= date('Y-m-d'))
                    <span class="s-disponible s-proximamente">EN VIVO</span>
                    @else
                    <span class="s-disponible">REALIZADOS</span>

                    @endif
              </div>
              <div class="text" style="height: auto;">
                <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h5 class="title font-weight">{{$curso->titulo}}</h5></a>
                 <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
              </div>

            </section>

            @endforeach
          </div>

          <div class="col-md-12 d-menu-r row ca-mineria d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS CAPACITACIONES</h5>
              @foreach($videosM as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="img">
                  <a href="{{route('getvideo',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                   {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
                </div>
                <div class="text">
                  <a  href="{{route('getvideo',$post->pslug)}}" class="td-none"><h5 class="title font-weight">{{$post->titulo}}</h5></a>
                  
                  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                </div>
                
              </section>
              @endforeach
          </div>

          <div class="col-md-12 row d-menu-r re-mineria d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS REVISTAS</h5>
              
              @foreach($revistasM as $revista)
                <section class="col-md-6 card-curso card-revista card-curso-p">
                  <div class="img bg-gris-black-0" style="">
                    <a href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}"><img src="{{asset('revistas/'.$revista->perspectiva)}}" ></a>
                    <span class="s-disponible">DISPONIBLES</span>
                  </div>
                  <div class="text">
                    <p><span class="s-edicion"> <a  href="{{'revista/'.$revista->medio.'/'.$revista->nro}}" class="td-none" style="color:white">EDICIÓN {{$revista->nro}}</a></span> <span class="s-clock"><i class="fas fa-calendar-alt"></i>{{$revista->fecha}}</span></p>
                  </div>
                  
                </section>
              @endforeach
          </div>

          <div class="col-md-12 row d-menu-r ar-mineria d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMOS ARTÍCULOS</h5>

              @foreach($articulosM as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="text">
                  <a href="{{route('getarticulo',$post->pslug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>
                  <a href="{{route('getarticulo',$post->pslug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                  <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                  <p>{!!substr($post->infoadd,0,65)!!}. . . </p>
                  <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> </i> {{$post->valoraciones->count()}}</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->clicks->count()}}</p>
                   <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads->count()}}</p>

                  
                </div>
                
              </section>

            @endforeach

          </div>  

          {{--ARQUITECTURA--}}

          <div class="col-md-12 d-menu-r row cu-arquitectura d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMOS CURSOS</h5>
               @foreach($cursosA as $curso)
              
              <section class="col-md-6 card-curso card-curso-p">
              <div class="img">
                <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                @if($curso->fecha_culminacion >= date('Y-m-d'))
                    <span class="s-disponible s-proximamente">EN VIVO</span>
                    @else
                    <span class="s-disponible">REALIZADOS</span>

                    @endif
              </div>
              <div class="text">
                <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h5 class="title font-weight">{{$curso->titulo}}</h5></a>

                   <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
            
              </div>
              
            </section>

            @endforeach
          </div>

          <div class="col-md-12 d-menu-r row se-arquitectura d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS SERIES</h5>
              @foreach($seriesA as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="img">
                  <a href="{{route('getserie',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                   {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
                </div>
                <div class="text">
                  <a  href="{{route('getserie',$post->pslug)}}" class="td-none"><h5 class="title font-weight">{{$post->titulo}}</h5></a>
                  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                </div>
                
              </section>
              @endforeach
          </div>


          <div class="col-md-12 d-menu-r row ca-arquitectura d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS CAPACITACIONES</h5>
              @foreach($videosA as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="img">
                  <a href="{{route('getvideo',$post->pslug)}}"><img src="{{asset('posts/'.$post->image)}}" width="100%"></a>
                   {{--<span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span>--}}
                </div>
                <div class="text">
                  <a  href="{{route('getvideo',$post->pslug)}}" class="td-none"><h5 class="title font-weight">{{$post->titulo}}</h5></a>
                  <a href="{{route('getAutor',$post->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span> &nbsp;{{$post->autor->nombre}}</p></a>
                </div>
                
              </section>
              @endforeach
          </div>

          <div class="col-md-12 row d-menu-r re-arquitectura d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMAS REVISTAS</h5>
              
              @foreach($revistasA as $revista)
                <section class="col-md-6 card-curso card-revista card-curso-p">
                  <div class="img bg-gris-black-0" style="">
                    <a href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}"><img src="{{asset('revistas/'.$revista->perspectiva)}}" ></a>
                    <span class="s-disponible">DISPONIBLES</span>
                  </div>
                  <div class="text">
                    <p><span class="s-edicion"> <a  href="{{'revista/'.$revista->medio.'/'.$revista->nro}}" class="td-none" style="color:white">EDICIÓN {{$revista->nro}}</a></span> <span class="s-clock"><i class="fas fa-calendar-alt"></i>{{$revista->fecha}}</span></p>
                  </div>
                  
                </section>
              @endforeach
          </div>

          <div class="col-md-12 row d-menu-r ar-arquitectura d-none c-c-active">
              <h5 class="font-weight mt-2">ÚLTIMOS ARTÍCULOS</h5>

              @foreach($articulosA as $post)
                <section class="col-md-6 card-curso card-curso-p">
                <div class="text">
                  <a href="{{route('getarticulo',$post->pslug)}}"><img class="img-pdf" src="{{asset('images/pdf-a.png')}}"></a>
                  <a href="{{route('getarticulo',$post->pslug)}}" class="td-none"><h4 class="title font-weight">{{$post->titulo}}</h4></a>
                  <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i> {{date('d/m/Y',strtotime($post->paper->fechaimp))}}</span></p>
                  <p>{!!substr($post->infoadd,0,65)!!}. . . </p>
                  <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i> </i> {{$post->valoraciones->count()}}</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{$post->clicks->count()}}</p>
                   <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i> {{$post->downloads->count()}}</p>

                  
                </div>
                
              </section>

            @endforeach
          </div>  




        </section>
      </section>
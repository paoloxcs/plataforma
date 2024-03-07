@extends('layouts.front')
@section('titulo', 'Mis cursos')
@section('content')
  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 
    
     
   <section class="col-md-10 col-xs-12 mx-auto ">
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

        <div class="carousel-inner ">
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

    <section class="col-md-10 col-xs-12  mx-auto row pbm-0 mt-5">
      <a href="{{route('getmicuenta')}}" class="td-none"><h5 class="title-c">MI CUENTA</h5></a>
    </section>


    <div class="d-flex align-items-start col-md-10 col-xs-12 mx-auto row">
      <div class="nav flex-column nav-pills  col-md-2 col-xs-12  mt-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <br>
        <button class="nav-link btn-left active none-mobile" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">MIS CURSOS</button>

       {{-- <button class="nav-link btn-left" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">MIS INTERESES</button>

        <button class="nav-link btn-left" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">MIS FAVORITOS</button>--}}

        
      </div>
      <div class="tab-content col-md-10 col-xs-12 mt-1" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

          <h5 class="font-weight  text-center-mob">MIS CURSOS</h5>
          {{--<h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>--}}
          <div class="col-md-12 row mt-2">
            <div class="col-md-12 row pbm-0 mt-2-mob">
            @if(Auth()->user()->isAdmin() or Auth()->user()->isSuscriptorManager() or Auth()->user()->isSuscriptorSupport() or Auth()->user()->isInvitado())
                 @foreach($cursos as $curso)

                   <section class="col-md-4 col-sm-12 card-curso card-curso-p mt-2-mob">
                      <div class="img">
                        <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                        @if($curso->fecha_culminacion >= date('Y-m-d'))
                        <span class="s-disponible s-proximamente">EN VIVO</span>
                        @else
                        <span class="s-disponible">REALIZADOS</span>

                        @endif
                      </div>
                      <div class="text">
                        <a href="{{route('getRubro',$curso->rubro->slug)}}" style="color:black" class="td-none"><span class="p-rubro" style="text-transform: uppercase;">{{$curso->rubro->nombrerubro}}</span></a>
                        <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h4 class="title font-weight">{{$curso->titulo}}</h4></a>
                        <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
                        <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
                        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$curso->CountValoracion()}}</p>

                        @if($curso->fecha_culminacion >= date('Y-m-d'))
                          <p class="mt-4"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO</a></p>

                        @else
                          <p class="mt-4"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO REALIZADO</a></p>


                        @endif
                      </div>
                      
                    </section>
                  
                @endforeach
            @else
                @foreach($cursos as $curso)
                  @if(Auth()->user()->SuscriptorCursos($curso->id) or Auth()->user()->SuscriptorCursosG($curso->id) )
                    <section class="col-md-4 col-sm-12 card-curso card-curso-p mt-2-mob">
                      <div class="img">
                        <a href="{{route('getcurso',$curso->slug)}}"><img src="{{asset('imgCurso/'.$curso->url_portada)}}" width="100%"></a>
                        @if($curso->fecha_culminacion >= date('Y-m-d'))
                        <span class="s-disponible s-proximamente">EN VIVO</span>
                        @else
                        <span class="s-disponible">REALIZADOS</span>

                        @endif
                      </div>
                      <div class="text">
                        <a href="{{route('getRubro',$curso->rubro->slug)}}" style="color:black" class="td-none"><span class="p-rubro" style="text-transform: uppercase;">{{$curso->rubro->nombrerubro}}</span></a>
                        <a href="{{route('getcurso',$curso->slug)}}" class="td-none"><h4 class="title font-weight">{{$curso->titulo}}</h4></a>
                        <a href="{{route('getAutor',$curso->autor->slug)}}" class="td-none"><p  class="name-d"><span><i class="fas fa-user-tie"></i></span>  &nbsp;{{$curso->autor->nombre}}</p></a>
                        <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{$curso->countAlumnos()}}</p>
                        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> {{$curso->CountValoracion()}}</p>

                        @if($curso->fecha_culminacion >= date('Y-m-d'))
                          <p class="mt-4"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO</a></p>

                        @else
                          <p class="mt-4"><a href="{{route('getcurso',$curso->slug)}}" class="a-transparent-g">VER CURSO REALIZADO</a></p>


                        @endif
                      </div>
                      
                    </section>
                  @endif
                @endforeach 
            @endif

            @if(Auth()->user()->countCursos()>0)
            <div class="font-weight p-right mt-5 d-flex justify-content-center ">
                {{$cursos->render('layouts.pagination')}}
            </div>
            @else
            <p class="mt-4">Cursos no disponibles</p>
            <p><a href="/" class="a-menu a-menu-b" type="submit" style="text-decoration: none">EMPEZAR</a></p>
            @endif


        </div>
          </div>


        </div>

        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
          <h5 class="font-weight p-inline">MIS INTERESES</h5>
          <h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>
          <br><br>

          <div class="col-md-12 row mt-2">
              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>
              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>
              <section class="col-md-4 card-curso card-curso-p">
                <div class="img">
                  <a href=""><img src="{{asset('images/c-proximamente.png')}}" width="100%"></a>
                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor <span class="s-clock"><i class="fas fa-calendar-alt"></i> 00/00/00</span></p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

               <h5 class="font-weight p-right mt-3">Página 1 de 3 <span class="btn-c-g"><i class="fas fa-arrow-left"></i></span>  <span class="btn-c-g"><i class="fas fa-arrow-right"></i></span></h5>



          </div>
        </div>
      </div>
    </div>



  </section>
@endsection
@extends('layouts.front')

@section('titulo','Revistas')

@section('content')

  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 

    

    <section class="col-md-10 mx-auto">

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

    <section class="col-md-10 mx-auto row pbm-0 mt-5 mt-2-mob">

      <h5 class="title-c font-weight">REVISTAS</h5>

    </section>





    <div class="d-flex align-items-start col-md-10 col-xs-12 mx-auto row">

      <div class="nav flex-column nav-pills  col-md-2 COL-XS-12  mt-3 padding-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">

        <h5 class="font-weight ">Mostrar Todos </h5>

        <br>

        <button class="nav-link btn-left active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Revistas disponibles</button>



        {{--<button class="nav-link btn-left" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Proximamente</button>--}}

        

      </div>

      <div class="tab-content col-md-10 mt-3" id="v-pills-tabContent">

        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

          <h5 class="font-weight p-inline">REVISTAS DISPONIBLES</h5>

          {{--<h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>--}}

          <br><br>



          <div class="col-md-12 row mt-2">

            @foreach($revistas as $revista)



              <section class="col-md-4 col-xs-12 card-curso card-revista card-curso-p mt-2-mob">

                  <div class="img bg-gris-black-0" style="">

                    <a href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}"><img src="{{asset('revistas/'.$revista->perspectiva)}}" ></a>

                    <span class="s-disponible">DISPONIBLES</span>

                  </div>

                  <div class="text text-info-curso">

                    <p><span class="s-edicion"> <a  href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}" class="td-none" style="color:white">EDICIÓN {{$revista->nro}}</a></span> <span class="s-clock"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;{{$revista->fecha}}&nbsp;{{$revista->año}}</span></p>

                    {{--<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>--}}

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> {{$revista->clicks()->count()}}</p>



                  

                  <section class="s-button text-center">

                     <p class="text-center-mob"><a href="{{'/revista/'.$revista->medio.'/'.$revista->nro}}" class="a-transparent-g">VER REVISTA</a></p>

                  </section>

                  </div>

                  

               </section>





            @endforeach

              

                <div class="font-weight p-right mt-5 d-flex justify-content-center ">

                {{$revistas->render('layouts.pagination')}}

              </div>



          </div>





        </div>



        <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">



          <h5 class="font-weight p-inline">PRÓXIMAMENTE</h5>

          <h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>

          <br><br>

          <div class="col-md-12 row mt-2">

              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>



              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>



              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>



              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>

              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>

              <section class="col-md-4 card-curso card-curso-p">

                <div class="img">

                  <a href=""><img src="{{asset('images/revista-p.png')}}" width="100%"></a>

                  <span class="s-disponible s-proximamente">PRÓXIMAMENTE</span>

                </div>

                <div class="text">

                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>

                  <p><span class="s-edicion">EDICIÓN 151</span> <span class="s-clock"><i class="fas fa-calendar-alt"></i> Agosto - Septiembre</span></p>

                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>

                  <p class="p-inline p-c-i"><i class="fas fa-eye"></i> 1000</p>



                  <p class="mt-4"><a href="" class="a-transparent-g">VER REVISTA</a></p>

                </div>

                

              </section>



               <h5 class="font-weight p-right mt-3">Página 1 de 3 <span class="btn-c-g"><i class="fas fa-arrow-left"></i></span>  <span class="btn-c-g"><i class="fas fa-arrow-right"></i></span></h5>







          </div>

        </div>

      </div>

    </div>







  </section>

@endsection
@extends('layouts.front')
@section('titulo')
@section('content')
  <section class="col-md-12 bg-gris pbm-0 s-cursos"> 
    
    <section class="col-md-10 mx-auto">
      <div id="carouselExampleCaptions" class="carousel slide mt-5" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active c-item">
            <img src="{{asset('images/r-construccion.png')}}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block text">
              <span class="p-rubro">CONSTRUCCIÓN</span>

             <h1 class="font-weight mt-3">Lorem ipsum amet consectetur sit lorem sed</h1>
            </div>
          </div>
          <div class="carousel-item c-item">
            <img src="{{asset('images/r-mineria.png')}}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block text">
              <span class="p-rubro">CONSTRUCCIÓN</span>

             <h1 class="font-weight mt-3">Lorem ipsum amet consectetur sit lorem sed</h1>
            </div>
          </div>
          <div class="carousel-item c-item">
            <img src="{{asset('images/r-arquitectura.png')}}" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block text">
              <span class="p-rubro">CONSTRUCCIÓN</span>

             <h1 class="font-weight mt-3">Lorem ipsum amet consectetur sit lorem sed</h1>
            </div>
          </div>
        </div>  
      </div>
    </section>
    <section>

    </section>
    <section class="col-md-10 mx-auto row pbm-0 mt-5">
      <h5 class="title-c">MI CUENTA</h5>
    </section>


    <div class="d-flex align-items-start col-md-10 mx-auto row">
      <div class="nav flex-column nav-pills  col-md-2 mt-1" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <h5 class="font-weight">Mostrar Todos </h5>
        <br>
        <button class="nav-link btn-left active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">MIS CURSOS</button>

        <button class="nav-link btn-left" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">MIS INTERESES</button>

        <button class="nav-link btn-left" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">MIS FAVORITOS</button>

        
      </div>
      <div class="tab-content col-md-10 mt-1" id="v-pills-tabContent">
        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

          <h5 class="font-weight p-inline">MIS CURSOS</h5>
          <h5 class="font-weight p-inline f-right">Populares <i class="fas fa-caret-down"></i></h5>
          <br><br>
          <div class="col-md-12 row mt-2">

            

              <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>
            <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>
            <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>
            <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>
            <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>
            <section class="col-md-4 card-curso card-curso-p">
              <div class="img">
                <a href=""><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                <span class="s-disponible">DISPONIBLES</span>
              </div>
              <div class="text">
                <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                <p>Nombre del profesor</p>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                <p class="mt-4"><a href="" class="a-transparent-g">VER CURSO</a></p>
              </div>
              
            </section>

            <h5 class="font-weight p-right mt-3">Página 1 de 3 <span class="btn-c-g"><i class="fas fa-arrow-left"></i></span>  <span class="btn-c-g"><i class="fas fa-arrow-right"></i></span></h5>

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
@extends('layouts.front')
@section('titulo')
{{$curso->titulo}}
@endsection
@section('content')
<div class="none">{{$a=($curso->rubro->slug)}}</div>
  <section class="col-md-10 mx-auto row pbm-0">
    <section class="col-md-8">
      <div class="d-title">
        <p><span class="p-rubro">CONSTRUCCIÓN</span></p>
        <h3 class="title-cur font-weight">Lorem ipsum amet lorem lo consectetur sit lorem sed</h3>

        <p class="p-inline ">Nombre del Profesor</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-user"></i> 4.912 k</p>
        <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up"></i> 4.912 k</p>

        <p class="p-inline p-c-i p-m-l"> <span class="s-disponibles">DISPONIBLES</span></p>
        
      </div>
      <div class="d-img mt-4">
        <img src="{{asset('images/getcurso.png')}}" width="100%"> 
      </div>

      <div class="descripción mt-4">
        <h4 class="font-weight">Aprenderás técnica profesionales lorem IPSUM</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>

        <h4 class="font-weight c-green mt-4">¿A quién está dirigido?</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
      </div>

      <div class="temario">
        <h4 class="font-weight">Temario del curso</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing eli  adipiscing eli</p>

        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">

              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="valoraciones mt-5">
        <h4 class="font-weight">Valoraciones</h4>
        <div class="col-md-11 mx-auto row pbm-0 mt-4">
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-thumbs-up"></i> 4.91</p>
            <p class="pbm-0 font-weight">Rating del curso</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-user"></i> 1000</p>
            <p class="pbm-0 font-weight">Alumnos</p>
          </div>
          <div class="col-md-4 div-valoraciones">
            <p class="p-grand c-green"><i class="fas fa-comment"></i> 354</p>
            <p class="pbm-0 font-weight">Comentarios</p>
          </div>
        </div>
      </div>

      <div class="valoraciones mt-5">
        <h4 class="font-weight">Comentarios</h4>

        <div class="col-md-11 mx-auto row pbm-0 mt-4">

          <div class="row col-md-12">
            <div class="col-md-1 pbm-0">
              <img src="{{asset('images/img-coment.png')}}" width="80%">
            </div>
            <div class="col-md-11 pbm-0">
              <h5 class="font-weight mt-2">NOMBRE DEL USUARIO</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
          </div>

          <div class="row col-md-12">
            <div class="col-md-1 pbm-0">
              <img src="{{asset('images/img-coment.png')}}" width="80%">
            </div>
            <div class="col-md-11 pbm-0">
              <h5 class="font-weight mt-2">NOMBRE DEL USUARIO</h5>
              <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
            </div>
          </div>

          <div class="row col-md-12">
            <div class="col-md-1 pbm-0">
              <img src="{{asset('images/user-coment.png')}}" width="80%">
            </div>
            <div class="col-md-11 pbm-0">
              <h5 class="font-weight mt-2">ESCRIBE UNA VALORACION</h5>
              <form>
                 <textarea class="form-control" placeholder="Valoración . . ." id="floatingTextarea2" style="height: 100px"></textarea>

                 <p class="mt-2 font-weight">¿Recomiendas este curso? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="s-coment"><a href=""><i class="fas fa-thumbs-up"></i> SI</a></span> <span class="s-coment"><a href=""><i class="fas fa-thumbs-down"></i> NO</a></span></p>

                 <a class="a-menu a-menu-b" style="text-decoration: none" href="#">COMENTAR</a>
              </form>
            </div>
          </div>
          
        </div>
      </div>


      <div class="temario mt-5" style="padding-bottom: 5%;">
        <h4 class="font-weight">Preguntas Frecuentes</h4>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing eli  adipiscing eli</p>

        <div class="accordion accordion-flush" id="accordionFlushExample">
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the first item's accordion body.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">Placeholder content for this accordion, which is intended to demonstrate the <code>.accordion-flush</code> class. This is the second item's accordion body. Let's imagine this being filled with some actual content.</div>
            </div>
          </div>
          <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
              <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                Lorem ipsum dolor
              </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
              <div class="accordion-body">
 Lorem ipsum dolor
              </div>
            </div>
          </div>
        </div>
      </div>

    </section>
    <section class="col-md-4 col-card-plan">
      <section class="card-curso">
          <div class="img">
            <a href=""><img src="{{asset('images/ejem-curso.png')}}" width="100%"></a>
            <span><a href="" class="a-icon"><i class="fas fa-play-circle"></i></a></span>
          </div>
          <div class="text" style="padding: 0">
            
            <h5 class="mt-3 font-weight">Lorem ipsum dolor ameter elit</h5>
            <p class="font-weight">Nombre del profesor</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
            <hr>
            <span>No has completado ninguna unidad del curso</span>
            <div class="col-md-12 row pbm-0 mt-3">
              <div class="col-md-6 pbm-0">
                <p><a class="nav-link a-menu a-menu-b text-center" href="/clase1/procesos-y-metodos-constructivos-61f1ab1aa606c">EMPEZAR</a></p>
              
              </div>
              <div class="col-md-6 pbm-0">
                <p><a class="nav-link a-menu  text-center" href="#">CERTIFICADO</a></p>
              
              </div>
            </div>
            
          </div>
          
        </section>
    </section>
  </section>
@endsection
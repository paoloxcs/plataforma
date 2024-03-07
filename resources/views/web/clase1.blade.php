@extends('layouts.front')
@section('titulo')
title
@endsection
@section('content')
  <section class="col-md-12 bg-gris-black  pbm-0" style="padding-bottom: 4% ">
    <section class="col-md-7 mx-auto">
      <br>
      <br>
        <img src="{{asset('images/62014fa14f19f.jpg')}}" width="100%;">

         <div class="portada  pbm-0" id="portada">
              <div id="cuenta" class="cuenta">
                
              </div>
          </div>

            <main class="btn-reunion pmb-0">

              <p class="text-center"><a class="nav-link a-menu a-menu-b a-ir" href="#" style="display: inline">IR A LA REUNIÓN</a></p>

            </main>
    </section>

    <section class="col-md-10 mx-auto">
      <span class="p-rubro">CONSTRUCCIÓN</span>
      <h2 class="mt-2 c-white font-weight">Lorem ipsum amet lorem lo consectetur sit lorem sed</h2>
      <p class="p-inline c-white"> Nombre del profesor</p> 
      <p class="p-inline p-c-i p-m-l c-white"><i class="fas fa-thumbs-up "></i> 4.912 k</p>
      <p class="p-inline p-c-i p-m-l c-white"><i class="fas fa-thumbs-up "></i> 4.912 k</p>
    </section>

    <section class="col-md-10 mx-auto mt-5 s-clase-nav">
      
      <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Módulos</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Descarga</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Comentarios</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="certificado-tab" data-bs-toggle="tab" data-bs-target="#certificado" type="button" role="tab" aria-controls="certificado" aria-selected="false">Certificado</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="encuesta-tab" data-bs-toggle="tab" data-bs-target="#encuesta" type="button" role="tab" aria-controls="encuesta" aria-selected="false">Encuesta</button>
      </li>
    </ul>

    <div class="tab-content col-md-6" id="myTabContent">
      <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
      
        <div class="temario mt-5" style="">
          
          <div class="accordion accordion-flush accordion-clase" id="accordionFlushExample">
            <div class="accordion-item">
              <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed font-weight" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                  Introducción / 2 clases
                </button>
              </h2>
              <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                <div class="accordion-body">
                  Lorem
                  lorem ipsum dolor sit amet, consectet
                </div>
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


      </div>

      <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"> 
        <section class="mt-5">

           <section class="col-md-12 row s-descarga">
            <div class="col-md-1">
              <img src="{{asset('images/pdf-a.png')}}" width="100%">
            </div>
            <div class="col-md-11">
              <p class="p-inline  c-white"> Lorem ipsum dolor nsectetur adipiscing elit, sed do</p>
              <p class="p-inline c-white f-right"><i class="fas fa-download c-white"></i></p>
            </div>
            
          </section>

           <section class="col-md-12 row s-descarga">
            <div class="col-md-1">
              <img src="{{asset('images/pdf-a.png')}}" width="100%">
            </div>
            <div class="col-md-11">
              <p class="p-inline  c-white"> Lorem ipsum dolor nsectetur adipiscing elit, sed do</p>
              <p class="p-inline c-white f-right"><i class="fas fa-download c-white"></i></p>
            </div>
            
          </section>

           <section class="col-md-12 row s-descarga">
            <div class="col-md-1">
              <img src="{{asset('images/pdf-a.png')}}" width="100%">
            </div>
            <div class="col-md-11">
              <p class="p-inline  c-white"> Lorem ipsum dolor nsectetur adipiscing elit, sed do</p>
              <p class="p-inline c-white f-right"><i class="fas fa-download c-white"></i></p>
            </div>
            
          </section>

           <section class="col-md-12 row s-descarga">
            <div class="col-md-1">
              <img src="{{asset('images/pdf-a.png')}}" width="100%">
            </div>
            <div class="col-md-11">
              <p class="p-inline  c-white"> Lorem ipsum dolor nsectetur adipiscing elit, sed do</p>
              <p class="p-inline c-white f-right"><i class="fas fa-download c-white"></i></p>
            </div>
            
          </section>
          
        </section>
       

      </div>
      <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
        <div class="valoraciones mt-2">
         

          <div class="col-md-12 mx-auto row pbm-0 s-coment-clase">

            <div class="row col-md-12 mt-4">
              <div class="col-md-1 pbm-0 mt-2">
                <img src="{{asset('images/img-coment.png')}}" width="80%">
              </div>
              <div class="col-md-11 pbm-0">
                <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">NOMBRE DEL USUARIO</h5>
                <span>Hace 7 meses</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>

               <p class="p-inline p-c-i"><i class="fas fa-thumbs-up"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-comments"></i> Responder</p>

              </div>
            </div>

            <div class="row col-md-12 mt-4">
              <div class="col-md-1 pbm-0 mt-2">
                <img src="{{asset('images/img-coment.png')}}" width="80%">
              </div>
              <div class="col-md-11 pbm-0">
                <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">NOMBRE DEL USUARIO</h5>
                <span>Hace 7 meses</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>

               <p class="p-inline p-c-i"><i class="fas fa-thumbs-up"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-comments"></i> Responder</p>

              </div>
            </div>

            <div class="row col-md-12 mt-4">
              <div class="col-md-1 pbm-0 mt-2">
                <img src="{{asset('images/img-coment.png')}}" width="80%">
              </div>
              <div class="col-md-11 pbm-0">
                <h5 class="font-weight mt-2" style="margin-bottom: 0;  ">NOMBRE DEL USUARIO</h5>
                <span>Hace 7 meses</span>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>

               <p class="p-inline p-c-i"><i class="fas fa-thumbs-up"></i> 1000</p>
                <p class="p-inline p-c-i p-m-l"><i class="fas fa-comments"></i> Responder</p>

              </div>
            </div>

           



            <div class="row col-md-12 mt-4">
              <div class="col-md-1 pbm-0 mt-2">
                <img src="{{asset('images/user-coment.png')}}" width="80%">
              </div>
              <div class="col-md-11 pbm-0">
                <h5 class="font-weight mt-2">ESCRIBE UNA VALORACION</h5>
                <form>
                   <textarea style="color:white!important" class="form-control ta-c-c" placeholder="Valoración . . ." id="floatingTextarea2" style="height: 100px"></textarea>

                   <p class="mt-2 font-weight c-white">¿Recomiendas este curso? &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span class="s-coment c-white"><a href="" class="c-white" style="color:white"><i class="fas fa-thumbs-up c-white"></i> SI</a></span> <span class="s-coment c-white"><a href="" class="c-white" style="color:white"><i class="fas fa-thumbs-down c-white"></i> NO</a></span></p>

                   <a class="a-menu a-menu-b" style="text-decoration: none" href="#">COMENTAR</a>
                </form>
              </div>
            </div>
            
          </div>
        </div>

      </div>

      <div class="tab-pane fade" id="certificado" role="tabpanel" aria-labelledby="certificado-tab">
        <h5 class="c-white mt-5 font-weight">DATOS PARA EL CERTTIFICADO</h5>
        <p class="c-white">Llene el formulario con tus datos para generar el certificado</p>

        <form class="">

          <label  class="form-label c-white mt-4">Correo electrónico</label>
          <input type="email"  class="form-control input-cert" aria-describedby="passwordHelpBlock" placeholder="postmaster@constructivo.com">

          <label  class="form-label c-white mt-4">Nombre Completo</label>
          <input type="text"  class="form-control input-cert" aria-describedby="passwordHelpBlock" placeholder="Nombre completo . . .">

          <label  class="form-label c-white mt-4">N° Teléfono
          </label>
          <input type="text"  class="form-control input-cert" aria-describedby="passwordHelpBlock" placeholder="0000 000 000">
          <br>
<a class="a-menu a-menu-b" style="text-decoration: none" href="#">SOLICITAR CERTTIFICADO</a>

        </form>
      </div>

      <div class="tab-pane fade" id="encuesta" role="tabpanel" aria-labelledby="encuesta-tab">
        
        <div class="col-xs-12 col-md-12" style="">
               <h5 class="text-center c-white font-weight mt-5" style="">TITLE</h5>
               
              <table class="table encuesta_table mt-4 pbm-0">
                <thead>
                  <tr>
                    <th scope="col"  rowspan="2">PREGUNTAS</th>
                    <th scope="col" colspan="5" class="escala" style="padding:0.2%">ESCALA DE IMPORTANCIA</th>
                  </tr>
                  <tr>
                    <th scope="col">No me gustó</th>
                    <th scope="col">Me gustó</th>
                    <th scope="col">Me gustó mucho</th>
                  </tr>
                </thead>
                <tbody>
                   <form class="" action="#" method="POST" enctype="multipart/form-data">
                      {{ csrf_field() }}
                      <input type="hidden" name="encuesta_id" value="#">
                 
                        <tr>
                          <th > ¿Cuál es su opinión sobre la expositora a cargo del curso?    </th>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="1"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="2"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="3"></td>
                        </tr>

                        <tr>
                          <th > ¿Cuál es su opinión sobre la expositora a cargo del curso?    </th>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="1"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="2"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="3"></td>
                        </tr>

                        <tr>
                          <th > ¿Cuál es su opinión sobre la expositora a cargo del curso?    </th>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="1"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="2"></td>
                          <td><input class="medium" type="radio" name="pregunta.*x"required value="3"></td>
                        </tr>
                     

                 
                        <tr>
                        <th >¿Tiene alguna sugerencia o comentario que nos ayude a mejorar los cursos?</th>
                        <td colspan="4" class="textarea_encuesta">
                          <textarea style="color:white!important" name="respuestax" required="" width="100%"></textarea>
                        </td>
                      </tr>

                      <tr>
                        <th >¿Tiene alguna sugerencia o comentario que nos ayude a mejorar los cursos?</th>
                        <td colspan="4" class="textarea_encuesta">
                          <textarea style="color:white!important" name="respuestax" required="" width="100%"></textarea>
                        </td>
                      </tr>

                      <tr>
                        <th >¿Tiene alguna sugerencia o comentario que nos ayude a mejorar los cursos?</th>
                        <td colspan="4" class="textarea_encuesta">
                          <textarea style="color:white!important" name="respuestax" required="" width="100%"></textarea>
                        </td>
                      </tr>
                 
                  

                 

                  <tr>
                    <th style="border:0px solid red!important;"></th>
                    <th colspan="5"  style="border:0px solid red!important;"><a class="a-menu a-menu-b" style="text-decoration: none;display:block;width:100%" href="#">ENVIAR ENCUESTA</a></th>
                  </tr>
                  </form>
                </tbody>
              </table>

            </div>


      </div>
    </div>

    </section>

  </section>


  <section class="bg-white">
{{-- JHED FRONT V2 --}}
        {{-- <section class="col-md-10 mx-auto row pbm-0 mt-5 mt-2-mob padding-1"> --}}
        <section class="col-md-10 mx-auto row pbm-0 mt-5-web mt-10-mob padding-1">
          <h5 class="font-weight p-inline ">CURSOS RELACIONADOS</h5>
          <section class="col-md-12 row mt-3">
            <section class="col-md-3 card-curso card-curso-p">
                <div class="img">
                  <a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8"><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                  <span class="s-disponible">DISPONIBLES</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>
              <section class="col-md-3 card-curso card-curso-p">
                <div class="img">
                  <a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8"><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                  <span class="s-disponible">DISPONIBLES</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

              <section class="col-md-3 card-curso card-curso-p">
                <div class="img">
                  <a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8"><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                  <span class="s-disponible">DISPONIBLES</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>

              <section class="col-md-3 card-curso card-curso-p">
                <div class="img">
                  <a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8"><img src="{{asset('images/c-constru.png')}}" width="100%"></a>
                  <span class="s-disponible">DISPONIBLES</span>
                </div>
                <div class="text">
                  <h4 class="title font-weight">Lorem ipsum dolor ameter elit sed tempor</h4>
                  <p>Nombre del profesor</p>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod…</p>
                  <p class="p-inline p-c-i"><i class="fas fa-user"></i> 1000</p>
                  <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i> 4.912 k</p>

                  <p class="mt-4"><a href="/curso/analisis-estructural-de-edificaciones-empleando-sap-2000-61d5b96f5eaa8" class="a-transparent-g">VER CURSO</a></p>
                </div>
                
              </section>
            </section>

    </section>
  </section>
@endsection

@section('script-extra')


  <script src="{{asset('js/simplyCountdown.min.js')}}"></script>
  <script >
    simplyCountdown('#cuenta', {
      year: {{date('Y',strtotime($clase->fecha))}}, // required
      month: {{date('m',strtotime($clase->fecha))}}, // required
      day: {{date('d',strtotime($clase->fecha))}}, // required
      hours: {{date('H',strtotime($clase->time))}} - 5 , // Default is 0 [0-23] integer
      minutes: {{date('i',strtotime($clase->time))}}, // Default is 0 [0-59] integer
      seconds: 0, // Default is 0 [0-59] integer
      words: { //words displayed into the countdown
        days: 'Día',
        hours: 'Hora',
        minutes: 'Minuto',
        seconds: 'Segundo',
        pluralLetter: 's'
      },
      plural: true, //use plurals
      inline: false, //set to true to get an inline basic countdown like : 24 days, 4 hours, 2 minutes, 5 seconds
      inlineClass: 'simply-countdown-inline', //inline css span class in case of inline = true
      // in case of inline set to false
      enableUtc: true, //Use UTC as default
      onEnd: function() {
        document.getElementById('portada').classList.add('oculta');
        return; 
      }, //Callback on countdown end, put your own function here
      refresh: 1000, // default refresh every 1s
      sectionClass: 'simply-section', //section css class
      amountClass: 'simply-amount', // amount css class
      wordClass: 'simply-word', // word css class
      zeroPad: false,
      countUp: false
    });
  </script>
  <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
@endsection
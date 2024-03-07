@if(!Auth()->user())
@if($url=='/' OR $url=='nosotros' OR $url=='privacidad' OR $url=='terminos' OR $url=='contacto' OR $url=='login' OR $url=='register'
OR $url=='profile/edituser' OR $url=='profile/favoritos' OR $url=='report' OR $url=='profile/changepassword' OR $url=='profile/suscription' OR $url=='profile' OR $url=='planes-de-suscripcion' OR $url=='password/reset' OR $url=='empresas' OR $url=='empresa/suscription')

@else

 
    
    <?php
     $url=Request::path();
     $palabra= 'curso/';
    $palabra1= 'video/';
    $palabra2= 'serie/';
    $palabra3= 'planes-de--suscripcion';
    $palabra4= 'agradecimiento';

     $posicion_coincidencia = strpos($url, $palabra);

     $posicion_coincidencia1 = strpos($url, $palabra1);

     $posicion_coincidencia2 = strpos($url, $palabra2);

     $posicion_coincidencia3 = strpos($url, $palabra3);

     $posicion_coincidencia4 = strpos($url, $palabra4);
     
    ?>
   
    @if ($posicion_coincidencia === false and $posicion_coincidencia1 === false and $posicion_coincidencia2===false and  $posicion_coincidencia3===false and $posicion_coincidencia4===false) 
      <div class="container">
     
        @if($a=='arquitectura-y-diseno')
            <div class="col-xs-12 col-md-12 mx-auto colaborador_titulo" >
              <h4 class="text-center" style="font-weight: 700;margin-bottom: 2%;">Empresas que promueven la capacitación en el sector de la Arquitectura y Diseño</h4>
            </div>

            <div class="col-xs-12 col-md-12  mx-auto colaborador">
              @foreach($colaboradoresA as $colaborador)
               <div class="img-logo">

              <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" width="100%">
              </div>
              @endforeach
            </div>

          @elseif($a=='construccion')

             <div class="col-xs-12 col-md-12 mx-auto colaborador_titulo" >
              <h4 class="text-center" style="font-weight: 700;margin-bottom: 2%;">Empresas que promueven la capacitación en el sector de la Construcción</h4>
            </div>

            <div class="col-xs-12 col-md-12  mx-auto colaborador">
              @foreach($colaboradoresC as $colaborador)
               <div class="img-logo ">

              <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" width="100%">
              </div>
              @endforeach
            </div>
          @else
             <div class="col-xs-12 col-md-12 mx-auto colaborador_titulo" >
              <h4 class="text-center" style="font-weight: 700;margin-bottom: 2%;">Empresas que promueven la capacitación en el sector de la Minería</h4>
            </div>

            <div class="col-xs-12 col-md-12  mx-auto colaborador">
              @foreach($colaboradoresM as $colaborador)
               <div class="img-logo">

              <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" width="100%">
              </div>
              @endforeach
            </div>
          @endif

      
      </div>


    @else

      

     @endif

@endif
@endif
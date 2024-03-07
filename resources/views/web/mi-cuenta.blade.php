@extends('layouts.front')
@section('titulo','Contactoa')
@section('content')
  <section class="col-md-12 bg-gris" style="padding-bottom: 5%">
    <section class="col-md-10 mx-auto">
        <section class="col-md-6 mt-5">
           <h2 class="font-weight">Mi cuenta</h2>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat</p>
        </section>
  
    </section>
    
    <section class="col-md-8 mx-auto bg-white s-informacion">
      <h4 class="font-weight">Información básica</h4>
      <form class="col-md-12 row">
        <div class="mb-3 col-md-6">
          <label for="exampleInputEmail1" class="form-label font-weight">Nombre</label>
          <input type="text" class="form-control" placeholder="lorem ipsum">
        </div>

        <div class="mb-3 col-md-6">
          <label for="exampleInputEmail1" class="form-label font-weight">Apellido</label>
          <input type="text" class="form-control" placeholder="lorem ipsum">
        </div>

        <div class="mb-3 col-md-6">
          <label for="exampleInputEmail1" class="form-label font-weight">Email</label>
          <input type="email" class="form-control"  placeholder="loremipsum@gmail.com">
        </div>
     

        <p class="font-weight mt-4">Cambiar contraseña</p>

        <div class="mb-3 col-md-6">
          <label for="exampleInputEmail1" class="form-label font-weight">Contraseña antigua</label>
          <input type="password" class="form-control"  placeholder="contraseña">
        </div>

        <div class="mb-3 col-md-6">
          <label for="exampleInputEmail1" class="form-label font-weight">Nueva contraseña</label>
          <input type="password" class="form-control"  placeholder="contraseña">
        </div>

        <p class="text-center mt-3"><a class="a-menu a-menu-b" href="#" style="text-decoration: none;padding: 1% 4%">GUARDAR CAMBIOS</a></p>
       </form>
    </section>


     <section class="col-md-10 mx-auto mt-5">
        <section class="col-md-6">
           <h4 class="font-weight">SUSCRIPCIONES ACTIVAS</h4>
        </section>
  
    </section>
    
    <section class="col-md-8 mx-auto bg-white s-informacion mt-5">
      <h4 class="font-weight">Facturación y pago</h4>
        <div class="col-md-6 row mt-4">
          <div class="col-md-1">
            <i class="fas fa-credit-card"></i>
          </div>
          <div class="col-md-11">
          <p>Pago recurrente a través de Culqi</p>
          </div>
            
         </div>

         <div class="col-md-6 row">
          <div class="col-md-1">
              <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="col-md-11">
          <p>S/ 60.00 / por 6 meses</p>
          <p> El siguiente pago se realizará el 20 oct 2021</p>
          <p>Plan Semestral</p>

          <a href="" class="c-green font-weight">cancelar suscripción</a>

          </div>
            
         </div>

         <div class="col-md-12 row mt-5">
           <div class="col-md-2">
             <p class="font-weight text-center">FECHA</p>
           </div>
           <div class="col-md-2">
             <p class="font-weight text-center">TIPO</p>
           </div>
           <div class="col-md-2">
             <p class="font-weight text-center">NÚMERO DE PEDIDO</p>
           </div>
           <div class="col-md-2">
             <p class="font-weight text-center">PLANES</p>
           </div>
           <div class="col-md-2">
             <p class="font-weight text-center">CANTIDAD</p>
           </div>
           <div class="col-md-2">
             <p class="font-weight text-center">ACCIÓN</p>
           </div>
         </div>
         <hr>
         <div class="col-md-12 row">
           <div class="col-md-2">
             <p class=" text-center">20 oct 2021</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Factura</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">FC00001</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Plan semestral</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">s/ 60.00</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center"><i class="fas fa-download"></i></p>
           </div>
         </div>

         <hr>
         <div class="col-md-12 row">
           <div class="col-md-2">
             <p class=" text-center">20 oct 2021</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Factura</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">FC00001</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Plan semestral</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">s/ 60.00</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center"><i class="fas fa-download"></i></p>
           </div>
         </div>

         <hr>
         <div class="col-md-12 row">
           <div class="col-md-2">
             <p class=" text-center">20 oct 2021</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Factura</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">FC00001</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">Plan semestral</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center">s/ 60.00</p>
           </div>
           <div class="col-md-2">
             <p class=" text-center"><i class="fas fa-download"></i></p>
           </div>
         </div>
        
    </section>


  </section>
@endsection
@extends('layouts.front')
@section('titulo','Mi perfil')
@section('content')
<div class="none">{{$a="construccion"}}</div>
  <section class="col-md-12 bg-gris" style="padding-bottom: 5%">
    <section class="col-md-10 col-xs-10 mx-auto">
        <section class="col-md-6 col-xs-12 mt-5">
           <h2 class="font-weight text-center-mob">Mi cuenta</h2>
            
          {{--<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
          tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
          quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
          consequat</p>--}}
        </section>
  
    </section>
    
    
    <section class="col-md-8 col-xs-12 mx-auto bg-white s-informacion row pbm-0-mob mt-5-mob">
      <form class="col-md-12 row"  action="{{route('updateuser',Auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
      <div class=" col-md-3 col-xs-3 mx-auto mb-3 mt-5-mob">
        {{--d-flex justify-content-center align-items-center--}}
            <div class="foto_profile">
              @if(Auth()->user()->url_foto != null)
                <img id="showImage" src="{{asset('fotousers/'.Auth()->user()->url_foto)}}" alt="">
              @else
                <img id="showImage" src="{{asset('fotousers/profile.png')}}" alt="">         
              @endif
              <span>
                <div class="action">
                  <label for="fotouser" id="ulpload-foto">Cambiar/ 100 Kb</label>
                  <input type="file" name="perfil" id="fotouser" onchange="readImage(this);" accept="image/*" style="display: none;" class="{{ $errors->has('perfil') ? ' is-invalid' : '' }}">
                  {{--@if ($errors->has('perfil'))
                     <span class="invalid-feedback">
                         <p  style="width: 80%;color:red;margin-left: 10%;text-align: center;font-weight:700">{{ $errors->first('perfil') }}</p>
                     </span>
                  @endif--}}

                </div>
              </span>
            </div>
            
      </div>
      <section class="col-md-9 col-xs-12">
      <h4 class="font-weight">Información básica</h4>
        <section class="col-md-12 row">
          <div class="mb-3 col-md-6 col-xs-6 ">
             
                            <label for="name" class="form-label font-weight">Nombres <i
                                    class="fas fa-exclamation-circle" style="color: #24db37" title="Campo Obligatorio"></i></label>
            <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{Auth()->user()->name}}">
                   @if ($errors->has('name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('name') }}</strong>
                     </span>
                  @endif
          </div>

          <div class="mb-3 col-md-6 col-xs-6 ">
               <label for="last_name" class="form-label font-weight">Apellidos <i
                                    class="fas fa-exclamation-circle" style="color: #24db37"
                                    title="Campo Obligatorio"></i></label>
                  <input type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{Auth()->user()->last_name}}">
                   @if ($errors->has('last_name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('last_name') }}</strong>
                     </span>
                  @endif
          </div>

          <div class="mb-3 col-md-6 col-xs-6 ">
            <label for="email" class="form-label font-weight">Email <i class="fas fa-exclamation-circle"
                                    style="color: #24db37" title="Campo Obligatorio"></i></label>
           <input type="email" class="form-control" name="email" disabled value="{{Auth()->user()->email}}">
          </div>

          <div class="mb-3 col-md-6 col-xs-6 ">
          <label for="address" class="form-label font-weight">Dirección</label>
                  @if(strlen((Auth()->user()->address)>50))
                  <input type="text" class="form-control" {{ $errors->has('address') ? ' is-invalid' : '' }} name="address" placeholder="define address" maxlength="50"  required="">
                     @if ($errors->has('address'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('address') }}</strong>
                     </span>
                  @endif
                  @elseif(Auth()->user()->address=="")
                  <input type="text" class="form-control" {{ $errors->has('address') ? ' is-invalid' : '' }} name="address" placeholder="define address" maxlength="50"  required="">
                     @if ($errors->has('address'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('address') }}</strong>
                     </span>
                  @endif
                  @else
                  <input type="text" class="form-control" {{ $errors->has('address') ? ' is-invalid' : '' }} name="address" value="{{Auth()->user()->address}}" maxlength="50" required="">
                     @if ($errors->has('address'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('address') }}</strong>
                     </span>
                  @endif
                  @endif
          </div>
          <div class="mb-3 col-md-6 col-xs-6 ">
             <label for="doc_number" class="form-label font-weight">N° Documento (Opcional)</label>
                  <input type="number" class="form-control {{ $errors->has('doc_number') ? ' is-invalid' : '' }}" name="doc_number" value="{{Auth()->user()->doc_number}}">
                   @if ($errors->has('doc_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('doc_number') }}</strong>
                     </span>
                  @endif
          </div>
          <div class="mb-3 col-md-6 col-xs-6 ">
              <label for="phone_number" class="form-label font-weight">N° Telf. / Movil <i
                                    class="fas fa-exclamation-circle" style="color: #24db37"
                                    title="Campo Obligatorio"></i></label>
                  <input type="number" class="form-control {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{Auth()->user()->phone_number}}">
                   @if ($errors->has('phone_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('phone_number') }}</strong>
                     </span>
                  @endif
          </div>
          
          {{-- Form Age_Profession --}}
                        <div class="mb-3 col-md-6 col-xs-6 ">
                            <?php $fecha = date('Y-m-d'); ?>
                            <label for="age" class="form-label font-weight">Fecha de Nacimiento</label>
                            <input type="date" name="age" id="age"
                                class="form-control {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder=""
                                value="{{ Auth()->user()->age }}" max="{{ $fecha }}"
                                onchange="fecha_nacimiento(this.value)">
                            @if ($errors->has('age'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('age') }}</strong>
                                </span>
                            @endif
                            <span class="invalid-feedback" id="invalid_FN">
                            </span>
                        </div>

                        <div class="mb-3 col-md-6 col-xs-6 ">
                            <label for="profession" class="form-label font-weight">Profesión</label>
                            <input class="form-control {{ $errors->has('profession') ? ' is-invalid' : '' }}"
                                type="text" name="profession" id="profession" placeholder=""
                                value="{{ Auth()->user()->profession }}">
                            @if ($errors->has('profession'))
                                <span class="invalid-feedback">
                                    <strong>{{ $errors->first('profession') }}</strong>
                                </span>
                            @endif
                        </div>


          {{-- Form Age_Profession --}}
                        {{-- <p class="text-center mt-3"><button type="submit" class="a-menu a-menu-b"
                                style="text-decoration: none;padding: 1% 4%">Guardar Cambios</button></p> --}}
                        <p class="text-center mt-3"><button type="submit" class="a-menu a-menu-b" id="btn_registro"
                                style="text-decoration: none;padding: 1% 4%">Guardar Cambios</button></p>
           </form>
        </section>
      </section>
     
      <section class="col-md-12">
        <p class="font-weight mt-4">Cambiar contraseña</p>
        <form class="col-md-12 row"  action="{{route('updatepassword')}}" method="POST">
          {{ csrf_field() }}
        <div class="mb-3 col-md-4 col-xs-12">
          <label for="currentpass" class="form-label font-weight">Contraseña Actual</label>
          <input type="password" class="form-control {{ $errors->has('currentpass') ? ' is-invalid' : '' }}" id="currentpass" name="currentpass" placeholder="Contraseña actual"> 
          @if ($errors->has('currentpass'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('currentpass') }}</strong>
            </span>
         @endif   
        </div>

        <div class="mb-3 col-md-4 col-xs-6">
         <label for="newpass" class="form-label font-weight">Nueva Contraseña</label>
          <input type="password" class="form-control {{ $errors->has('newpass') ? ' is-invalid' : '' }}" id="newpass" name="newpass" placeholder="6 caracteres alfanumericos como mínimo" >
           @if ($errors->has('newpass'))
             <span class="invalid-feedback">
                 <strong>{{ $errors->first('newpass') }}</strong>
             </span>
          @endif  
        </div>

        <div class="mb-3 col-md-4 col-xs-6">
         <label for="newpass-confirm" class="form-label font-weight">Confirmar Nueva Contraseña</label>
          <input type="password" class="form-control" id="newpass-confirm" name="newpass_confirmation" placeholder="Confirmar nueva contraseña">
        </div>

        <p class="text-center mt-3"><button class="a-menu a-menu-b" type="submit" style="text-decoration: none;padding: 1% 4%">Cambiar Contraseña</button></p>
       </form>
      </section>
    </section>

     <section class="col-md-10 col-xs-10 mx-auto mt-5">
        <section class="col-md-6 col-xs-12">
           <h4 class="font-weight text-center-mob">SUSCRIPCIONES ACTIVAS</h4>
        </section>
  
    </section>
@if($user->isPremium() and $user->tarjeta_id=='')
    {{--suscriptor depósito--}}
      <section class="col-md-8 col-xs-12 mx-auto bg-white s-informacion mt-5">
        <h4 class="font-weight">Facturación y pago</h4>
          <div class="col-md-6 col-xs-6 row mt-4">
            <div class="col-md-1 col-xs-1">
              <i class="fas fa-credit-card"></i>
            </div>
            <div class="col-md-11 col-xs-11">
            <p>Pago Depósito</p>
            </div>
              
           </div>

        @if($user->suscriptorDeposito)
           <div class="col-md-6 col-xs-6 row">
            <div class="col-md-1 col-xs-1">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="col-md-11 col-xs-11">
            {{--<p>S/ {{$user->suscriptorDeposito->plan->name}} / por {{$user->suscriptorDeposito->plan->meses}} meses</p>--}}
            <p> Su suscripción caducará el {{date('d/m/Y',strtotime($user->suscriptorDeposito->suscription_end))}}</p>
            <p class="font-weight">{{$user->suscriptorDeposito->plan->name}}</p>

            </div>
              
           </div>
        @else
        <div class="col-md-6 col-xs-6 row">
            <div class="col-md-1 col-xs-1">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="col-md-11 col-xs-11">
                {{-- <p>S/ {{$user->suscriptorDepositoUni->plan->name}} / por {{$user->suscriptorDepositoUni->plan->meses}} meses</p> --}}
                <p> Su suscripción caducará el
                    {{ date('d/m/Y', strtotime($user->suscriptorDepositoUni->suscription_end)) }}
                </p>
                <p class="font-weight">{{ $user->suscriptorDepositoUni->plan->name }}</p>

            </div>

        </div>
        @endif

        @if($user->suscriptorDeposito)
            @if($user->suscriptorDeposito->currentDays() < 15)
             <div class="col-md-6 col-xs-6">
               <a class="a-menu a-menu-b tt-uppercase"
                        style="text-decoration: none;padding: 1.3% 4%" href="/planes-de-suscripcion/construccion"><i class="fas fa-sync-alt"></i> RENOVAR ONLINE</a>

                <a class="a-transparent-g tt-uppercase"
                        style="text-decoration: none;padding: 1% 4%" type="button"   data-bs-toggle="modal" data-bs-target="#modal-notificar"><i class="fas fa-sync-alt"></i> NOTIFICAR</a>

             </div>
            @endif
        @endif
           {{--MODAL--}}
           <div class="modal fade" id="modal-notificar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-xs modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius:   15px">
                     <div class="modal-body">
                            <h5 class="font-weight text-center"> FORMULARIO DE NOTIFICACIÓN </h5>


                            <form action="{{route('notifications.store')}}" method="POST">
          {{ csrf_field() }}
                              <section class="col-md-12 row">

                                
                                 <div class="col-md-12">
                                  <input type="hidden" name="type_id" value="2">
                                  <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                                </div>
                                              
                                
                              </section>
                            
                            
                          </div>
                          <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-outline-success" data-dismiss="modal">ENVIAR SOLICITUD</button>
                            
                          </div>
                        </form>
                  </div>
                </div>
              </div>
           {{--MODAL--}}


           <div class="col-md-12 row mt-5">
            <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">NÚMERO DE PEDIDO</p>
             </div>

             <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">FECHA</p>
             </div>
             <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">Mod. Pago</p>
             </div>
                          <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">PLANES</p>
             </div>
             <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">MONTO</p>
             </div>
             <div class="col-md-2 col-xs-2">
               <p class="font-weight text-center">COMPROBANTE</p>
             </div>
           </div>
           <hr>
           <div class="col-md-12 row">
                @if($user->suscriptorDeposito)
              @foreach($user->suscriptorDeposito->pagos()->orderBy('id','desc')->get() as $pago)

                @if($pago->moneda=="PEN")
                  <div class="none">{{$simbolo="S/"}}</div>
                @else
                  <div class="none">{{$simbolo="$"}}</div>
                @endif
                <div class="col-md-2 col-xs-2">
                   <p class=" text-center">{{$pago->id}}</p>
                 </div>
                 <div class="col-md-2 col-xs-2">
                   <p class=" text-center">{{date('d/m/Y',strtotime($pago->created_at))}}</p>
                 </div>
                 <div class="col-md-2 col-xs-2">
                   <p class=" text-center">{{$pago->metodoPago->name}}</p>
                 </div>
                 
                 <div class="col-md-2 col-xs-2">
                   <p class=" text-center">{{$user->suscriptorDeposito->plan->name}}</p>
                 </div>
                 <div class="col-md-2 col-xs-2">
                   <p class=" text-center">{{$simbolo}} {{$pago->monto}}</p>
                 </div>
                 <div class="col-md-2 col-xs-2">
                    @if($pago->voucher_emit == 0)
                      
                    <p class=" text-center"><a class="a-menu a-menu-b tt-uppercase"
                      style="text-decoration: none;padding: 1% 4%" type="button"   data-bs-toggle="modal" data-bs-target="#modal-solicitar{{$pago->id}}"><i class="fas fa-download"></i> Solicitar</a></p>
                      @elseif($pago->voucher_emit == 1)
                      <p class=" text-center">Solicitada</p>
                      @else
                      <p class=" text-center font-weight">Emitida</p>
                      @endif
                 </div>
              @endforeach
                @endif

                @if($user->suscriptorDeposito)
              @foreach($user->suscriptorDeposito->pagos()->orderBy('id','desc')->get() as $pago)
              <div class="modal fade" id="modal-solicitar{{$pago->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-xs modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius:   15px">
                     <div class="modal-body">
                            <h5 class="font-weight text-center"> SOLICITUD DE COMPROBANTE </h5>


                            <form action="{{route('solicitudvoucher')}}" method="POST" enctype="multipart/form-data">
                              {{ csrf_field() }}
                              <input type="hidden" name="pago_id" value="{{$pago->id}}">
                              <section class="col-md-12 row">

                                <div class="col-md-12">
                                  <div class="form-group">
                                    <label>
                                      <input type="radio" name="tipo_comprobante" value="Boleta" checked> Boleta
                                    </label>
                                    <label class="ml-5">
                                      <input type="radio" name="tipo_comprobante" value="Factura"> Factura
                                    </label>
                                  </div> 
                                </div>

                                <div class="col-md-12 mt-4">
                                  <div class="form-group">
                                    <label for="name">Nombre / Razon social</label>
                                    <input type="text" class="form-control {{ $errors->has('rsocial') ? ' is-invalid' : '' }}"  name="rsocial" autofocus value="{{Auth()->user()->fullname()}}">
                                     @if ($errors->has('rsocial'))
                                       <span class="invalid-feedback">
                                           <strong>{{ $errors->first('rsocial') }}</strong>
                                       </span>
                                    @endif
                                  </div>
                                </div>
                                <div class="mt-3">
                                  <div class="form-group">
                                    <label for="name">Dirección</label>
                                    <input type="text" class="form-control" name="address" value="{{Auth()->user()->address}}">
                                  </div> 
                                </div>

                                <div class="mt-3">
                                   <div class="form-group">
                                    <label for="last_name">RUC/DNI</label>
                                    <input type="text" class="form-control {{ $errors->has('ruc') ? ' is-invalid' : '' }}" name="ruc" value="{{Auth()->user()->doc_number}}">
                                     @if ($errors->has('ruc'))
                                       <span class="invalid-feedback">
                                           <strong>{{ $errors->first('ruc') }}</strong>
                                       </span>
                                    @endif
                                  </div>
                                </div>

                                
                                
                              </section>
                            
                            
                          </div>
                          <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-outline-success" data-dismiss="modal">ENVIAR SOLICITUD</button>
                            
                          </div>
                        </form>
                  </div>
                </div>
              </div>

           
           @endforeach
                @endif

          </div>
      </section>
@elseif($user->isFree())
      <section class="col-md-8 mx-auto bg-white s-informacion mt-5">
        <h4 class="font-weight">Facturación y pago</h4>
        

         <div class="col-md-6 col-xs-6 row">
          <div class="col-md-1 col-xs-1">
              <i class="fas fa-user-cog"></i>
          </div>
          <div class="col-md-10 col-xs-10">
          <p>Usuario: <span>Gratuito</span></p>
        </div>

          </div>
            
         <a class="a-menu a-menu-b tt-uppercase"
                        style="text-decoration: none;padding: 1.3% 4%" href="/planes-de-suscripcion/construccion"><i class="fas fa-user-plus"></i> MEJORAR PLAN</a>

         
        
    </section>
@elseif($user->isCliente())
    <section class="col-md-8 mx-auto bg-white s-informacion mt-5">
        <h4 class="font-weight">Facturación y pago</h4>
        

        <div class="col-md-6 col-xs-6 row">
          <div class="col-md-1 col-xs-1">
              <i class="fas fa-user-cog"></i>
          </div>
          <div class="col-md-10 col-xs-10">
          <p>Cliente</p>
        </div>

          </div>
        <div class="col-md-6 col-xs-6 row">
            <div class="col-md-1 col-xs-1">
                <i class="far fa-keyboard"></i>
            </div>
            <div class="col-md-10 col-xs-10">
            <p>Acceso: <span class="font-weight">{{$user->cliente->getEstado()}}</span> </p>
          </div>

        </div>
        @if($user->cliente->status == 0)
          <div>
            <a class="a-transparent-g tt-uppercase"
                        style="text-decoration: none;padding: 1% 4%" type="button"   data-bs-toggle="modal" data-bs-target="#modal-notificacion"><i class="fas fa-sync-alt"></i> SOLICITAR ACTIVACIÓN</a>
          </div>

           {{--MODAL--}}
           <div class="modal fade" id="modal-notificacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog modal-xs modal-dialog modal-dialog-centered">
                  <div class="modal-content" style="border-radius:   15px">
                     <div class="modal-body">
                            <h5 class="font-weight text-center"> FORMULARIO DE NOTIFICACIÓN </h5>


                            <form action="{{route('notifications.store')}}" method="POST">
          {{ csrf_field() }}
                              <section class="col-md-12 row">

                                
                                 <div class="col-md-12">
                                  <input type="hidden" name="type_id" value="3">
                                  <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                                </div>
                                              
                                
                              </section>
                            
                            
                          </div>
                          <div class="modal-footer text-center">
                            <button type="submit" class="btn btn-outline-success" data-dismiss="modal">ENVIAR SOLICITUD</button>
                            
                          </div>
                        </form>
                  </div>
                </div>
              </div>
           {{--MODAL--}}
        @endif
         

         
        
    </section>
 @elseif($user->isPremium() and $user->tarjeta_id!='')
     <?php 
      $fecha_creacion= (new DateTime())
      ->setTimestamp( $suscripcion->creation_date/ 1000)
      ->format('d/m/Y');

      $fecha_iniciociclo= (new DateTime())
      ->setTimestamp( $suscripcion->current_period_start/ 1000)
      ->format('d/m/Y');    

      $fecha_sigpago= (new DateTime())
      ->setTimestamp( $suscripcion->next_billing_date/ 1000)
      ->format('d/m/Y');

    ?>

    <section class="col-md-8 mx-auto bg-white s-informacion mt-5">
      <h4 class="font-weight">Facturación y pago</h4>
        <div class="col-md-6 col-xs-6 row mt-4">
          <div class="col-md-1 col-xs-1">
            <i class="fas fa-credit-card"></i>
          </div>
          <div class="col-md-11 col-xs-11">
          <p>Pago Online</p>
          </div>
            
         </div>

         <div class="col-md-6 col-xs-6 row">
          <div class="col-md-1 col-xs-1">
              <i class="fas fa-calendar-alt"></i>
          </div>
          <div class="col-md-11 col-xs-11">
          <p> Siguiente pago el {{$fecha_sigpago}}</p>
          <p class="font-weight">{{$plan->name}}</p>

           <a type="button" class="a-transparent-g  font-weight"  type="button"   data-bs-toggle="modal" data-bs-target="#modal-cancel">
          CANCELAR SUSCRIPCIÓN
        </a>
          </div>
            
         </div>

         {{--modal--}}

         <div class="modal fade" id="modal-cancel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog modal-xl modal-dialog modal-dialog-centered">
              <div class="modal-content" style="border-radius:   15px">
                 <div class="modal-body">
                        <h5 class="text-warning text-center font-weight"><i class="fas fa-exclamation-triangle text-danger"></i> Si cancelas la suscripción <i class="fas fa-exclamation-triangle text-danger"></i></h5>
                        <li>Dejarás de ser usuario <span class="font-weight text-info">Premium</span></li>
                        <li>No tendrás acceso a los <span class="font-weight text-danger">videos</span> de la plataforma</li>
                        <li>No tendrás acceso a los <span class="font-weight text-danger">artículos</span> de la plataforma </li>
                        <li>No tendrás acceso al <span class="font-weight text-danger">suplemento técnico</span>  de la plataforma</li>
                        <li>No tendrás acceso a las <span class="font-weight text-danger">revistas</span>  de la plataforma </li>
                        <li>Inmediatamente pasarás a ser <span class=" text-secondary font-weight">usuario gratuito</span></li>
                        <br>
                        <h5 class="font-weight text-danger text-center">¿Estás seguro que quieres eliminar tu suscripción?</h5>


                        
                        
                      </div>
                      <div class="modal-footer text-center">
                        <button type="button" class="btn btn-outline-success font-weight" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Seguir Con el Plan</button>
                        <a href="{{route('cancelsus')}}"  class="btn btn-outline-dange font-weight">Eliminar Suscripción</a>
                      </div>
              </div>
            </div>
          </div>

          {{--MODAL--}}



         <div class="col-md-12 row mt-5">
          
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">FECHA </p>
           </div>
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">MOD. PAGO</p>
           </div>
           
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">TIPO</p>
           </div>
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">MONTO</p>
           </div>
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">ESTADO</p>
           </div>
           <div class="col-md-2 col-xs-2">
             <p class="font-weight text-center">COMPROBANTE</p>
           </div>
         </div>
         <hr>
         <div class="col-md-12 row" id="charges">
           
         </div>

         <hr>
        
    </section>

@else
      <!-- OTROS ROLES -->
       <section class="col-md-8 mx-auto bg-white s-informacion mt-5">
        <h4 class="font-weight">Facturación y pago</h4>
        

         <div class="col-md-6 col-xs-6 row">
          <div class="col-md-1 col-xs-1">
              <i class="fas fa-user-cog"></i>
          </div>
          <div class="col-md-10 col-xs-10">
          <p>Usuario: <span class="font-weight"> {{Auth()->user()->role->name}}</span></p>
          <p>No tiene suscripción</p>
        </div>

          </div>
            
         

         
        
    </section>
      <!-- OTROS ROLES -->
@endif
    
    {{-- JHED INFO --}}
    <section class="col-md-8 mx-auto bg-white s-informacion-info mt-2">   
      <div class="col-md-12 col-xs-12 row">  
            <span>Para mayor información sobre su facturación y pagos realizados, comuniquese al 
              <a class="text-decoration-none" href="tel:981324180"><span>981 324 180</span></a>
               o puede escribirnos al 
               <a class="text-decoration-none" href="mailto:info2@constructivo.com"><span>info2@constructivo.com</span></a>
            </span>        
      </div>       
    </section>
    {{-- JHED INFO --}}  

  </section>

@endsection
@section('script-extra')
<script>
  function updateProfile(form) {
    event.preventDefault();
    console.log(form);
  }

  function readImage(input) {
    if (input.files && input.files[0]) {
          let reader = new FileReader();

          reader.onload = function (e) {
              $('#showImage')
                  .attr('src', e.target.result);
              //toastr.info('Ahora presione Actualizar','¡Genial!');
              console.log('Ahora presione Actualizar','¡Genial!');
          };

          reader.readAsDataURL(input.files[0]);
    }
  }
</script>

<script>
  $(document).ready(function(){
    getCharges();
  });

 // let tbCharges = $("#subscriptions");
  let tbCharges = $("#charges");

  function getCharges(page = 0, cursor = '') {
    console.log("1");
   let ruta = '/profile/cargos/cargos-data';
    //spinner.show();
    $.ajax({
      url: ruta,
      type: 'GET',
      dataType: 'JSON',
      success: res =>{
        tbCharges.empty();
        //spinner.hide();

        res.charges.forEach(charge =>{
          if(charge.current_amount>0) {

            if (charge.outcome.type=="venta_exitosa"){
              tbCharges.append(`

                <div class="col-md-2 col-xs-2">
                 <p class=" text-center">${ getDateFormat(charge.creation_date)}</p>
               </div>
               <div class="col-md-2 col-xs-2">
                 <p class=" text-center">Recurrente</p>
               </div>
               <div class="col-md-2 col-xs-2">
                 <p class=" text-center">Revista Digital</p>
               </div>
               <div class="col-md-2 col-xs-2">
                 <p class=" text-center">${charge.current_amount/100}.00 ${charge.currency_code}</p>
               </div>
               <div class="col-md-2 col-xs-2">
                 <p class=" text-center">ACTIVO</p>
               </div>
               <div class="col-md-2 col-xs-2">
                 <p class=" text-center"><a class="a-menu a-menu-b tt-uppercase"
                      style="text-decoration: none;padding: 1% 4%" href=""cargos/vaucher/${charge.creation_date}""><i class="fas fa-download"></i> Solicitar</a></p>
               </div>

              `);
            }
          }
          else{

          }

         
        });  
              
          console.log(res.charges);
          console.log(res);
        
        
        
      },
      error: error =>{
        spinner.hide();
        toastr.error(JSON.parse(error.responseJSON).message);
        console.log(error.responseText);
      }
    });
  }



  function getDateFormat(unix_timestamp) {

    let date = new Date(unix_timestamp);

    let fecha = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

    return fecha;
  }
</script>
 {{-- Form Age_Profession --}}
    <script>
        function fecha_nacimiento(value) {
            var fecha_seleccionada = value;
            var fecha_nacimiento = new Date(fecha_seleccionada);
            var fecha_Actual = new Date();
            var edad = (parseInt((fecha_Actual - fecha_nacimiento) / (1000 * 60 * 60 * 24 * 365)));
            if (edad < 18) {
                document.getElementById("invalid_FN").style.display = "block";
                document.getElementById("invalid_FN").innerHTML = "<strong>La fecha de nacimineto es menor de 18+</strong>";
                document.getElementById("btn_registro").disabled = true;
            } else if (edad > 151) {
                document.getElementById("invalid_FN").style.display = "block";
                document.getElementById("invalid_FN").innerHTML =
                    "<strong>La fecha de nacimineto no puede exeder de 150</strong>";
                document.getElementById("btn_registro").disabled = true;
            } else {
                document.getElementById("invalid_FN").style.display = "none";
                document.getElementById("invalid_FN").innerHTML = " ";
                document.getElementById("btn_registro").disabled = false;
            }
        }
    </script>
@endsection
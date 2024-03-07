@extends('layouts.front')
@section('titulo','Suscripción')
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-5 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-9 view-text-blue">
      
      @if($user->isPremium() and $user->tarjeta_id=='')
      {{--@if($user->isPremium())--}}
      <!-- SUSCRIPCION PREMIUM -->
        <h4 class="title">Datos de suscripción</h4>
        <div class="suscrip-header mt-3">
          <div class="row text-center">
            <div class="col-md-3 p-1 plan">{{$user->suscriptorDeposito->plan->name}}</div>
            <div class="col-md-5 p-1">
              <span><strong>Fecha de caducidad: </strong>{{date('d/m/Y',strtotime($user->suscriptorDeposito->suscription_end))}}</span>
            </div>
            <div class="col-md-4 p-1">
              <span><strong>Modalidad: </strong>{{$user->suscriptorDeposito->getTipo()}}</span>
            </div>
          </div>
        </div>
        <div class="row mt-2">
          <div class="col-xs-12 col-md-4"></div>
          <div class="col-xs-12 col-md-4"></div>
          <div class="col-xs-12 col-md-4">
            <span><strong>Mod. Último pago: </strong>{{$user->suscriptorDeposito->metodoPago->name}}</span>
          </div>
        </div>
        
        @if($user->suscriptorDeposito->currentDays() < 15)
        <div class="row mt-4 mb-4 d-flex justify-content-center">
            <a href="{{route('planes',$a)}}" class="btn btn-green btn-sm"><i class="fas fa-sync-alt"></i> Renovar Online</a>&nbsp;
            <button type="button" class="btn btn-blue btn-sm" data-toggle="modal" data-target="#modal1"><i class="fas fa-sync-alt"></i> Notificar</button>
        </div>
        @endif
        <div class="mt-3">
          <h5>Lista de pagos</h5>
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <th>Id</th>
                <th>Monto</th>
                <th>Mod. Pago</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Comprobante</th>
              </thead>

              <tbody>
                @foreach($user->suscriptorDeposito->pagos()->orderBy('id','desc')->get() as $pago)
                  <tr>
                    <td>{{$pago->id}}</td>
                    <td>{{$pago->monto}} {{$pago->moneda}}</td>
                    <td>{{$pago->metodoPago->name}}</td>
                    <td>{{$pago->getTipo()}}</td>
                    <td>{{$pago->descrip}}</td>
                    <td>
                      @if($pago->voucher_emit == 0)
                      <a href="{{route('voucher.create',$pago->id)}}" class="btn btn-secondary btn-sm">Solicitar</a>
                      @elseif($pago->voucher_emit == 1)
                      <span>Solicitada</span>
                      @else
                      <span>Emitida</span>
                      @endif
                      
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>

        <form action="{{route('notifications.store')}}" method="POST">
          {{ csrf_field() }}
        <!-- Modal -->
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title blacktext" id="exampleModalLabel">Formulario de Notificación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="col-md-12">
                    <input type="hidden" name="type_id" value="2">
                    <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            
          </div>
        </div>
        </form>
      <!-- SUSCRIPCION PREMIUM -->
      @elseif($user->isFree())
      <!-- SUSCRIPCION GRATIS -->
      <div class="bordeador">
        <h3>Suscripción</h3>
        <div class="container-fluid">
          <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-6">                  
              <span class="oranger">Plan Actual:</span> Gratis
            </section>
            {{-- <section class="col-xs-12 col-sm-12 col-md-6">
              <span class="oranger">Fecha de Ingreso:</span> 01/01/2012
            </section> --}}
            
          </div>
          <div class="row valign">
            <section class="col-12">
              <a href="{{route('planes',$a)}}" class="btn btn-success"><i class="fas fa-user-plus"></i> Mejorar Plan</a>
            </section>
          </div>
        </div>
      </div>
      <!-- SUSCRIPCION GRATIS -->
      @elseif($user->isCliente())
      <!-- CLIENTE -->
      <div class="bordeador">
        <div class="container-fluid">
          <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-6">                  
              <h4><span class="oranger">Rol:</span> {{$user->role->name}}</h4>
            </section>
            <section class="col-xs-12 col-sm-12 col-md-6">
              <h4>Acceso: <span class="badge badge-secondary">{{$user->cliente->getEstado()}}</span></h4>
              @if($user->cliente->status == 0)
               <div class="mt-3">
                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal2"><i class="fas fa-sync-alt"></i> Solicitar Activación</button>
               </div>
               <form action="{{route('notifications.store')}}" method="POST">
                 {{ csrf_field() }}
               <!-- Modal -->
               <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                   
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title blacktext" id="exampleModalLabel">Formulario de Notificación</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                       <div class="modal-body">
                         <div class="col-md-12">
                           <input type="hidden" name="type_id" value="3">
                           <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                         </div>
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Enviar</button>
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                       </div>
                   </div>
                   
                 </div>
               </div>
               </form>
              @endif
            </section>
          </div>
        </div>
      </div>
      <!-- CLIEENTE -->
      <!-- RECURRENTE-->
           
      @elseif($user->isPremium() and $user->tarjeta_id!='')
          <!-- SUSCRIPCION PREMIUM -->
        <h4 class="title">Datos de suscripción</h4>
        <div class="suscrip-header mt-3">
          <div class="row text-center">
            <div class="col-md-3 p-1 plan">{{$plan->name}}</div>
            <div class="col-md-5 p-1">
<?php 
  $fecha_creacion= (new DateTime())
  ->setTimestamp( $suscripcion->creation_date/ 1000)
  ->format('d-m-Y');

  $fecha_iniciociclo= (new DateTime())
  ->setTimestamp( $suscripcion->current_period_start/ 1000)
  ->format('d-m-Y');    

  $fecha_sigpago= (new DateTime())
  ->setTimestamp( $suscripcion->next_billing_date/ 1000)
  ->format('d-m-Y');

?>
              <span><strong>Siguiente pago: </strong>{{$fecha_sigpago}}</span>
            </div>
            <div class="col-md-4 p-1">
              <span><strong>Modalidad: </strong>{{--$user()->suscriptorRecurrente->getTipo()--}} Revista Digital</span>
            </div>
          </div>
        </div>
     
        <div class="mt-3">
          <h5>Lista de pagos</h5>
          <div class="table-responsive">
            <table class="table table-hover table-bordered">
              <thead>
                <th>Fecha del pago</th>
                <th>Monto</th>
                <th>Mod. Pago</th>
                <th>Tipo</th>
                <th>Estado</th>
                <!--<th>N° ciclo actual</th>-->
                <th>Comprobante</th>
              </thead>
              <tbody id="charges">
                <tr>
              </tbody>
            </table>
          </div>
        </div>

         <div class="text-right">
        <br>
       <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#exampleModal">
          Cancelar Suscripción
        </button>
      </div>
        

                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h4 class="modal-title text-center text-danger font-weight-bold" id="exampleModalLabel">¡ ADVERTENCIA !</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <h5 class="text-warning text-center"><i class="fas fa-exclamation-triangle text-danger"></i> Si cancelas la suscripción <i class="fas fa-exclamation-triangle text-danger"></i></h5>
                        <li>Dejarás de ser usuario <span class="font-weight-bold text-info">Premium</span></li>
                        <li>No tendrás acceso a los <span class="font-weight-bold text-danger">videos</span> de la plataforma</li>
                        <li>No tendrás acceso a los <span class="font-weight-bold text-danger">artículos</span> de la plataforma </li>
                        <li>No tendrás acceso al <span class="font-weight-bold text-danger">suplemento técnico</span>  de la plataforma</li>
                        <li>No tendrás acceso a las <span class="font-weight-bold text-danger">revistas</span>  de la plataforma </li>
                        <li>Inmediatamente pasarás a ser <span class=" text-secondary">usuario gratuito</span></li>
                        <br>
                        <h5 class="font-weight-bold text-danger text-center">¿Estás seguro que quieres eliminar tu suscripción?</h5>


                        
                        
                      </div>
                      <div class="modal-footer text-center">
                        <button type="button" class="btn btn-outline-success" data-dismiss="modal">Seguir Con el Plan</button>
                        <a href="{{route('cancelsus')}}"  class="btn btn-outline-danger">Eliminar Suscripción</a>
                      </div>
                    </div>
                  </div>
                </div>

        <form action="{{route('notifications.store')}}" method="POST">
          {{ csrf_field() }}
        <!-- Modal -->
        <div class="modal fade" id="modal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title blacktext" id="exampleModalLabel">Formulario de Notificación</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="col-md-12">
                    <input type="hidden" name="type_id" value="2">
                    <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Enviar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            
          </div>
        </div>
        </form>
      <!-- SUSCRIPCION PREMIUM -->
      @elseif($user->isFree())
      <!-- SUSCRIPCION GRATIS -->
      <div class="bordeador">
        <h3>Suscripción</h3>
        <div class="container-fluid">
          <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-6">                  
              <span class="oranger">Plan Actual:</span> Gratis
            </section>
            {{-- <section class="col-xs-12 col-sm-12 col-md-6">
              <span class="oranger">Fecha de Ingreso:</span> 01/01/2012
            </section> --}}
            
          </div>
          <div class="row valign">
            <section class="col-12">
              <a href="{{route('planes',$a)}}" class="btn btn-success"><i class="fas fa-user-plus"></i> Mejorar Plan</a>
            </section>
          </div>
        </div>
      </div>
      <!-- SUSCRIPCION GRATIS -->
      @elseif($user->isCliente())
      <!-- CLIENTE -->
      <div class="bordeador">
        <div class="container-fluid">
          <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-6">                  
              <h4><span class="oranger">Rol:</span> {{$user->role->name}}</h4>
            </section>
            <section class="col-xs-12 col-sm-12 col-md-6">
              <h4>Acceso: <span class="badge badge-secondary">{{$user->cliente->getEstado()}}</span></h4>
              @if($user->cliente->status == 0)
               <div class="mt-3">
                 <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal2"><i class="fas fa-sync-alt"></i> Solicitar Activación</button>
               </div>
               <form action="{{route('notifications.store')}}" method="POST">
                 {{ csrf_field() }}
               <!-- Modal -->
               <div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                 <div class="modal-dialog" role="document">
                   
                   <div class="modal-content">
                     <div class="modal-header">
                       <h5 class="modal-title blacktext" id="exampleModalLabel">Formulario de Notificación</h5>
                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                       </button>
                     </div>
                       <div class="modal-body">
                         <div class="col-md-12">
                           <input type="hidden" name="type_id" value="3">
                           <textarea name="body" class="form-control" rows="4" placeholder="Escriba un mensaje..."></textarea>
                         </div>
                       </div>
                       <div class="modal-footer">
                         <button type="submit" class="btn btn-primary">Enviar</button>
                         <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                       </div>
                   </div>
                   
                 </div>
               </div>
               </form>
              @endif
            </section>
          </div>
        </div>
      </div>
    }
      <!-- RECURRENTE -->
      @else
      <!-- OTROS ROLES -->
      <div class="bordeador">
        <div class="container-fluid">
          <div class="row">
            <section class="col-xs-12 col-sm-12 col-md-6">                  
              <span class="oranger">Rol:</span> {{Auth()->user()->role->name}}
            </section>
            <section class="col-xs-12 col-sm-12 col-md-6">
              <span class="oranger">No tiene suscripción<br>
            </section>
          </div>
        </div>
      </div>
      <!-- OTROS ROLES -->
      @endif
       
      

    </div>
  </div>
</div>
@endsection
@section('script-extra')
<script>
  $(document).ready(function(){
    getCharges();
  });

 // let tbCharges = $("#subscriptions");
  let tbCharges = $("#charges");

  function getCharges(page = 0, cursor = '') {
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
                 <tr>
                <td>${ getDateFormat(charge.creation_date)}</td>
                <td> ${charge.current_amount/100}.00 ${charge.currency_code}</td>
                <td>Recurrente</td>
                <td>Revista Digital</td>
                <td>ACTIVO</td>
                <td>
                      <a href="cargos/vaucher/${charge.creation_date}" class="btn btn-outline-success">Solicitar</button>
                </td>
                </tr>

              `);
            }
          }
          else{

          }

         
        });  
              
         // console.log(res.charges);
          //console.log(res);
        
        
        
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


  function verDetalle(charge) {
    $("#details").html(`
<form action="{{route('solicitudvoucher')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
  <div class="form-group">
              <label>
                <input type="radio" name="tipo_comprobante" value="Boleta" checked> Boleta
              </label>
              &nbsp; &nbsp; &nbsp; 
              <label class="ml-5">
                <input type="radio" name="tipo_comprobante" value="Factura"> Factura
              </label>
  </div>
  <div class="form-group">
              <label for="name">Nombre / Razon social</label>
              <input type="text" class="form-control {{ $errors->has('rsocial') ? ' is-invalid' : '' }}"  name="rsocial" autofocus>
               @if ($errors->has('rsocial'))
                 <span class="invalid-feedback">
                     <strong>{{ $errors->first('rsocial') }}</strong>
                 </span>
              @endif
   </div>  
   <div class="form-group">
            <label for="name">Dirección</label>
            <input type="text" class="form-control" name="address" value="{{Auth()->user()->address}}">
          </div>               
            <div class="form-group">
              <label for="last_name">RUC/DNI</label>
              <input type="text" class="form-control {{ $errors->has('ruc') ? ' is-invalid' : '' }}" name="ruc" value="{{Auth()->user()->doc_number}}">
               @if ($errors->has('ruc'))
                 <span class="invalid-feedback">
                     <strong>{{ $errors->first('ruc') }}</strong>
                 </span>
              @endif
            </div> 
        <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
              <button type="submit" class="btn btn-default">Enviar solicitud</button>
        </div>

  
 
</form>
      `);
    $("#modal-details").modal();
  }

</script>
@endsection
@extends('layouts.app')
@section('titulo','Transacciones de CULQI')
@section('content')
<div class="container-fluid">
  <div class="panel panel-default">
    <div class="panel-heading">
      <div class="panel-title">Transacciones de CULQI</div>
    </div>
    <div class="panel-body">
      
      <hr>
      <h5>Ultimos cargos</h5>

      <div class="table-responsive">
        <table class="table table-condensed table-hover table-bordered">
              <thead>
                <th>id</th>
                <th>Fecha del pago</th>
                <th>Monto</th>
                <th>Descripción</th>
                <th>Control</th>      
              </thead>
              <tbody id="charges">
                
              </tbody>
            </table>
      </div>
      {{--<div class="modal" tabindex="-1" id="modal-details" role="dialog">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <div class="modal-title"><h3>Solicitar Comprobante</h3></div>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-12" id="details"></div>
              </div>
            </div>
            
          </div>
        </div>
      </div>--}}
        
    </div>
  </div>
</div>

@endsection
@section('extra_scripts')
<script>
  $(document).ready(function(){
    getCharges();
  });

 // let tbCharges = $("#subscriptions");
  let tbCharges = $("#charges");

  function getCharges(page = 0, cursor = '') {
   let ruta = '/profile/cargos/cargos-data';


    spinner.show();
    $.ajax({
      url: ruta,
      type: 'GET',
      dataType: 'JSON',
      success: res =>{
        tbCharges.empty();
        spinner.hide();

        res.charges.forEach(charge =>{
          tbCharges.append(`
            <td>${charge.id}</td>
            <td>${ getDateFormat(charge.creation_date)}</td>
            <td>S/. ${charge.amount/100}.00</td>
            <td>${charge.description}</td>
            <td>
                  <a href="cargos/vaucher/${charge.creation_date}" class="btn btn-default">Solicitar Comprobante</button>
            </td>

        `);
        });  
              
          console.log(res.charges);
          console.log(res);
        
        //renderPagination(response,'getCharges');
         //setPagination(res.paging);
         
        
        
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
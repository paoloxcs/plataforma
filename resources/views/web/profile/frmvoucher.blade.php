@extends('layouts.front')
@section('titulo','Solicitud de comprobante')
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-4 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-9 view-text-blue">
      <h4 class="title">Solicitud de comprobante</h4><hr>
      <form action="{{route('solicitudvoucher')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        <input type="hidden" name="pago_id" value="{{$pago_id}}">
      <div class="row">
        <section class="col-xs-12 col-sm-12 col-md-6">
            <div class="form-group">
              <label>
                <input type="radio" name="tipo_comprobante" value="Boleta" checked> Boleta
              </label>
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
        </section>
        <section class="col-xs-12 col-sm-12 col-md-6">   
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
        </section>
      </div>
      <div class="row flexcentre valign">
        <button type="submit" class="btn btn-green"><i class="fas fa-location-arrow"></i> Enviar solicitud</button>
      </div>
      </form>
    </div>
  </div>
</div>

@endsection
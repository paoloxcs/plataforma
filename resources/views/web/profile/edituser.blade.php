@extends('layouts.front')
@section('titulo','Datos Personales')
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-5 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-9">
      <form action="{{route('updateuser',Auth()->user()->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="row">
          <div class="col-xs-12 col-md-4 d-flex justify-content-center align-items-center mb-3">
            <div class="foto_profile">
              @if(Auth()->user()->url_foto != null)
                <img id="showImage" src="{{asset('fotousers/'.Auth()->user()->url_foto)}}" alt="">
              @else
                <img id="showImage" src="{{asset('fotousers/profile.png')}}" alt="">         
              @endif
              <span>
                <div class="action">
                  <label for="fotouser" id="ulpload-foto">Cambiar</label>
                  <input type="file" name="perfil" id="fotouser" onchange="readImage(this);" accept="image/*" style="display: none;">

                </div>
              </span>
            </div>
            
          </div>
          <div class="col-xs-12 col-md-8 view-text-blue">
            <h4 class="title">Mis datos personales</h4>
            <hr>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <label for="name">Nombres:</label>
                  <input type="text" class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{Auth()->user()->name}}">
                   @if ($errors->has('name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('name') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <label for="last_name">Apellidos:</label>
                  <input type="text" class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{Auth()->user()->last_name}}">
                   @if ($errors->has('last_name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('last_name') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="email">Correo electrónico:</label>
              <input type="email" class="form-control" name="email" disabled value="{{Auth()->user()->email}}">
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-4">
                <div class="form-group">
                  <label for="phone_number">N° telf.</label>
                  <input type="text" class="form-control {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number"  value="{{Auth()->user()->phone_number}}">
                   @if ($errors->has('phone_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('phone_number') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-md-8">
                <div class="form-group">
                  <label for="address">Dirección:</label>
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
              </div>
            </div>
            <div class="mt-2 text-center">
              <input type="submit" class="btn btn-blue" value="Actualizar">
            </div>
            
            
          </div>
        </div>
      </form>
    </div>
  </div>
  
</div>
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
              toastr.info('Ahora presione Actualizar','¡Genial!');
          };

          reader.readAsDataURL(input.files[0]);
    }
  }
</script>
@endsection
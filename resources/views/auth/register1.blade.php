@extends('layouts.front')
@section('titulo','Regístrate Gratis')
@section('content')

  <div class="container">
    <div class="col-xs-12 col-md-8 col-lg-6 mx-auto mt-3">
      <div class="card card-register">
        <div class="card-header text-center">
          <div class="card-title">REGÍSTRATE AHORA</div>
        </div>
        <div class="card-body">
          <form action="{{route('register')}}" method="POST">
            {{ csrf_field() }}
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input class="form-control {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" aria-describedby="nameHelp" placeholder="Nombres" autofocus value="{{old('name')}}">
                   @if ($errors->has('name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('name') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input class="form-control {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" aria-describedby="nameHelp" placeholder="Apellidos" value="{{old('last_name')}}">
                   @if ($errors->has('last_name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('last_name') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
            </div>
            <div class="form-group">
                <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" aria-describedby="emailHelp" placeholder="Correo electrónico" value="{{old('email')}}">
                 @if ($errors->has('email'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('email') }}</strong>
                   </span>
                @endif
            </div>
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input id="password" type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña">
                   @if ($errors->has('password'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Confirmar contraseña">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input type="number" name="phone_number" class="form-control {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="Telf. / Movil">
                   @if ($errors->has('phone_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('phone_number') }}</strong>
                     </span>
                  @endif
                </div>
              </div>

                <div class="col-xs-12 col-md-6">
                <div class="form-group">
              
                    <select name="pais" class="form-control {{ $errors->has('pais') ? ' is-invalid' : '' }}" >
                      <option value="" disabled="" selected=""><< Seleccione País >></option>
                      <option value="Argentina">Argentina</option>
                      <option value="Bolivia">Bolivia</option>
                      <option value="Chile">Chile</option>
                      <option value="Colombia">Colombia</option>
                      <option value="Ecuador">Ecuador</option>
                      <option value="México">México</option>
                      <option value="Perú">Perú</option>
                      <option value="Otro">Otro</option>
                    </select>
                   @if ($errors->has('pais'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('pais') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="form-group">
                  <input type="hidden" name="address" class="form-control {{ $errors->has('address') ? ' is-invalid' : '' }}" placeholder="Dirección" value="Defined address">
                   @if ($errors->has('address'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('address') }}</strong>
                     </span>
                  @endif
                </div>
              </div>
              <input type="hidden" name="slugplan" class="form-control"  value="{{$slug}}">
              <input type="hidden" name="tipo" class="form-control"  value="user">
              <input type="hidden" name="empresa" class="form-control"  value="defined">

                  <input type="hidden" name="cargo" class="form-control" value="defined" >
              <div class="col-xs-12 col-md-12">
                <div class="form-group">
                  <label>Medios de Interés</label><br>
                  @if ($errors->has('medios'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('medios') }}</strong>
                     </span>
                  @endif
                  @foreach($medios as $medio)
                  <div class="form-check form-check-inline">
                    <input class="form-check-input {{ $errors->has('medios') ? ' is-invalid' : '' }}" name="medios[]" type="radio" id="inlineCheckbox{{$medio->id}}" value="{{$medio->id}}">
                    <label class="form-check-label" for="inlineCheckbox{{$medio->id}}">{{$medio->name}}</label>
                  </div>
                  @endforeach
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-blue btn-block">Registrarme</button>
          </form>
          <div class="text-center mt-2">
            <hr>
            <a class="d-block" href="{{route('login')}}">Ó inicia sesión</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
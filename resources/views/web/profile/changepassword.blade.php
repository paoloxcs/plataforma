@extends('layouts.front')
@section('titulo','Cambiar Contraseña')
@section('content')
<div class="none">{{$a='construccion'}}</div>
<div class="container">
  <div class="row mt-5 mb-3">
    <div class="col-xs-12 col-md-3">
      @include('web.profile.menu')
    </div>
    <div class="col-xs-12 col-md-6 view-text-blue">
      <h4 class="title">Cambiar contraseña</h4>
      <hr>
      <form action="{{route('updatepassword')}}" method="POST">
        {{ csrf_field() }}
        <div class="form-group">
          <label for="currentpass">Contraseña Actual</label>
          <input type="password" class="form-control {{ $errors->has('currentpass') ? ' is-invalid' : '' }}" id="currentpass" name="currentpass"> 
          @if ($errors->has('currentpass'))
            <span class="invalid-feedback">
                <strong>{{ $errors->first('currentpass') }}</strong>
            </span>
         @endif                  
        </div>
        <div class="form-group">
          <label for="newpass">Nueva Contraseña</label>
          <input type="password" class="form-control {{ $errors->has('newpass') ? ' is-invalid' : '' }}" id="newpass" name="newpass" placeholder="6 caracteres alfanumericos como mínimo">
           @if ($errors->has('newpass'))
             <span class="invalid-feedback">
                 <strong>{{ $errors->first('newpass') }}</strong>
             </span>
          @endif        
        </div>

        <div class="form-group">
          <label for="newpass-confirm">Confirmar Nueva Contraseña</label>
          <input type="password" class="form-control" id="newpass-confirm" name="newpass_confirmation">
        </div>
        <div class="fila flexcentre valign">
          <button type="submit" class="btn btn-blue"><i class="fas fa-save"></i> Cambiar</button>  
        </div>               
      </form>
    </div>
  </div>
</div>
@endsection
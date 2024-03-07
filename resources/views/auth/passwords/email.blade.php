@extends('layouts.front')
@section('titulo','Restablecer Contraseña')
@section('content')
<div class="none">{{$a='construccion'}}</div>

<div class="container">
    <div class="col-xs-12 col-md-6 col-lg-4 mx-auto mt-5">
        <div class="card">
            <div class="card-header">
                <div class="card-title text-center">Recuperar contraseña</div>
            </div>
            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="Ingresa tu correo" autofocus placeholder="Correo electrónico">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-blue btn-block">
                            Enviar link de recuperación
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

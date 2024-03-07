@extends('layouts.app')
@section('titulo','Nuevo registro')
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('users.index')}}"><i class="fa fa-list-ol"></i> Usuarios</a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fa fa-plus"></i> Nuevo registro
        </li>
    </ol>
    <div class="panel panel-primary">
        <div class="panel-body">
            <form method="POST" action="{{route('users.store')}}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Nombres</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ingrese nombres" value="{{old('name')}}" autofocus>
                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label for="last_name">Apellidos</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Ingrese apellidos" value="{{old('last_name')}}" autofocus>
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email">Correo electrónico</label>
                            <input type="email" name="email" class="form-control" placeholder="Ingrese correo electrónico" value="{{old('email')}}">
                            @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label for="password">Contraseña</label>
                                    <input type="password" name="password" class="form-control" placeholder="Nueva contraseña">
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <div class="form-group">
                                    <label for="password-confirm">Confirmar Contraseña</label>
                                    <input type="password" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Confirme la contraseña">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="role" class="control-label">Seleccione Rol</label>
                            <select name="role" id="role" class="form-control">
                                @foreach($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            <a href="#" class="btn btn-default" onclick="history.back();"><i class="fa fa-arrow-left" aria-hidden="true"></i> Volver</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

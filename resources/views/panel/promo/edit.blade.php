@extends('layouts.app')
@section('titulo','Editar registro')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li>
          <a href="{{route('promos.index')}}"><i class="fa fa-list-ol"></i> Promociones</a>
      </li>
      <li class="breadcrumb-item active">
        <i class="fa fa-pencil"></i> Editar registro
      </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
            <form action="{{route('promos.update',$promo->id)}}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" class="form-control" value="{{old('name',$promo->name)}}">
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->has('descripcion') ? ' has-error' : '' }}">
                            <label for="descripcion">Detalle</label>
                            <textarea name="descripcion" class="form-control ckeditor">{{old('descripcion',$promo->descripcion)}}</textarea>
                            @if ($errors->has('descripcion'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('descripcion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="plan">Elige un plan</label>
                                    <select name="plan" class="form-control">
                                        @foreach($planes as $plan)
                                        @if($promo->plan_id == $plan->id)
                                        <option selected value="{{$plan->id}}">{{$plan->name}}</option>
                                        @else
                                        <option value="{{$plan->id}}">{{$plan->name}}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group {{ $errors->has('precio') ? ' has-error' : '' }}">
                                    <label for="precio">Precio</label>
                                    <input type="number" name="precio" class="form-control" value="{{old('precio',$promo->precio)}}">
                                    @if ($errors->has('precio'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('precio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group {{ $errors->has('fecha_ini') ? ' has-error' : '' }}">
                                    <label for="fecha_ini">Fecha de Inicio</label>
                                    <input type="date" name="fecha_ini" class="form-control" value="{{old('fecha_ini',$promo->fecha_ini)}}">
                                    @if ($errors->has('fecha_ini'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fecha_ini') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-4">
                                <div class="form-group {{ $errors->has('fecha_fin') ? ' has-error' : '' }}">
                                    <label for="fecha_fin">Fecha de Fin</label>
                                    <input type="date" name="fecha_fin" class="form-control" value="{{old('fecha_fin',$promo->fecha_fin)}}">
                                    @if ($errors->has('fecha_fin'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('fecha_fin') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group {{ $errors->has('portada') ? ' has-error' : '' }}">
                                    <label for="portada">Remplazar portada (Opcional)</label>
                                    <input type="file" name="portada" accept="image/*">
                                    @if ($errors->has('portada'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('portada') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group">
                                    <label for="estado">Estado</label>
                                    <select name="estado" class="form-control">
                                        @if($promo->estado == 1)
                                        <option selected value="1">Activo</option>
                                        <option value="0">Inactivo</option>
                                        @else
                                        <option value="1">Activo</option>
                                        <option selected value="0">Inactivo</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Actualizar</button>
                            </div>    
                        </div>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endsection
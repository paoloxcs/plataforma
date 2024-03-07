@extends('layouts.app')
@section('titulo','Promociones')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Promociones
      </li>
    </ol>
    @include('alerts.success')
    <div class="panel panel-success">
        <div class="panel-body">
        <div class="row">
            <div class="col-md-2 pull-right">
                <a href="{{route('promos.create')}}" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Portada</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Plan</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($promos as $promo)
                    <tr>
                        <td>{{$promo->id}}</td>
                        <td>{{$promo->name}}</td>
                        <td>
                            <img width="100" src="{{asset('posts/'.$promo->url_portada)}}" alt="">
                        </td>
                        <td>{{date('d/m/Y',strtotime($promo->fecha_ini))}}</td>
                        <td>{{date('d/m/Y',strtotime($promo->fecha_fin))}}</td>
                        <td>{{$promo->plan->name}}</td>
                        <td>
                            @if($promo->estado == 1)
                            <span class="label label-success">Activo</span>
                            @else
                            <span class="label label-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{route('promos.edit',$promo->id)}}" class="btn btn-primary btn-sm">Editar</a>
                            <a href="{{route('promos.destroy',$promo->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro de eliminar el registro?');">Eliminar</a>
                        </td>
                    </tr>
                @endforeach    
                   
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>
@endsection
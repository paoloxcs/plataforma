@extends('layouts.app')
@section('titulo','Permisos')
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <a href="{{route('roles.index')}}"><i class="fa fa-list-ol"></i> Roles</a>
            
        </li>
        <li>
            <i class="fa fa-cog"></i> Permisos
        </li>
    </ol>
    @include('alerts.success')
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Permisos de {{ strtoupper($role->name) }}</div>
        </div>
        <div class="panel-body">
            <form action="{{route('auditpermiso',$role->id)}}" method="POST">
                {{ csrf_field()}} {{method_field('PUT')}}
                <div class="row">
                    @foreach($permisos as $perm)
                    
                    <div class="col-xs-12 col-md-3">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        <i class="fa fa-cog"></i>
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div>{{$perm->name}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                @if($role->hasPermisoTo($perm->id))
                                <label>
                                    <input type="checkbox" checked name="permisos[]" value="{{$perm->id}}"> {{$perm->slug}}
                                </label>
                                @else
                                <label>
                                    <input type="checkbox" name="permisos[]" value="{{$perm->id}}"> {{$perm->slug}}
                                </label>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-4 col-md-offset-4">
                        <button type="submit" class="btn btn-success"><span class="fa fa-refresh"></span> Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
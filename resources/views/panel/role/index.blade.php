@extends('layouts.app')
@section('titulo','Roles')
@section('content')
<div class="container">
    @include('alerts.success')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <i class="fa fa-list-ol"></i> Roles
        </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Grupo</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{$role->id}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->grupo}}</td>
                        <td>
                            <a href="{{route('roles.show',$role->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Permisos</a>

                            {{-- <a href="{{route('roles.destroy',$role->id)}}" class="btn btn-danger btn-sm" onclick="return confirm('Advertencia!\n¿Está seguro de eliminar el registro ?')"><i class="fa fa-trash"></i> Eliminar</a> --}}
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
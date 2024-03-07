@extends('layouts.app')
@section('titulo', 'Planes')
@section('content')
    <style>
        .panel-secondary {
            border-color: #5f5f5f;
        }

        .panel-secondary>.panel-heading {
            color: #fff;
            background-color: #5f5f5f;
            border-color: #5f5f5f;
        }
    </style>
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <i class="fa fa-list-ol"></i> Planes
            </li>
        </ol>
        @include('alerts.success')
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="row">
                    {{-- Filtrar por fecha Filtrar por estado --}}
                    <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column; float: right">
                        <div style="display: flex">
                            <span onclick="openNewModalFilter();" class="btn btn-warning"
                                style="margin: 1rem 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter" aria-hidden="true"></i>
                                Filtros</span>
                            <a href="{{ route('planes.index') }}" class="btn btn-danger" title="Eliminar filtros"
                                style="margin-top: 1rem"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </div>
                        <a href="{{ route('planes.create') }}" class="btn btn-success" style="margin-top: 2rem"> <i
                                class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Precio</th>
                                <th>Promoción</th>
                                <th>Moneda</th>
                                <th>Estado</th>
                                <th>Fecha Up</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($planes as $plan)
                                <tr>
                                    <td>{{ $plan->id }}</td>
                                    <td>{{ $plan->name }}</td>
                                    <td>{{ $plan->precio }}</td>
                                    <td>{{ $plan->promocion }}</td>
                                    <td>{{ $plan->moneda }}</td>
                                    <td>
                                        @if ($plan->status == 1)
                                            <span class="label label-success">Activo</span>
                                        @else
                                            <span class="label label-danger">Inactivo</span>
                                        @endif
                                    </td>
                                    <td>{{ $plan->updated_at->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('planes.edit', $plan->id) }}"
                                            class="btn btn-primary btn-sm">Editar</a>
                                        <a href="{{ route('planes.destroy', $plan->id) }}" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro de eliminar el registro?');">Eliminar</a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div> 

                @include('panel.plan.new_filters')
            </div>
        </div>
    </div>
@endsection
@section('extra_scripts')
    <script>
        function openNewModalFilter() {
            $("#modal_new_filter").modal();
        }
    </script>
@endsection

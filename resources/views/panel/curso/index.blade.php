@extends('layouts.app')
@section('titulo', 'Cursos')
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

        .span_off {
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgba(255, 179, 179, 0.582);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            line-height: 1;
            padding-top: .25rem;
            padding-bottom: .25rem;
            padding-left: .5rem;
            padding-right: .5rem;
            color: rgb(255, 0, 0);
        }

        .span_on {
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgb(210, 252, 199);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.25rem;
            line-height: 1;
            padding-top: .25rem;
            padding-bottom: .25rem;
            padding-left: .5rem;
            padding-right: .5rem;
            color: rgb(32, 153, 1);
        }

        .span_mini_off {
            color: rgba(74, 85, 104, 1);
            line-height: 1.5;
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgba(229, 62, 62, 1);
            border-radius: 9999px;
            display: inline-block;
            height: .5rem;
            margin-right: .5rem;
            width: .5rem;
        }

        .span_mini_on {
            color: rgba(74, 85, 104, 1);
            line-height: 1.5;
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgb(95, 229, 62);
            border-radius: 9999px;
            display: inline-block;
            height: .5rem;
            margin-right: .5rem;
            width: .5rem;
        }
    </style>

    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <i class="fa fa-list-ol"></i> cursos
            </li>
        </ol>
        <div class="panel panel-success">
            <div class="panel-body">
                {{-- <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="input-group has-success">
                            <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                            <input type="text" id="texto" class="form-control" aria-describedby="basic-addon3"
                                placeholder="Escriba aquí">
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            data-target=".bd-example-modal-lg"><i class="fa fa-plus"></i> Nuevo registro</button>
                    </div>
                </div> --}}

                {{-- Filtrar por fecha Filtrar por estado --}}
                <div class="row">
                    <form action="{{ route('cursos') }}" class="col-xs-12 col-md-8">
                        @if (request('order'))
                            <input type="hidden" name="order" value="{{ request('order') }}">
                        @endif
                        @if (request('r'))
                            <input type="hidden" name="r" value="{{ request('r') }}">
                        @endif

                        <div class="">
                            <p> Buscador:</p>
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3"><i class="fa fa-search"></i></span>
                                <input type="text" name="search" value="{{ old('search', request('search')) }}"
                                    class="form-control" aria-describedby="basic-addon3" placeholder="Escriba aquí">
                                {{-- <input type="text" name="search" class="form-control" aria-describedby="basic-addon3"
                                    value="{{ old('search', request('search')) }}" placeholder="Escriba aquí"> --}}
                            </div>
                        </div>
                    </form>
                    <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column;">
                        <div style="display: flex">
                            <span onclick="openNewModalFilter();" class="btn btn-warning"
                                style="margin: 1rem 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter" aria-hidden="true"></i>
                                Filtros</span>
                            <a href="{{ route('cursos') }}" class="btn btn-danger" title="Eliminar filtros"
                                style="margin-top: 1rem"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </div>
                        <button type="button" class="btn btn-success pull-right" data-toggle="modal"
                            data-target=".bd-example-modal-lg" style="margin-top: 2rem"><i class="fa fa-plus"></i> Nuevo
                            registro</button>
                    </div>
                </div>
                <hr>
                <div id="contenedor">
                    <div class="table-responsive">
                        @if ($cursos_count > 0)
                            <span class="badge" style="margin-bottom: 1rem; float: right">
                                {{ $cursos_count }} Registros
                            </span>
                        @endif
                        <table class="table table-condensed table-hover table-bordered">
                            <thead>
                                <th>Estado / Id</th>
                                <th>Título</th>
                                <th>Portada</th>
                                <th>Precio no Suscriptor</th>
                                <th>Precio Suscriptor</th>
                                <th>Rubro</th>
                                <th>Autor</th>
                                <th title="Fecha de Inicio">Fec. Start</th>
                                <th title="Fecha de Expiración">Fec. Exp </th>
                                <th>Acción</th>
                            </thead>
                            @forelse ($cursos as $curso)
                                <tbody>
                                    <tr>
                                        <td>
                                            @if ($curso->estado == 1)
                                                <span class="span_on"> <i class="fa fa-check"></i></span>
                                            @else
                                                <span class="span_off"> <i class="fa fa-times"></i></span>
                                            @endif
                                            {{ $curso->id }}
                                        </td>
                                        <td>{{ $curso->titulo }}</td>
                                        <td>
                                            <img class="img-responsive" width="100"
                                                src="{{ asset('imgCurso/' . $curso->url_portada) }}" alt="">
                                        </td>
                                        <td>S/. {{ $curso->precio }}.00 <br> $ {{ $curso->precio_d }}.00</td>
                                        <td>S/. {{ $curso->promocion }}.00 <br> $ {{ $curso->promocion_d }}.00</td>

                                        <td>{{ $curso->rubro->nombrerubro }}</td>
                                        <td>{{ $curso->autor->nombre }}</td>

                                        {{-- <td>{{ $curso->fecha }}</td> --}}
                                        @php
                                            $date = new DateTime($curso->fecha);
                                            $date_expira = new DateTime($curso->expira);
                                        @endphp

                                        <td>{{ $date->format('d/m/Y') }}</td>
                                        <td>{{ $date_expira->format('d/m/Y') }}</td>

                                        <td width="250">
                                            <a href="{{ route('curso.editar', $curso->id) }}"
                                                class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                                            <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')"
                                                href="{{ route('curso.delete', $curso->id) }}"
                                                onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')"
                                                class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</a>
                                            <a href="{{ route('temas', $curso->id) }}" class="btn btn-secondary btn-sm"><i
                                                    class="fa fa-sitemap"></i> Temas</a>
                                            <a href="{{ route('clase', $curso->id) }}" class="btn btn-success btn-sm"><i
                                                    class="fa fa-folder"></i> Clases</a>
                                            {{-- <a href="{{route('evaluacion',$curso->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i> Evaluación</a> --}}
                                            <a href="{{ route('material', $curso->id) }}" class="btn btn-warning btn-sm"><i
                                                    class="fa fa-clipboard"></i> Material</a>
                                            <a
                                                href="{{ route('encuesta_curso', $curso->id) }}"class="btn btn-warning btn-sm"><i
                                                    class="fa fa-clipboard"></i> Encuesta</a>

                                        </td>
                                    </tr>
                                </tbody>
                            @empty
                                <tbody>
                                    <tr>
                                        <td colspan="10">Sin Resultados ...</td>
                                    </tr>
                                </tbody>
                            @endforelse

                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-8">
                            <div class="input-group custom-pagination">
                                <!-- Render pagination here -->
                                {{ $cursos->appends(['search' => request('search'), 'order' => request('order'), 'r' => request('r'), 'count_curso' => $cursos_count])->render() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('panel.curso.create')
        @include('panel.curso.new_filters')
    </div>

@endsection
@section('extra_scripts')
    <script>
        var order = "{{ request('order') }}";
        var r = "{{ request('r') }}";
        window.addEventListener('load', function() {
            document.getElementById("search").addEventListener("keyup", () => {
                if ((document.getElementById("search").value.length) >= 1) {

                    let search = document.getElementById("search").value;
                    $parametros = '';

                    if (search.length > 0) {
                        $parametros += 'search=' + search;
                    }

                    if (order.length > 0) {
                        if ($parametros.length > 0) {
                            $parametros += '&';
                        }
                        $parametros += 'order=' + order;
                    }

                    if (r.length > 0) {
                        if ($parametros.length > 0) {
                            $parametros += '&';
                        }
                        $parametros += 'r=' + r;
                    }

                    fetch(
                            // `{{ route('curso.buscador') }}?search=${document.getElementById("search").value}`, {
                            //     method: 'get'
                            // })
                            `{{ route('curso.buscador') }}?${$parametros}`, {
                                method: 'get'
                            })
                        .then(response => response.text())
                        .then(html => {
                            document.getElementById("contenedor").innerHTML = html
                        })
                    document.getElementById("search_text").value = document.getElementById("search").value;
                } else {
                    location.reload();
                }
            })
        });

        function openNewModalFilter() {
            $("#modal_new_filter").modal();
        }
    </script>
@endsection

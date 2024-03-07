@extends('layouts.app')
@section('titulo', 'Suscriptores gratis')
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

        .btn_verPagos,
        .btn_ModalAsignAsesor {
            /* text-decoration: none; */
            color: rgb(4, 82, 172);
            /* background: rgb(4, 82, 172); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(4, 82, 172);
        }

        .btn_verPagos:hover,
        .btn_ModalAsignAsesor:hover {
            color: #fff;
            background: rgb(3, 64, 134);
        }

        .btn_ModalAsignC {
            /* text-decoration: none; */
            color: rgb(124, 4, 172);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(124, 4, 172);
        }

        .btn_ModalAsignC:hover {
            color: #fff;
            background: rgb(84, 3, 131);
        }

        .btn_HistorialSusc {
            /* text-decoration: none; */
            color: rgb(10, 172, 4);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(10, 172, 4);
        }

        .btn_HistorialSusc:hover {
            color: #fff;
            background: rgb(7, 131, 3);
        }

        .btn_ModalEditSubs {
            /* text-decoration: none; */
            color: rgb(211, 144, 0);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(211, 144, 0);
        }

        .btn_ModalEditSubs:hover {
            color: #fff;
            background: rgb(202, 115, 2);
        }

        .btn_anularSusc,
        .btn_ModalDesasignAsesor {
            /* text-decoration: none; */
            color: rgb(172, 4, 4);
            /* background: rgb(172, 4, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(172, 4, 4);
        }

        .btn_anularSusc:hover,
        .btn_ModalDesasignAsesor:hover {
            color: #fff;
            background: rgb(131, 3, 3);
        }

        .btn_exportarExcel {
            text-decoration: none !important;
            color: rgb(10, 172, 4);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 2rem;
            border: 1px solid rgb(10, 172, 4);
            margin: 22px 0;
        }

        .btn_exportarExcel:hover {
            color: #fff;
            background: rgb(7, 131, 3);
        }
    </style>
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <i class="fa fa-list-ol"></i> Suscriptores gratis
            </li>
        </ol>
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="searcher">
                    <div class="row">
                        <form action="{{ route('subscribers.free') }}">

                            @if (request('asesor'))
                                <input type="hidden" name="asesor" value="{{ request('asesor') }}">
                            @endif
                            <div class="col-xs-12 col-md-6">
                                <div class="input-group has-success">
                                    <span class="input-group-addon" id="basic-addon3">Buscador <i
                                            class="fa fa-search"></i></span>
                                    <input type="text" name="search" class="form-control"
                                        value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                        placeholder="Escriba aquí ( Nombre y Apellidos o Correo Electrónico o Teléfono ) y precione Enter">
                                </div>
                            </div>
                        </form>

                        <div class="col-xs-12 col-md-3">
                            <form method="POST" id="form_select" action="#">
                                {{-- <select name="asesor" id="asesores" class="form-control"
                                    onchange="getSubscribersByAsesor()"></select> --}}
                                <select name="asesor" id="asesores" class="form-control"
                                    onchange="getByFilterFreeAsesor()">
                                    <option value=" ">Filtrar por Asesor</option>
                                    @foreach ($asesores as $asesor)
                                        <option value="{{ $asesor->id }}"
                                            @if (request('asesor') == $asesor->id) selected @endif>
                                            {{ $asesor->name }} {{ $asesor->last_name }} </option>
                                    @endforeach
                                </select>
                            </form>

                        </div>
                        <button onclick="createSubscriberFree();" class="btn btn-success"><i class="fa fa-plus"
                                aria-hidden="true"></i> Nuevo registro</button>

                        <span id="box-btn"></span>
                        {{-- <span class="badge" id="totalReg"></span> --}}
                        @if ($suscriptores_free_count > 0)
                            <span class="badge" id="totalReg">
                                {{ $suscriptores_free_count }} Registros
                            </span>
                        @endif
                    </div>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-condensed table-hover table-bordered">
                            <thead>
                                <th>Id</th>
                                <th>Nombres y Apellidos</th>
                                <th>Correo electrónico</th>
                                  <th>Acceso</th>
                                <th>Profesión</th>
                                <th>Edad</th>
                                <th>País</th>
                                <th>Telf.</th>
                                <th>F. Registro</th>
                                <th>Intereses</th>
                                <th>Asesor asignado</th>
                                <th>Control</th>
                            </thead>

                            <tbody id="subscribers">
                                @forelse ($suscriptores_free as $subs)
                                    <tr>
                                        <td>{{ $subs->id }}</td>
                                        <td style="text-transform: uppercase;">
                                            {{ $subs->name . ' ' . $subs->last_name }}</td>
                                        <td>{{ $subs->email }}</td>
                                         <td style="text-transform: uppercase">
                                         {{-- {{ $subs->socialProfiles == '[]' ? 'email' : $subs->socialProfiles()->first()->social_name }} --}}
                                            @if ($subs->socialProfiles == '[]')
                                                Email
                                            @else
                                                @if ($subs->socialProfiles()->count() == 1)
                                                    @if ($subs->email)
                                                        Email, {{ $subs->socialProfiles()->first()->social_name }}
                                                    @else
                                                        {{ $subs->socialProfiles()->first()->social_name }}
                                                    @endif
                                                @else
                                                    @if ($subs->email)
                                                        Email, Google y Facebook
                                                    @else
                                                        Google y Facebook
                                                    @endif
                                                @endif
                                            @endif
                                        </td> 
                                           <td>{{ $subs->profession }}</td>
                                        @php
                                            $nacimiento = new DateTime($subs->age);
                                            $ahora = new DateTime(date('Y-m-d'));
                                            $diferencia = $ahora->diff($nacimiento);
                                        @endphp
                                        <td>{{ $subs->age ? $diferencia->format('%y') . ' años' : '' }} </td>
                                        <td>{{ $subs->pais }}</td>
                                        <td>{{ $subs->phone_number }}</td>
                                        @php
                                            $date = new DateTime($subs->created_at);
                                        @endphp
                                        <td>{{ $date->format('d/m/Y') }}</td>
                                        <td>{{ $subs->intereses == '[]' ? '...' : $subs->intereses[0]->medio->sigla }}</td>
                                        <td>{{ $subs->asignacion == null ? '...' : $subs->asignacion->gestor->name }}</td>
                                        <td>
                                            @if ($subs->asignacion == null)
                                                <button type="button" onclick='openModalAsign({{ $subs->id }})'
                                                    class="btn btn-primary btn-sm btn_ModalAsignAsesor"
                                                    title="Asignar un asesor">
                                                    <i class="fa fa-user-plus"></i>
                                                </button>
                                            @else
                                                <button type="button" onclick='destroyAsignation({{ $subs->id }})'
                                                    class="btn btn-danger btn-sm btn_ModalDesasignAsesor"
                                                    title="Quitar asignación de asesor">
                                                    <i class="fa fa-user-times" aria-hidden="true"></i>
                                                </button>
                                            @endif

                                            <button type="button" onclick='openModalAsignC({{ $subs->id }})'
                                                class="btn btn-light btn-sm btn_ModalAsignC" title="Asignar Curso">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>

                                            <button type="button"
                                                onclick='getRecords({{ $subs->records }},"{{ $subs->name }}");'
                                                class="btn btn-success btn-sm btn_HistorialSusc" title="Ver historial">
                                                <i class="fa fa-history" aria-hidden="true"></i>
                                            </button>

                                            <button type="button" onclick="destroyUser({{ $subs->id }})"
                                                class="btn btn-danger btn-sm btn_anularSusc" title="Borrar">
                                                <i class="fa fa-trash" aria-hidden="true"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">Sin resultados</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                    </div>

                    <div class="row">
                        <div class="col-xs-12 col-md-6">
                            <div class="input-group custom-pagination">
                                <!-- Render pagination here -->
                                {{ $suscriptores_free->appends(['search' => request('search'), 'asesor' => request('asesor'), 'count_free' => $suscriptores_free_count])->render() }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-6">
                            <button onclick="exportNewExcel()" class="btn btn-link btn_exportarExcel"><i
                                    class="fa fa-file-excel-o"></i>
                                Exportar a Excel</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('panel.subscriber.free.records')
        @include('panel.subscriber.free.asignate')
        @include('panel.subscriber.free.create')
        @include('panel.subscriber.free.asignatecurso')
    </div>

@endsection
@section('extra_scripts')
    <script>
        $(document).ready(function() {
            // getSubscribers();
            // getAsesores();
        });

        let props = {
            tbSubscribers: $("#subscribers"),
            counter: $("#totalReg"),
            ruta: '',
            selectAsesores: $("#asesores"),
            modal_create: $("#modal_create"),
        }

        function createSubscriberFree() {
            props.modal_create.modal();
        }
        
        function saveSubscriberFree(form) {
            event.preventDefault();
            if (validateForm(form)) {
                spinner.show();
                props.ruta = '/panel/subscribers/free';
                let token = '{{ csrf_token() }}',
                    data = $(form).serialize();

                $.ajax({
                    url: props.ruta,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: data,
                    dataType: 'JSON',
                    success: data => {
                        spinner.hide();
                        if (data.status == 200) {
                            props.modal_create.modal('hide');

                            // getSubscribers();

                            toastr.success(data.message, 'Exito');
                            $(form).trigger('reset');

                            setTimeout(
                                function() {
                                    location.reload();
                                }, 0001);
                        }

                        if (data.status == 422) {
                            for (var error in data.errors) {
                                toastr.error(data.errors[error][0], 'Advertencia');
                            }
                        }

                        console.log(data);
                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }

        }


        function getRecords(records, usermane) {
            $('#records').empty();
            $('#modalrecords').modal();
            $("#usernamerecord").text(usermane);
            if (records.length > 0) {
                records.forEach(record => {
                    $('#records').append(`
						<tr>
							<td>${record.id}</td>
							<td>${record.gestor.name}</td>
							<td>${record.body}</td>
							<td>${dateFormat(record.created_at)}</td>
						</tr>
					`);
                });

            } else {
                $('#records').append('No hay registros...');
            }
        }


        function getByFilterFreeAsesor() {
            var search = "{{ request('search') }}";
            var asesor = $("#asesores").val();

            $parametros = '';

            if (search.length > 0) {
                $parametros += 'search=' + search;
            }
            if (asesor.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'asesor=' + asesor;
            }

            let url_download = `/panel/subscribers/free?${$parametros}`;

            window.location = url_download;
        }

        // function quitarFiltros() {
        //     getAsesores();
        //     getSubscribers();
        //     $("#box-btn").html('');
        // }

        function openModalAsign(userId) {
            let formAsign = $("#form-asign")[0];
            props.ruta = '/panel/asesores-data';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    $(formAsign.gestor).empty();
                    res.forEach(user => {
                        $(formAsign.gestor).append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
                    });
                },
                error: error => {
                    console.log(error);
                }
            });

            $(formAsign.user_id).val(userId);
            $('#modalasign').modal();
        }

        var userIdModal;
        function openModalAsignC(userId) {
            let formAsign = $("#form-asign-c")[0];
            props.ruta = '/panel/cursos-data';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    console.log("aaaa");
                    console.log(res);
                     $(formAsign.gestor).empty();
                    $(formAsign.gestor).append(
                        `<option value="" selected disabled>Seleccione un curso</option>`)
                    res.cursos.forEach(curso => {
                        $(formAsign.gestor).append(`
							<option value="${curso.id}">${curso.titulo}</option>
						`);
                    });

                    $(formAsign.gestor_a).empty();
                    res.gestores.forEach(user => {
                        $(formAsign.gestor_a).append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
                    });


                },
                error: error => {
                    console.log(error);
                }
            });
            
            userIdModal = userId;
            $("[name=pago_monto]").val("")
            $(formAsign.user_id).val(userId);
            $('#modalasign1').modal();
        }

        $("[name=gestor]").change(function() {
            var selected = $(this).val()
            var monedaModal = $("[name=moneda]").val();
            $("[name=pago_monto]").val("")
            // console.log(userIdModal);
            $.ajax({
                url: '/panel/cursos-precio',
                data: "curso_id=" + selected + "&user_id=" + userIdModal + "&moneda=" + monedaModal,
                success: res => {
                    // console.log(res);
                    $("[name=pago_monto]").val(res.pago_monto)
                },
                error: error => {
                    console.log(error);
                }
            });
            // $("[name=pago_monto]").val(selected)
        })

        function saveAsignation(form) {
            event.preventDefault();
            props.ruta = '/panel/asignateto';
            let data = $(form).serialize();
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'POST',
                dataType: 'JSON',
                data: data,
                success: res => {
                    // spinner.hide();
                    $('#modalasign').modal('hide');

                    // getSubscribers($("#current_page").val());
                    toastr.success(res.message, 'Exito');
                    setTimeout(
                        function() {
                            location.reload();
                        }, 0001);
                },
                error: error => {
                    console.log(error);
                }
            });
        }

        function saveAsignationc(form) {
            event.preventDefault();
            props.ruta = '/panel/asignatecurso';
            let data = $(form).serialize();
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'POST',
                dataType: 'JSON',
                data: data,
                success: res => {
                    // spinner.hide();
                    $('#modalasign1').modal('hide');

                    // getSubscribers($("#current_page").val());
                    toastr.success(res.message, 'Exito');
                    setTimeout(
                        function() {
                            location.reload();
                        }, 0001);
                },
                error: error => {
                    console.log(error);
                }
            });
        }

        function destroyAsignation(userId) {
            if (confirm('¿Seguro de quitar la asignación?')) {
                props.ruta = `/panel/destroyasination/${userId}`;
                spinner.show();
                $.ajax({
                    url: props.ruta,
                    type: 'GET',
                    dataType: 'JSON',
                    success: res => {
                        // spinner.hide();
                        // getSubscribers($("#current_page").val());
                        toastr.success(res.message, 'Exito');
                        setTimeout(
                            function() {
                                location.reload();
                            }, 0001);
                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }

        }

        function destroyUser(userId) {
            if (confirm('¿Seguro de eliminar el registro?')) {
                spinner.show();
                props.ruta = `/panel/user/${userId}/destroy-json`;
                $.ajax({
                    url: props.ruta,
                    type: 'GET',
                    dataType: 'JSON',
                    success: res => {
                        // spinner.hide();
                        // getSubscribers($("#current_page").val());
                        toastr.success(res.message, 'Exito');
                        setTimeout(
                            function() {
                                location.reload();
                            }, 0001);
                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        function exportExcel() {

            let data = $("#form_select").serialize();
            let url_download = `/panel/subscribers-free/download?${data}`;

            window.location = url_download;

        }


        function exportNewExcel() {

            var search = "{{ request('search') }}";
            var asesor = "{{ request('asesor') }}";

            $parametros = '';

            if (search.length > 0) {
                $parametros += 'search=' + search;
            }
            if (asesor.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'asesor=' + asesor;
            }

            // let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-free/download?${$parametros}`;

            window.location = url_download;

        }
    </script>
@endsection

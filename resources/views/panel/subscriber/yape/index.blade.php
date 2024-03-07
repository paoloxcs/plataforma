@extends('layouts.app')
@section('titulo', 'Suscriptores Yape')
@section('content')
    <style>
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

        .panel-secondary {
            border-color: #5f5f5f;
        }

        .panel-secondary>.panel-heading {
            color: #fff;
            background-color: #5f5f5f;
            border-color: #5f5f5f;
        }

        .btn_verPagos {
            /* text-decoration: none; */
            color: rgb(4, 82, 172);
            /* background: rgb(4, 82, 172); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(4, 82, 172);
        }

        .btn_verPagos:hover {
            color: #fff;
            background: rgb(3, 64, 134);
        }

        .btn_ModalAsignC {
            /* text-decoration: none; */
            color: rgb(10, 172, 4);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(10, 172, 4);
        }

        .btn_ModalAsignC:hover {
            color: #fff;
            background: rgb(7, 131, 3);
        }

        .btn_EmailAsignC {
            /* text-decoration: none; */
            color: rgb(124, 4, 172);
            /* background: rgb(10, 172, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(124, 4, 172);
        }

        .btn_EmailAsignC:hover {
            color: #fff;
            background: rgb(105, 3, 131);
        }

        .btn_anularSusc {
            /* text-decoration: none; */
            color: rgb(172, 4, 4);
            /* background: rgb(172, 4, 4); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(172, 4, 4);
        }

        .btn_anularSusc:hover {
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
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Suscripcion Yape</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-8" style="padding-bottom: 1rem">
                        <form action="{{ route('subscribers.pago_yape') }}" class="row col-10"
                            style="margin-right: 2rem ; margin-left: 2rem">

                            @if (request('order'))
                                <input type="hidden" name="order" value="{{ request('order') }}">
                            @endif
                            @if (request('plan'))
                                <input type="hidden" name="plan" value="{{ request('plan') }}">
                            @endif
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3">Buscador <i
                                        class="fa fa-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                    placeholder="Escriba aquí ( Nombre y Apellidos o Correo Electrónico o Teléfono o DNI ) y precione Enter">
                            </div>
                        </form>
                    </div>

                    <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column">
                        <div style="display: flex">
                            <span onclick="openNewModalFilter();" class="btn btn-success"
                                style="margin: 0 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter" aria-hidden="true"></i>
                                Filtros</span>
                            <a href="{{ route('subscribers.pago_yape') }}" class="btn btn-danger" title="Eliminar Filtro"
                                style="margin-top: 0"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </div>
                        @if ($subsYape_count > 0)
                            <span class="badge" style="margin-top: 1rem" id="totalReg">
                                {{ $subsYape_count }} Registros
                            </span>
                        @endif
                    </div>

                    {{-- <div class="col-xs-12 col-md-6">

                        <div class="input-group has-success">
                            <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                            <input type="text" id="texto" class="form-control" onkeyup="buscar(this);"
                                aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-6">
                        <button onclick="openModalFilter();" class="btn btn-warning">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filtros
                        </button>
                        <button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars"
                                aria-hidden="true"></i> Mostrar todo</button>

                        <span class="badge" id="totalReg"></span>
                    </div> --}}
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-bordered">
                        <thead>
                            <th>Id</th>
                            <th>Nombres y Apellidos</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>Dni</th>
                            <th>Codigo Verificar</th>
                            <th>Tipo</th>
                            <th>Curso</th>
                            <th>Plan</th>
                            <th>Estado</th>
                            <th>Control</th>
                        </thead>
                        <tbody>
                            @forelse ($subsYape as $subs)
                                <tr>
                                    <td>
                                        @if ($subs->status_efectivo)
                                            <span class="span_on"> <i class="fa fa-check"></i></span>
                                        @else
                                            <span class="span_off"> <i class="fa fa-times"></i></span>
                                        @endif
                                        {{ $subs->id }}
                                    </td>
                                    <td style="text-transform: uppercase;">
                                        {{ $subs->user->name . ' ' . $subs->user->last_name }} </td>
                                    <td>{{ $subs->user->email }} </td>
                                    <td>{{ $subs->telefono }} </td>
                                    <td>{{ $subs->dni }} </td>
                                    <td>{{ $subs->codigo_verification }} </td>
                                    @if ($subs->tipo_susc == 'P')
                                        <td>Susc. Recurrente</td>
                                        <td></td>
                                        <td>{{ $subs->plan->name . ' ' . $subs->plan->moneda }} </td>
                                    @elseif ($subs->tipo_susc == 'C')
                                        <td>Susc. Curso</td>
                                        <td>{{ $subs->curso->titulo }}</td>
                                        <td></td>
                                    @endif
                                    @php
                                        if ($subs->suscription_end < date('Y-m-d')) {
                                            $status = 'Expirado';
                                        } else {
                                            $status = 'Vigente';
                                        }
                                    @endphp
                                    <td>{{ $status }} </td>
                                    <td>
                                        <button type="button"
                                            onclick='enviarCorreo({{ $subs->id }},"{{ $subs->tipo_susc }}")'
                                            class="btn btn-light btn-sm btn_EmailAsignC" style="tex"
                                            title="{{ $subs->tipo_susc == 'P' ? 'Enviar correo usuario para suscripcion Premium con Yape' : 'Enviar correo usuario para suscripcion Curso con Yape' }}">
                                            <i class="fa fa-inbox" aria-hidden="true"></i>
                                        </button>
                                        @if ($subs->tipo_susc == 'P')
                                            {{-- Crear suscripcion premium --}}
                                            <button type="button"
                                                onclick='modalSubsYapePremium({{ $subs->user }},"{{ $subs->plan_id }}","{{ $subs->gestor_id }}","{{ $subs->id }}","{{ $subs->suscription_end }}","{{ $subs->codigo_verification }}","{{ $subs->medio }}","{{ $subs->tipo }}")'
                                                class="btn btn-light btn-sm btn_ModalAsignC" style="tex"
                                                title="Asignar Suscripcion">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        @elseif ($subs->tipo_susc == 'C')
                                            {{-- Modal Asignar Cursos --}}
                                            <button type="button"
                                                onclick='modalSubsYapeAsignCurso({{ $subs->user->id }},"{{ $subs->curso->id }}","{{ $subs->gestor->id }}","{{ $subs->id }}","{{ $subs->codigo_verification }}")'
                                                class="btn btn-light btn-sm btn_ModalAsignC" style="tex"
                                                title="Asignar Curso">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        @endif

                                        <button onclick="anulaSuscriptin({{ $subs->id }})"
                                            class="btn btn-danger btn-sm btn_anularSusc" title="Eliminar Suscripción"><i
                                                class="fa fa-ban"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Sin resultados</td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="input-group custom-pagination">
                            <!-- Render pagination here -->
                            {{ $subsYape->appends(['search' => request('search'), 'order' => request('order'), 'plan' => request('plan'), 'count_yape' => $subsYape_count])->render() }}
                        </div>
                    </div>
                    {{-- <div class="col-xs-12 col-md-8">
					<button onclick="exportExcel()" class="btn btn-link"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
				</div>	 --}}

                </div>

                @include('panel.subscriber.yape.new_filters')
                @include('panel.subscriber.yape.asignatecurso')
                @include('panel.subscriber.yape.create_deposito')
            </div>

        </div>
    </div>

@endsection
@section('extra_scripts')
    <script>
        let props = {
            modal_create: $("#modal_create"),
            modal_edit: $("#modal_edit"),
            modal_edit_premium: $("#modal_edit_premium"),
            tbSubscribers: $("#subscribers"),
            total_reg: $("#totalReg"),
            ruta: '',
        }

        //PAGO YAPE OPEN MODAL SUSC PREMIUM 
        function modalSubsYapePremium(subs_user, planId, gestorId, subsId, subs_end, subs_cod_verif, subs_medio,
            subs_tipo) {
            props.ruta = '/panel/data_plan_gestor_yape';
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    $("#planes-edit").empty();
                    response.planes.forEach(plan => {
                        if (planId == plan.id) {
                            $("#planes-edit").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);

                            $(".caduca").val(plan.caduca);
                            if (Number(plan.promocion) > 0) {
                                // formEdit.monto.value = plan.promocion;
                                $(".precio_plan").val(plan.promocion);
                            } else {
                                $(".precio_plan").val(plan.precio);
                            }
                        } else {
                            $("#planes-edit").append(`
							<option data-caduca="${plan.caduca}" data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
                        }

                    });

                    $("#gestores_edit").empty();
                    response.gestores.forEach(user => {
                        if (gestorId == user.id) {
                            $("#gestores_edit").append(`
							<option selected value="${user.id}">${user.name} ${user.last_name}</option>
						`);
                        } else {
                            $("#gestores_edit").append(`

							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
                        }

                    });
                })
                .catch(error => {
                    console.log(error);
                });


            let formEdit = $("#editformPremium")[0];
            // console.log(subs);
            formEdit.suscriptor_yape_id.value = subsId;
            formEdit.user_id.value = subs_user.id;
            formEdit.name.value = subs_user.name;
            formEdit.last_name.value = subs_user.last_name;
            formEdit.email.value = subs_user.email;
            formEdit.suscription_end.value = subs_end;

            formEdit.nro_comprobante.value = "B_Yape-" + subs_cod_verif;

            formEdit.phone_number.value = subs_user.phone_number;
            formEdit.doc_number.value = subs_user.doc_number;
            formEdit.address.value = subs_user.address;

            $(formEdit.medio).empty();
            $(formEdit.medio).append(`
				<option ${subs_medio =='RC'? 'selected' : ''} value="RC">RC</option>
				<option ${subs_medio =='TM'? 'selected' : ''} value="TM">TM</option>
				<option ${subs_medio =='DA'? 'selected' : ''} value="DA">DA</option>
			`);
            $(formEdit.modalidad).empty();
            $(formEdit.modalidad).append(`
				<option ${subs_tipo =='D'? 'selected' : ''} value="D">Digital</option>
				<option ${subs_tipo =='F'? 'selected' : ''} value="F">Física</option>
				<option ${subs_tipo =='NA'? 'selected' : ''} value="NA">Ninguna</option>
			`);

            props.modal_edit_premium.modal();
        }

        //PAGOS YAPE CREATE/UPDATE SUSC
        function saveSubscriberPremium(form) {
            event.preventDefault();
            if (validateForm(form)) {
                spinner.show();
                props.ruta = `/panel/subscribers/pago_yape/${form.user_id.value}`;
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
                            props.modal_edit_premium.modal('hide');
                            // getSubscribers();
                            // getSubscribers($("#current_page").val());
                            toastr.success(data.message, 'Exito');
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

        function changeCaducidad(select) {
            $(".caduca").val(select.options[select.selectedIndex].getAttribute('data-caduca'));
            $(".precio_plan").val(select.options[select.selectedIndex].getAttribute('data-precio'));
        }

        // Status Pago  Efectivo
        var token = '{{ csrf_token() }}';

        function anulaSuscriptin(id) {
            if (confirm('¿Seguro de eliminar los datos para suscripción o curso de este usuario?')) {
                props.ruta = `/panel/subscribers/pago_yape/${id}/destroy`;

                $.ajax({
                    url: props.ruta,
                    type: 'GET',
                    dataType: 'JSON',
                    success: data => {
                        if (data.status == 200) {
                            // getSubscribers($("#current_page").val());
                            toastr.success(data.message);
                            setTimeout(
                                function() {
                                    location.reload();
                                }, 0001);
                        }

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        function enviarCorreo(id, type) {
            let ruta;

            ruta = `/panel/subscribers/pago_yape/${id}/notificate`;
           if (type == 'P') {
                if (!confirm('¿Seguro que quieres notificar al usuario de su plan?')) {
                    return;
                }
            } else {
                if (!confirm('¿Seguro que quieres notificar al usuario de su curso?')) {
                    return;
                }
            }
            $.ajax({
                url: ruta,
                type: 'GET',
                dataType: 'JSON',
                success: data => {
                    if (data.status == 200) {
                        toastr.success(data.message);
                        setTimeout(
                            function() {
                                location.reload();
                            }, 0001);
                    }
                },
                error: error => {
                    console.log(error);
                }
            });

        }

        //PAGOS YAPE - MODAL CURSOS
        function openNewModalFilter() {
            $("#modal_filter").modal();
        }

        function exportExcel() {

            let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-premium/download?${data}`;

            window.location = url_download;

        }

        //PAGO YAPE OPEN MODAL SUSC CURSO 
        function modalSubsYapeAsignCurso(userId, cursoId, gestorId, subsId, subs_cod_verif) {
            let formAsign = $("#form-asign-c")[0];
            props.ruta = '/panel/subscribers/pago_yape/cursos-data';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    $(formAsign.gestor).empty();

                    res.cursos.forEach(curso => {
                        var b = "";
                        if (curso.id == cursoId) {
                            b = "<option value=" + curso.id + " selected>" + curso.titulo + "</option>"
                        } else {
                            b = "<option value=" + curso.id + ">" + curso.titulo + "</option>"
                        }
                        $(formAsign.gestor).append(
                            `${b}`
                        );

                    });


                    $(formAsign.gestor_a).empty();

                    $(formAsign.gestor_a).empty();
                    res.gestores.forEach(user => {
                        if (gestorId == user.id) {
                            $(formAsign.gestor_a).append(
                                `<option value="${user.id}" selected>${user.name} ${user.last_name}</option>`
                            );
                        } else {
                            $(formAsign.gestor_a).append(
                                `<option value="${user.id}">${user.name} ${user.last_name}</option>`
                            );
                        }

                    });

                },
                error: error => {
                    console.log(error);
                }
            });

            $(formAsign.user_id).val(userId);
            $(formAsign.suscriptor_yape_id).val(subsId);
            $(formAsign.nro_comprobante).val("B_Yape-" + subs_cod_verif);

            $('#modalasign1').modal();
        }

        //PAGO YAPE CREATE/UPDATE SUSC CURSO 
        function saveAsignationc(form) {
            event.preventDefault();
            props.ruta = '/panel/subscribers/pago_yape/asignatecurso';
            let data = $(form).serialize();
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'POST',
                dataType: 'JSON',
                data: data,
                success: res => {
                    spinner.hide();
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
    </script>
@endsection

@extends('layouts.app')
@section('titulo', 'Suscriptores Premium')
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
    <style>
        .btn-culqi-eye {
            background: #763383;
            color: #ffffff;
        }

        .btn-culqi-eye:hover {
            background: #763383b7;
            color: #ffffff;
        }
    </style>
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Suscripcion Pago Efectivo</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- <div class="col-xs-12 col-md-6">

                        <div class="input-group has-success">
                            <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                            <input type="text" id="texto" class="form-control" onkeyup="buscar(this);"
                                aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-6">
                        <button onclick="createSubscriber();" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
                        <button onclick="openModalFilter();" class="btn btn-warning">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filtros
                        </button>
                        <button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars"
                                aria-hidden="true"></i> Mostrar todo</button>

                        <span class="badge" id="totalReg"></span>
                    </div> --}}
                    <form action="{{ route('subscribers.pago_efectivo') }}" class="row col-10"
                        style="margin-right: 2rem ; margin-left: 2rem">

                        @if (request('order'))
                            <input type="hidden" name="order" value="{{ request('order') }}">
                        @endif
                        @if (request('plan'))
                            <input type="hidden" name="plan" value="{{ request('plan') }}">
                        @endif
                        @if (request('modpago'))
                            <input type="hidden" name="modpago" value="{{ request('modpago') }}">
                        @endif
                        {{-- @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif --}}

                        <div class="col-xs-12 col-md-8" style="padding-bottom: 1rem">
                            <p> Buscador: </p>
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3"><i class="fa fa-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                    placeholder="Escriba aquí">
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column">
                            <div style="display: flex">
                                {{-- <button type="submit" class="btn btn-success" style="margin: 1rem 1rem 0 0;flex: 1 1 0%;">
                                Aplicar
                                filtro</button> --}}
                                <span onclick="openNewModalFilter();" class="btn btn-success"
                                    style="margin: 1rem 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter"
                                        aria-hidden="true"></i> Filtros</span>
                                <a href="{{ route('subscribers.pago_efectivo') }}" class="btn btn-danger"
                                    title="Eliminar Filtro" style="margin-top: 1rem"> <i class="fa fa-trash"
                                        aria-hidden="true"></i> </a>
                            </div>
                            @if ($suscriptores_efectivo_count > 0)
                                <span class="badge" style="margin-top: 1rem" id="totalReg">
                                    {{ $suscriptores_efectivo_count }} Registros
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-bordered">
                        <thead>
                            {{-- <th> </th> --}}
                            <th>Id</th>
                            <th>Nombres y Apellidos</th>
                            <th>Correo electrónico</th>
                            <th>Teléfono</th>
                            <th>F. Suscripción</th>
                            <th>F. Caducidad</th>
                            <th>Tipo</th>
                            <th>Curso</th>
                            <th>Plan</th>
                            {{-- <th>Mod. pago</th> --}}
                            {{-- <th>Estado</th> --}}
                            <th>Gestor</th>
                            <th>Control</th>
                        </thead>
                        {{-- <tbody id="subscribers">

                        </tbody> --}}
                        <tbody>
                            @forelse ($suscriptores_efectivo as $subs)
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
                                    <td>{{ $subs->user->phone_number }} </td>
                                    @php
                                        $date = new DateTime($subs->suscription_init);
                                        $date_end = new DateTime($subs->suscription_end);
                                    @endphp
                                    <td>{{ $date->format('d/m/Y') }}</td>
                                    <td>{{ $date_end->format('d/m/Y') }}</td>
                                    @if ($subs->tipo_susc == 'P')
                                        <td>Susc. Recurrente</td>
                                        <td></td>
                                        <td>{{ $subs->plan->name . ' ' . $subs->plan->moneda }} </td>
                                    @elseif ($subs->tipo_susc == 'C')
                                        <td>Susc. Curso</td>
                                        <td>{{ $subs->curso->titulo }}</td>
                                        <td></td>
                                    @endif

                                    {{-- @php
                                        if ($subs->suscription_end < date('Y-m-d')) {
                                            $status = 'Expirado';
                                        } else {
                                            $status = 'Vigente';
                                        }
                                    @endphp
                                    <td>{{ $status }} </td> --}}
                                    <td>{{ $subs->gestor->name }}</td>

                                    <td>
                                        <button
                                            onclick='verPagosEfectivo({{ $subs->user->id }},"{{ $subs->user->name }}","{{ $subs->id_culqi }}")'
                                            class="btn btn-link btn-sm btn_verPagos" title="Ver Estado de PagoEfectivo">
                                            <i class="fa fa-eye"></i></button>

                                        @if ($subs->tipo_susc == 'P')
                                            <button type="button" onclick='enviarCorreoPremium({{ $subs->id }})'
                                                class="btn btn-light btn-sm btn_EmailAsignC" style="tex"
                                                title="Enviar Mensaje User Premium">
                                                <i class="fa fa-inbox" aria-hidden="true"></i>
                                            </button>
                                            {{-- Crear suscripcion premium --}}
                                            <button type="button"
                                                onclick='createSubscriberPremium({{ $subs->user }},"{{ $subs->plan_id }}","{{ $subs->gestor_id }}","{{ $subs->id }}","{{ $subs->id_culqi }}","{{ $subs->suscription_end }}","{{ $subs->medio }}","{{ $subs->tipo }}")'
                                                class="btn btn-light btn-sm btn_ModalAsignC" style="tex"
                                                title="Asignar Suscripcion">
                                                <i class="fa fa-plus" aria-hidden="true"></i>
                                            </button>
                                        @elseif ($subs->tipo_susc == 'C')
                                            <button type="button" onclick='enviarCorreo({{ $subs->id }})'
                                                class="btn btn-light btn-sm btn_EmailAsignC" style="tex"
                                                title="Enviar Mensaje User x Curso">
                                                <i class="fa fa-inbox" aria-hidden="true"></i>
                                            </button>
                                            {{-- Modal Asignar Cursos --}}
                                            <button type="button"
                                                onclick='openModalAsignC({{ $subs->user->id }},"{{ $subs->curso->id }}","{{ $subs->id_culqi }}","{{ $subs->gestor->id }}","{{ $subs->id }}")'
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
                    <div class="col-xs-12 col-md-6">
                        <div class="input-group custom-pagination">
                            <!-- Render pagination here -->
                            {{ $suscriptores_efectivo->appends(['search' => request('search'), 'order' => request('order'), 'status' => request('status'), 'plan' => request('plan'), 'modpago' => request('modpago'), 'count_efectivo' => $suscriptores_efectivo_count])->render() }}
                        </div>
                    </div>
                </div>
                {{-- <div class="col-xs-12 col-md-8">
					<button onclick="exportExcel()" class="btn btn-link"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
				</div>	 --}}

            </div>

            @include('panel.subscriber.pago_efectivo.pagos')
            {{-- @include('panel.subscriber.deposito.create') --}}
            {{-- JHED PREMIUM --}}
            {{-- @include('panel.subscriber.deposito.edit') --}}
            {{-- @include('panel.subscriber.deposito.filters') --}}
            @include('panel.subscriber.pago_efectivo.filters')
            @include('panel.subscriber.pago_efectivo.new_filters')
            {{-- @include('panel.subscriber.free.asignatecurso') --}}
            @include('panel.subscriber.pago_efectivo.asignatecurso')
            {{-- JHED PREMIUM --}}
            @include('panel.subscriber.pago_efectivo.create_deposito')
        </div>

    </div>
    </div>

@endsection
@section('extra_scripts')
    <script>
        $(document).ready(function() {
            // getSubscribers(); // Listar al cargar la pagina
            // getPrevInfo();
        });

        let props = {
            modal_create: $("#modal_create"),
            modal_edit: $("#modal_edit"),
            modal_edit_premium: $("#modal_edit_premium"),
            tbSubscribers: $("#subscribers"),
            total_reg: $("#totalReg"),
            ruta: '',
        }
        //PAGO EFECTIVO DATA
        function getSubscribers(page = 0) {
            spinner.show();
            $("#form_filter").trigger('reset');
            props.ruta = '/panel/subscribers/pago_efectivo_data';
            if (page != 0) props.ruta = `/panel/subscribers/pago_efectivo_data/?page=${page}`;
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    props.tbSubscribers.empty();
                    spinner.hide();
                    props.total_reg.text(`${response.total} Registros`);
                    response.data.forEach(subs => {
                        var b = "";
                        if (subs.status_efectivo == "1") {
                            b = " <td><i class='fa fa-check'></i></td>"
                        } else {
                            b = "<td><i class='fa fa-times'></i></td>"
                        }
                        var tplan = "";
                        var dplan = "";
                        var dcurso = "";
                        var btnplan = "";
                        var btnmessage = "";
                        if (subs.tipo_susc == "P") { //Premiun
                            tplan = " <td>Susc. Recurrente</td>"
                            dplan = " <td>" + subs.plan.name + " (" + subs.plan.moneda + ")" + "</td>"
                            dcurso = " <td></td>"
                            btnplan =
                                `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                            btnmessage =
                                `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                        } else if (subs.tipo_susc == "C") { //Curso
                            tplan = " <td>Susc. Curso</td>"
                            dplan = " <td></td>"
                            dcurso = " <td>" + subs.curso.titulo + "</td>"
                            btnplan =
                                `<button type="button" onclick='openModalAsignC(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                            btnmessage =
                                `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                        }
                        props.tbSubscribers.append(`
					<tr>
                        ${b}
						<td>${subs.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td> 
						<td>${subs.user.phone_number}</td>
						<td>${dateFormat(subs.suscription_init)}</td>
						<td>${dateFormat(subs.suscription_end)}</td> 
						${tplan}
						${dcurso}
						${dplan}
						<td>${subs.status}</td>
						<td>${subs.gestor.name} </td>
						<td>
							<button onclick='verPagosEfectivo(${subs.user.id},"${subs.user.name}","${subs.id_culqi}")' class="btn btn-culqi-eye btn-sm" title=" Ver Estado Pago Efectivo"><i class="fa fa-eye" aria-hidden="true"></i></button>
							${btnmessage}
							${btnplan}
							<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
						</td>
					</tr>
					`)

                    });
                    // <button type="button" onclick='openModalAsignC(${subs.user.id},"${subs.curso.id}","${subs.id_culqi}","${subs.id}")' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>
                    // <button onclick="saveEstadoPagoEfectivo(${subs.id})" class="btn btn-success btn-sm" title="Up Estado Pago Efectivo"><i class="fa fa-check" aria-hidden="true"></i> </button>
                    renderPagination(response, 'getSubscribers');
                    /*console.log(response);*/
                })
                .catch(error => {
                    console.log(error);
                });
        }

        //PAGO EFECTIVO BUSCADOR
        function buscar(input) {
            if (input.value != '') {
                if (event.keyCode == 13) {
                    spinner.show();
                    props.ruta = `/panel/subscribers/pago_efectivo/search/?text=${input.value}`;
                    $.ajax({
                        url: props.ruta,
                        type: 'GET',
                        dataType: 'JSON',
                        success: response => {
                            props.total_reg.empty();
                            props.tbSubscribers.empty();
                            $(".custom-pagination").empty();
                            spinner.hide();
                            if (response.length > 0) {
                                response.forEach(subs => {
                                    var b = "";
                                    if (subs.status_efectivo == "1") {
                                        b = " <td><i class='fa fa-check'></i></td>"
                                    } else {
                                        b = "<td><i class='fa fa-times'></i></td>"
                                    }
                                    var tplan = "";
                                    var dplan = "";
                                    var dcurso = "";
                                    var btnplan = "";
                                    var btnmessage = "";
                                    if (subs.tipo_susc == "P") { //Premiun
                                        tplan = " <td>Susc. Recurrente</td>"
                                        dplan = " <td>" + subs.plan.name + " (" + subs.plan.moneda +
                                            ")" + "</td>"
                                        dcurso = " <td></td>"
                                        btnplan =
                                            `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                                        btnmessage =
                                            `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                                    } else if (subs.tipo_susc == "C") { //Curso
                                        tplan = " <td>Susc. Curso</td>"
                                        dplan = " <td></td>"
                                        dcurso = " <td>" + subs.curso.titulo + "</td>"
                                        btnplan =
                                            `<button type="button" onclick='openModalAsignC(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                                        btnmessage =
                                            `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                                    }
                                    props.tbSubscribers.append(`
								<tr>
									${b}
									<td>${subs.id}</td>
									<td>${subs.user.name} ${subs.user.last_name}</td>
									<td>${subs.user.email}</td> 
									<td>${subs.user.phone_number}</td>
									<td>${dateFormat(subs.suscription_init)}</td>
									<td>${dateFormat(subs.suscription_end)}</td> 
									${tplan}
									${dcurso}
									${dplan}
									<td>${subs.status}</td>
									<td>${subs.gestor.name} </td>
									<td>
										<button onclick='verPagosEfectivo(${subs.user.id},"${subs.user.name}","${subs.id_culqi}")' class="btn btn-culqi-eye btn-sm" title=" Ver Estado Pago Efectivo"><i class="fa fa-eye" aria-hidden="true"></i></button>
										${btnmessage}
										${btnplan}
										<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
									</td>
								</tr>
									`)
                                });

                            } else {
                                props.tbSubscribers.append('<span>Sin resultados...</span>');
                            }
                        },
                        error: error => {
                            spinner.hide();
                            console.log(error);
                            toastr.error(error.statusText, error.status);
                        }
                    });

                }
            } else {
                getSubscribers();
            }

        }


        function openNewModalFilter() {
            $("#modal_new_filter").modal();
        }
        // Crear suscripcion premium 
        //PAGO EFECTIVO OPEN MODAL SUSC PREMIUM 
        function createSubscriberPremium(subs_user, planId, gestorId, subsId, culqiId, subs_suscription_end, subs_medio,
            subs_tipo) {
            props.ruta = '/panel/planes-gestor-data';
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
                                // formEdit.monto.value = subs.plan.precio;
                                $(".precio_plan").val(plan.precio);
                                // console.log(Number(subs.plan.precio));
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
            formEdit.suscriptor_efectivo_id.value = subsId;
            formEdit.user_id.value = subs_user.id;
            formEdit.name.value = subs_user.name;
            formEdit.last_name.value = subs_user.last_name;
            formEdit.email.value = subs_user.email;
            formEdit.suscription_end.value = subs_suscription_end;
            let ruta_culqi = `/panel/cargos/cargos_pago_efectivo/${subs_user.id}/${culqiId}`;
            $.ajax({
                url: ruta_culqi,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    // $(formAsign.nro_comprobante).val(res.payment_code); 
                    formEdit.nro_comprobante.value = "BoltSP_" + res.payment_code;
                },
                error: error => {
                    console.log(error);
                }
            });
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
        //PAGO EFECTIVO CREATE/UPDATE SUSC PREMIUM 
        function saveSubscriberPremium(form) {
            event.preventDefault();
            if (validateForm(form)) {
                spinner.show();
                props.ruta = `/panel/subscribers/pago_efectivo_premium/${form.user_id.value}`;
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

        function saveEstadoPagoEfectivo(id) {

            if (confirm('¿Seguro quieres cambiar el estado?')) {
                var ruta = '{{ route('statusPagoEfectivo') }}';
                $.ajax({
                    url: ruta,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    dataType: 'JSON',
                    data: {
                        id: id
                    },
                    success: data => {
                        if (data.status == 200) {
                            toastr.success(data.message);
                            location.reload();
                        }
                        console.log(data);

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }


            // $.ajax({
            //   url: ruta,
            //   type: 'POST',
            //   headers:{'X-CSRF-TOKEN': token},
            //   dataType: 'json',
            //   data:{
            //     id: id
            //   },
            //   success:function(data){
            //     console.log(data);
            //     location.reload();
            //   },
            //   error:function(data){
            //     console.log(data);
            //   }
            // });
        }

        function anulaSuscriptin(id) {
            if (confirm('¿Seguro de anular la suscripción?')) {
                props.ruta = `/panel/subscribers/pago_efectivo/${id}/destroy`;

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
                        // console.log(data);

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        function enviarCorreo(id) {
            if (confirm('¿Seguro que quieres notificar al usuario?')) {
                let ruta = `/panel/subscribers/pago_efectivo/${id}/notificate`;

                //spinner.show(); 
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
                        // console.log(data);

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        function enviarCorreoPremium(id) {
            if (confirm('¿Seguro que quieres notificar al usuario de su plan?')) {
                let ruta = `/panel/subscribers/pago_efectivo/${id}/notificate_premium`;

                //spinner.show(); 
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
                        // console.log(data);

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        //FILTRO JHED
        function getPrevInfo() {
            props.ruta = '/panel/filters-to-subscribers';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: data => {
                    $("#planes-filter").empty();
                    $("#planes-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="plan" id="planx" value="0" checked>
					   	Todo
					  </label>
					</div>
					`);
                    data.planes.forEach((plan, index) => {
                        $("#planes-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="plan" id="plan${plan.id}" value="${plan.id}">
						   	${plan.name} (${plan.moneda} por ${plan.meses} meses)
						  </label>
						</div>
						`);
                    });

                    $("#modpago-filter").empty();
                    $("#modpago-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="modpago" id="modpagox" value="0" checked>
					   	Ambos
					  </label>
					</div>
					`);
                    data.modpago.forEach((mod, index) => {
                        $("#modpago-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="modpago" id="modpago${mod.id}" value="${mod.id}">
						   	${mod.name}
						  </label>
						</div>
						`);
                    });


                    $("#statuspago-filter").empty();
                    $("#statuspago-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="statuspago" id="statuspagox" value="2" checked>
					   	Ambos
					  </label>
					</div>
					`);
                    $("#statuspago-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="statuspago" id="statuspago_no" value="0">
					   	No Asignado
					  </label>
					</div>
					`);
                    $("#statuspago-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="statuspago" id="statuspago_si" value="1">
					   	Asignado
					  </label>
					</div>
					`);
                },
                error: error => {
                    console.log(error);
                }
            });
        }

        //PAGO EFECTIVO - MODAL CURSOS
        function openModalFilter() {
            $("#modal_filter").modal();
        }
        //PAGO EFECTIVO
        function applyFilter(page = 0) {
            event.preventDefault();

            if (page != 0) {
                props.ruta = `/panel/subscribers/pago_efectivo/filter/?page=${page}`;
            } else {
                props.ruta = '/panel/subscribers/pago_efectivo/filter/';
            }
            let data = $("#form_filter").serialize(),
                token = '{{ csrf_token() }}';

            spinner.show();

            $.ajax({
                url: props.ruta,
                type: 'GET',
                headers: {
                    'X-CSRF-TOKEN': token
                },
                data: data,
                dataType: 'JSON',
                success: response => {
                    props.total_reg.text(`${response.total} Registros`);
                    if (Array.isArray(response.data)) {
                        subscribers = response.data;
                    } else {
                        subscribers = Object.values(response.data);
                    }
                    props.tbSubscribers.empty();
                    $("#modal_filter").modal('hide');
                    spinner.hide();
                    if (subscribers.length > 0) {
                        subscribers.forEach(subs => {
                            var b = "";
                            if (subs.status_efectivo == "1") {
                                b = " <td><i class='fa fa-check'></i></td>"
                            } else {
                                b = "<td><i class='fa fa-times'></i></td>"
                            }
                            var tplan = "";
                            var dplan = "";
                            var dcurso = "";
                            var btnplan = "";
                            var btnmessage = "";
                            if (subs.tipo_susc == "P") { //Premiun
                                tplan = " <td>Susc. Recurrente</td>"
                                dplan = " <td>" + subs.plan.name + " (" + subs.plan.moneda + ")" +
                                    "</td>"
                                dcurso = " <td></td>"
                                btnplan =
                                    `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                                btnmessage =
                                    `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                            } else if (subs.tipo_susc == "C") { //Curso
                                tplan = " <td>Susc. Curso</td>"
                                dplan = " <td></td>"
                                dcurso = " <td>" + subs.curso.titulo + "</td>"
                                btnplan =
                                    `<button type="button" onclick='openModalAsignC(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
                                btnmessage =
                                    `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
                            }
                            props.tbSubscribers.append(`
									<tr>
										${b}
										<td>${subs.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td> 
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.suscription_init)}</td>
										<td>${dateFormat(subs.suscription_end)}</td> 
										${tplan}
										${dcurso}
										${dplan}
										<td>${subs.status}</td>
										<td>${subs.gestor.name} </td>
										<td>
											<button onclick='verPagosEfectivo(${subs.user.id},"${subs.user.name}","${subs.id_culqi}")' class="btn btn-culqi-eye btn-sm" title=" Ver Estado Pago Efectivo"><i class="fa fa-eye" aria-hidden="true"></i></button>
											${btnmessage}
											${btnplan}
											<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
										</td>
									</tr>
									`)
                        });

                        renderPagination(response, 'applyFilter');
                    } else {
                        props.tbSubscribers.append('<span>Filtro sin registros</span>');
                        $(".custom-pagination").empty();
                    }

                },
                error: error => {
                    console.log(error);
                }
            });

        }

        function exportExcel() {

            let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-premium/download?${data}`;

            window.location = url_download;

        }

        //Ver estado de Pago Efectivo
        function verPagosEfectivo(user_id, username, id_culqi) {
            $('#pagosde_user').text(username);
            let ruta = `/panel/cargos/cargos_pago_efectivo/${user_id}/${id_culqi}`;
            //spinner.show();
            $.ajax({
                url: ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    console.log(res);
                    $("#dataPagos").empty();
                    //spinner.hide();
                    $('#sig_pago').text(res.id);

                    // res.charges.forEach(charge =>{  

                    // 	var a= "";
                    // 	if (charge.outcome.type=="card_error") {
                    //    	a= "<td><strong>"+ charge.outcome.merchant_message+"</strong></td>"
                    //    }else{
                    //    a= "<td>"+ charge.outcome.merchant_message+"</td>"
                    //    }

                    $("#dataPagos").append(`
			<tr>  
			<td>${ getDateFormatTimestamp(res.creation_date)}</td>
			<td>${ getDateFormatTimestamp(res.expiration_date)}</td>
			<td>${ getDateFormatTimestamp(res.updated_at)}</td>
			<td>${res.payment_code}</td>
			<td>${res.state}</td>
			<td>${res.amount/100}</td>   
			
			</tr>
			`);
                    // });         
                    // console.log(res.charges);
                    //console.log(res);  
                },
                error: error => {
                    spinner.hide();
                    toastr.error(JSON.parse(error.responseJSON).message);
                    console.log(error.responseText);
                }

            });

            $("#modal_pagos").modal();

        }


        function getDateFormat(unix_timestamp) {

            let date = new Date(unix_timestamp);

            let fecha = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

            return fecha;
        }

        function getDateFormatTimestamp(unix_timestamp) {

            let date = new Date(unix_timestamp * 1000);
            // Hours part from the timestamp
            var hours = date.getHours();
            // Minutes part from the timestamp
            var minutes = "0" + date.getMinutes();
            // Seconds part from the timestamp
            var seconds = "0" + date.getSeconds();

            var formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);
            let fecha = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()} ${formattedTime}`;

            return fecha;
        }

        function updateStatusCompronte(pago_id) {
            spinner.show();
            props.ruta = `/panel/updatestatuscomprobante/${pago_id}`;
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    spinner.hide();
                    if (response.status == 200) {
                        $("#modal_pagos").modal('hide');
                        // getSubscribers($("#current_page").val());
                        toastr.success(response.message, 'Exito');
                        setTimeout(
                            function() {
                                location.reload();
                            }, 0001);
                    }
                })
                .catch(error => {
                    console.log(error);
                });
        }
        // Modal Asignar Cursos
        //PAGO EFECTIVO OPEN MODAL SUSC CURSO 
        function openModalAsignC(userId, cursoId, culqiId, gestorId, subsId) {
            // function openModalAsignC(subs) {
            let formAsign = $("#form-asign-c")[0];
            props.ruta = '/panel/subscribers/pago_efectivo/cursos-data';
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

                    // res.gestores.forEach(user =>{
                    // 	$(formAsign.gestor_a).append(`
                // 			<option value="${user.id}">${user.name} ${user.last_name}</option>
                // 		`);
                    // }); 

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

            let ruta_culqi = `/panel/cargos/cargos_pago_efectivo/${userId}/${culqiId}`;
            $.ajax({
                url: ruta_culqi,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    $(formAsign.nro_comprobante).val("BoltC_" + res.payment_code);
                },
                error: error => {
                    console.log(error);
                }

            });

            $(formAsign.user_id).val(userId);
            $(formAsign.pago_id).val(subsId);
            $(formAsign.culqi_id).val(culqiId);

            $('#modalasign1').modal();
        }

        //PAGO EFECTIVO CREATE/UPDATE SUSC CURSO 
        function saveAsignationc(form) {
            event.preventDefault();
            props.ruta = '/panel/subscribers/pago_efectivo/asignatecurso';
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

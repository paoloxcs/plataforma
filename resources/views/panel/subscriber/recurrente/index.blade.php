@extends('layouts.app')
@section('titulo', 'Suscriptores Premium')
{{-- @section('extra_style')
@endsection --}}
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
                <div class="panel-title">Suscripcion Recurrente</div>
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

                        <button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars"
                                aria-hidden="true"></i> Mostrar todo</button>

                        <span class="badge" id="totalReg">
                            @if ($suscriptores_recurrente_count > 0)
                                {{ $suscriptores_recurrente_count }} Registros
                            @endif
                        </span>
                    </div> --}}
                    <form action="{{ route('subscribers.recurrente') }}" class="row col-10"
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
                            {{-- <p> Buscador: </p> --}}
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3">Buscador <i
                                        class="fa fa-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                    
                                    placeholder="Escriba aquí ( Nombre y Apellidos o Correo Electrónico o Teléfono ) y precione Enter">
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column">
                            <div style="display: flex">
                                {{-- <button type="submit" class="btn btn-success" style="margin: 1rem 1rem 0 0;flex: 1 1 0%;">
                                    Aplicar
                                    filtro</button> --}}
                                <span onclick="openNewModalFilter();" class="btn btn-success"
                                    style="margin: 0 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter"
                                        aria-hidden="true"></i> Filtros</span>
                                <a href="{{ route('subscribers.recurrente') }}" class="btn btn-danger"
                                    style="margin-top: 0"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                            </div>
                            @if ($suscriptores_recurrente_count > 0)
                                <span class="badge" style="margin-top: 1rem" id="totalReg">
                                    {{ $suscriptores_recurrente_count }} Registros
                                </span>
                            @endif
                        </div>
                    </form>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-bordered">
                        <thead>
                            <th>Id</th>
                            <th>Nombres y Apellidos</th>
                            <th>Correo electrónico</th>
                            <th>País</th>
                            <th>Teléfono</th>
                            <th>DNI</th>
                            <th>F. Suscripción</th>
                            <th>Plan</th>
                            {{-- <th>Estado</th> --}}
                            <th>Control</th>
                        </thead>
                        <tbody>
                            @forelse ($suscriptores_recurrente as $subs)
                                <tr>
                                    <td>{{ $subs->id }}</td>
                                    <td style="text-transform: uppercase;">
                                        {{ $subs->user->name . ' ' . $subs->user->last_name }} </td>
                                    <td>{{ $subs->user->email }} </td>
                                    <td style="text-transform: uppercase;">{{ $subs->user->pais }} </td>
                                    <td>{{ $subs->user->phone_number }} </td>
                                    <td>{{ $subs->user->doc_number }} </td>
                                    @php
                                        $date = new DateTime($subs->suscription_init);
                                    @endphp
                                    <td>{{ $date->format('d/m/Y') }}</td>
                                    <td>{{ $subs->plan->name . ' ' . $subs->plan->moneda }} </td>


                                    <td>
                                        <button onclick='verPagos({{ $subs->user->id }},"{{ $subs->user->name }}")'
                                            class="btn btn-link btn-sm btn_verPagos" title="Ver Pagos">
                                            <i class="fa fa-eye"></i></button>

                                        <button type="button" onclick='openModalAsignC({{ $subs->user->id }})'
                                            class="btn btn-light btn-sm btn_ModalAsignC" style="tex"
                                            title="Asignar Curso">
                                            <i class="fa fa-plus" aria-hidden="true"></i>
                                        </button>

                                        <button onclick="anulaSuscriptin({{ $subs->user->id }})"
                                            class="btn btn-danger btn-sm btn_anularSusc" title="Anular Suscripción"><i
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
                            {{ $suscriptores_recurrente->appends(['search' => request('search'), 'order' => request('order'), 'r' => request('r'), 'plan' => request('plan'), 'modpago' => request('modpago'), 'count_recurrente' => $suscriptores_recurrente_count])->render() }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 d-flex justify-content-center">
                        <button onclick="exportNewExcel()" class="btn btn-link btn_exportarExcel"><i
                                class="fa fa-file-excel-o"></i>
                            Exportar a Excel</button>
                    </div>

                </div>

                @include('panel.subscriber.recurrente.pagos')
                @include('panel.subscriber.recurrente.new_filters')
            </div>
        </div>
        @include('panel.subscriber.free.asignatecurso')
    </div>

@endsection
@section('extra_scripts')
    <script>
        // $(document).ready(function(){
        // 	getSubscribers(); // Listar al cargar la pagina

        // });

        let props = {
            tbSubscribers: $("#subscribers"),
            total_reg: $("#totalReg"),
            ruta: '',
        }

        function getSubscribers(page = 0) {
            spinner.show();
            $("#form_filter").trigger('reset');
            props.ruta = '/panel/subscribers/premium-data-recurrente';
            if (page != 0) props.ruta = `/panel/subscribers/premium-data-recurrente/?page=${page}`;
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    props.tbSubscribers.empty();
                    spinner.hide();
                    props.total_reg.text(`${response.total} Registros`);
                    response.data.forEach(subs => {
                        /*if (subs.status=="card_error") {
                        	status= "<td><strong class='text-danger'>"+subs.status+"</strong></td>"
                        }else{
                        	status= "<td>"+subs.status+"</td>"
                        }

                        ${status}*/
                        props.tbSubscribers.append(`
					<tr>
						<td>${subs.user.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td>
						<td>${subs.user.pais}</td>
						<td>${subs.user.phone_number}</td>
						<td>${dateFormat(subs.suscription_init)}</td>
						<td>${subs.plan.name}  (${subs.plan.moneda})</td>
						
						
						<td>
							<button onclick='verPagos(${subs.user.id},"${subs.user.name}")' class="btn btn-link btn-sm">Pagos</button>

							<button type="button" onclick='openModalAsignC(${subs.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
							</button>
							
							<button onclick="anulaSuscriptin(${subs.user.id})" class="btn btn-danger btn-sm">Anular</button>
						</td>
					</tr>
					`)

                    });

                    renderPagination(response, 'getSubscribers');
                    /*console.log(response);*/
                })
                .catch(error => {
                    console.log(error);
                });
        }

        function buscar(input) {
            if (input.value != '') {
                if (event.keyCode == 13) {
                    spinner.show();
                    props.ruta = `/panel/subscribers-premium-recurrente/search/?text=${input.value}`;
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

                                    props.tbSubscribers.append(`
									<tr>
										<td>${subs.user.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td>
										<td>${subs.user.pais}</td>
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.suscription_init)}</td>
										<td>${subs.plan.name}  (${subs.plan.moneda})</td>
										<td>
											<button onclick='verPagos(${subs.user.id},"${subs.user.name}")' class="btn btn-link btn-sm">Pagos</button>

											<button type="button" onclick='openModalAsignC(${subs.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
											</button>

											<button onclick="anulaSuscriptin(${subs.user.id})" class="btn btn-danger btn-sm">Anular</button>
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

        function anulaSuscriptin(user_id) {
            if (confirm('¿Seguro de anular la suscripción?')) {
                props.ruta = `/panel/subscribers-premium-recurrente/${user_id}/destroy`;

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
                        console.log(data);

                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }

        function exportExcel() {

            let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-premium-recurrente/download?${data}`;

            window.location = url_download;

        }


        function exportNewExcel() {

            var search = "{{ request('search') }}";
            var order = "{{ request('order') }}";
            var plan = "{{ request('plan') }}";
            var modpago = "{{ request('modpago') }}";
            // var status = "{{ request('status') }}";

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
            if (plan.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'plan=' + plan;
            }
            if (modpago.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'modpago=' + modpago;
            }
            // if (status.length > 0) {
            //     if ($parametros.length > 0) {
            //         $parametros += '&';
            //     }
            //     $parametros += 'status=' + status;
            // }

            // let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-premium-recurrente/download?${$parametros}`;

            window.location = url_download;

        }



        function verPagos(user_id, username) {
            $('#pagosde_user').text(username);
            let ruta = `/panel/cargos/cargos-data-recurrente/${user_id}`;
            //spinner.show();
            $.ajax({
                url: ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    console.log(res);
                    $("#dataPagos").empty();
                    //spinner.hide();
                    $('#sig_pago').text(getDateFormat(res.next_billing_date));
                    res.charges.forEach(charge => {
                        var b = "";
                        if (charge.outcome.type == "card_error") {
                            b = "<td><strong class='text-danger'>" + charge.outcome.type +
                                "</strong></td>"
                        } else {
                            b = "<td>" + charge.outcome.type + "</td>"
                        }


                        var a = "";
                        if (charge.outcome.type == "card_error") {
                            a = "<td><strong>" + charge.outcome.merchant_message + "</strong></td>"
                        } else {
                            a = "<td>" + charge.outcome.merchant_message + "</td>"
                        }


                        $("#dataPagos").append(`
          <tr>
           <td>${ getDateFormat(charge.creation_date)}</td>
           <td>S/. ${charge.current_amount/100}.00</td>
           <td>${charge.current_amount/100}</td>
           <td> Recurrente</td>
           <td>${charge.source.iin.card_brand} / ${charge.source.iin.card_type} / ${charge.source.iin.card_category} / ${charge.source.iin.issuer.name}</td>   
           ${b}
           ${a}
          </tr>
        `);
                    });
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

        function openModalAsignC(userId) {
            let formAsign = $("#form-asign-c")[0];
            props.ruta = '/panel/cursos-data';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    // console.log("aaaa");
                    console.log(res);
                    $(formAsign.gestor).empty();
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

            $(formAsign.user_id).val(userId);
            $('#modalasign1').modal();
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

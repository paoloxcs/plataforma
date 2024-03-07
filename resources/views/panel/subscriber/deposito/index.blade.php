@extends('layouts.app')
@section('titulo', 'Suscriptores Premium')
@section('extra_style')
    <style>
        .card {
            position: relative; 
            display: flex; 
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box; 
        }

        .card-columns .card {
            display: inline-block;
            width: 100%;
        }

        @media (min-width: 768px) {
            .card-columns {
                column-count: 2;
            }
        }


        @media (min-width: 992px) {
            .card-columns {
                column-count: 3;
                column-gap: 1.25rem;
                orphans: 1;
                widows: 1;
            }

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
@endsection
@section('content')
    <div class="container-fluid">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Suscripcion Premium</div>
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- <div class="col-xs-12 col-md-6">

                        <div class="input-group has-success">
                            <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                            <input type="text" id="texto" class="form-control" onkeyup="buscar(this);"
                                aria-describedby="basic-addon3" 
                                    placeholder="Escriba aquí ( Nombre y Apellidos o Correo Electrónico o Teléfono ) y precione Enter">
                        </div>

                    </div>
                    <div class="col-xs-12 col-md-6">
                        <button onclick="createSubscriber();" class="btn btn-success"><i class="fa fa-plus"
                                aria-hidden="true"></i> Nuevo registro</button>
                        <button onclick="openModalFilter();" class="btn btn-warning">
                            <i class="fa fa-filter" aria-hidden="true"></i> Filtros
                        </button>
                        <button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars"
                                aria-hidden="true"></i> Mostrar todo</button>

                        <span class="badge" id="totalReg"></span>
                    </div> --}}
                    <div class="col-xs-12 col-md-8" style="padding-bottom: 1rem">
                        <form action="{{ route('subscribers.premium') }}" class="row col-10"
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
                            @if (request('asesor'))
                                <input type="hidden" name="asesor" value="{{ request('asesor') }}">
                            @endif
                            @if (request('status'))
                                <input type="hidden" name="status" value="{{ request('status') }}">
                            @endif

                            {{-- <p> Buscador: </p> --}}
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3">Buscador <i
                                        class="fa fa-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                    placeholder="Escriba aquí">
                            </div>

                        </form>
                    </div>

                    <div class="col-xs-12 col-md-4" style="display: flex; flex-direction: column">
                        <div style="display: flex">
                            {{-- <button type="submit" class="btn btn-success" style="margin: 1rem 1rem 0 0;flex: 1 1 0%;">
                                Aplicar
                                filtro</button> --}}
                            <button onclick="createSubscriber();" class="btn btn-success"
                                style="margin: 0 1rem 0 0;flex: 1 1 0%;"><i class="fa fa-plus" aria-hidden="true"></i>
                                Nuevo registro</button>
                            <span onclick="openNewModalFilter();" class="btn btn-warning"
                                style="margin: 0 1rem 0 0;flex: 1 1 0%;"> <i class="fa fa-filter" aria-hidden="true"></i>
                                Filtros</span>
                            <a href="{{ route('subscribers.premium') }}" class="btn btn-danger" title="Eliminar filtros"
                                style="margin-top: 0"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                        </div>
                        @if ($suscriptores_premium_count > 0)
                            <span class="badge" style="margin-top: 1rem" id="totalReg">
                                {{ $suscriptores_premium_count }} Registros
                            </span>
                        @endif
                    </div>
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
                            <th>F. Suscripción</th>
                            <th>Caducidad</th>
                            <th>Plan</th>
                            {{-- <th>Mod. pago</th> --}}
                            <th>Nro. Comp. </th>
                            <th>Monto </th>
                            <th>Ult. Pago </th>

                            <th>Estado</th>
                            <th>Gestor</th>
                            <th>Control</th>
                        </thead>
                        {{-- <tbody id="subscribers">
		      			
		      		</tbody> --}}
                        @forelse ($suscriptores_premium as $subs)
                            <tr>
                                <td>
                                    {{ $subs->id }}
                                </td>
                                <td style="text-transform: uppercase;">
                                    {{ $subs->user->name . ' ' . $subs->user->last_name }} </td>
                                <td>{{ $subs->user->email }} </td>
                                <td style="text-transform: uppercase;">{{ $subs->user->pais }} </td>
                                <td>{{ $subs->user->phone_number }} </td>
                                {{-- <td>{{ $subs->suscription_init}} </td> --}}
                                @php
                                    $date = new DateTime($subs->suscription_init);
                                    $date_end = new DateTime($subs->suscription_end);
                                @endphp
                                <td>{{ $date->format('d/m/Y') }}</td>
                                <td>{{ $date_end->format('d/m/Y') }}</td>
                                <td>{{ $subs->plan->name . ' ' . $subs->plan->moneda }} </td>
                                @php
                                    $pagos = App\Pago::where('suscriptor_id', '=', $subs->id)
                                        ->orderBy('id', 'desc')
                                        ->first();
                                @endphp
                                <td>{{ $pagos ? $pagos->nro_comprobante : 'No hay comprobante' }}</td>
                                <td>
                                    @if ($pagos)
                                        {{ $pagos->moneda == 'PEN' ? 'S/.' : '$' }} {{ $pagos->monto }}
                                    @else
                                        $ 0.00
                                    @endif
                                </td>
                                <td>{{ $pagos ? $pagos->created_at->format('d/m/Y') : '' }}</td>
                                @php
                                    if ($subs->suscription_end < date('Y-m-d')) {
                                        $status = 'Expirado';
                                    } else {
                                        $status = 'Vigente';
                                    }
                                @endphp
                                <td>{{ $status }} </td>

                                <td>{{ $subs->gestor->name }} </td>

                                <td>
                                    <button onclick='verPagos({{ $subs->pagos }},"{{ $subs->user->name }}")'
                                        class="btn btn-link btn-sm btn_verPagos" title="Ver Pagos">
                                        <i class="fa fa-eye"></i></button>

                                    <button onclick='openModalAsignC({{ $subs->user->id }})'
                                        class="btn btn-light btn-sm btn_ModalAsignC" style="tex" title="Asignar Curso">
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                    </button>
                                    {{-- Update Subscription --}}
                                    <button onclick='editSubscriber({{ $subs->user }},"{{$subs->plan_id}}","{{$subs->gestor_id}}","{{$subs->suscription_end}}","{{$subs->medio}}","{{$subs->tipo}}")'
                                        class="btn btn-light btn-sm btn_ModalEditSubs" title="Editar Suscripción">
                                        <i class="fa fa-edit" aria-hidden="true"></i>
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
                    </table>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="input-group custom-pagination">
                            <!-- Render pagination here -->
                            {{ $suscriptores_premium->appends(['search' => request('search'), 'order' => request('order'), 'status' => request('status'), 'plan' => request('plan'), 'modpago' => request('modpago'),'asesor' => request('asesor'), 'count_premium' => $suscriptores_premium_count])->render() }}
                        </div>
                    </div>
                    <div class="col-xs-12 col-md-6 d-flex justify-content-center">
                        <button onclick="exportNewExcel()" class="btn btn-link btn_exportarExcel"><i
                                class="fa fa-file-excel-o"></i>
                            Exportar a Excel</button>
                    </div>

                </div>

                @include('panel.subscriber.deposito.pagos')
                @include('panel.subscriber.deposito.create')
                @include('panel.subscriber.deposito.edit')
                {{-- @include('panel.subscriber.deposito.filters') --}}
                @include('panel.subscriber.deposito.new_filters')
                @include('panel.subscriber.free.asignatecurso')
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
            tbSubscribers: $("#subscribers"),
            total_reg: $("#totalReg"),
            ruta: '',
        }

        function getSubscribers(page = 0) {
            spinner.show();
            $("#form_filter").trigger('reset');
            props.ruta = '/panel/subscribers/premium-data';
            if (page != 0) props.ruta = `/panel/subscribers/premium-data/?page=${page}`;
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    props.tbSubscribers.empty();
                    spinner.hide();
                    props.total_reg.text(`${response.total} Registros`);
                    response.data.forEach(subs => {
                        props.tbSubscribers.append(`
					<tr>
						<td>${subs.user.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td>
						<td>${subs.user.pais}</td>
						<td>${subs.user.phone_number}</td>
						<td>${dateFormat(subs.suscription_init)}</td>
						<td>${dateFormat(subs.suscription_end)}</td>
						<td>${subs.plan.name} (${subs.plan.moneda})</td>
						<td>${subs.status}</td>
						<td>${subs.gestor.name} </td>
						<td>
							<button onclick='verPagos(${JSON.stringify(subs.pagos)},"${subs.user.name}")' class="btn btn-link btn-sm">Pagos</button>
							<button type="button" onclick='openModalAsignC(${subs.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i>Curso
							</button>
							<button onclick='editSubscriber(${JSON.stringify(subs)})' class="btn btn-primary btn-sm">Editar</button>
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
                    props.ruta = `/panel/subscribers-premium/search/?text=${input.value}`;
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
										<td>${dateFormat(subs.suscription_end)}</td>
										<td>${subs.plan.name} (${subs.plan.moneda})</td>
										<td>${subs.status}</td>
										<td>${subs.gestor.name}</td>
										<td>
											<button onclick='verPagos(${JSON.stringify(subs.pagos)},"${subs.user.name}")' class="btn btn-link btn-sm">Pagos</button>
											<button type="button" onclick='openModalAsignC(${subs.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i>Curso
											</button>
											<button onclick='editSubscriber(${JSON.stringify(subs)})' class="btn btn-primary btn-sm">Editar</button>
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

        function createSubscriber() {
            props.modal_create.modal();
            props.ruta = '/panel/planes-gestor-data';
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    $("#planes-create").empty();
                    response.planes.forEach((plan, index) => {
                        if (index == 0) {
                            $("#planes-create").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
                            $(".caduca").val(plan.caduca);
                            $(".precio_plan").val(plan.precio);

                        } else {
                            $("#planes-create").append(`
							<option data-caduca="${plan.caduca}"  data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
                        }

                    });

                    $("#gestores").empty();
                    response.gestores.forEach(user => {
                        $("#gestores").append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
                    });

                })
                .catch(error => {
                    console.log(error);
                });

        }



        function saveSubscriber(form) {
            event.preventDefault();
            if (validateForm(form)) {
                spinner.show();
                props.ruta = '/panel/subscribers/premium';
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


        function changeCaducidad(select) {
            $(".caduca").val(select.options[select.selectedIndex].getAttribute('data-caduca'));
            $(".precio_plan").val(select.options[select.selectedIndex].getAttribute('data-precio'));
        }

        //Update Subscription
        // function editSubscriber(subs) {
        function editSubscriber(subs_user,subs_plan_id,subs_gestor_id,subs_suscription_end,subs_medio,subs_tipo) {
            props.ruta = '/panel/planes-gestor-data';
            fetch(props.ruta)
                .then(response => response.json())
                .then(response => {
                    $("#planes-edit").empty();
                    console.log(subs_plan_id);
                    response.planes.forEach(plan => {
                        if (subs_plan_id == plan.id) {
                            $("#planes-edit").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
                            $(".precio_plan").val(plan.precio);
                        } else {
                            $("#planes-edit").append(`
							<option data-caduca="${plan.caduca}" data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
                        }
                    });

                    $("#gestores_edit").empty();
                    // console.log(subs.gestor_id);
                    response.gestores.forEach(user => {
                        if (subs_gestor_id == user.id) {
                            // console.log(user.id);
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


            let formEdit = $("#editform")[0];
            formEdit.user_id.value = subs_user.id;
            formEdit.name.value = subs_user.name;
            formEdit.last_name.value = subs_user.last_name;
            formEdit.email.value = subs_user.email;
            formEdit.suscription_end.value = subs_suscription_end;

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

            props.modal_edit.modal();
        }


        function updateSubscriber(form) {
            event.preventDefault();
            if (validateForm(form)) {
                spinner.show();
                props.ruta = `/panel/subscribers/premium/${form.user_id.value}`;
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
                            props.modal_edit.modal('hide');
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

        function anulaSuscriptin(user_id) {
            if (confirm('¿Seguro de anular la suscripción?')) {
                props.ruta = `/panel/subscribers-premium/${user_id}/destroy`;

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
						   	${plan.name}
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
                },
                error: error => {
                    console.log(error);
                }
            });
        }

        function openModalFilter() {
            $("#modal_filter").modal();
        }

        function applyFilter(page = 0) {
            event.preventDefault();

            if (page != 0) {
                props.ruta = `/panel/subscribers-premium/filter/?page=${page}`;
            } else {
                props.ruta = '/panel/subscribers-premium/filter/';
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
                            props.tbSubscribers.append(`
									<tr>
										<td>${subs.user.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td>
										<td>${subs.user.pais}</td>
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.suscription_init)}</td>
										<td>${dateFormat(subs.suscription_end)}</td>
										<td>${subs.plan.name} (${subs.plan.moneda})</td>
										<td>${subs.status}</td>
										<td>${subs.gestor.name}</td>
										<td>
											<button onclick='verPagos(${JSON.stringify(subs.pagos)},"${subs.user.name}")' class="btn btn-link btn-sm">Pagos</button>
											<button type="button" onclick='openModalAsignC(${subs.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Curso
											</button>
											<button onclick='editSubscriber(${JSON.stringify(subs)})' class="btn btn-primary btn-sm">Editar</button>
											<button onclick="anulaSuscriptin(${subs.user.id})" class="btn btn-danger btn-sm">Anular</button>
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

        function exportNewExcel() {

            var search = "{{ request('search') }}";
            var order = "{{ request('order') }}";
            var plan = "{{ request('plan') }}";
            var modpago = "{{ request('modpago') }}";
            var asesor = "{{ request('asesor') }}";
            var status = "{{ request('status') }}";

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
            if (asesor.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'asesor=' + asesor;
            }
            if (status.length > 0) {
                if ($parametros.length > 0) {
                    $parametros += '&';
                }
                $parametros += 'status=' + status;
            }

            // let data = $("#form_filter").serialize();
            let url_download = `/panel/subscribers-premium/download?${$parametros}`;

            window.location = url_download;

        }



        function verPagos(pagos, username) {
            $('#pagosde_user').text(username);
            $("#dataPagos").empty();
            if (pagos.length > 0) {
                pagos.forEach((pago, index) => {
                    $("#dataPagos").append(
                        `<tr>
						<td>${pago.id}</td>
						<td>${pago.moneda=="PEN" ? 'S/.' : '$'} ${pago.monto}</td>
						<td>${pago.tipo}</td>
						<td>${pago.metodopago_id === 1 ? 'Pago en linea' : 'Depósito/Transferencia'}</td>


						<td>
						${pago.voucher_emit === 0 ? 
							`<span>No solicitado</span>` : pago.voucher_emit === 1 ? `<button onclick="updateStatusCompronte(${pago.id})" class="btn btn-primary btn-sm">Validar emisión</button>` : `<span>Emitido</span>`}
						</td>
						<td>${pago.nro_comprobante}</td>

					</tr>`);

                });

            } else {
                $("#dataPagos").append(`<span>No se encontró registros...</span>`);
            }

            $("#modal_pagos").modal();

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
            // let formAsign = $("#form-asign-c")[0];
            var selected = $(this).val()
            var monedaModal = $("[name=moneda]").val();
            $("[name=pago_monto]").val("")
            // console.log(userIdModal);
            $.ajax({
                url: '/panel/cursos-precio',
                data: "curso_id=" + selected + "&user_id=" + userIdModal + "&moneda=" + monedaModal,
                success: res => {
                    console.log(res.pago_monto);
                    $("[name=pago_monto]").val(res.pago_monto)
                    // $(formAsign.pago_monto).val(res.pago_monto);
                },
                error: error => {
                    console.log(error);
                }
            });
            // $("[name=pago_monto]").val(selected)
        })
        
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

@extends('layouts.app')
@section('titulo','Suscriptores gratis')
@section('content')
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
					<div class="col-xs-12 col-md-6">
						<div class="input-group has-success">
						  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
						  <input type="text" id="texto" class="form-control" onkeyup="buscar(this);" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
						</div>
					</div>
					<div class="col-xs-12 col-md-3">
						<form method="POST" id="form_select" action="#">
							<select name="asesor" id="asesores" class="form-control" onchange="getSubscribersByAsesor()"></select>
						</form>
						
					</div>
					<button onclick="createSubscriberFree();" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>

					<span id="box-btn"></span>
					<span class="badge" id="totalReg"></span>
				</div>
				<hr>
				<div class="table-responsive">
					<table class="table table-condensed table-hover table-bordered">
						<thead>
							<th>Id</th>
							<th>Nombres y Apellidos</th>
							<th>Correo electrónico</th>
							<th>País</th>
							<th>Telf.</th>
							<th>F. Registro</th>
							<th>Intereses</th>
							<th>Asesor asignado</th>
							<th>Control</th>
						</thead>
						
						<tbody id="subscribers">
							
						</tbody>
					</table>

				</div>

				<div class="row">
				   <div class="col-xs-12 col-md-4">
				       <div class="input-group custom-pagination">
				        <!-- Render pagination here -->
				       </div>
				    </div>
				    <div class="col-xs-12 col-md-8">
					<button onclick="exportExcel()" class="btn btn-link"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
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
	$(document).ready(function(){
		getSubscribers();
		getAsesores();
	});

	let props = {
		tbSubscribers : $("#subscribers"),
		counter : $("#totalReg"),
		ruta : '',
		selectAsesores: $("#asesores"),
		modal_create : $("#modal_create"),
	}

	function createSubscriberFree() {	
		props.modal_create.modal();
		
		
	}
	function saveSubscriberFree(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show();
			props.ruta = '/panel/subscribers/free';
			let	token = '{{ csrf_token() }}',
				data = $(form).serialize();

			$.ajax({
				url: props.ruta,
				type: 'POST',
				headers: {'X-CSRF-TOKEN': token},
				data: data,
				dataType: 'JSON',
				success: data =>{
					spinner.hide();
					if(data.status == 200){
						props.modal_create.modal('hide');

						getSubscribers();
						
						toastr.success(data.message,'Exito');
						$(form).trigger('reset');
					}

					if(data.status == 422){
						for (var error in data.errors){
						    toastr.error(data.errors[error][0],'Advertencia');
						}
					}

					console.log(data);
				},
				error: error =>{
					console.log(error);
				}
			});
		}
		
	}

	function getSubscribers(page = 0) {
		props.ruta = '/panel/subscribers/free-data';
		if(page != 0) props.ruta = `/panel/subscribers/free-data/?page=${page}`;
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				props.tbSubscribers.empty();
				spinner.hide();
				props.counter.text(`${res.total} Registros`);
				res.data.forEach(subs =>{
					props.tbSubscribers.append(`
							<tr>
								<td>${subs.id}</td>
								<td>${subs.name} ${subs.last_name}</td>
								<td>${subs.email}</td>
								<td>${subs.pais}</td>
								<td>${subs.phone_number}</td>
								<td>${dateFormat(subs.created_at)}</td>
								<td>${getIntereses(subs.intereses)}</td>
								<td>${subs.asignacion == null ? '...' : `${subs.asignacion.gestor.name}`}</td>
								<td>
								${subs.asignacion == null ? `<button type="button" onclick='openModalAsign(${subs.id})' class="btn btn-primary btn-sm" title="Asignar a">
									  <i class="fa fa-plus" aria-hidden="true"></i> Asignar a
									</button>` : `<button type="button" onclick='destroyAsignation(${subs.id})' class="btn btn-danger btn-sm" title="Quitar asignación">
									  <i class="fa fa-times" aria-hidden="true"></i> Desasignar
									</button>`}

									<button type="button" onclick='openModalAsignC(${subs.id})' class="btn btn-light btn-sm" title="Asignar Curso">
									  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
									</button>
									
									<button type="button" onclick='getRecords(${JSON.stringify(subs.records)},"${subs.name}");' class="btn btn-success btn-sm" title="Ver historial">
									  <i class="fa fa-history" aria-hidden="true"></i>
									</button>

									<button type="button" onclick="destroyUser(${subs.id})" class="btn btn-danger btn-sm" title="Borrar">
									  <i class="fa fa-trash" aria-hidden="true"></i>
									</button>

								</td>
							</tr>
						`);
				});

				renderPagination(res,'getSubscribers');

			},
			error: error =>{
				console.log(error);
			}
		});
	}

	function getIntereses(intereses) {
		let intereses_str ='';
		for (var i = 0; i < intereses.length; i++) {
			intereses_str += `${intereses[i].medio.sigla} `;
		}
		return intereses_str;
	}

	
	function buscar(input) {
		if(input.value != ''){
			if(event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/searchSubscriberfree?text=${input.value.trim()}`;
				$.ajax({
					url: props.ruta,
					type: 'GET',
					dataType: 'JSON',
					success: res =>{
						spinner.hide();
						props.counter.empty();
						$(".custom-pagination").empty();
						props.tbSubscribers.empty();
						if(res.length > 0){
							res.forEach(subs =>{
								props.tbSubscribers.append(`
										<tr>
											<td>${subs.id}</td>
											<td>${subs.name} ${subs.last_name}</td>
											<td>${subs.email}</td>
											<td>${subs.pais}</td>
											<td>${subs.phone_number}</td>
											<td>${dateFormat(subs.created_at)}</td>
											<td>${getIntereses(subs.intereses)}</td>
											<td>${subs.asignacion == null ? '...' : `${subs.asignacion.gestor.name}`}</td>
											<td>
												${subs.asignacion == null ? `<button type="button" onclick='openModalAsign(${subs.id})' class="btn btn-primary btn-sm" title="Asignar a">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar a
													</button>` : `<button type="button" onclick='destroyAsignation(${subs.id})' class="btn btn-danger btn-sm" title="Quitar asignación">
													  <i class="fa fa-times" aria-hidden="true"></i> Desasignar
													</button>`}

													<button type="button" onclick='openModalAsignC(${subs.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
													</button>
													
													<button type="button" onclick='getRecords(${JSON.stringify(subs.records)},"${subs.name}");' class="btn btn-success btn-sm" title="Ver historial">
													  <i class="fa fa-history" aria-hidden="true"></i>
													</button>

													<button type="button" onclick="destroyUser(${subs.id})" class="btn btn-danger btn-sm" title="Borrar">
													  <i class="fa fa-trash" aria-hidden="true"></i>
													</button>
											</td>
										</tr>
									`);
							});
						}else{
							tbSubscribers.append('No hay registros...');
						}
						
					},
					error: error =>{
						console.log(error);
					}
				});
			}
		}else{
			getSubscribers();
		}
	}
	function getRecords(records,usermane) {
		$('#records').empty();
		$('#modalrecords').modal();
		$("#usernamerecord").text(usermane);
		if(records.length > 0){
			records.forEach(record =>{
				$('#records').append(`
						<tr>
							<td>${record.id}</td>
							<td>${record.gestor.name}</td>
							<td>${record.body}</td>
							<td>${dateFormat(record.created_at)}</td>
						</tr>
					`);
			});

		}else{
			$('#records').append('No hay registros...');
		}
	}

	function getAsesores() {
		props.ruta = '/panel/asesores-data';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: resp =>{
				props.selectAsesores.empty();
				props.selectAsesores.append(`<option selected disabled>Filtrar por asesor</option>`);
				resp.forEach(user =>{
					props.selectAsesores.append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
				});
			},
			error: err =>{
				console.log(err);
			}
		});
	}

	function getSubscribersByAsesor(page = 0) {
		spinner.show();
		props.ruta = `/panel/subscribers/byasesor/`;

		if(page != 0) props.ruta = `/panel/subscribers/byasesor/?page=${page}`;
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			data: {'asesorid': $("#asesores").val()},
			success: resp =>{
				spinner.hide();
				props.tbSubscribers.empty();
				props.counter.text(`${resp.total} Registros`);
				resp.data.forEach(subs =>{
					props.tbSubscribers.append(`
							<tr>
								<td>${subs.id}</td>
								<td>${subs.name} ${subs.last_name}</td>
								<td>${subs.email}</td>
								<td>${subs.pais}</td>
								<td>${subs.phone_number}</td>
								<td>${dateFormat(subs.created_at)}</td>
								<td>${getIntereses(subs.intereses)}</td>
								<td>${subs.asignacion == null ? '...' : `${subs.asignacion.gestor.name}`}</td>
								<td>
								${subs.asignacion == null ? `<button type="button" onclick='openModalAsign(${subs.id})' class="btn btn-primary btn-sm" title="Asignar a">
									  <i class="fa fa-plus" aria-hidden="true"></i> Asignar a
									</button>` : `<button type="button" onclick='destroyAsignation(${subs.id})' class="btn btn-danger btn-sm" title="Quitar asignación">
									  <i class="fa fa-times" aria-hidden="true"></i> Desasignar
									</button>`}

									<button type="button" onclick='openModalAsignC(${subs.id})' class="btn btn-light btn-sm" title="Asignar Curso">
									  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
									</button>
									
									<button type="button" onclick='getRecords(${JSON.stringify(subs.records)},"${subs.name}");' class="btn btn-success btn-sm" title="Ver historial">
									  <i class="fa fa-history" aria-hidden="true"></i>
									</button>

									<button type="button" onclick="destroyUser(${subs.id})" class="btn btn-danger btn-sm" title="Borrar">
									  <i class="fa fa-trash" aria-hidden="true"></i>
									</button>

								</td>
							</tr>
						`);
				});

				renderPagination(resp,'getSubscribersByAsesor');

				$("#box-btn").html(`<button onclick="quitarFiltros()" class="btn btn-warning"><i class="fa fa-filter"></i> Quitar filtros</button>`);

			},
			error: err =>{
				console.log(err);
			}
		});
	}
	function quitarFiltros() {
		getAsesores();
		getSubscribers();
		$("#box-btn").html('');
	}

	function openModalAsign(userId) {
		let formAsign = $("#form-asign")[0];
		props.ruta = '/panel/asesores-data';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				$(formAsign.gestor).empty();
				res.forEach(user =>{
					$(formAsign.gestor).append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
				});
			},
			error: error =>{
				console.log(error);
			}
		});

		$(formAsign.user_id).val(userId);
		$('#modalasign').modal();
	}

	function openModalAsignC(userId) {
		let formAsign = $("#form-asign-c")[0];
		props.ruta = '/panel/cursos-data';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				console.log("aaaa");
				console.log(res);
				$(formAsign.gestor).empty();
				res.cursos.forEach(curso =>{
					$(formAsign.gestor).append(`
							<option value="${curso.id}">${curso.titulo}</option>
						`);
				});

				$(formAsign.gestor_a).empty();
				res.gestores.forEach(user =>{
					$(formAsign.gestor_a).append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
				});


			},
			error: error =>{
				console.log(error);
			}
		});

		$(formAsign.user_id).val(userId);
		$('#modalasign1').modal();
	}

	function saveAsignation(form) {
		event.preventDefault();
		props.ruta = '/panel/asignateto';
		let	data = $(form).serialize();
			spinner.show();
		$.ajax({
			url: props.ruta,
			type:'POST',
			dataType: 'JSON',
			data: data,
			success: res =>{
				spinner.hide();
				$('#modalasign').modal('hide');

				getSubscribers($("#current_page").val());
				toastr.success(res.message,'Exito');
			},
			error: error =>{
				console.log(error);
			}
		});
	}


	function saveAsignationc(form) {
		event.preventDefault();
		props.ruta = '/panel/asignatecurso';
		let	data = $(form).serialize();
			spinner.show();
		$.ajax({
			url: props.ruta,
			type:'POST',
			dataType: 'JSON',
			data: data,
			success: res =>{
				spinner.hide();
				$('#modalasign1').modal('hide');

				getSubscribers($("#current_page").val());
				toastr.success(res.message,'Exito');
			},
			error: error =>{
				console.log(error);
			}
		});
	}

	function destroyAsignation(userId) {
		if(confirm('¿Seguro de quitar la asignación?')){
			props.ruta = `/panel/destroyasination/${userId}`;
			spinner.show();
			$.ajax({
				url: props.ruta,
				type: 'GET',
				dataType: 'JSON',
				success: res =>{
					spinner.hide();
					getSubscribers($("#current_page").val());
					toastr.success(res.message,'Exito');
				},
				error: error =>{
					console.log(error);
				}
			});
		}
		
	}

	function destroyUser(userId) {
		if(confirm('¿Seguro de eliminar el registro?')){
			spinner.show();
			props.ruta =`/panel/user/${userId}/destroy-json`;
			$.ajax({
				url: props.ruta,
				type: 'GET',
				dataType: 'JSON',
				success: res =>{
					spinner.hide();
					getSubscribers($("#current_page").val());
					toastr.success(res.message,'Exito');
				},
				error: error =>{
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

</script>
@endsection
@extends('layouts.app')
@section('titulo','Mis asignaciones')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<i class="fa fa-list-ol"></i> Mis asignaciones
		</li>
	</ol>
	@include('alerts.success')
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					<div class="input-group has-success">
					  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
					  <input type="text" id="texto" class="form-control" onkeyup="buscar(this);" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione enter">
					</div>
					
				</div>
				<div class="col-xs-12 col-md-6">
					<span class="badge" id="total-reg"></span>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Id</th>
						<th>Nombres y Apellidos</th>
						<th>Correo electrónico</th>
						<th>Telf.</th>
						<th>F. Registro</th>
						<th>Intereses</th>
						<th>Generar</th>
					</thead>
					<tbody id="asignations">
						
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
	@include('panel.subscriber.deposito.records')
	@include('panel.subscriber.deposito.frmconvert')
	@include('panel.subscriber.free.asignatecurso')

</div>

@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getAsignations();
	});

	let props = {
		ruta: '',
		tbAsignations : $("#asignations"),
		modal_records : $("#modalrecords"),
		tbRecords : $("#records"),
		counter: $("#total-reg"),
		modal_convert : $("#modal_convert"),
	}

	function getAsignations(page = 0) {
		props.ruta = '/panel/users/asignations-data';
		if(page != 0) props.ruta = `/panel/users/asignations-data/?page=${page}`;
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				props.tbAsignations.empty();
				spinner.hide();
				props.counter.text(`${res.total} Registros`);
				res.data.forEach(asign =>{
					props.tbAsignations.append(`
						<tr>
							<td>${asign.suscriptor.id}</td>
							<td>${asign.suscriptor.name} ${asign.suscriptor.last_name}</td>
							<td>${asign.suscriptor.email}</td>
							<td>${asign.suscriptor.phone_number}</td>
							<td>${dateFormat(asign.suscriptor.created_at)}</td>
							<td>${getIntereses(asign.suscriptor.intereses)}</td>
							<td>
								<button onclick='showModalConvert(${JSON.stringify(asign.suscriptor)})' class="btn btn-primary btn-sm">Suscripción</button>
								<button onclick='showModalRecords(${JSON.stringify(asign.suscriptor)})' class="btn btn-success btn-sm"><i class="fa fa-history"></i> Historial</button>
								<button type="button" onclick='openModalAsignC(${asign.suscriptor.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
							</button>
						</tr>
						`);
				});
				renderPagination(res,'getAsignations');
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
	function exportExcel() {

		let res = $("#form_filter").serialize();
		let url_download = `/panel/subscribers-support/download?${res}`;

		window.location = url_download;

	}


	function buscar(input) {
		if(input.value != ''){
			if(event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/users/asignations/search/${input.value.trim()}`;
				$.ajax({
					url: props.ruta,
					type: 'GET',
					dataType: 'JSON',
					success: res =>{
						spinner.hide();
						props.counter.empty();
						$(".custom-pagination").empty();
						props.tbAsignations.empty();
						if(res.length > 0){
							res.forEach(asign =>{
								props.tbAsignations.append(`
										<tr>
											<td>${asign.suscriptor.id}</td>
											<td>${asign.suscriptor.name} ${asign.suscriptor.last_name}</td>
											<td>${asign.suscriptor.email}</td>
											<td>${asign.suscriptor.phone_number}</td>
											<td>${dateFormat(asign.suscriptor.created_at)}</td>
											<td>${getIntereses(asign.suscriptor.intereses)}</td>
											<td>
												<button onclick='showModalConvert(${JSON.stringify(asign.suscriptor)})' class="btn btn-primary btn-sm">Suscripción</button>
												<button onclick='showModalRecords(${JSON.stringify(asign.suscriptor)})' class="btn btn-success btn-sm"><i class="fa fa-history"></i> Historial</button>
												<button type="button" onclick='openModalAsignC(${asign.suscriptor.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Asignar Curso
												</button>
										</tr>
									`);
							});
						}else{
							props.tbAsignations.append('No hay registros...');
						}
						
					},
					error: error =>{
						console.log(error);
					}
				});
			}
		}else{
			getAsignations();
		}
	}

	function showModalRecords(subs) {
		getRecords(subs.id);
		$("#user_id").val(subs.id);
		let user_name = `${subs.name} ${subs.last_name}`;
		$("#usernamerecord").html(`Nombres: <strong>${user_name.toUpperCase()} </strong> N°: <strong>${subs.phone_number}</strong>`);
		props.modal_records.modal();
	}

	function getRecords(subsId) {
		props.ruta = `/panel/subscribers/${subsId}/records`;
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				spinner.hide();
				props.tbRecords.empty();
				if(res.length > 0){
					res.forEach(record =>{
					props.tbRecords.append(`
							<tr>
								<td>${record.id}</td>
								<td>${record.body}</td>
								<td>${dateFormat(record.created_at)}</td>
								<td>
									<button onclick="destroyRecord(${record.id})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>

								</td>
							</tr>
						`);
					});
				}else{
					props.tbRecords.append('<span>No hay registros...</span>');
				}
			},
			error: error =>{
				console.log(error);
			}
		});
	}

	function saveRecord(form) {
		event.preventDefault();
		props.ruta = '/panel/recordsave';
		let data = $(form).serialize();
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'POST',
			headers: {'X-CSRF-TOKEN': form._token.value},
			dataType: 'JSON',
			data: data,
			success: res =>{
				spinner.hide();
				getRecords(form.user_id.value);
				toastr.success(res.message);
				$(form).trigger('reset');
			},
			error: error =>{
				if (error.status == 422){
					spinner.hide();
					let errors = Object.values(error.responseJSON.errors);
					for (var error in errors){
					    toastr.error(errors[error][0],'Advertencia');
					}

				}else{
					console.log(error);
				}
			}
		});
	}
	function destroyRecord(recordId) {
		if(confirm('¿Seguro de eliminar el registro?')){
		props.ruta = `/panel/record-destroy/${recordId}`;
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				spinner.hide();
				getRecords($("#user_id").val());
				toastr.success(res.message);
			},
			error: error =>{
				console.log(error);
			}
		});

		}
	}
	function showModalConvert(user) {
		let fConvert = $("#form-convert")[0];
		fConvert.user_convert_id.value = user.id; 
		fConvert.name.value = user.name;
		fConvert.last_name.value = user.last_name;
		fConvert.email.value = user.email;
		fConvert.phone_number.value = user.phone_number;
		fConvert.doc_number.value = user.doc_number;
		
		//Llena los planes al select 
		props.modal_convert.modal();
		props.ruta = '/panel/planes-data';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			$("#planes").empty();
			response.forEach((plan, index) =>{
				if(index == 0){
					$("#planes").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
					$(".caduca").val(plan.caduca);
					$(".precio_plan").val(plan.precio);
				}else{
					$("#planes").append(`
							<option data-caduca="${plan.caduca}" data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
				}
			});
		})
		.catch(error =>{
			console.log(error);
		});
	}
	function changeCaducidad(select) {
		$(".caduca").val(select.options[select.selectedIndex].getAttribute('data-caduca'));
		$(".precio_plan").val(select.options[select.selectedIndex].getAttribute('data-precio'));
	}

	function saveSubscriber(form) {
		event.preventDefault();
		props.ruta = `/panel/convertosuscrip/${form.user_id.value}`;
		let data = $(form).serialize();
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'POST',
			headers: {'X-CSRF-TOKEN': form._token.value},
			dataType: 'JSON',
			data: data,
			success: res =>{
				spinner.hide();
				if($("#current_page").val()){
					getAsignations($("#current_page").val());
				}
				getAsignations();
				toastr.success(res.message);
				props.modal_convert.modal('hide');
			},
			error: error =>{
				if (error.status == 422){
					spinner.hide();
					let errors = Object.values(error.responseJSON.errors);
					for (var error in errors){
					    toastr.error(errors[error][0],'Advertencia');
					}
				}else{
					console.log(error);
				}
			}
		});

	}
	  function openModalAsignC(userId) {
		let formAsign = $("#form-asign-c")[0];
		props.ruta = '/panel/cursos-data';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				$(formAsign.gestor).empty();
				res.forEach(curso =>{
					$(formAsign.gestor).append(`
							<option value="${curso.id}">${curso.titulo}</option>
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
</script>
@endsection
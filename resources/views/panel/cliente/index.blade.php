@extends('layouts.app')
@section('titulo','Clientes')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			Clientes
		</li>
	</ol>
	<div class="panel panel-success">
		<div class="panel-body">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="input-group has-success">
						  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
						  <input type="text" name="texto" class="form-control" onkeyup="buscar(this)" id="basic-url" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
						</div>
						
					</div>
					<div class="col-xs-12 col-md-6">
						
						<button  onclick="createCliente()" class="btn btn-success">Nuevo registro <i class="fa fa-plus" aria-hidden="true"></i></button>
						
						<button onclick="openModalFilter();" class="btn btn-warning">
						<i class="fa fa-filter" aria-hidden="true"></i> Filtros
					</button>
					<button onclick="getClientes();" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i> Mostrar todo</button>
						<span class="badge" id="totalReg"></span>
					</div>
				</div>
				<hr>
				<div class="table-responsive">
					<table class="table table-condensed table-hover table-bordered">
			      		<thead>
			      			<th>Id</th>
			      			<th>Nombres y Apellidos</th>
			      			<th>Correo electrónico</th>
			      			<th>F. Registro</th>
			      			<th>F. Caducidad</th>
			      			<th>Ejecutivo</th>
			      			<th>Estado</th>
			      			<th>Control</th>
			      		</thead>
			      		<tbody id="clientes">
			      			
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
		@include('panel.cliente.filters')
	@include('panel.subscriber.free.asignatecurso')
	@include('panel.cliente.create')
	@include('panel.cliente.edit')


</div>

@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getClientes();
	});

	let props = {
		modal_create :$("#modal_create"),
		modal_edit : $("#modal_edit"),
		tbClientes : $("#clientes"),
		counter : $("#totalReg"),
		ruta : ''
	}


	function getClientes(page = 0) {
		spinner.show();
		props.ruta = '/panel/clientes-data';
		if(page != 0) props.ruta = `/panel/clientes-data/?page=${page}`;

		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbClientes.empty();
			spinner.hide();
			props.counter.text(`${response.total} Registros`);
			response.data.forEach(cliente =>{
				props.tbClientes.append(`
						<tr>
							<td>${cliente.user.id}</td>
							<td>${cliente.user.name} ${cliente.user.last_name}</td>
							<td>${cliente.user.email}</td>
							<td>${dateFormat(cliente.fecha_registro)}</td>
							<td>${dateFormat(cliente.fecha_caducidad)}</td>
							<td>${cliente.ejecutivo[0].nombres} ${cliente.ejecutivo[0].apellidos}</td>
							<td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
							<td>
								<button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Curso
											</button>
								<button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
								<button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
							</td>
						</tr>
					`);
			});

			renderPagination(response,'getClientes');
		})
		.catch(error =>{
			console.log(error);
		});
	}



	function buscar(input) {
		if(input.value != ''){
			if (event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/clientes/search?text=${input.value}`;
				$.ajax({
					url: props.ruta,
					type: 'GET',
					dataType: 'JSON',
					success:function(data){
						props.tbClientes.empty();
						props.counter.empty();
						$(".custom-pagination").empty();
						spinner.hide();

						if(data.length > 0){
							data.forEach(cliente =>{
							props.tbClientes.append(`
									<tr>
										<td>${cliente.user.id}</td>
										<td>${cliente.user.name} ${cliente.user.last_name}</td>
										<td>${cliente.user.email}</td>
										<td>${dateFormat(cliente.fecha_registro)}</td>
										<td>${dateFormat(cliente.fecha_caducidad)}</td>
										<td>${cliente.ejecutivo[0].nombres} ${cliente.ejecutivo[0].apellidos}</td>
										<td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
										<td>
											<button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
													  <i class="fa fa-plus" aria-hidden="true"></i> Curso
											</button>
											<button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
											<button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
										</td>
									</tr>
								`);
							});
						}else{
							props.tbClientes.append('<span>Busqueda sin resultados</span>');
						}

					},
					error: error =>{
						spinner.hide();
						console.log(error);
						toastr.error(error.statusText,error.status);
					}
				});
				
			}
		}else{
			getClientes();
		}

	}

	function createCliente() {
		props.modal_create.modal();
		props.ruta = '/panel/ejecutivos-all';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response => {
			$("#ejecutivos_create").empty();
			response.forEach(ejec =>{
				$("#ejecutivos_create").append(`
						<option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
					`);
			});
		})
		.catch(error =>{
			console.log(error);
		});
		
	}

	function saveCliente(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show();
			props.ruta = '/panel/clientes';
			let	token = '{{ csrf_token() }}',
				data = $(form).serialize();
			$.ajax({
				url: props.ruta,
				type: 'POST',
				headers:{'X-CSRF-TOKEN': token},
				data: data,
				dataType: 'JSON',
				success: data =>{
					spinner.hide();
					if(data.status == 200){
						props.modal_create.modal('hide');

						getClientes();
						
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

	function editCliente(cliente) {
		props.modal_edit.modal();
		props.ruta = '/panel/ejecutivos-all';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response => {
			$("#ejecutivos_edit").empty();
			response.forEach(ejec =>{
				if(cliente.ejecutivo[0]){

					if(cliente.ejecutivo[0].idejecutivo == ejec.idejecutivo){
					$("#ejecutivos_edit").append(`
							<option selected value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
						`);
					}else{
						$("#ejecutivos_edit").append(`
								<option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
							`);
					}
				}else{
					
				
					$("#ejecutivos_edit").append(`
							<option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
						`);
			

				}
				
				
			});
		})
		.catch(error =>{
			console.log(error);
		});

		let formEdit = $("#editform")[0];
		formEdit.user_id.value = cliente.user.id;
		formEdit.name.value = cliente.user.name;
		formEdit.last_name.value = cliente.user.last_name;
		formEdit.email.value = cliente.user.email;
		formEdit.phone_number.value = cliente.user.phone_number;
		formEdit.doc_number.value = cliente.user.doc_number;
		formEdit.address.value = cliente.user.address;
		formEdit.empresa.value = cliente.empresa;
		formEdit.caducidad.value = cliente.fecha_caducidad;
		$(formEdit.status).empty();
		$(formEdit.status).append(`
				<option ${cliente.status == 0 ? 'selected' : ''} value="0">Inactivo</option>
				<option ${cliente.status == 1 ? 'selected' : ''} value="1">Activo</option>
			`);
		$(formEdit.medio).empty();
		$(formEdit.medio).append(`
				<option ${cliente.medio == 'RC' ? 'selected' : ''} value="RC">RC</option>
				<option ${cliente.medio == 'TM' ? 'selected' : ''} value="TM">TM</option>
				<option ${cliente.medio == 'DA' ? 'selected' : ''} value="DA">DA</option>
			`);

	}

	function updateCliente(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show();
			props.ruta = `/panel/clientes/${form.user_id.value}`;
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
						props.modal_edit.modal('hide');

						getClientes($("#current_page").val());
						
						toastr.success(data.message,'Exito');
						$(form).trigger('reset');
					}

					if(data.status == 422) {
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

	function destroyClient(userId) {
		if(confirm('¿Seguro de eliminar el registro?')){
			spinner.show();
			props.ruta = `/panel/user/${userId}/destroy-json`;
			$.ajax({
				url: props.ruta,
				type: 'GET',
				dataType: 'JSON',
				success: res =>{
					spinner.hide();
					getClientes($("#current_page").val());
					toastr.success(res.message,'Exito');

				},
				error: error =>{
					console.log(error);
				}

			});
		}
	}
		function getPrevInfo() {
		props.ruta = '/panel/filters-to-clients';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: data =>{
				$("#ejecutivos-filter").empty();
				$("#ejecutivos-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="ejecutivo" id="ejecutivox" value="0" checked>
					   	Todo
					  </label>
					</div>
					`);
				data.ejecutivos.forEach((ejec, index )=>{
					$("#ejecutivos-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="ejecutivo" id="ejecutivo${ejec.idejecutivo}" value="${ejec.idejecutivo}">
						   	${ejec.nombres} ${ejec.apellidos}
						  </label>
						</div>
						`);
				});
			},
			error: error =>{
				console.log(error);
			}
		});
	}

	function openModalFilter() {
		$("#modal_filter").modal();
	}

	function applyFilter(page = 0) {
		event.preventDefault();

		if(page != 0){
			props.ruta = `/panel/clientes/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/clientes/filter/';
		}
		let data = $("#form_filter").serialize(),
			token = '{{csrf_token()}}';

		spinner.show();

		$.ajax({
			url: props.ruta,
			type: 'GET',
			headers: {'X-CSRF-TOKEN': token},
			data: data,
			dataType: 'JSON',
			success: response =>{
				props.counter.text(`${response.total} Registros`);
				if(Array.isArray(response.data)){
					clientes = response.data;
				}else{
					clientes = Object.values(response.data);
				}
				props.tbClientes.empty();
				$("#modal_filter").modal('hide');
				spinner.hide();
					if(clientes.length > 0){
							clientes.forEach(cliente =>{
								props.tbClientes.append(`
									<tr>
										<td>${cliente.user.id}</td>
										<td>${cliente.user.name} ${cliente.user.last_name}</td>
										<td>${cliente.user.email}</td>
										<td>${dateFormat(cliente.fecha_registro)}</td>
										<td>${dateFormat(cliente.fecha_caducidad)}</td>
										<td>${cliente.ejecutivo[0] ? cliente.ejecutivo[0].nombres + " " +cliente.ejecutivo[0].apellidos : "-" } </td>
										<td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
										<td>
											<button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
																  <i class="fa fa-plus" aria-hidden="true"></i> Curso
														</button>
											<button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
											<button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
										</td>
									</tr>
									`)
							});

						renderPagination(response,'applyFilter');
					}else{
						props.tbClientes.append('<span>Filtro sin registros</span>');
						$(".custom-pagination").empty();
					}

			},	
			error: error =>{
				console.log(error);
			}
		});

	}

	function exportExcel() {

		let data = $("#form_filter").serialize();
		let url_download = `/panel/clientes/download?${data}`;

		window.location = url_download;

	}

</script>
@endsection
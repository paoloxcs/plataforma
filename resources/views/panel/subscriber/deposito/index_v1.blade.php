@extends('layouts.app')
@section('titulo','Suscriptores Premium')
@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Suscripcion Premium</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					
					<div class="input-group has-success">
					  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
					  <input type="text" id="texto" class="form-control" onkeyup="buscar(this);"  aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
					</div>

				</div>
				<div class="col-xs-12 col-md-6">
					<button onclick="createSubscriber();" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
					<button onclick="openModalFilter();" class="btn btn-warning">
						<i class="fa fa-filter" aria-hidden="true"></i> Filtros
					</button>
					<button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i> Mostrar todo</button>

					<span class="badge" id="totalReg"></span>
				</div>
			</div>
			<hr>
			{{-- JHED SP-P --}}
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
		      			<th>Nro. Comp.</th>
		      			<th>Monto</th>
		      			<th>Ult. Pago</th>
		      			{{-- <th>Mod. pago</th> --}}
		      			<th>Estado</th>
		      			<th>Gestor</th>
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
		
			@include('panel.subscriber.deposito.pagos')
			@include('panel.subscriber.deposito.create')
			@include('panel.subscriber.deposito.edit')
			@include('panel.subscriber.deposito.filters')
			@include('panel.subscriber.free.asignatecurso')
		</div>
	</div>
</div>

@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getSubscribers(); // Listar al cargar la pagina
		getPrevInfo();
	});

	let props = {
		modal_create : $("#modal_create"),
		modal_edit : $("#modal_edit"),
		tbSubscribers : $("#subscribers"),
		total_reg : $("#totalReg"),
		ruta: '',
	}

	// JHED SP-P
	function getSubscribers(page = 0) {
		spinner.show();
		$("#form_filter").trigger('reset');
		props.ruta ='/panel/subscribers/premium-data';
		if(page != 0) props.ruta = `/panel/subscribers/premium-data/?page=${page}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbSubscribers.empty();
			spinner.hide();
			props.total_reg.text(`${response.total} Registros`);
			response.data.forEach(subs =>{
			    var c_pais= "";
				var c_nro_comprobante= "";
				var c_monto= "";
			if (!subs.user.pais) {//
				c_pais= "<td> </td>"
			}else{//
				c_pais= `<td>${subs.user.pais}</td>`
			}
		    if (!subs.pago_time.nro_comprobante) {//
				c_nro_comprobante= "<td>No hay comprobante</td>"
				c_monto= "<td>$ 0.00</td>"
			}else{//
				c_nro_comprobante= `<td>${subs.pago_time.nro_comprobante}</td>`
				c_monto= `<td>${subs.pago_time.moneda=="PEN" ? 'S/.' : '$'} ${subs.pago_time.monto}</td>`
			}
				props.tbSubscribers.append(`
					<tr>
						<td>${subs.user.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td>
						${c_pais}
						<td>${subs.user.phone_number}</td>
						<td>${dateFormat(subs.suscription_init)}</td>
						<td>${dateFormat(subs.suscription_end)}</td>
						<td>${subs.plan.name} (${subs.plan.moneda})</td>
						${c_nro_comprobante}
						${c_monto}
						<td>${getDateFormat(subs.pago_time.created_at)}</td>
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

			renderPagination(response,'getSubscribers');
			/*console.log(response);*/
		})
		.catch(error =>{
			console.log(error);
		});
	}

	// JHED SP-P
	function buscar(input) {
		if(input.value != ''){
			if (event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/subscribers-premium/search/?text=${input.value}`;
				$.ajax({
					url: props.ruta,
					type: 'GET',
					dataType: 'JSON',
					success:response =>{
						props.total_reg.empty();
						props.tbSubscribers.empty();
						$(".custom-pagination").empty();
						spinner.hide();
						if(response.length > 0){
							response.forEach(subs =>{
							    var c_pais= "";
								var c_nro_comprobante= "";
								var c_monto= "";
							    if (!subs.user.pais) {//
									c_pais= "<td> </td>"
								}else{//
									c_pais= `<td>${subs.user.pais}</td>`
								}
								if (!subs.pago_time.nro_comprobante) {//
									c_nro_comprobante= "<td>No hay comprobante</td>"
									c_monto= "<td>$ 0.00</td>"
								}else{//
									c_nro_comprobante= `<td>${subs.pago_time.nro_comprobante}</td>`
									c_monto= `<td>${subs.pago_time.moneda=="PEN" ? 'S/.' : '$'} ${subs.pago_time.monto}</td>`
								}
								props.tbSubscribers.append(`
									<tr>
										<td>${subs.user.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td>
										${c_pais}
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.suscription_init)}</td>
										<td>${dateFormat(subs.suscription_end)}</td>
										<td>${subs.plan.name} (${subs.plan.moneda})</td> 
										${c_nro_comprobante}
										${c_monto}
										<td>${getDateFormat(subs.pago_time.created_at)}</td>
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

						}else{
							props.tbSubscribers.append('<span>Sin resultados...</span>');
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
			getSubscribers();
		}

	}


	function createSubscriber() {
		props.modal_create.modal();
		props.ruta = '/panel/planes-gestor-data';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			$("#planes-create").empty();
			response.planes.forEach((plan, index) =>{
				// if(index == 0){
				// 	$("#planes-create").append(`
				// 			<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
				// 		`);
				// 	$(".caduca").val(plan.caduca);
				// 	$(".precio_plan").val(plan.precio);

				// }else{
				// 	$("#planes-create").append(`
				// 			<option data-caduca="${plan.caduca}"  data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
				// 		`);
				// }
				if((`"${plan.name} (${plan.moneda})"`).toLowerCase().includes("anual (pen)")){
					$("#planes-create").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
					$(".caduca").val(plan.caduca);
					$(".precio_plan").val(plan.precio);
					status=true;
				}else{
					if(!status){
						$("#planes-create").append(`
								<option selected data-caduca="${response.planes[0].caduca}"  data-precio="${response.planes[0].precio}"  value="${response.planes[0].id}">${response.planes[0].name} (${response.planes[0].moneda})</option>
							`);
						$(".caduca").val(response.planes[0].caduca);
						$(".precio_plan").val(response.planes[0].precio); 
						status=true;
					}else{
						$("#planes-create").append(`
								<option data-caduca="${plan.caduca}"  data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
					}
				}
				
			});

			$("#gestores").empty();
				response.gestores.forEach(user =>{
					$("#gestores").append(`
							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
			});

		})
		.catch(error =>{
			console.log(error);
		});
		
	}

	

	function saveSubscriber(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show();
			props.ruta = '/panel/subscribers/premium';
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


	function changeCaducidad(select) {
		$(".caduca").val(select.options[select.selectedIndex].getAttribute('data-caduca'));
		$(".precio_plan").val(select.options[select.selectedIndex].getAttribute('data-precio'));
	}

	function editSubscriber(subs) {
		props.ruta = '/panel/planes-gestor-data';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			$("#planes-edit").empty();
			response.planes.forEach(plan =>{
				if(subs.plan_id == plan.id){
					$("#planes-edit").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
						$(".precio_plan").val(plan.precio);
				}else{
					$("#planes-edit").append(`
							<option data-caduca="${plan.caduca}" data-precio="${plan.precio}" value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
				}
				
			});

			$("#gestores_edit").empty();
			response.gestores.forEach(user =>{
				if(subs.gestor_id == user.id){
					$("#gestores_edit").append(`
							<option selected value="${user.id}">${user.name} ${user.last_name}</option>
						`);
				}else{
					$("#gestores_edit").append(`

							<option value="${user.id}">${user.name} ${user.last_name}</option>
						`);
				}
				
			});
		})
		.catch(error =>{
			console.log(error);
		});

		
		let formEdit = $("#editform")[0];
		formEdit.user_id.value = subs.user.id; 
		formEdit.name.value = subs.user.name;
		formEdit.last_name.value = subs.user.last_name;
		formEdit.email.value = subs.user.email;
		formEdit.suscription_end.value = subs.suscription_end;

		formEdit.phone_number.value = subs.user.phone_number;
		formEdit.doc_number.value = subs.user.doc_number;
		formEdit.address.value = subs.user.address;

		$(formEdit.medio).empty();
		$(formEdit.medio).append(`
				<option ${subs.medio =='RC'? 'selected' : ''} value="RC">RC</option>
				<option ${subs.medio =='TM'? 'selected' : ''} value="TM">TM</option>
				<option ${subs.medio =='DA'? 'selected' : ''} value="DA">DA</option>
			`);
		$(formEdit.modalidad).empty();
		$(formEdit.modalidad).append(`
				<option ${subs.tipo =='D'? 'selected' : ''} value="D">Digital</option>
				<option ${subs.tipo =='F'? 'selected' : ''} value="F">Física</option>
				<option ${subs.tipo =='NA'? 'selected' : ''} value="NA">Ninguna</option>
			`);

		props.modal_edit.modal();
	}

	function updateSubscriber(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show();
			props.ruta =`/panel/subscribers/premium/${form.user_id.value}`;
			let token = '{{ csrf_token() }}',
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
						getSubscribers($("#current_page").val());
						
						toastr.success(data.message,'Exito');
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

	function anulaSuscriptin(user_id) {
		if(confirm('¿Seguro de anular la suscripción?')){
			props.ruta = `/panel/subscribers-premium/${user_id}/destroy`;

			$.ajax({
				url: props.ruta,
				type: 'GET',
				dataType: 'JSON',
				success: data =>{
					if(data.status == 200){
						getSubscribers($("#current_page").val());
						toastr.success(data.message);
					}
					console.log(data);
					
				},
				error: error =>{
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
			success: data =>{
				$("#planes-filter").empty();
				$("#planes-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="plan" id="planx" value="0" checked>
					   	Todo
					  </label>
					</div>
					`);
				data.planes.forEach((plan, index )=>{
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
				data.modpago.forEach((mod, index) =>{
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
			error: error =>{
				console.log(error);
			}
		});
	}

	function openModalFilter() {
		$("#modal_filter").modal();
	}

	// JHED SP-P
	function applyFilter(page = 0) {
		event.preventDefault();

		if(page != 0){
			props.ruta = `/panel/subscribers-premium/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers-premium/filter/';
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
				props.total_reg.text(`${response.total} Registros`);
				if(Array.isArray(response.data)){
					subscribers = response.data;
				}else{
					subscribers = Object.values(response.data);
				}
				props.tbSubscribers.empty();
				$("#modal_filter").modal('hide');
				spinner.hide();
					if(subscribers.length > 0){
							subscribers.forEach(subs =>{
							    var c_pais= "";
								var c_nro_comprobante= "";
								var c_monto= "";
								if (!subs.user.pais) {//
									c_pais= "<td> </td>"
								}else{//
									c_pais= `<td>${subs.user.pais}</td>`
								}
								if (!subs.pago_time.nro_comprobante) {//
									c_nro_comprobante= "<td>No hay comprobante</td>"
									c_monto= "<td>$ 0.00</td>"
								}else{//
									c_nro_comprobante= `<td>${subs.pago_time.nro_comprobante}</td>`
									c_monto= `<td>${subs.pago_time.moneda=="PEN" ? 'S/.' : '$'} ${subs.pago_time.monto}</td>`
								}
								props.tbSubscribers.append(`
									<tr>
										<td>${subs.user.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td>
										${c_pais}
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.suscription_init)}</td>
										<td>${dateFormat(subs.suscription_end)}</td>
										<td>${subs.plan.name} (${subs.plan.moneda})</td>
										${c_nro_comprobante}
										${c_monto}
										<td>${getDateFormat(subs.pago_time.created_at)}</td>
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

						renderPagination(response,'applyFilter');
					}else{
						props.tbSubscribers.append('<span>Filtro sin registros</span>');
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
		let url_download = `/panel/subscribers-premium/download?${data}`;

		window.location = url_download;

	}


	// JHED SP-P
	function verPagos(pagos,username){
		$('#pagosde_user').text(username);
		$("#dataPagos").empty();
		if(pagos.length > 0){
			pagos.forEach((pago, index) =>{
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
						<td>${dateFormat(pago.created_at)}</td>

					</tr>`);

			});

		}else{
			$("#dataPagos").append(`<span>No se encontró registros...</span>`);
		}
		
		$("#modal_pagos").modal();

	}

	function updateStatusCompronte(pago_id){
		spinner.show();
		props.ruta = `/panel/updatestatuscomprobante/${pago_id}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			spinner.hide();
			if(response.status == 200){
				$("#modal_pagos").modal('hide');
				getSubscribers($("#current_page").val());
				toastr.success(response.message,'Exito');
			}
		})
		.catch(error =>{
			console.log(error);
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
	
	function getDateFormat(unix_timestamp) {

		if(unix_timestamp != null){
			let date = new Date(unix_timestamp);

			let fecha = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

			return fecha;
		}else{
			return "No hay pago";
		}
	}
</script>
@endsection
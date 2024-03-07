@extends('layouts.app')
@section('titulo','Suscriptores Yape')
@section('content')
<style>
	.btn-culqi-eye{
		background: #763383;
    	color: #ffffff;
	}
	.btn-culqi-eye:hover{
		background: #763383b7;
    	color: #ffffff;
	}
</style>
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Suscripcion Yape</div>
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
					{{-- <button onclick="createSubscriber();" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button> --}}
					<button onclick="openModalFilter();" class="btn btn-warning">
						<i class="fa fa-filter" aria-hidden="true"></i> Filtros
					</button>
					<button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i> Mostrar todo</button>

					<span class="badge" id="totalReg"></span>
				</div>
			</div>
			<hr>
			<div class="table-responsive">
				<table class="table table-condensed table-hover table-bordered">
		      		<thead>
                        <th> </th>
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
				{{-- <div class="col-xs-12 col-md-8">
					<button onclick="exportExcel()" class="btn btn-link"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button>
				</div>	 --}}
	      	    
	      	</div>
		  
			@include('panel.subscriber.yape.filters') 
			@include('panel.subscriber.yape.asignatecurso') 
			@include('panel.subscriber.yape.create_deposito')
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
		modal_edit_premium : $("#modal_edit_premium"),
		tbSubscribers : $("#subscribers"),
		total_reg : $("#totalReg"),
		ruta: '',
	}
	//PAGO EFECTIVO DATA
	function getSubscribers(page = 0) {
		spinner.show();
		$("#form_filter").trigger('reset');
		props.ruta ='/panel/subscribers/pago_yape_data';
		if(page != 0) props.ruta = `/panel/subscribers/pago_yape_data/?page=${page}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbSubscribers.empty();
			spinner.hide();
			props.total_reg.text(`${response.total} Registros`);
			response.data.forEach(subs =>{ 
                var b= "";
                    if (subs.status_efectivo=="1") {
                        b= " <td><i class='fa fa-check'></i></td>"
                    }else{
                        b= "<td><i class='fa fa-times'></i></td>"
                    }
					var tplan= "";
					var dplan= "";
					var dcurso= "";		
					var btnplan= "";	
					var btnmessage= "";
						if (subs.tipo_susc=="P") {//Premiun
							tplan= " <td>Susc. Recurrente</td>"
							dplan= " <td>"+subs.plan.name+" ("+subs.plan.moneda+")"+"</td>"
							dcurso= " <td></td>"
							btnplan= `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
							btnmessage = `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
						}else if (subs.tipo_susc=="C") {//Curso
							tplan= " <td>Susc. Curso</td>"
							dplan= " <td></td>"
							dcurso= " <td>"+subs.curso.titulo+"</td>"
							btnplan= `<button type="button" onclick='openModalAsignC(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
							btnmessage = `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
						}				
				props.tbSubscribers.append(`
					<tr>
                        ${b}
						<td>${subs.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td> 
						<td>${subs.telefono}</td>
						<td>${subs.dni}</td>
						<td>${subs.codigo_verification}</td>
						${tplan}
						${dcurso}
						${dplan}
						<td>${subs.status}</td>
						
						<td>
							
							${btnmessage}
							${btnplan}
							<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
						</td>
					</tr>
					`)

			});
			// <button type="button" onclick='openModalAsignC(${subs.user.id},"${subs.curso.id}","${subs.id_culqi}","${subs.id}")' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>
			// <button onclick="saveEstadoPagoEfectivo(${subs.id})" class="btn btn-success btn-sm" title="Up Estado Pago Efectivo"><i class="fa fa-check" aria-hidden="true"></i> </button>
			renderPagination(response,'getSubscribers');
			/*console.log(response);*/
		})
		.catch(error =>{
			console.log(error);
		});
	}

	//PAGO EFECTIVO BUSCADOR
	function buscar(input) {
		if(input.value != ''){
			if (event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/subscribers/pago_yape/search/?text=${input.value}`;
				$.ajax({
					url: props.ruta,
					type: 'GET',
					dataType: 'JSON',
					success:response =>{
						console.log(response);
						props.total_reg.empty();
						props.tbSubscribers.empty();
						$(".custom-pagination").empty();
						spinner.hide(); 
						if(response.length > 0){
							response.forEach(subs =>{
								
									var b= "";
									if (subs.status_efectivo=="1") {
										b= " <td><i class='fa fa-check'></i></td>"
									}else{
										b= "<td><i class='fa fa-times'></i></td>"
									}
									var tplan= "";
									var dplan= "";
									var dcurso= "";		
									var btnplan= "";
									var btnmessage= "";
										if (subs.tipo_susc=="P") {//Premiun
											tplan= " <td>Susc. Recurrente</td>"
											dplan= " <td>"+subs.plan.name+" ("+subs.plan.moneda+")"+"</td>"
											dcurso= " <td></td>"
											btnplan= `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
											btnmessage = `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
										}else if (subs.tipo_susc=="C") {//Curso
											tplan= " <td>Susc. Curso</td>"
											dplan= " <td></td>"
											dcurso= " <td>"+subs.curso.titulo+"</td>"
											btnplan= `<button type="button" onclick='openModalAsignC(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
											btnmessage = `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
										}				
								props.tbSubscribers.append(`
								<tr>
									${b}
									<td>${subs.id}</td>
									<td>${subs.user.name} ${subs.user.last_name}</td>
									<td>${subs.user.email}</td> 
									<td>${subs.telefono}</td>
									<td>${subs.dni}</td>
									<td>${subs.codigo_verification}</td> 
									${tplan}
									${dcurso}
									${dplan}
									<td>${subs.status}</td>
									
									<td> 
										${btnmessage}
										${btnplan}
										<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
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

	//PAGO EFECTIVO OPEN MODAL SUSC PREMIUM 
	function createSubscriberPremium(subs) {
		props.ruta = '/panel/data_plan_gestor_yape';
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			$("#planes-edit").empty();
			response.planes.forEach(plan =>{
				if(subs.plan_id == plan.id){
					$("#planes-edit").append(`
							<option selected data-caduca="${plan.caduca}"  data-precio="${plan.precio}"  value="${plan.id}">${plan.name} (${plan.moneda})</option>
						`);
						
					$(".caduca").val(plan.caduca); 
					if(Number(plan.promocion)>0){ 
						// formEdit.monto.value = plan.promocion;
						$(".precio_plan").val(plan.promocion);
					}else{ 
						// formEdit.monto.value = subs.plan.precio;
						$(".precio_plan").val(plan.precio);
						console.log(Number(subs.plan.precio));
					}
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

		
		let formEdit = $("#editformPremium")[0];
		// console.log(subs);
		formEdit.suscriptor_yape_id.value = subs.id; 
		formEdit.user_id.value = subs.user.id; 
		formEdit.name.value = subs.user.name;
		formEdit.last_name.value = subs.user.last_name;
		formEdit.email.value = subs.user.email;
		formEdit.suscription_end.value = subs.suscription_end;
		
		formEdit.nro_comprobante.value = "B_Yape-"+subs.codigo_verification;

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

		props.modal_edit_premium.modal();
	} 
	//PAGOS YAPE CREATE/UPDATE SUSC
	function saveSubscriberPremium(form) {
		event.preventDefault();
		if(validateForm(form)){
			spinner.show(); 
			props.ruta = `/panel/subscribers/pago_yape/${form.user_id.value}`;
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
						props.modal_edit_premium.modal('hide');
						// getSubscribers();
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
     
	function changeCaducidad(select) {
		$(".caduca").val(select.options[select.selectedIndex].getAttribute('data-caduca'));
		$(".precio_plan").val(select.options[select.selectedIndex].getAttribute('data-precio'));
	}

	// Status Pago  Efectivo
	var token = '{{ csrf_token() }}';
	 
	function anulaSuscriptin(id) {
		if(confirm('¿Seguro de eliminar los datos para suscripción o curso de este usuario?')){
			props.ruta = `/panel/subscribers/pago_yape/${id}/destroy`;

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

	function enviarCorreo(id) {
		if(confirm('¿Seguro que quieres notificar al usuario?')){
			let ruta = `/panel/subscribers/pago_efectivo/${id}/notificate`;
		 
    	//spinner.show(); 
			$.ajax({
				url: ruta,
				type: 'GET',
				dataType: 'JSON',
				success: data =>{
					
					if(data.status == 200){ 
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

	function enviarCorreoPremium(id) {
		if(confirm('¿Seguro que quieres notificar al usuario de su plan?')){
			let ruta = `/panel/subscribers/pago_efectivo/${id}/notificate_premium`;
		 
    	//spinner.show(); 
			$.ajax({
				url: ruta,
				type: 'GET',
				dataType: 'JSON',
				success: data =>{
					
					if(data.status == 200){ 
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

	//FILTRO JHED
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
			error: error =>{
				console.log(error);
			}
		});
	}

	//PAGOS YAPE - MODAL CURSOS
	function openModalFilter() {
		$("#modal_filter").modal();
	}
	//PAGOS YAPE 
	function applyFilter(page = 0) {
		event.preventDefault();

		if(page != 0){
			props.ruta = `/panel/subscribers/pago_yape/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers/pago_yape/filter/';
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
								var b= "";
									if (subs.status_efectivo=="1") {
										b= " <td><i class='fa fa-check'></i></td>"
									}else{
										b= "<td><i class='fa fa-times'></i></td>"
									}
									var tplan= "";
									var dplan= "";
									var dcurso= "";		
									var btnplan= "";
									var btnmessage= "";
										if (subs.tipo_susc=="P") {//Premiun
											tplan= " <td>Susc. Recurrente</td>"
											dplan= " <td>"+subs.plan.name+" ("+subs.plan.moneda+")"+"</td>"
											dcurso= " <td></td>"
											btnplan= `<button onclick='createSubscriberPremium(${JSON.stringify(subs)})' class="btn btn-light btn-sm" title="Asignar Suscripcion"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
											btnmessage = `<button onclick='enviarCorreoPremium(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje User Premium"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
										}else if (subs.tipo_susc=="C") {//Curso
											tplan= " <td>Susc. Curso</td>"
											dplan= " <td></td>"
											dcurso= " <td>"+subs.curso.titulo+"</td>"
											btnplan= `<button type="button" onclick='openModalAsignC(${subs.user.id},"${subs.curso.id}","${subs.codigo_verification}","${subs.id}")' class="btn btn-light btn-sm" title="Asignar Curso"><i class="fa fa-plus" aria-hidden="true"></i> </button>`
											btnmessage = `<button onclick='enviarCorreo(${subs.id})' class="btn btn-primary btn-sm" title="Enviar Mensaje"><i class="fa fa-inbox" aria-hidden="true"></i></button>`
										}			
									props.tbSubscribers.append(`
									<tr>
										${b}
										<td>${subs.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td> 
										<td>${subs.telefono}</td>
										<td>${subs.dni}</td>
										<td>${subs.codigo_verification}</td>
										${tplan}
										${dcurso}
										${dplan}
										<td>${subs.status}</td>
										
										<td>											
											${btnmessage}
											${btnplan}
											<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm" title="Eliminar"><i class="fa fa-trash" aria-hidden="true"></i> </button>
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
 
    //Ver estado de Pago Efectivo
    function verPagosEfectivo(user_id,username,id_culqi){
		$('#pagosde_user').text(username);
		 let ruta = `/panel/cargos/cargos_pago_efectivo/${user_id}/${id_culqi}`;
    	//spinner.show();
		$.ajax({
		url: ruta,
		type: 'GET',
		dataType: 'JSON',
		success: res =>{
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
		error: error =>{
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

	//PAGO EFECTIVO OPEN MODAL SUSC CURSO 
	function openModalAsignC(subs) {
		let formAsign = $("#form-asign-c")[0];
		props.ruta = '/panel/subscribers/pago_yape/cursos-data';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				$(formAsign.gestor).empty();
				
				res.cursos.forEach(curso =>{
					var b= "";
					if (curso.id==subs.curso.id) {
						b= "<option value="+curso.id+" selected>"+curso.titulo+"</option>"
					}else{
						b= "<option value="+curso.id+">"+curso.titulo+"</option>"
					}
					$(formAsign.gestor).append(
						`${b}`
					);
					 
				});


				$(formAsign.gestor_a).empty();

				// var list_gestor="";
				// res.gestores.forEach(user =>{
				// 	if (user.id=={{auth()->user()->id}}) {
				// 		list_gestor= `<option value="${user.id}" selected>${user.name} ${user.last_name}</option>`
				// 	}else{
				// 		list_gestor= `<option value="${user.id}">${user.name} ${user.last_name}</option>`
				// 	}
				// 	$(formAsign.gestor_a).append(` ${list_gestor} `);
				// });

				$(formAsign.gestor_a).empty();
				res.gestores.forEach(user =>{
					if(subs.gestor_id == user.id){
						$(formAsign.gestor_a).append(`<option value="${user.id}" selected>${user.name} ${user.last_name}</option>`);
					}else{
						$(formAsign.gestor_a).append(`<option value="${user.id}">${user.name} ${user.last_name}</option>`);
					}
					
				});
				
			},
			error: error =>{
				console.log(error);
			}
		});  
		 
		$(formAsign.user_id).val(subs.user.id);
		$(formAsign.suscriptor_yape_id).val(subs.id); 
		$(formAsign.nro_comprobante).val("B_Yape-"+ subs.codigo_verification);  
		
		$('#modalasign1').modal();
	}

	//PAGO EFECTIVO CREATE/UPDATE SUSC CURSO 
	function saveAsignationc(form) {
		event.preventDefault();
		props.ruta = '/panel/subscribers/pago_yape/asignatecurso';
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
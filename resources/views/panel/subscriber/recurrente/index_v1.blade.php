@extends('layouts.app')
@section('titulo','Suscriptores Premium')
@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Suscripcion Recurrente</div>
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
					
					<button onclick="getSubscribers();" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i> Mostrar todo</button>
                    {{-- CAMBIOS JHED --}}
					<button onclick="openModalFilter();" class="btn btn-warning">
						<i class="fa fa-filter" aria-hidden="true"></i> Filtros
					</button>
					{{-- CAMBIOS JHED --}}
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
		      			<th>País</th>
		      			<th>Teléfono</th>
		      			<th>DNI</th>
		      			<th>F. Suscripción</th>
		      			<th>Plan</th>
		      			{{--<th>Estado</th>--}}
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
		
			@include('panel.subscriber.recurrente.pagos')
		</div>
	</div>
	@include('panel.subscriber.free.asignatecurso')
	@include('panel.subscriber.recurrente.filters')
</div>

@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getSubscribers(); // Listar al cargar la pagina
		getPrevInfo();
	});

	let props = {
		tbSubscribers : $("#subscribers"),
		total_reg : $("#totalReg"),
		ruta: '',
	}

	function getSubscribers(page = 0) {
		spinner.show();
		$("#form_filter").trigger('reset');
		props.ruta ='/panel/subscribers/premium-data-recurrente';
		if(page != 0) props.ruta = `/panel/subscribers/premium-data-recurrente/?page=${page}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbSubscribers.empty();
			spinner.hide();
			props.total_reg.text(`${response.total} Registros`);
			response.data.forEach(subs =>{
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
						<td>${subs.user.doc_number}</td>
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

			renderPagination(response,'getSubscribers');
			/*console.log(response);*/
		})
		.catch(error =>{
			console.log(error);
		});
	}

		function buscar(input) {
		if(input.value != ''){
			if (event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/subscribers-premium-recurrente/search/?text=${input.value}`;
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
								
								props.tbSubscribers.append(`
									<tr>
										<td>${subs.user.id}</td>
										<td>${subs.user.name} ${subs.user.last_name}</td>
										<td>${subs.user.email}</td>
										<td>${subs.user.pais}</td>
										<td>${subs.user.phone_number}</td>
						                <td>${subs.user.doc_number}</td>
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



	function anulaSuscriptin(user_id) {
		if(confirm('¿Seguro de anular la suscripción?')){
			props.ruta = `/panel/subscribers-premium-recurrente/${user_id}/destroy`;

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

	function exportExcel() {

		let data = $("#form_filter").serialize();
		let url_download = `/panel/subscribers-premium-recurrente/download?${data}`;

		window.location = url_download;

	}

  
	function verPagos(user_id,username){
		$('#pagosde_user').text(username);
		 let ruta = `/panel/cargos/cargos-data-recurrente/${user_id}`;
    //spinner.show();
    $.ajax({
      url: ruta,
      type: 'GET',
      dataType: 'JSON',
      success: res =>{
      	console.log(res);
        $("#dataPagos").empty();
        //spinner.hide();
        $('#sig_pago').text(getDateFormat(res.next_billing_date));
        res.charges.forEach(charge =>{
        	var b= "";
        	if (charge.outcome.type=="card_error") {
           	b= "<td><strong class='text-danger'>"+charge.outcome.type+"</strong></td>"
           }else{
           b= "<td>"+charge.outcome.type+"</td>"
           }


        	var a= "";
        	if (charge.outcome.type=="card_error") {
           	a= "<td><strong>"+ charge.outcome.merchant_message+"</strong></td>"
           }else{
           a= "<td>"+ charge.outcome.merchant_message+"</td>"
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

    
	// FILTROS	
	function openModalFilter() {
		$("#modal_filter").modal();
	}
 
	function applyFilterRecurrente(page = 0) {
		event.preventDefault();

		if(page != 0){
			props.ruta = `/panel/subscribers/data-recurrente/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers/data-recurrente/filter/';
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

						renderPagination(response,'applyFilterRecurrente');
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
			},
			error: error =>{
				console.log(error);
			}
		});
	}
	// FILTROS	
	function openModalFilter() {
		$("#modal_filter").modal();
	}
 
	function applyFilterRecurrente(page = 0) {
		event.preventDefault();

		if(page != 0){
			props.ruta = `/panel/subscribers/data-recurrente/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers/data-recurrente/filter/';
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

						renderPagination(response,'applyFilterRecurrente');
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
			},
			error: error =>{
				console.log(error);
			}
		});
	}
	
</script>

@endsection
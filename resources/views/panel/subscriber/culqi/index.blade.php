@extends('layouts.app')
@section('titulo','Transacciones de CULQI')
@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Transacciones de CULQI</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					
					<div class="input-group has-success">
					  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
					  <input type="email" onkeyup="searchByEmail(this);" class="form-control" aria-describedby="basic-addon3" placeholder="Busca por correo electrónico">
					</div>

				</div>
				<div class="col-xs-12 col-md-6">
					
				</div>
			</div>
			<hr>
			<h5>Ultimos cargos</h5>

			<div class="table-responsive">
				<table class="table table-condensed table-hover table-bordered">
		      		<thead>
		      			<th>Código de referencia</th>
		      			<th>Descripción</th>
		      			<th>Correo</th>
						<!-- <th>Correo tarjeta</th> -->
		      			<th>Monto</th>
		      			<th>Fecha</th>  
		      			<th>Tipo</th>
		      			<th>Control</th>			
		      		</thead>
		      		<tbody id="charges">
		      			
		      		</tbody>
		      	</table>
			</div>
			
	      	{{-- <div class="row">
	      	   <div class="col-xs-12 col-md-4">
	      	       <div class="input-group custom-pagination">
	      	        <!-- Render pagination here -->
	      	       </div>
	      	    </div>
	      	    
	      	</div> --}}
			<div class="modal" tabindex="-1" id="modal-details" role="dialog">
				<div class="modal-dialog modal-md" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<div class="modal-title"><h3>Detalles de la transacción</h3></div>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12" id="details"></div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
</div>

@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getCharges();
	});

	let tbCharges = $("#charges");

	function getCharges(page = 0, cursor = '') {
		let ruta = '/panel/culqi/cargos-data';
		if(page != 0) ruta = `/panel/culqi/cargos-data/?${cursor}&page=${page}`;

		spinner.show();
		$.ajax({
			url: ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				tbCharges.empty();
				spinner.hide();

				res.data.forEach(charge =>{
					tbCharges.append(`
							<tr class="${charge.outcome.type == 'venta_exitosa' ? 'success' : 'danger'}">
								<td>${charge.reference_code}</td>
								<td>${charge.description}</td>
								<td>${charge.email}</td>
								<td>S/. ${(charge.amount)/100}.00</td>
								<td>${ getDateFormat(charge.creation_date)}</td>
								<td><span title="${charge.outcome.merchant_message}">${charge.outcome.type}</span></td>
								<td>
									<button onclick='verDetalle(${JSON.stringify(charge)})' class="btn btn-warning btn-sm">Ver detalle</button>
								</td>
							</tr>
						`);
					//console.log(charge);
				});
				//renderPagination(response,'getCharges');
				 //setPagination(res.paging);
				 
				
				
			},
			error: error =>{
				spinner.hide();
				toastr.error(JSON.parse(error.responseJSON).message);
				console.log(error.responseText);
			}
		});
	}

	function searchByEmail(input) {

		let re = /[A-Z0-9._%+-]+@[A-Z0-9.-]+.[A-Z]{2,4}/igm;

		if(input.value != ''){
			
			if(event.keyCode == 13){
				if(re.test(input.value)){
					spinner.show();
					let ruta = `/panel/culqi/cargos/search/${input.value}`;
					$.ajax({
						url: ruta,
						type: 'GET',
						dataType: 'JSON',
						success: res =>{
							
							tbCharges.empty();
/*							$(".custom-pagination").empty();*/
							spinner.hide();
							if(res.data.length > 0){
								res.data.forEach(charge =>{
									tbCharges.append(`
											<tr class="${charge.outcome.type == 'venta_exitosa' ? 'success' : 'danger'}">
												<td>${charge.reference_code}</td>
												<td>${charge.description}</td>
												{{--<td>${charge.email}</td>--}}
												<td>${charge.source.email}</td>
												<td>S/. ${(charge.amount)/100}.00</td>
												<td>${ getDateFormat(charge.creation_date)}</td>
												<td><span title="${charge.outcome.merchant_message}">${charge.outcome.type}</span></td>
												<td>
													<button onclick='verDetalle(${JSON.stringify(charge)})' class="btn btn-warning btn-sm">Ver detalle</button>
												</td>
											</tr>

										`);

								});

							}else{
								tbCharges.append('Búsqueda sin resultados...');
							}
							
						},
						error: error =>{

							console.log(error);
						}
					});
				}else{
					toastr.error('Ingrese un correo válido');
				}
				
			}
		}else{
			getCharges();

		}
	}

	function getDateFormat(unix_timestamp) {

		let date = new Date(unix_timestamp);

		let fecha = `${date.getDate()}/${date.getMonth() + 1}/${date.getFullYear()}`;

		return fecha;
	}

/*	function setPagination(paging) {
		$(".custom-pagination").empty();
		let html = '';

		    if(paging.page > 1){ // Mostrar boton atras
		        html +=`<span class="input-group-btn">
		                    <button onclick="getCharges(${paging.page - 1},'before=${paging.cursors.before}')" class="btn btn-default" type="button">Atrás &laquo;</button>
		                </span>`;
		    }else{
		        html+=`<span class="input-group-btn">
		                    <button class="btn btn-default" disabled type="button">Atrás &laquo;</button>
		                </span>`;
		    }

		    html+=`<span class="input-group-addon">Página</span>
		            <input type="number" class="form-control" disabled value="${paging.page}">
		            <span class="input-group-addon">de ${paging.lastPage}</span>`;

		            
		    if (paging.page < paging.lastPage) { // Mostrar boton siguiente
		        html +=`<span class="input-group-btn">
		                       <button onclick="getCharges(${paging.page + 1},'after=${paging.cursors.after}')" class="btn btn-default" type="button">Siguiente &raquo;</button>
		                     </span>`;
		    }else{
		        html +=`<span class="input-group-btn">
		                   <button disabled class="btn btn-default" type="button">Siguiente &raquo;</button>
		                 </span>`;
		    }


		$(".custom-pagination").append(html);
	}*/

	function verDetalle(charge) {
		$("#details").html(`
				<table class="table table-condensed table-bordered">
				<tr>
					<th width="200px">Codigo de referencia</th>
					<td>${charge.reference_code}</td>
				</tr>
				<tr>
					<th width="200px">Código de autorización</th>
					<td>${charge.authorization_code}</td>
				</tr>
				<tr>
					<th width="200px">Nro de tarjeta</th>
					<td>${charge.source.card_number}</td>
				</tr>
				<tr>
					<th width="200px">Tipo de tarjeta</th>
					<td>${charge.source.iin.card_type}</td>
				</tr>
				<tr>
					<th width="200px">Correo en la tarjeta</th>
					<td>${charge.source.email}</td>
				</tr>
				<tr>
					<th width="200px">Nombre del banco</th>
					<td>${charge.source.iin.issuer.name}</td>
				</tr>
				<tr>
					<th width="200px">País del banco</th>
					<td>${charge.source.iin.issuer.country}</td>
				</tr>
				
				<tr>
					<th width="200px">IP del dispositivo</th>
					<td>${charge.source.client.ip}</td>
				</tr>
				<tr>
					<th width="200px">Estado de transacción</th>
					<td>${charge.outcome.type}</td>
				</tr>
				${charge.capture == true ? `
						<tr>
							<th width="200px">Pago a Pullcreativo</th>
							${charge.paid == true ? '<td class="success">Hecho</td>' : '<td class="warning">Por depositar</td>'}
						</tr>
					` : ''}
				
				<tr>
					<th width="200px">Descripción</th>
					<td>${charge.outcome.merchant_message}</td>
				</tr>
				</table>
			`);
		$("#modal-details").modal();
	}

</script>
@endsection
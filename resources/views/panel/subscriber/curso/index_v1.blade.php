@extends('layouts.app')
@section('titulo','Suscriptores Premium')
@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Suscripcion Cursos</div>
		</div>
		<div class="panel-body">
			<div class="row">
				<div class="col-xs-12 col-md-6">
					
					<div class="input-group has-success">
					  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
					  <input type="text" id="texto" class="form-control" onkeyup="buscar(this);"  aria-describedby="basic-addon3" placeholder="Escriba aqu&iacute; y presione Enter">
					</div>

				</div>
				<div class="col-xs-12 col-md-6">
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
		      			<th>Id</th>
		      			<th>Nombres y Apellidos</th>
		      			<th>Correo electr&oacute;nico</th>
		      			<th>Tel&eacute;fono</th>
		      			<th>F. Suscripci&oacute;n</th>
		      			{{-- <th>Mod. pago</th> --}}
		      			<th>Curso</th>
		      			<th>Nro Comprobante</th>
		      			<th>Tipo de usuario</th>
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
		
			@include('panel.subscriber.curso.filters')
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

	function getSubscribers(page = 0) {
		spinner.show();
		$("#form_filter").trigger('reset');
		props.ruta ='/panel/subscribers/data-curso';
		if(page != 0) props.ruta = `/panel/subscribers/data-curso/?page=${page}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbSubscribers.empty();
			spinner.hide();
			props.total_reg.text(`${response.total} Registros`);
			response.data.forEach(subs =>{
				props.tbSubscribers.append(`
					<tr>
						<td>${subs.user.id}</td>
						<td>${subs.user.name} ${subs.user.last_name}</td>
						<td>${subs.user.email}</td>
						<td>${subs.user.phone_number}</td>
						<td>${dateFormat(subs.created_at)}</td>
						<td>${subs.curso.titulo} (${subs.moneda})</td>
						<td>${subs.nro_comprobante}</td>
						<td>${subs.user.role.name}</td>
						<td>${subs.gestor.name}</td>
						<td>
							<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm">Anular</button>
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

	function anulaSuscriptin(id) {
		if(confirm('¿Seguro de anular la suscripción?')){
			props.ruta = `/panel/subscribers-curso/${id}/destroy`;

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

	function buscar(input) {
		if(input.value != ''){
			if (event.keyCode == 13){
				spinner.show();
				props.ruta = `/panel/subscribers-curso/search/?text=${input.value}`;
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
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.created_at)}</td>
										<td>${subs.curso.titulo} (${subs.moneda})</td>
										<td>${subs.nro_comprobante}</td>
										<td>${subs.user.role.name}</td>
									
										<td>${subs.gestor.name}</td>
										<td>
											<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm">Anular</button>
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


	



	function getPrevInfo() {
		props.ruta = '/panel/filters-to-subscribers-cursos';
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: data =>{
				$("#planes-filter").empty();
				$("#planes-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="curso" id="cursox" value="0" checked>
					   	Todo
					  </label>
					</div>
					`);
				data.cursos.forEach((curso, index )=>{
					$("#planes-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="curso" id="curso${curso.id}" value="${curso.id}">
						   	${curso.titulo}
						  </label>
						</div>
						`);
				});
				

				$("#modpago-filter").empty();
				$("#modpago-filter").append(`
					<div class="radio">
					  <label>
					    <input type="radio" name="gestor" id="gestorx" value="" checked>
					   	Todos
					  </label>
					</div>
					`);
				data.gestor.forEach((mod, index) =>{
					$("#modpago-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="gestor" id="gestor${mod.id}" value="${mod.id}">
						   	${mod.name} 	${mod.last_name}
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
			props.ruta = `/panel/subscribers-curso/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers-curso/filter/';
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
										<td>${subs.user.phone_number}</td>
										<td>${dateFormat(subs.created_at)}</td>
										<td>${subs.curso.titulo} (${subs.moneda})</td>
										<td>${subs.nro_comprobante}</td>
										<td>${subs.user.role.name}</td>
										<td>${subs.gestor.name}</td>
										<td>
											<button onclick="anulaSuscriptin(${subs.id})" class="btn btn-danger btn-sm">Anular</button>
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
		let url_download = `/panel/subscribers-cursos/download?${data}`;

		window.location = url_download;

	}


</script>
@endsection
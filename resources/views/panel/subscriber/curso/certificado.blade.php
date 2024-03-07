@extends('layouts.app')
@section('titulo','Suscriptores Premium')
@section('content')
<div class="container-fluid">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Certificados</div>
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
		      			<th>Tipo de usuario</th>
		      			<th>Estado</th>
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
		props.ruta ='/panel/subscribers/data-certificado';
		if(page != 0) props.ruta = `/panel/subscribers/data-certificado/?page=${page}`;
		fetch(props.ruta)
		.then(response => response.json())
		.then(response =>{
			props.tbSubscribers.empty();
			spinner.hide();
			props.total_reg.text(`${response.total} Registros`);
			response.data.forEach(subs =>{
				props.tbSubscribers.append(`
					<tr>
						<td>${subs.id}</td>
						<td>${subs.fullname} ${subs.user.last_name}</td>
						<td>${subs.email}</td>
						<td>${subs.phone_number}</td>
						<td>${dateFormat(subs.created_at)}</td>
						<td>${subs.curso.titulo}</td>
						<td>${subs.user.role.name}</td>
						<td>
						

						${subs.estado =='1' ? `<button  class="btn btn-primary btn-sm disabled">Enviado</button>` : `<button onclick='saveEstado(${subs.id});' class="btn btn-primary btn-sm">Solicitado</button>`}
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
				props.ruta = `/panel/subscribers-certificado/search/?text=${input.value}`;
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
										<td>${subs.fullname} ${subs.user.last_name}</td>
										<td>${subs.email}</td>
										<td>${subs.phone_number}</td>
										<td>${dateFormat(subs.created_at)}</td>
										<td>${subs.curso.titulo}</td>
										<td>${subs.user.role.name}</td>
										<td>
										

										${subs.estado =='1' ? `<button  class="btn btn-primary btn-sm disabled">Enviado</button>` : `<button onclick='saveEstado(${subs.id});' class="btn btn-primary btn-sm">Solicitado</button>`}
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

	 var token = '{{ csrf_token() }}';
	  function saveEstado(id) {
	    var ruta = '{{route('certificadoestado')}}';

	    $.ajax({
	      url: ruta,
	      type: 'POST',
	      headers:{'X-CSRF-TOKEN': token},
	      dataType: 'json',
	      data:{
	        id: id
	      },
	      success:function(data){
	        console.log(data);
	        location.reload();
	      },
	      error:function(data){
	        console.log(data);
	      }
	    });
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
				data.forEach((curso, index )=>{
					$("#planes-filter").append(`
						<div class="radio">
						  <label>
						    <input type="radio" name="curso" id="curso${curso.id}" value="${curso.id}">
						   	${curso.titulo}
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
			props.ruta = `/panel/subscribers-certificado/filter/?page=${page}`;
		}else{
			props.ruta = '/panel/subscribers-certificado/filter/';
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
										<td>${subs.fullname} ${subs.user.last_name}</td>
										<td>${subs.email}</td>
										<td>${subs.phone_number}</td>
										<td>${dateFormat(subs.created_at)}</td>
										<td>${subs.curso.titulo}</td>
										<td>${subs.user.role.name}</td>
										<td>
										

										${subs.estado =='1' ? `<button  class="btn btn-primary btn-sm disabled">Enviado</button>` : `<button onclick='saveEstado(${subs.id});' class="btn btn-primary btn-sm">Solicitado</button>`}
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
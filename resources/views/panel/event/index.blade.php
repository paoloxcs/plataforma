@extends('layouts.app')
@section('titulo','Eventos')
@section('content')
	<div class="container">
		<ol class="breadcrumb">
		  <li class="breadcrumb-item active">
		    <i class="fa fa-list-ol"></i> Eventos
		  </li>
		</ol>
		<div class="panel panel-success">
			<div class="panel-body">
				<div class="row">
				    <div class="col-md-2 pull-right">
				        <button onclick="create_Event()" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
				    </div>
				</div>
				<hr>
				<div class="table-responsive">
					<table class="table table-condensed table-hover table-bordered">
						<thead>
							<tr>
								<th>id</th>
								<th>Título</th>
								<th>Display</th>
								<th>Link</th>
								<th>Tipo</th>
								<th>Rubro</th>
								<th>Fecha de Inicio</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody id='eventos'>
							
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

			</div>
		</div>
	</div>
@include('panel.event.create')
@include('panel.event.edit')
@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
	    getEvents();
	});
	let props ={
	    modal_create : $("#modal_create"),
	    modal_edit : $("#modal_edit"),
	    tbEvents : $("#eventos"),
	    ruta : '',
	}

	function getEvents(page = 0) {
	    spinner.show();
	    props.ruta ='/panel/eventos-data';
	    if(page != 0) props.ruta =`/panel/eventos-data/?page=${page}`;
	    fetch(props.ruta)
	    .then(response => response.json())
	    .then(response => {
	        props.tbEvents.empty();
	        spinner.hide();
	        response.data.forEach((evento,index) =>{
	            props.tbEvents.append(
	                `<tr>
	                    <td>${evento.id}</td>
	                    <td>${evento.title}</td>
	                    <td><img width="40" style="border-radius : 50%;" src="/posts/${evento.url_image}"></td>
	                    <td>
	                    	<a href="${evento.url_web}" target="_blank">Probar vínculo</a>
	                    </td>
	                    <td>${evento.type_event.name}</td>
	                    <td>${evento.rubro.nombrerubro}</td>
	                    <td>${evento.date_init}</td>
	                    
	                    <td>
	                        <button onclick='editEvent(${JSON.stringify(evento)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
	                        <button onclick='deleteEvent(${evento.id})' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
	                    </td>
	                </tr>`);
	        });
	        console.log(response);

	        renderPagination(response,'getEvents'); // Invoca la funcion de paginacion
	    })
	    .catch(error =>{
	        console.log(error);
	    })
	}
	function create_Event(){
		props.modal_create.modal();
		getRubros();
	    getTypeEventos();
	}

	function editEvent(evento){
		getRubros(evento);
	    getTypeEventos(evento);

	    let frmedit = $("#form-edit")[0];
        frmedit.idevent.value = evento.id;
        frmedit.title.value = evento.title;
        frmedit.url_web.value = evento.url_web;
        frmedit.date_init.value = evento.date_init;
		props.modal_edit.modal();
	}

	function saveEvent(form) {
	    event.preventDefault();
	    
	    if(validateForm(form)){ // Validacion del formulario
	        spinner.show();
	        props.ruta = '/panel/eventos';
	        let token = '{{ csrf_token() }}', // Creacion de variable token csrf
	            data = new FormData($(form)[0]); // creacion de la variable data

	        // data.set('bio', CKEDITOR.instances[form.bio.name].getData()); // updating data

	        $.ajax({
	            url: props.ruta,
	            type: 'POST',
	            headers: {'X-CSRF-TOKEN': token},
	            cache: false,
	            data: data,
	            contentType: false,
	            processData: false,
	            success: data =>{
	                spinner.hide();
	                    props.modal_create.modal('hide');
	                    getEvents();
	                    toastr.success(data.message,'Exito');
	                    $(form).trigger('reset');

	                if(data.status == 422){
	                    for (var error in data.errors){
	                        toastr.error(data.errors[error][0],'Advertencia');
	                    }
	                }
	                console.log(data);
	            },
	            error : error =>{
	                console.log(error);
	            }
	        });
	    }
	}

	function updateEvent(form) {
	    event.preventDefault();
	    if (validateForm(form)) {
	        spinner.show();
	        props.ruta  = `/panel/eventos/${form.idevent.value}`;
	        let token = form.token.value,
	            data = new FormData($(form)[0]);

	        //data.set('bioedit', CKEDITOR.instances[form.bioedit.name].getData());
	        data.append('_method', 'PUT');

	            $.ajax({
	                url: props.ruta,
	                type: 'POST',
	                headers: {'X-CSRF-TOKEN': token},
	                data: data,
	                cache: false,
	                processData: false,
	                contentType: false,
	                success: data => {
	                    spinner.hide();
	                    	                        
                        props.modal_edit.modal('hide');
                        getEvents($("#current_page").val());
                        toastr.success(data.message,'Exito');
	                    
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

	function getRubros(current_event=null){
		props.ruta='/panel/rubros-all';
		$.ajax({
			url:props.ruta,
			type:'GET',
			dataType:'json',
			success:resp=>{
				$('.rubros').empty();
				resp.forEach(rub=>{
					if(current_event!=null){
						$('.rubros').append(`
							${current_event.rubro_id==rub.idrubro?`<option selected value='${rub.idrubro}'> ${rub.nombrerubro} </option>`:`<option value='${rub.idrubro}'> ${rub.nombrerubro} </option>`}
						`)
					}else{
						$('.rubros').append(`
							<option value='${rub.idrubro}'> ${rub.nombrerubro} </option>
						`)
					}	
				});
				//console.log(resp);
			},
			error:err=>{
				console.log(err);
			}
		});
	}

	function getTypeEventos(current_event=null){
		props.ruta='/panel/event-type-data';
		$.ajax({
			url:props.ruta,
			type:'GET',
			dataType:'json',
			success:resp=>{
				$('.tipos').empty();
				resp.forEach(tipo=>{
					if(current_event!=null){
						$('.tipos').append(`
							${current_event.type_event_id==tipo.id?`<option selected value='${tipo.id}'> ${tipo.name} </option>`:`<option value='${tipo.id}'> ${tipo.name} </option>`}
						`)
					}else{
					$('.tipos').append(`
						<option value='${tipo.id}'> ${tipo.name} </option>
					`)						
					}

				});
				//console.log(resp);
			},
			error:err=>{
				console.log(err);
			}
		});
	}

	function deleteEvent(idevento) {
	    if(confirm('¿Seguro de eliminar el registro?')){
	        props.ruta = `/panel/eventos/${idevento}/destroy/`;
	        $.ajax({
	            url: props.ruta,
	            type: 'GET',
	            dataType: 'JSON',
	            success: data =>{
	                
                    getEvents($("#current_page").val());
                    toastr.success(data.message,'Exito');
	                
	                console.log(data);
	            },
	            error: error =>{
	                console.log(error);
	            }
	        });
	    }
	}

</script>
@endsection

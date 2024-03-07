@extends('layouts.app')
@section('titulo','Notificaciones')
@section('content')
<div class="container">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<a href="{{route('notifications.index')}}"><i class="fa fa-list-ol"></i> Notificaciones</a>
		</li>
	</ol>
	@include('alerts.success')
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-bordered table-hover table-condensed">
					<thead>
						<th>Foto</th>
						<th>Nombres y Apellidos</th>
						<th>Tipo de Notificación</th>
						<th>Fecha</th>
						<th>Estado</th>
						<th>Acción</th>
					</thead>
					<tbody id="notifications">
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
	@include('panel.notification.details')
</div>
@endsection
@section('extra_scripts')
<script>
	$(document).ready(function(){
		getNotifications();
	});

	let props = {
		tbNotifies : $("#notifications"),
		ruta : '',
		modal_details : $("#modal_details")
	}
	function getNotifications(page = 0) {
		props.ruta = '/panel/notifications-data';
		if(page != 0) props.ruta = `/panel/notifications-data/?page=${page}`;
		spinner.show();
		$.ajax({
			url: props.ruta,
			type: 'GET',
			dataType: 'JSON',
			success: res =>{
				spinner.hide();
				props.tbNotifies.empty();
				res.data.forEach(notify =>{
					props.tbNotifies.append(`
							<tr class="${notify.is_readed == false ? 'success': ''}">
								<td width="50">
								${notify.user.url_foto != null ? `<img width="100%" class="img-circle img-responsive" src="/fotousers/${notify.user.url_foto}">` : '<img width="100%" class="img-circle img-responsive" src="/fotousers/profile.png">'}
								</td>
								<td>${notify.user.name} ${notify.user.last_name}</td>
								<td>${notify.type.name}</td>
								<td>${dateFormat(notify.created_at)}</td>
								<td>${notify.is_readed == true ? 'Leído' : 'No leído'}</td>
								<td>
									<button onclick='showDetails(${JSON.stringify(notify)})' class="btn btn-link"><i class="fa fa-eye"></i> Ver detalle</button>
								</td>
							</tr>
						`);
				});
				
				renderPagination(res,'getNotifications');
			},
			error: error =>{
				console.log(error);
			}
		});
	}
	function showDetails(notify) {
		$("#username").html(`${notify.user.name.toUpperCase()}   |  <small>${notify.user.phone_number}</small>`);
		$("#typenotify").text(notify.type.name);
		$("#user-role").text(notify.user.role.name);
		$("#notify-body").text(notify.body);

		$("#checkboxes").html(`
			${notify.is_readed == true ? '<input checked disabled type="checkbox"> Leído' : `<input type='checkbox' onchange='updateReaded(this,${notify.id})'> Marcar como leído`}
				
			`);

		props.modal_details.modal();
	}

	function updateReaded(checkbox, notify_id) {
		if(checkbox.checked == true){
			props.ruta = `/panel/notifications/read/${notify_id}`;
			spinner.show();
	        $.ajax({
	        	url: props.ruta,
	        	type: 'GET',
	        	dataType: 'JSON',
	        	success:function(data){
	        		spinner.hide();
	        		props.modal_details.modal('hide');
	        		getNotifications($("#current_page").val());
	        		toastr.success(data.message);
	        	},
	        	error:function(data){
	        		console.log(data);
	        	}
	        });

		}
	}
</script>
@endsection
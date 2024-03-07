@extends('layouts.app')
@section('titulo')
Suscriptores {{$metodoPago->name}}
@endsection
@section('content')
<div class="container-fluid">
	<ol class="breadcrumb">
		<li class="breadcrumb-item active">
			<i class="fa fa-list-ol"></i> Suscriptores {{$metodoPago->name}}
		</li>
	</ol>
	<div class="panel panel-success">
		<div class="panel-body">
			<div class="table-responsive">
				<table class="table table-condensed table-hover">
					<thead>
						<th>Nombres y Apellidos</th>
						<th>Correo electrónico</th>
						<th>Telf.</th>
						<th>F. Registro</th>
						<th>Caducidad</th>
						<th>Plan</th>
						<th>Estado</th>
						<th>Control</th>
					</thead>
					@foreach($suscriptores as $suscriptor)
					<tbody>
						<tr class="{{{ $suscriptor->medio === "RC" ? "bg-danger" : ($suscriptor->medio ==="TM" ? "bg-info" : "bg-success") }}}" >

							<td>{{$suscriptor->user->fullName()}}</td>
							<td>{{$suscriptor->user->email}}</td>
							<td>{{$suscriptor->user->phone_number}}</td>
							<td>{{date("d/m/Y g:ia",strtotime($suscriptor->user->created_at))}}</td>
							<td>{{date('d/m/Y',strtotime($suscriptor->suscription_end))}}</td>
							<td>{{$suscriptor->plan->name}}</td>
							
							<td>
							@if($suscriptor->isExpired())
							<span class="label label-danger">Expirado</span>
							@else
							<span class="label label-success">Vigente</span>
							@endif
							</td>

							<td>
								<button onclick="verPagos({{$suscriptor->pagos}},'{{$suscriptor->user->fullName()}}');" class="btn btn-link btn-sm">Ver pagos</button>
								<a href="{{route('subscribersdeposito.edit',$suscriptor->user->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</a>
								{{-- <a href="{{route('subscribersdeposito.destroy',$suscriptor->user->id)}}" onclick="return confirm('ATENCIÓN\nUna vez anulada, el registro estará en la lista de suscripción gratuito');" class="btn btn-danger btn-sm">Anular</a> --}}
							</td>
						</tr>
					</tbody>
					@endforeach
				</table>
			</div>
				{{$suscriptores->render('layouts.pagination')}}
				@include('panel.subscriber.deposito.pagos')
		</div>
	</div>
	
</div>

@endsection
@section('extra_scripts')
<script>
	function verPagos(pagos,username){

		$('#pagosde_user').text(username);
		$("#dataPagos").empty();
		if(pagos.length > 0){
			pagos.forEach((pago, index) =>{
				$("#dataPagos").append(
					`<tr>
						<td>${pago.id}</td>
						<td>S/. ${pago.monto}</td>
						<td>${pago.tipo}</td>
						<td>${getMetodoPago(pago.metodopago_id)}</td>

						<td>
						${pago.voucher_emit === 0 ? 
							`<span>No solicitado</span>` : pago.voucher_emit === 1 ? `<button onclick="updateStatusCompronte(${pago.id})" class="btn btn-primary btn-sm">Validar emisión</button>` : `<span>Emitido</span>`}
						</td>

					</tr>`);

			});

		}else{
			$("#dataPagos").append(`<span>No se encontró registros...</span>`);
		}
		
		$("#modal_pagos").modal();

	}
	function getMetodoPago(metodopago_id){
		if(metodopago_id === 1) return "Pago en linea";

		return "Depósito/Transferencia";
	}

	function updateStatusCompronte(pago_id){
		fetch('/panel/updatestatuscomprobante/'+pago_id)
		.then(response => response.json())
		.then(response =>{
			if(response.status == 200){
				alert(response.message);
				location.reload();
			}
		})
		.catch(error =>{
			console.log(error);
		});
	}
</script>
@endsection
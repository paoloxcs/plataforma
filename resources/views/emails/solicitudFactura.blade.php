<style>
	table{
		text-align: center;
		width: 100%;
	}
</style>
<h2>Datos del suscriptor</h2>
<table>
	<thead>
		<th>Nombres</th>
		<th>Correo</th>
		<th>Dirección</th>
		<th>Telef.</th>
	</thead>
	<tbody>
		<tr>
			<td>{{$data['name']}}</td>
			<td>{{$data['email']}}</td>
			<td>{{$data['address']}}</td>
			<td>{{$data['phone']}}</td>
		</tr>
	</tbody>
</table>
<br>
<hr>
<br>
<h2>Datos para el comprobante</h2>
<table>
	<thead>
		<th>Id pago</th>
		<th>Comprobante</th>
		<th>Razon social</th>
		<th>RUC</th>
		<th>Plan</th>
		<th>Modalidad de pago</th>
		<th>Monto</th>
		<th>Fecha de pago</th>
	</thead>
	<tbody>
		<tr>
			<td>{{$data['pago_id']}}</td>
			<td>{{$data['comprobante']}}</td>
			<td>{{$data['rsocial']}}</td>
			<td>{{$data['ruc']}}</td>
			<td>{{$data['plan']}}</td>
			<td>{{$data['modpago']}}</td>
			@if($data['moneda']=="PEN")
			<td>S/. {{$data['amount']}} soles</td>
			@else
			<td>$ {{$data['amount']}} Dólares</td>
			@endif
			<td>{{date('d/m/Y',strtotime($data['creation_date']))}}</td>
		</tr>
	</tbody>	
</table>
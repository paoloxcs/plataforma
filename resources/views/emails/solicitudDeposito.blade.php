<h3>Datos del Solicitante</h3>

<table width="100%">
	<thead>
		<th>Nombres</th>
		<th>Apellidos</th>
		<th>Correo</th>
		<th>Dirección</th>
		<th>DNI</th>
		<th>Teléfono</th>
		<th>Plan Elegido</th>
		<th>Precio</th>
	</thead>
	<tbody>
		<tr>
			<td>{{$data['name']}}</td>
			<td>{{$data['last_name']}}</td>
			<td>{{$data['email']}}</td>
			<td>{{$data['direccion']}}</td>
			<td>{{$data['dni']}}</td>
			<td>{{$data['telef']}}</td>
			<td>{{$data['plan']}}</td>
			@if($data['moneda']=="PEN")
			<td>S/. {{$data['precio']}} Soles</td>
			@else
			<td>$ {{$data['precio']}} Dólares</td>
			@endif
		</tr>
	</tbody>
</table>

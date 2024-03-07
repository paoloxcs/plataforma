@component('mail::message')

Datos del solicitante<br>

<table>
	<tbody>
		<tr>
			<th>Suscriptor Gratuito</th>
			<th>Telf</th>
			<th>Correo</th>
			<th>Precio a Pagar</th>
		</tr>
		<tr>
			<td> {{$data['nameuser']}} </td>
			<td> {{$data['phone']}} </td>
			<td> {{$data['email']}} </td>
			<td> S/. {{$data['precio']}} </td>		
		</tr>
	</tbody>
</table>

<br>
{{ config('app.name') }}
@endcomponent

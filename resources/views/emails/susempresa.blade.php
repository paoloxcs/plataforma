@component('mail::message')
# Suscripción de la empresa: {{$data['empresa']}}



<h4>Datos de suscripcion</h4>
<p>Nombres: <strong>{{$data['nombre']}}</strong></p>
<p>Email	 : <strong>{{$data['email']}}</strong></p>
<p>Empresa	 : <strong>{{$data['empresa']}}</strong></p>
<p>Teléfono	 : <strong>{{$data['telefono']}}</strong></p>
<p>Nro de Personas	 : <strong>{{$data['nro_personas']}}</strong></p>
<p>objetivos	 : <strong>{{$data['objetivos']}}</strong></p>
<hr>



Saludos,<br>
{{ config('app.name') }}<br>
Movil/Whatsapp: 981 324 180
@endcomponent

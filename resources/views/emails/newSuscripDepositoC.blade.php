@component('mail::message')
# {{$data['message']}}



<h4>Datos de suscripción</h4>

<p>Suscriptor: <strong>{{$data['name']}}</strong></p>
<p>Fecha de suscripción: <strong>{{$data['suscription_init']}}</strong></p>
<p>N° Documento: <strong>{{$data['doc_number']}}</strong></p>
<p>N° Celular: <strong>{{$data['phone']}}</strong></p>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Responsable: <strong>{{$data['gestor']}}</strong></p>
@if($data['data']==0)
<p>Plan: <strong>{{$data['plan']}}</strong></p>
@else
<p>Curso: <strong>{{$data['plan']}}</strong></p>
@endif
@if($data['moneda']=="PEN")
<p>Pago: <strong>S/. {{$data['precio']}} Soles</strong></p>
@else
<p>Pago: <strong>$ {{$data['precio']}} Dólares</strong></p>
@endif
<p>N° Comprobante: <strong> {{$data['nro_comprobante']}}</strong></p>




Saludos,<br>
{{ config('app.name') }}<br>
Movil / Whatsapp: 981 324 180
@endcomponent


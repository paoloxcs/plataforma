@component('mail::message')
# Gracias por participar en nuestro curso

##  Estimado(a). {{$data['name']}}

<p>Nos es grato saludarlo y darle la bienvenida a nuestro curso de {{$data['rubro']}}, ahora como participante podra; acceder de manera digital al curso: {{$data['curso']}} y a todas sus clases con sus materiales de apoyo</p>

<h4>Datos de suscripcion</h4>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Curso	 : <strong>{{$data['curso']}}</strong></p>
@if($data['moneda']=="PEN")
<p>Monto pagado: <strong>S/. {{$data['amount']}} Soles</strong></p>
@else
<p>Monto pagado: <strong>$ {{$data['amount']}} Dólares</strong></p>
@endif
<p>Mensaje: <strong>{{$data['user_message']}}</strong></p>
<hr>
@component('mail::button', ['url' => 'http://plataforma.constructivo.com/curso/'.$data['slug'].''])
Ingresar ahora
@endcomponent


Saludos,<br>
{{ config('app.name') }}<br>
Movil/Whatsapp: 981 324 180
@endcomponent

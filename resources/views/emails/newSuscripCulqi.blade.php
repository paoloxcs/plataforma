@component('mail::message')
{{-- # Gracias por suscribirte a nuestra Plataforma de Ingeniería --}}
# Gracias por suscribirte a nuestra Plataforma de Capacitación 

##  Estimado(a). {{$data['name']}}


{{-- <p>Nos es grato saludarlo y darle la bienvenida a nuestra PLATAFORMA DE INGENIERÍA, ahora como suscriptor podrá acceder de manera digital a todas nuestras publicaciones: CONSTRUCTIVO, DOSSIER DE ARQUITECTURA Y TECNOLOGIA MINERA; podrá también descargar el SUPLEMENTO TECNICO DE PRESUPUESTOS PARA OBRA y autocapacitarse con los videos y artículos técnicos de cada rubro.</p> --}}
<p>Nos es grato saludarlo y darle la bienvenida a nuestra PLATAFORMA DE CAPACITACIÓN, ahora como suscriptor podrá acceder de manera digital a todas nuestras publicaciones: CONSTRUCTIVO, DOSSIER DE ARQUITECTURA Y TECNOLOGIA MINERA; podrá también descargar el SUPLEMENTO TECNICO DE PRESUPUESTOS PARA OBRA y autocapacitarse con los videos y artículos técnicos de cada rubro.</p>


<h4>Datos de suscripción</h4>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Plan	 : <strong>{{$data['plan']}}</strong></p>
@if($data['moneda']=="PEN")
<p>Monto pagado: <strong>S/. {{$data['amount']}} Soles</strong></p>
@else
<p>Monto pagado: <strong>$ {{$data['amount']}} Dólares</strong></p>
@endif
<p>Siguiente pago: <strong>{{date('d/m/Y',strtotime($data['suscription_end']))}}</strong></p>
<p>Mensaje: <strong>{{$data['user_message']}}</strong></p>
<hr>
@component('mail::button', ['url' => 'https://plataforma.constructivo.com/'])
Ingresar ahora
@endcomponent


Saludos,<br>
{{ config('app.name') }}<br>
Movil/Whatsapp: 981 324 180
@endcomponent

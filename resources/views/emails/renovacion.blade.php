@component('mail::message')
# Estimado(a). {{$data['name']}}

<h4>RENOVACIÓN DE SUSCRIPCIÓN A LA PLATAFORMA DE INGENIERIA</h4>

<p>Le informamos que su suscripción ha sido renovado con éxito, usted podra seguir accediendo a cada una de nuestras publicaciones digitales: CONSTRUCTIVO, DOSSIER DE ARQUITECTURA Y TECNOLOGIA MINERA. Y además visualizar videos de capacitación y descargar suplemento técnico.</p>

<hr>
<h4>Datos de suscripción</h4>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Plan	 : <strong>{{$data['plan']}}</strong></p>
<p>Monto pagado: <strong>S/. {{$data['amount']}}</strong></p>
<p>Nueva fecha de Caducidad: <strong>{{date('d/m/Y',strtotime($data['suscription_end']))}}</strong></p>
<p>Mensaje: <strong>{{$data['user_message']}}</strong></p>
<hr>

@component('mail::button', ['url' => 'https://plataforma.constructivo.com/'])
Acceder ahora
@endcomponent

Saludos,<br>
{{ config('app.name') }}<br>
Movil/Whatsapp: 981 324 180
@endcomponent

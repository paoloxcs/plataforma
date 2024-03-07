@component('mail::message')
# Estimado(a). {{$data['username']}}

<h4>RENOVACIÓN DE SUSCRIPCIÓN A LA PLATAFORMA DE INGENIERIA</h4>

<p>Le informamos que su suscripción ha sido renovado con éxito, usted podra seguir accediendo a cada una de nuestras publicaciones digitales: CONSTRUCTIVO, DOSSIER DE ARQUITECTURA Y TECNOLOGIA MINERA. Y además visualizar videos de capacitación y descargar suplemento técnico.</p>

<hr>
<p>Siguiente pago: <strong>{{date("d/m/Y",strtotime($data['caducidad']))}}</strong></p>

@component('mail::button', ['url' => 'https://plataforma.constructivo.com/'])
Acceder ahora
@endcomponent

Saludos,<br>
{{ config('app.name') }}<br>
Movil/Whatsapp: 981 324 180
@endcomponent

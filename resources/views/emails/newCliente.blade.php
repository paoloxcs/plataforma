@component('mail::message')
# Gracias por suscribirte a nuestra Plataforma de Ingeniería


##  Estimado(a). {{$data['name']}}

<p>Nos es grato saludarlo y darle la bienvenida a nuestra PLATAFORMA DE INGENIERÍA, desde el cual podrá acceder a cada una de nuestras publicaciones digitales: CONSTRUCTIVO, DOSSIER DE ARQUITECTURA Y TECNOLOGIA MINERA.</p>

<h4>Datos de suscripción</h4>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Password: <strong>{{$data['password']}}</strong></p>

@component('mail::button', ['url' => 'https://plataforma.constructivo.com/'])
Ingresar ahora
@endcomponent

Saludos,<br>
{{ config('app.name') }}
@endcomponent


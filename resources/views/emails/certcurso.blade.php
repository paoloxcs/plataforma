@component('mail::message')
# Solicitud de certificado


<h4>Datos de Certificado</h4>

<p>nombres: <strong> {{$data['fullname']}}</strong></p>
<p>nro celular: <strong> {{$data['phone_number']}}</strong></p>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>Curso	 : <strong>{{$data['curso']}}</strong></p>
<p>rubro: <strong> {{$data['rubro']}}</strong></p>

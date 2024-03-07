@component('mail::message')
# Usuario interesado


<h4>Datos del usuario</h4>
<p>Correo: <strong>{{$data['email']}}</strong></p>
<p>nro celular: <strong> {{$data['phone_number']}}</strong></p>
<p>nombres: <strong> {{$data['fullname']}}</strong></p>
<p>Curso	 : <strong>{{$data['curso']}}</strong></p>
<p>rubro: <strong> {{$data['rubro']}}</strong></p>

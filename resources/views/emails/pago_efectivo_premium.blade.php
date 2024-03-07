@component('mail::message')
# Estimado(a). {{$data['name']}}

<h4>PAGO PENDIENTE A LA PLATAFORMA CONSTRUCTIVO</h4>
 
<p>Le informamos que su pago esta pendiente de cancelación, para poder participar en nuestros cursos y acceder a sus materiales de apoyo.</p>

<hr>
<h4>Datos de pago</h4>
<p>Plan	 : <strong>{{$data['plan']}}</strong></p> 
<p>Precio	 : <strong>{{$data['moneda']}} {{$data['precio']}}</strong></p> 
<p>CIP : <strong>{{$data['cip']}}</strong></p>
<p>Fecha de Caducidad: <strong>{{date('d/m/Y g:i:s A',$data['suscription_end'])}}</strong></p>
<hr>

@component('mail::button', ['url' => 'https://plataforma.constructivo.com/'])
Acceder ahora
@endcomponent

Si ya realizó el pago, por favor comuníquelo<br>
por Whatsapp al <a href="https://api.whatsapp.com/send?phone=51981229242">+51 981 229 242</a> y/o<br>
al siguiente correo: <a href="mailto:info2@constructivo.com">info2@constructivo.com</a><br>
@endcomponent

@component('mail::message')

Estimado {{$data['nameuser']}}, <br>

Gracias por participar en nuestra promoción, recuerde que debe enviarnos una copia de su voucher indicando el depósito del monto S/. {{$data['precio']}} a la Cta Cte. N° 193-2366918-0-60, del Banco de Crédito BCP a nombre del PULL CREATIVO COMUNICACIONES SAC.

Si tiene alguna duda o consulta adicional, no dude en comunicarse con nosotros al 463 4070 / 99 831 2612.

@component('mail::button', ['url' => 'https://plataforma.constructivo.com'])
Visitar Plataforma
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent

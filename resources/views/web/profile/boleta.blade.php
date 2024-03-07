<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    
    <title>Plataforma de Ingeniería - CONSTRUCTIVO</title>
    <link href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/estilos.css')}}" rel="stylesheet">
  </head>
  <body>
    <div class="none">{{$a='construccion'}}</div>
    <div align="center" style="width: 100%;">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <!-- CABECERA -->
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="20%"><img src="{{asset('images/black.png')}}" width="200" alt=""> </td>
                <td width="80%" align="right"> <h5>Fecha de Emisión</h5><h3>{{date('d/m/Y',substr($pago->creation_date, 0,10))}}</h3></td>
              </tr>
            </table>
            <!-- CABECERA -->
          </td>
        </tr>
        <tr>
          <td style="padding-top: 15px; padding-bottom: 15px;">
            <!-- DATOS SUSCRIPTOR -->
            <table width="100%" cellpadding="0" cellspacing="0">
              <tr>
                <td width="70%"><p><strong>Nombres y Apellidos</strong>: {{$user->fullName()}}</p></td>
                <td width="30%" align="right"><p><strong>Doc. Identidad</strong>: {{$user->doc_number}}</p></td>
              </tr>
              <tr>
                <td width="70%"><p><strong>Dirección:</strong> {{$user->address}}</p></td>
                <td width="30%"><p> &nbsp; </td>
              </tr>
            </table>
            <!-- DATOS SUSCRIPTOR -->            
          </td>
        </tr>
        <tr>
          <td style="padding-top: 15px; padding-bottom: 15px;">
            <!-- DESCRIPCION -->
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #333333;">
              <tbody>
                <tr>                  
                  <th width="50%" style="background: #DADADA; font-weight: bold;">Descripción</th>
                  <th width="30%" style="background: #DADADA; font-weight: bold;">Plan</th>
                  <th width="20%" style="background: #DADADA; font-weight: bold;">Monto Pagado</th>
                </tr>
                <tr>
                  <td> Suscripción a la Plataforma de Ingeniería</td>
                  <td>{{$pago->description}}</td>
                  <td>S/. {!! number_format($pago->amount/100, 2, '.', ',') !!}</td>
                </tr>
              </tbody>
            </table>
            <!-- DESCRIPCION -->
            
          </td>
        </tr>
        <tr>
          <td style="padding-top: 15px; padding-bottom: 15px;">
            <table width="100%" cellpadding="0" cellspacing="0" style="border:1px solid #333333;">
              <tr>
                <td width="80%" align="right" style="padding-right: 10px;"> <strong>Monto Total: </strong> </td>
                <td width="20%"> S/. {!! number_format($pago->amount/100, 2, '.', ',') !!}</td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </div>
  </body>
</html>
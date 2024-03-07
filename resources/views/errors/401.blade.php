<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Acceso Restringido</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="panel-title">Acceso Restringido</div>
			</div>
			<div class="panel-body">
				<img class="img-responsive center-block" src="{{asset('images/deny-access.png')}}" alt="">
				<hr>
				<div align="center">
					<p>Usted no tiene Acceso a esta Sección.</p>
					<p><a href="{{url('/')}}">Volver al Inicio</a></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
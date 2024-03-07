<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Recurso no encontrado</title>
	<link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div class="col-md-4 col-md-offset-4">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<div class="panel-title">Recurso no encontrado !</div>
			</div>
			<div class="panel-body">
				<img class="img-responsive center-block" src="{{asset('images/not-found.png')}}" alt="">
				<hr>
				<div align="center">
					<p>No encontramos lo que buscas</p>
					<p><a href="#" onclick="history.back()">Volver Atras</a></p>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
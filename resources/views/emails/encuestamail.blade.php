<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style type="text/css">
			.body{
				width: 80%;
				margin-left: 10%;
				font-size: 14px;
			}
			.body h2{
				text-align: center;
			}
			.mensaje{
				width: 80%;
				margin-left: 10%;
				text-align: left;
			}
			.card{
				background: #EDEDED;
				padding: 1% 3%;
				position: relative;
				font-weight: 700;
			}
			.row {
				display: flex;
				width: 60%;
				margin-left: 20%;
			}
			.col-md-6{
				width: 60%;
			}
			.col-md-4{
				width: 33.3%;
			}
			.table{
				width: 100%;
			}
			.table thead tr{
				background: #00be72;
				font-weight: 700;
				text-align: center;
			}
			.table thead tr,.table .total_div{
				background: #00be72;
				font-weight: 700;
				text-align: center;
			}
			.total{
				color: red;
				text-align: left;
			}
			hr{
				width: 100%;
				border: solid #EDEDED 2px;
			}
			.aviso{
				font-size: 11px;
				text-align: center;
			}
			.footer{
				background: #EDEDED;
				width: 100%;
				display: flex;

			}
			.footer div{
				width: 40%;
				margin-left: 5%;
			}
			th,td{
				padding: 1% 2%;
				text-align: center;

			}
			tr{

			}
			.real{
				font-size: 12px;
				text-decoration: line-through;
				color: #B1B1B1;
			}
			a{
				text-decoration: none;
				padding-left: 2%;
			}
			.encuesta_table{
				font-size: 16px;
			}
			.encuesta_table thead{
			background: #00be72;
			color: white;
			}

			.encuesta_table thead tr th{
			border:none;
			border:solid .5px white;
			text-align: center;
			vertical-align: middle;
			}

			.escala{
				font-size: 15px;
				padding: 0;
				margin: 0;
			}
			.encuesta_table tbody {
				background: white;
			}
			.encuesta_table tbody tr th, .encuesta_table tbody tr td{
				text-align: center;
				vertical-align: middle;
				border:none;
				border:solid .5px #dcdede;
			}

			.encuesta_table input[type="radio"] {
			  appearance: none;
			  margin: 3%;
			  width: 20px;
			  height: 20px;
			  background: #eeeeee;
			  box-shadow: inset 0 0 0 0.4em white, 0 0 0 0.15em;
			  border-radius: 50%;
			  transition: 0.2s;
			  cursor: pointer;
			  color: #363945;
			}
			.encuesta_table input[type="radio"]:hover, input[type="radio"]:checked {
			  background: #363945;
			  box-shadow: inset 0 0 0 0.6em white, 0 0 0 0.15em;
			}
			.encuesta_table input[type="radio"]:checked {
			  background: #56be8e;
			  box-shadow: inset 0 0 0 0.4em white, 0 0 0 0.15em #56be8e;
			}
			.encuesta_table input[type="radio"]:focus {
			  outline: 0;
			}

			.encuesta_table input[type="radio"]:hover, input[type="radio"]:checked {
			  background: #363945;
			  box-shadow: inset 0 0 0 0.6em white, 0 0 0 0.15em;
			}
			.encuesta_table input[type="radio"]:checked {
			  background: #56be8e;
			  box-shadow: inset 0 0 0 0.4em white, 0 0 0 0.15em #56be8e;
			}
			.textarea_encuesta{

				padding: 0;
				margin:0;
				}

			.textarea_encuesta textarea{
				width: 100%;
				height: 100%;
				margin:0;
				padding: 1;
				max-height: 100px;
				border: 1px solid #56be8e;
			}

		</style>

	</head>
	<body>
		<div class="body">
				<h2>{{$data['encuesta']}}</h2>
				<hr>
				<div class="mensaje">

				<p><span class="bold">Fecha: {{$data['fecha']}}</span> </p>
				<p><span class="bold">Curso: {{$data['curso']}}</span> </p>
				<p><span class="bold">Rubro: {{$data['rubro']}}</span> </p>

				</div>
				
				<div class="card">
				    Usuario
				</div>

				<div class="row">
				 
				   <div class="col-md-6">
				   	<h5>Datos</h5>
				   	<p><span class="bold">Nombres: </span>{{$data['name']}} {{$data['last_name']}}</p>
				   	<p><span class="bold">Email: </span>{{$data['email']}}</p>
				   	<p><span class="bold">Teléfono: </span>{{$data['phone_number']}}</p>
				   	<p><span class="bold">Rol: </span>{{$data['role']}}</p>
				   	

				   </div>

				   <div class="col-md-6">
				   

				   </div>
				</div>

				<table class="table encuesta_table">
				  <thead>
				     <tr>
                    <th scope="col"  rowspan="2">PREGUNTA</th>
                    <th scope="col" colspan="5" class="escala" style="padding:0.2%">ESCALA DE IMPORTANCIA</th>
                  </tr>
                  <tr>
                    <th scope="col">No me gustó</th>
                    <th scope="col">Me gustó</th>
                    <th scope="col">Me gustó mucho</th>
                  </tr>
				  </thead>
				  <tbody>
				  	@foreach($data['preguntas'] as $pre)
					  	@foreach($data['respuestas'] as $enc)
					  	  	@if($pre['id']==$enc['pregunta_id'] and $enc['valor']!='')
							  <tr>
		                        <th >{{$pre['pregunta']}}</th>
		                        @if($enc['valor']==1)
			                        <td><input class="medium" type="radio" checked="" value="1" disabled=""></td>
			                        <td><input class="medium" type="radio"  value="2" disabled=""></td>
			                        <td><input class="medium" type="radio"  value="3" disabled=""></td>
		                        @elseif($enc['valor']==2)
			                        <td><input class="medium" type="radio"  value="1" disabled=""></td>
			                        <td><input class="medium" type="radio"  checked="" value="2" disabled=""></td>
			                        <td><input class="medium" type="radio"  value="3" disabled=""></td>
		                        @else
			                        <td><input class="medium" type="radio"  value="1" disabled=""></td>
			                        <td><input class="medium" type="radio"  value="2" disabled=""></td>
			                        <td><input class="medium" type="radio"  checked="" value="3" disabled=""></td>
		                        @endif
		                        
		                      </tr>
		                      @else
		                    @endif
					    @endforeach
					@endforeach
				    @foreach($data['preguntas'] as $pre)
					  	@foreach($data['respuestas'] as $enc)
					  	  	@if($pre['id']==$enc['pregunta_id'] and $enc['texto']!='')
							  <tr>
		                        <th >{{$pre['pregunta']}}</th>
		                        <td colspan="4" class="textarea_encuesta"><textarea disabled="">{{$enc['texto']}}</textarea></td>
		                      </tr>
		                     @else
				    		@endif
					    @endforeach
					@endforeach
				    
				  </tbody>
				</table>
				<hr>
				<br>

				

				<p class="aviso">© {{date('Y')}} Plataforma Constructivo</p>

		</div>
				
	</body>
</html>

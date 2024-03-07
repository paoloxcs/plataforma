@if (count($cursos))
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>Estado</th>
                          <th>Id</th>
                          <th>Título</th>
                          <th>portada</th>
                          <th>Precio</th>
                          <th>Promoción</th>
                          <th>rubro</th>
                          <th>Fecha</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($cursos as  $curso)
                  <tbody>
                       <tr>
                       	@if($curso->estado==1)
		                <td><i class="fa fa-check"></i></td>
		                @else
						<td><i class="fa fa-times"></i></td>
		                @endif
		                <td>{{$curso->id}}</td>
		                <td>{{$curso->titulo}}</td>
		                <td>
		                <img class="img-responsive" width="100" src="{{asset('imgCurso/'.$curso->url_portada)}}" alt="">
		            	</td>
		                <td>{{$curso->precio}}</td>
		                <td>{{$curso->promocion}}</td>

		                <td>{{$curso->rubro->nombrerubro}}</td>

		                <td>{{$curso->fecha}}</td>
		                <td>
		                <a  href="{{route('curso.editar',$curso->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
		                <a href="{{route('curso.delete',$curso->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</a>
		                <a href="{{route('clase',$curso->id)}}" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Clases</a>
		                </td>
		              </tr>
                  </tbody>
                  @endforeach
                 
              </table>
@else
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>Estado</th>
                          <th>Id</th>
                          <th>Título</th>
                          <th>portada</th>
                          <th>Precio</th>
                          <th>Promoción</th>
                          <th>rubro</th>
                          <th>Fecha</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($cursos as  $curso)
                  <tbody>
                       <tr>
                       	<td>----------</td>
						<td>----------</td>
						<td>----------</td>
						<td>----------</td>
						<td>----------</td>
						<td>----------</td>
						<td width="300">----------</td>
		              </tr>
                  </tbody>
                  @endforeach
                 
              </table>
@endif

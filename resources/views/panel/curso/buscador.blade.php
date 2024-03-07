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
		                <td>S/. {{$curso->precio}}.00 <br>  $  {{$curso->precio_d}}.00</td>
                    <td>S/. {{$curso->promocion}}.00 <br>  $  {{$curso->promocion_d}}.00</td>

		                <td>{{$curso->rubro->nombrerubro}}</td>

		                <td>{{$curso->fecha}}</td>
		               <td width="250">
                    <a  href="{{route('curso.editar',$curso->id)}}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                    <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" href="{{route('curso.delete',$curso->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
                    <a href="{{route('temas',$curso->id)}}" class="btn btn-secondary btn-sm"><i class="fa fa-sitemap"></i> Temas</a>
                    <a href="{{route('clase',$curso->id)}}" class="btn btn-success btn-sm"><i class="fa fa-folder"></i> Clases</a>
                    {{--<a href="{{route('evaluacion',$curso->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i> Evaluación</a>--}}
                    <a href="{{route('material',$curso->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i>  Material</a>
                    
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
                  <tbody>
                       <tr>
                       	<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
                        <td>----------</td>
                        <td>----------</td>
            						<td width="300">----------</td>
		                   </tr>
                  </tbody>
                 
              </table>
@endif

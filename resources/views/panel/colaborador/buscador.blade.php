@if (count($colaboradores))
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Logo</th>
                        <th>Rubro</th>
                        <th>Descripción</th>
                        <th>Orden</th>
                        <th>Acción</th>
                  </thead>
                  @foreach($colaboradores as  $colaborador)
                 <tbody>
                  <td>{{$colaborador->id}}</td>
                  <td>
                  <img class="img-responsive" width="90" src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" alt="">
                  </td>
                  <td>{{$colaborador->nombre}}</td>
                  <td>{{$colaborador->rubro->nombrerubro}}</td>
                  <td>{{$colaborador->descripcion}}</td>
                  <td>{{$colaborador->orden}}</td>
                  <td width="350">
                    <a href="{{route('colaborador.editar',$colaborador->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                    <a href="{{route('colaborador.delete',$colaborador->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
                  </td>
                </tbody>
                  @endforeach
                 
              </table>
@else
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Logo</th>
                        <th>Rubro</th>
                        <th>Descripción</th>
                        <th>Orden</th>
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
          						<td width="350">----------</td>
		              </tr>
                  </tbody>
                 
              </table>
@endif

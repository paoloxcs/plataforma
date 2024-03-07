@if (count($sponsors))
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>nombre</th>
                        <th>Logo</th>
                        <th>Web</th>
                        <th>Control</th>
                  </thead>
                  @foreach($sponsors as  $sponsor)
                  <tbody>
                  <td>{{$sponsor->id}}</td>
                  <td>{{$sponsor->nombre}}</td>
                  <td>
                  <img class="img-responsive" width="70" src="{{asset('imgCurso/'.$sponsor->url_logo)}}" alt="">
                  </td>
                  <td><a target="_blank" href="{{$sponsor->url_web}}">{{$sponsor->url_web}}</a></td>
                  <td width="350">
                    <a href="{{route('sponsor.editar',$sponsor->id)}}"  class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</a>
                    <a href="{{route('sponsor.delete',$sponsor->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
                    <a href="{{route('sponsorcontact',$sponsor->id)}}" class="btn btn-success btn-sm"><i class="fa fa-phone-square"></i>Contacto</a>
                          <a href="{{route('sponsormaterial',$sponsor->id)}}" class="btn btn-warning btn-sm"><i class="fa fa-clipboard"></i>Material</a>
                  </td>
                  </tbody>
                  @endforeach
                 
              </table>
@else
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>nombre</th>
                        <th>Logo</th>
                        <th>Web</th>
                        <th>Control</th>
                  </thead>
                  
                  <tbody>
                  <tr>
          						<td>----------</td>
          						<td>----------</td>
          						<td>----------</td>
                      <td>----------</td>
          						<td width="350">----------</td>
		              </tr>
                  </tbody>
                 
              </table>
@endif

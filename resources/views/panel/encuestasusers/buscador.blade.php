@if (count($encuestasu))
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th></th>
                          <th>Nombres y apellidos</th>
                          <th>Correo Electrónico</th>
                          <th>Teléfono</th>
                          <th>Curso</th>
                          <th>Encuesta</th>
                          <th>Acción</th>
                  </thead>
                  <tbody>
                      @foreach($encuestasu as  $enc)
                 
                                 
                                       <tr>
                                        <td><i class="fa fa-check"></i></td>
                                        
                                        <td>{{$enc->name}} {{$enc->last_name}}</td>
                                        <td>{{$enc->email}}</td>
                                        <td>{{$enc->phone_number}}</td>
                                        <td>{{$enc->tituloc}}</td>
                                        <td>{{$enc->titulo}}</td>

                                        <td>
                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target=".bd-example-modal{{$loop->iteration}}">Encuesta</button>
                                         @include('panel.encuestasusers.create')  
                                        </td>
                                      </tr>


                      @endforeach
                    
                  </tbody>
                 
              </table>
@else
	 <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th></th>
                          <th>Nombres y apellidos</th>
                          <th>Correo Electrónico</th>
                          <th>Teléfono</th>
                          <th>Curso</th>
                          <th>Encuesta</th>
                          <th>Acción</th>
                  </thead>
                  
                  <tbody>
                       <tr>
                       	<td>--</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
            						<td>----------</td>
                        <td>----------</td>
    		              </tr>
                      </tbody>
                     
                 
              </table>
@endif

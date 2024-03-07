@if (count($autores))
   <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>Autor</th>
                        <th>País</th>
                        <th>Foto</th>
                        <th>Acción</th>
                  </thead>
                  <tbody>
                      @foreach($autores as  $autor)
                 
                                 
                                       <tr>
                                        
                                        <td>{{$autor->idautor}}</td>
                                        <td>{{$autor->nombre}}</td>
                                        <td>{{$autor->nacionalidad}}</td>
                                        <td>{{$autor->imagen}}</td>

                                        <td>
                                          <button onclick='editAutor({{$autor->idautor}})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                                          <button onclick='deleteAutor({{$autor->idautor}})' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                                        </td>
                                      </tr>


                      @endforeach
                    
                  </tbody>
                 
              </table>
@else
   <table class="table table-condensed table-hover table-bordered">
                  <thead>
                        <th>Id</th>
                        <th>Autor</th>
                        <th>País</th>
                        <th>Foto</th>
                        <th>Acción</th>
                  </thead>
                  
                  <tbody>
                       <tr>
                        <td>--</td>
                        <td>----------</td>
                        <td>----------</td>
                        <td>----------</td>
                        <td>----------</td>
                      </tr>
                      </tbody>
                     
                 
              </table>
@endif

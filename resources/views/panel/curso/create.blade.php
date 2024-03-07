<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width: 55%;" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nuevo Curso</font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container">
        <form action="{{route('curso.store')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row col-md-12">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus required>
                     </div>
                     {{--<div class="form-group">
                         <label for="infoadd">Descripción</label>
                         <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese descripción" required></textarea>
                     </div>--}}
                      <div class="form-group">
                         <label for="infoadd">Información</label>
                         <textarea name="informacion"  cols="30" rows="5" class="form-control" placeholder="Ingrese información" required></textarea>
                     </div>

                     <div class="form-group">
                         <label for="infoadd">Descripción</label>
                         <textarea name="descripcion"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese descripcion" required></textarea>
                     </div>

                     <div class="form-group">
                         <label for="infoadd">Objetivos</label>
                         <textarea name="objetivos"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese objetivos" required></textarea>
                     </div>

                     <div class="form-group">
                         <label for="infoadd">Público</label>
                         <textarea name="publico"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese publico" required></textarea>
                     </div>

                    

                      <div class="form-group">
                         <label for="infoadd">Beneficios</label>
                         <textarea name="beneficios"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese beneficios" required></textarea>
                     </div>
                     

                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <label for="">Elegir rubro</label>
                        <select name="rubro_id"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                          @foreach($rubros as  $rubro)
                          <option value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Elegir Docente</label>
                        <select name="autor_id"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                          @foreach($autores as  $autor)
                          <option value="{{$autor->idautor}}">{{$autor->nombre}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Soles)</label>
                        <input type="number" class="form-control" name="precio" placeholder="Precio no suscriptor aquí (PEN)" autofocus required>
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Soles)</label>
                        <input type="number" class="form-control" name="promocion" placeholder="Precio suscriptor aquí (PEN)" autofocus required="">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Dólares)</label>
                        <input type="number" class="form-control" name="precio_d" placeholder="Precio no suscriptor aquí (USD)" autofocus required>
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Dólares)</label>
                        <input type="number" class="form-control" name="promocion_d" placeholder="Precio suscriptor aquí (USD)" autofocus required="">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Culminado)</label>
                        <input type="number" class="form-control" name="precio_c" placeholder="Precio no suscriptor una vez culminado el curso" autofocus >
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Culminado)</label>
                        <input type="number" class="form-control" name="promocion_c" placeholder="Precio suscriptor una vez culminado el curso" autofocus >
                     </div>

                     <div class="form-group">
                        <label for="">Estado</label>
                        <select name="estado"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                           <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                        </select>
                    </div>    


                     <div class="form-group">
                        <label for="titulo">Fecha</label>
                        <input type="date" class="form-control" name="fecha" autofocus value="{{date('Y-m-d')}}" required>
                    </div>

                    <div class="form-group">
                        <label for="time">Hora</label>
                        <input type="time" class="form-control" name="time" autofocus
                        required>
                     </div>

                    <div class="form-group">
                        <label for="titulo">Fecha de culminación</label>
                        <input type="date" class="form-control" name="fecha_culminacion" autofocus value="{{date('Y-m-d')}}" required>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Fecha de expiración</label>
                        <input type="date" class="form-control" name="expira" autofocus value="{{date('Y-m-d')}}" required>
                    </div>


                    <div class="form-group">
                        <label for="titulo">Url video preview</label>
                        <input type="text" class="form-control" name="url_video_preview"  value="">
                    </div>
                    <hr>
                    <h5 style="text-align: center;color:#dc3545;font-weight: 900">Descuento para cursos en vivo</h5>
                    <div class="form-group">
                        <label for="porcentaje_d_v">Porcentaje</label>
                        <input type="number" class="form-control" name="porcentaje_d_v"  value="">
                    </div>


                    <div class="form-group">
                        <label for="fecha_d_v">Fecha límite</label>
                        <input type="date" class="form-control" name="fecha_d_v"  value="">
                    </div>


                </div>


              </div>

           
             <div class="row">
                <div class="col-xs-12 col-md-4">
                         <div class="form-group">
                            <label for="">Subir Portada</label>
                            <input type="file" accept="image/*" name="portada" required>
                        </div>
                </div>

                <div class="col-xs-12 col-md-4">
                         <div class="form-group">
                            <label for="">Subir Certificado</label>
                            <input type="file" accept="image/*" name="certificado" >
                        </div>
                </div>
             </div>
         


              <h4>---- Banner ----</h4>
              <div class="row">
                
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir Portada (1350px * 500px | 100KB) </label>
                      <input type="file" accept="image/*" name="banner_portada" required>
                  </div>
                </div>
                
              </div>
              <div class="row">
                  <div  class="col-xs-12 col-md-10">
                       <label for="infoadd">Descripción</label>
                      <input type="text" name="banner_descripcion"  class="form-control" placeholder="Ingrese descripción" required>
                  </div>
              </div>
              
              
              <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
              
        </div>
          
        
      </form>
      </div>
    </div>
  </div>
</div>
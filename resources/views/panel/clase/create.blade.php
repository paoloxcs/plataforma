<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nueva Clase</font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container">
        <form action="{{route('clase.create')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row col-md-12 row">
                <div class="col-xs-12 col-md-6">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus required>
                     </div>
                     <div class="form-group">
                         <label for="infoadd">Información</label>
                         <textarea name="informacion"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"   placeholder="Ingrese información" required></textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-3">
                      <div class="form-group">
                        <label for="titulo">Código Zoom</label>
                        <input type="text" class="form-control" name="codigo_zoom" placeholder="Código de Zoom aquí" autofocus>
                     </div>

                     <div class="form-group">
                        <label for="titulo">Video Código</label>
                        <input type="text" class="form-control" name="codigo_video" placeholder="Código de video aquí" autofocus>
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
                        <input type="date" class="form-control" name="fecha" autofocus
                        value="{{date('Y-m-d')}}" required>
                     </div>


                     <div class="form-group">
                        <label for="time">Hora</label>
                        <input type="time" class="form-control" name="time" autofocus
                        required>
                     </div>

                     <div class="form-group">
                        <label for="">Hora Expiración</label>
                        <input type="time" class="form-control" name="time_exp" autofocus
                        required>
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
                
              </div>
              <input type="hidden" value="{{$curso->id}}" name="curso_id">
              
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
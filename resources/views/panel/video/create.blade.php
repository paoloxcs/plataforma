
<!-- Small modal -->
<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-plus"></i> Crear registro</h4></div>
        </div>
          <form onsubmit="saveVideo(this)" method="POST" action="#" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                      <label for="">Título</label>
                      <input type="text" class="form-control" name="titulo" placeholder="Ingrese Título al video">
                     </div>
                     <div class="form-group">
                         <label for="">Descripción</label>
                         <textarea name="infoaddc"  data-validate="true" cols="30" rows="4" class="form-control ckeditor" placeholder="Ingrese descripción"></textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="idrubro">Elige rubro</label>
                      <select name="idrubro" onchange="getCategs(this.value)" class="form-control rubros">
                       
                      </select>
                  </div>
                  <div class="form-group">
                       <label for="">Seleccione Categoría</label>
                      <select name="idcategoria" onchange="getSubcates(this.value)" class="form-control categs">

                      </select>
                  </div>
                  <div class="form-group">
                       <label for="">Seleccione Sub-categoria</label>
                       <select name="idsubcategoria" class="form-control subcates">
                       </select>
                  </div>
                {{-- Is_active_capacitacion --}}
                <div class="form-group">
                    <label for="is_active">¿Video Activo?</label>
                    <select name="is_active" class="form-control">
                        <option value="1">Si</option>
                        <option value="0">No</option>
                    </select>
                </div>
                   
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <label for="url_video"><i class="fa fa-play"></i> URL Video</label>
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Código</span>
                        <input type="text" name="url_video" class="form-control" aria-describedby="basic-addon3" placeholder="8755215487">
                      </div>
                  </div>
                  
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir Portada</label>
                      <input type="file" name="portada" accept="image/*">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                     <label for="idautor"><i class="fa fa-user"></i> Autor</label>
                     <select name="idautor" id="" class="form-control autores">
                     </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                      <label for="url_preview"><i class="fa fa-play"></i> URL Preview</label>
                      <div class="input-group">
                        <span class="input-group-addon" id="basic-addon3">Código</span>
                        <input type="text" name="url_preview" class="form-control" aria-describedby="basic-addon3" placeholder="875424154">
                      </div>
                  </div>
                </div>
                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                      <label for="duracion"><i class="fa fa-clock-o"></i> Duración</label>
                      <input type="text" name="duracion" class="form-control" placeholder="Ejemplo: 2:34">
                  </div>
                </div>
                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                      <label for="">Elige prioridad</label>
                      <select name="orden" class="form-control">
                        <option value="0">General</option>
                        <option value="1">Principal</option>
                      </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                      <label for="acceso">¿Disponible Gratuito?</label>
                      <select name="acceso" class="form-control">
                        <option value="0">Si</option>
                        <option value="1">No</option>
                      </select>
                  </div>
                </div>
              </div>   
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>
           </form>
    </div>
  </div>
</div>

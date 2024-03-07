
<!-- Small modal -->
<div class="modal" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-pencil"></i> Editar registro</h4></div>
        </div>
          <form onsubmit="updateVideo(this)" method="POST" action="#" id="form-edit" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <input type="hidden" name="post_id">
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                      <label for="titulo">Título</label>
                      <input type="text" class="form-control" name="titulo" placeholder="Ingrese Título al video">
                     </div>
                     <div class="form-group">
                         <label for="">Descripción</label>
                         <textarea name="infoadd"  cols="30" rows="4" class="form-control ckeditor" placeholder="Ingrese descripción"></textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="idrubro">Rubro</label>
                      <select name="idrubro" onchange="getCategs(this.value)" class="form-control rubros">
                       
                      </select>
                  </div>
                  <div class="form-group">
                       <label for="">Categoría</label>
                      <select name="idcategoria" onchange="getSubcates(this.value)"  class="form-control categs">

                      </select>
                  </div>
                  <div class="form-group" id="suboculto">
                       <label for="">Subcategoria</label>
                       <select name="idsubcategoria" class="form-control subcates">
                       </select>
                  </div>
                {{-- Is_active_capacitacion --}}
                <div class="form-group" id="is_active">
                    <label for="is_active">¿Video Activo?</label>
                    <select name="is_active" class="form-control">
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
                        <input type="text" name="url_video" class="form-control" aria-describedby="basic-addon3" placeholder="875421454">
                      </div>
                  </div>
                  
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Remplazar Portada <small>(Opcional)</small></label>
                      <input type="file" name="portada" accept="image/*">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                     <label for="idautor"><i class="fa fa-user"></i> Autor</label>
                     <select name="idautor" class="form-control autores">
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
                        <input type="text" name="url_preview" class="form-control" aria-describedby="basic-addon3" placeholder="87542154">
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
                        
                      </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                      <label for="acceso">¿Disponible Gratuito?</label>
                      <select name="acceso" class="form-control">
                        
                      </select>
                  </div>
                </div>
              </div>   
            </div>
            <div class="modal-footer">
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Actualizar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>
           </form>
    </div>
  </div>
</div>

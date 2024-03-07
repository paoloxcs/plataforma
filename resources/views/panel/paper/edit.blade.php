
<!-- modal -->
<div class="modal" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-pencil"></i> Editar registro</h4></div>
        </div>
          <form onsubmit="updateArticle(this)" method="POST" action="#" id="form-edit" enctype="multipart/form-data">
            {{ csrf_field() }}
            {{ method_field('PUT') }}
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="hidden" name="post_id">
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí">
                     </div>
                     <div class="form-group">
                         <label for="infoadd">Descripción</label>
                         <textarea name="infoadd"  cols="30" rows="5" class="form-control" placeholder="Ingrese descripción"></textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                        <label for="">Elegir rubro</label>
                        <select name="idrubro" onchange="getCategs(this.value)" class="form-control rubros">
                        </select>
                    </div>

                    <div class="form-group" id="catoculto">
                         <label for="">Seleccione Categoría</label>
                        <select name="idcategoria" onchange="getSubcates(this.value)" class="form-control categs">
                        </select>
                    </div>

                    <div class="form-group" id="suboculto">
                         <label for="">Seleccione Sub-categoria</label>
                         <select name="idsubcategoria" class="form-control subcates">
                         </select>
                    </div>

                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Remplazar archivo PDF <small>(Opcional)</small></label>
                      <input type="file" accept="application/pdf" name="pdf" >
                  </div> 
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Remplazar Portada (Opcional)</label>
                      <input type="file" accept="image/*" name="portada" >
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <label for="">Autor</label>
                      <select name="idautor" id="" class="form-control autores">
                      </select>
                  </div>
                </div>
                
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                      <label for="">Num. Pag.</label>
                      <input type="text" name="pages" class="form-control" placeholder="Páginas">
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="">Idioma</label>
                    <select name="idioma" class="form-control">
                      
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="orden">Seleccione Prioridad</label>
                    <select name="orden" class="form-control">
                      
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="acceso">¿Disponible Gratuito?</label>
                    <select name="acceso" class="form-control">
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2"></div>
              </div>
            </div>   
            <div class="modal-footer">
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Actualizar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>

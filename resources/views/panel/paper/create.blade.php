
<!-- modal -->
<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-plus"></i> Crear registro</h4></div>
        </div>
          <form onsubmit="saveArticle(this)" method="POST" action="#" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus>
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
                      <label for="">Subir archivo PDF</label>
                      <input type="file" accept="application/pdf" name="pdf" >
                  </div> 
                </div>
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir Portada</label>
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
                      <label for="">Fecha de Creación</label>
                      <input type="date" name="fechaimp" step="1" class="form-control" value="{{date("Y-m-d")}}">
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="">Idioma</label>
                    <select name="idioma" id="" class="form-control">
                      <option value="ES">Español</option>
                      <option value="EN">Ingles</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="orden">Seleccione Prioridad</label>
                    <select name="orden" class="form-control">
                      <option value="0">General</option>
                      <option value="1">Principal</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2">
                  <div class="form-group">
                    <label for="acceso">¿Disponible Gratuito?</label>
                    <select name="acceso" class="form-control">
                      <option value="0">Si</option>
                      <option value="1">No</option>
                    </select>
                  </div>
                </div>
                <div class="col-xs-12 col-md-2"></div>
              </div>
            </div>   
            <div class="modal-footer">
              <div class="form-group">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>
          </div>
        </form>
    </div>
  </div>
</div>

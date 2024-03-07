
<!-- Small modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title">Editar autor</div>
        </div>
          <form onsubmit="updateAutor(this);" method="POST" id="editform" action="#" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="form-group">
                    <input type="hidden" name="idautor">
                    <input type="hidden" name="token" value="{{ csrf_token()}}">
                    <label for="nombre">Nombres y Apellidos</label>
                    <input type="text" data-validate="true" class="form-control" name="nombre" placeholder="Nombres y apellidos" autofocus>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6">
                  <div class="form-group">
                      <label for="pais">País</label>
                      <input type="text" name="pais" data-validate="true" class="form-control" placeholder="Ingrese país">
                  </div>
                </div>
              </div>
               <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="form-group">
                    <input type="text" data-validate="true" class="form-control" name="cargo" placeholder="Ingrese Profesion" autofocus>
                  </div>
                </div>
                <div class="col-xs-12 col-md-6">
                  <select name="principal" class="form-control">
                 </select>
                </div>
              </div>
              
              <div class="form-group">
                  <label for="">Biografía</label>
                  <textarea name="bioedit" data-validate="true" class="form-control ckeditor" cols="30" rows="4" placeholder="Ingrese Biografía del Autor"></textarea>
              </div>
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="form-group">
                      <label for="">Remplazar foto <small>(Opcional)</small></label>
                      <input type="file" accept="image/*" name="imagen">
                  </div>
                </div>
                <div class="col-xs-12 col-md-6">
                  <div class="form-group">
                     <button type="submit" class="btn btn-primary">Actualizar</button>
                     <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                   </div>
                </div>
              </div>
            </div>
           </form>
    </div>
  </div>
</div>

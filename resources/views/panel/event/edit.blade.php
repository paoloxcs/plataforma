<!-- Small modal -->
<div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title">Editar Evento</div>
        </div>
          <form onsubmit="updateEvent(this);" method="POST" id="form-edit" action="#" enctype="multipart/form-data">
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                    <input type="hidden" name="idevent">
                    <input type="hidden" name="token" value="{{ csrf_token()}}">
                    <label for="title">Título de Evento</label>
                    <input type="text" data-validate="true" class="form-control" name="title" placeholder="Título de Evento" autofocus>
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <label for="url_web">Enlace del Evento</label>
                      <input type="text" name="url_web" data-validate="true" class="form-control" placeholder="Link del Evento">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <label for="">Remplazar foto <small>(Opcional)</small></label>
                      <input type="file" accept="image/*" name="url_image">
                  </div>
                </div>
              </div>

              <div class="row">

                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                    <label for="rubro">Elegir Rubro</label>                   
                    <select name="rubro" class="form-control rubros"></select>
                  </div>
                </div>

                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                    <label for="tipo">Elegir Tipo</label>             
                    <select name="tipo" class="form-control tipos"></select>
                  </div>
                </div>

                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                    <label for="date_init">Fecha de Inicio</label>                
                    <input type="date" name="date_init" value="{{date('Y-m-d')}}" class="form-control">
                  </div>
                </div>

                <div class="col-xs-12 col-md-3">
                  <div class="form-group">
                    <label for="status">Estado de Evento</label>
                    <select name="status" class="form-control" id="status">
                      <option value="1" selected>Activo</option>
                      <option value="0">Desactivado</option>
                    </select>
                  </div>
                </div>


                <div class="col-xs-12 col-md-12">
                  <div class="form-group">
                   <button type="submit" class="btn btn-primary">Guardar</button>
                   <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                   </div>
                </div>

              </div>
            </div>
           </form>
    </div>
  </div>
</div>

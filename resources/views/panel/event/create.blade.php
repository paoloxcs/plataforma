<!-- Small modal -->
<div class="modal fade" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title">Nuevo Evento</div>
        </div>
          <form onsubmit="saveEvent(this);" method="POST" action="#" enctype="multipart/form-data" >
            <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                    <input type="text" data-validate="true" class="form-control" name="title" placeholder="Nombre de Evento" autofocus>
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <input type="text" name="url_web" data-validate="true" class="form-control" placeholder="Ingrese URL del Evento">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                      <label for="">Subir foto</label>
                      <input type="file" data-validate="true" accept="image/*" name="url_image">
                  </div>
                </div>
              </div>
              
              <div class="row">

                <div class="col-xs-12 col-md-4">
                  <div class="form-group">                    
                    <select name="rubro" class="form-control rubros"></select>
                  </div>
                </div>

                <div class="col-xs-12 col-md-4">
                  <div class="form-group">                    
                    <select name="tipo" class="form-control tipos"></select>
                  </div>
                </div>

                <div class="col-xs-12 col-md-4">
                  <div class="form-group">
                    <label for="date_init">Fecha de Inicio</label>                
                    <input type="date" name="date_init" value="{{date('Y-m-d')}}" class="form-control">
                  </div>
                </div>

                <div class="col-xs-12 col-md-4">
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
<!-- Small modal -->
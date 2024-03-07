
<!-- Small modal -->
<div class="modal" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4>Aplicar filtros</h4></div>
        </div>
          <form onsubmit="applyFilter();" method="POST" id="form_filter" action="#">
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-4">
						<div class="panel panel-primary">
							<div class="panel-heading">
								<div class="panel-title">Por Planes</div>
							</div>
							<div class="panel-body" id="planes-filter">
								

							</div>
						</div>
						
					</div>


          {{-- <div class="col-xs-12 col-md-4">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="panel-title">Por Gestor</div>
              </div>
              <div class="panel-body" id="modpago-filter">
                
              </div>
            </div>
            
          </div> --}}

          {{-- ESTADO DE PAGO EFECTIVO ASIGNADO O NO ASIGNADO --}}
          <div class="col-xs-12 col-md-4">
            <div class="panel panel-success">
              <div class="panel-heading">
                <div class="panel-title">Por Asignar</div>
              </div>
              <div class="panel-body" id="statuspago-filter">
                
              </div>
            </div>
            
          </div>

									
				</div>
            </div>
            <div class="modal-footer">
            	<div class="form-group">
            		<button type="submit" class="btn btn-primary">Aplicar filtros</button>
            		<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            	</div>
            </div>
           </form>
    </div>
  </div>
</div>

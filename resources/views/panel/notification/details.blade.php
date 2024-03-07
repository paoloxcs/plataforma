<!-- Modal -->
<div class="modal bs-example-modal-lg" id="modal_details" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="username"></h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-xs-12 col-md-8">
                <span>Tipo : <strong id="typenotify"></strong></span>
            </div>
            <div class="col-xs-12 col-md-4">
                <span>Rol  : <strong id="user-role"></strong></span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <h4>Mensaje</h4>
                <p id="notify-body"></p>
            </div>
        </div>
        <div class="row">
        	<div class="col-xs-12 col-md-4 col-md-offset-4">
				<div class="form-group mt-5">
					<label id="checkboxes">
						
					</label>
				</div>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
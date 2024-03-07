<!-- Modal formulario de asignacion -->
<div class="modal" id="modalasign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario de asignación</h4>
      </div>
      <div class="modal-body">
        <form action="#" onsubmit="saveAsignation(this);" method="POST" id="form-asign">
        	<div class="row">
        		{{ csrf_field() }}
        	  <div class="col-md-12">
        	  	<input type="hidden" name="user_id">
        	    <div class="input-group">
        	      <select name="gestor" class="form-control">
                    
        	      </select>
        	      <span class="input-group-btn">
        	        <button type="submit" class="btn btn-success" type="button">ASIGNAR</button>
        	      </span>
        	    </div>
        	  </div>
        	</div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>
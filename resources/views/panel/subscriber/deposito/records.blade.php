<!-- Modal2 historial -->
<div class="modal" id="modalrecords" tabindex="-2" role="dialog" aria-labelledby="myModalLabel1">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h5 class="modal-title" id="usernamerecord"></h5>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12">
            <form action="#" onsubmit="saveRecord(this);" method="POST">
              {{ csrf_field() }}
              <input type="hidden" id="user_id" name="user_id">
              <div class="form-group">
                <textarea name="body" class="form-control" cols="30" rows="3" placeholder="Escriba aquí..."></textarea>
              </div>
              <div class="form-group text-center">
                <button type="submit" class="btn btn-primary"><i class="fa fa-plus"></i> Agregar historial</button>
              </div>
            </form>
          </div>
        </div>
        <hr>
      	<div class="row">
      		<div class="col-md-12">
      			<table class="table table-hover">
      				<thead>
      					<th>Id</th>
      					<th>Detalle</th>
      					<th>Fecha</th>
                <th>Acción</th>
      				</thead>
      				<tbody id="records">
      					
      				</tbody>
      			</table>
      		</div>
      	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
      </div>
    </div>
  </div>
</div>

<!-- Small modal -->
<div class="modal" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        
		<div class="d-flex w-100"> 
			<div class="modal-title"><h4>Editar cliente</h4></div>
			<button type="button" class="close" onclick="closeEditClienteExecute();" style="margin-left:auto"  data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		</div>

        </div>
          <form onsubmit="updateCliente(this);" method="POST" action="#" id="editform">
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-6" style="padding: 0">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<input type="hidden" name="user_id">
									<input type="hidden" name="idejecutivo">
									<input type="hidden" name="_method" value="PUT">
									<label for="nombres">Nombres</label>
									<input type="text" data-validate="true" name="name" class="form-control" placeholder="Ingrese nombres">
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="last_name">Apellidos</label>
									<input type="text" data-validate="true" name="last_name" class="form-control" placeholder="Ingrese apellidos">
								</div>
							</div>
						</div>
						<div class="form-group">
							<label for="email">Correo electrónico</label>
							<input type="email" data-validate="true" name="email" class="form-control" placeholder="Ingrese correo electrónico">
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="phone_number">Telf. o Movil</label>
									<input type="number" name="phone_number" class="form-control" placeholder="Opcional">
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="doc_number">DNI / Pasaporte</label>
									<input type="number" name="doc_number" class="form-control" placeholder="Opcional">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="address">Dirección</label>
									<input type="text" name="address" class="form-control">
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6" style="padding: 0">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="empresa">Empresa</label>
									<input type="text" name="empresa" class="form-control" placeholder="Nombre de empresa">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="ejecutivo">Ejecutivo</label>
									<input type="text" data-validate="true" name="ejecutivos_name" class="form-control" disabled placeholder="Nombre Ejecutivo">
									{{-- <select name="ejecutivo" id="ejecutivos_edit" disabled class="form-control">
										
									</select> --}}
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="medio">Medio</label>
									<select name="medio" class="form-control">
										<option value="RC">RC</option>
										<option value="DA">DA</option>
										<option value="TM">TM</option>
									</select>
								</div>
							</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<label for="status">Estado</label>
								<select name="status" id="status" class="form-control">
									
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6">
							<div class="form-group">
								<label for="caducidad">Fecha Caducidad</label>
								<input type="date" name="caducidad" class="form-control" placeholder="Fecha de caducidad">
							</div>
						</div>
					</div>

				</div>
            </div>
            <div class="modal-footer">
            	<div class="form-group">
            		<button type="submit" class="btn btn-primary">Actualizar</button>
            		<button type="button" class="btn btn-default" onclick="closeEditClienteExecute();"  data-dismiss="modal">Cancelar</button>
            	</div>
            </div>
           </form>
    </div>
  </div>
</div>

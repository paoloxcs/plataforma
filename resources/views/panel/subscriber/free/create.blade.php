
<!-- Small modal -->
<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-plus"></i> Crear suscripción</h4></div>
        </div>
          <form onsubmit="saveSubscriberFree(this);" method="POST" action="#">
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="name">Nombres</label>
									<input type="text" data-validate="true" name="name" class="form-control" placeholder="Ingrese nombres" autofocus>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="last_name">Apellidos</label>
									<input type="text" data-validate="true" name="last_name" class="form-control" placeholder="Ingrese apellidos" autofocus>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="password">Contraseña</label>
									<input type="password" data-validate="true" name="password" class="form-control" placeholder="Nueva contraseña">
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="password-confirm">Confirmar Contraseña</label>
									<input type="password" data-validate="true" id="password-confirm" name="password_confirmation" class="form-control" placeholder="Confirme la contraseña">
								</div>
							</div>
						</div>
						
								{{-- New Campos Form --}}
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
								  <label for="profession">Profeción</label>
                                        <input type="text" name="profession" class="form-control"
                                            placeholder="Ingrese la profeción" required>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="cargo_user">Cargo</label>
									<input type="text" name="cargo_user" class="form-control"
										placeholder="Ingrese el cargo" required>
								</div>
							</div> 
						</div>
						
					</div>
					<div class="col-xs-12 col-md-6">
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="email">Correo electrónico</label>
									<input type="email" data-validate="true" name="email" class="form-control" placeholder="Ingrese correo electrónico">
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="phone_number">Telf. o Movil</label>
									<input type="number" name="phone_number" class="form-control" placeholder="Opcional">
								</div>
							</div>
							
							
						</div>
						
						<div class="row">
							
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="doc_number">DNI / Pasaporte / RUC</label>
									<input type="number" name="doc_number" class="form-control" placeholder="Opcional">
								</div>
							</div>

							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="medio">Medio</label>
									<select name="medio" class="form-control">
										<option value="1">RC</option>
										<option value="2">TM</option>
										<option value="3">DA</option>
									</select>
								</div>
							</div>
							
						</div>
						
						{{-- New Campos Form --}}
						<div class="row"> 
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="address">Dirección</label>
									<input type="text" name="address" class="form-control"
										placeholder="Ingrese la dirección" required>
								</div>
							</div> 
						</div>


					</div>
				</div>
            </div>
            <div class="modal-footer">
            	<div class="form-group">
            		<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
            		<button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
            	</div>
            </div>
           </form>
    </div>
  </div>
</div>

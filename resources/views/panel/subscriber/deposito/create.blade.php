
<!-- Small modal -->
<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <div class="modal-title"><h4><i class="fa fa-plus"></i> Crear suscripción</h4></div>
        </div>
          <form onsubmit="saveSubscriber(this);" method="POST" action="#">
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
									<label for="email">Correo electrónico</label>
									<input type="email" data-validate="true" name="email" class="form-control" placeholder="Ingrese correo electrónico">
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="nro_comprobante">N° Comprobante</label>
									<input type="text" data-validate="true" name="nro_comprobante" class="form-control" placeholder="Ej: EB01-XXXXXXX" required="">
								</div>
							</div>
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
								  <label for="doc_number">DNI / Pasaporte / RUC</label>
									<input type="number" name="doc_number" class="form-control" placeholder="Opcional">
								</div>
							</div>
						</div>
						
						 {{-- New Campos Form --}}
                            <div class="row">
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="profession">Profesión</label>
                                        <input type="text" name="profession" class="form-control"
                                            placeholder="Ingrese la profesión" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="cargo_user">Cargo</label>
                                        <input type="text" name="cargo_user" class="form-control"
                                            placeholder="Ingrese el cargo" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="address">Dirección</label>
                                        <input type="text" name="address" class="form-control"
                                            placeholder="Ingrese la dirección" required>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-md-6">
                                    <div class="form-group">
                                        <label for="num_operacion">Nro de Operación</label>
                                        <input type="text" name="num_operacion" class="form-control"
                                            placeholder="Ingrese el num de operacion" required>
                                    </div>
                                </div>
                            </div>
                            
					</div>
					<div class="col-xs-12 col-md-6">
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
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="plan">Seleccione plan</label>
									<select name="plan" id="planes-create" class="form-control" onchange="changeCaducidad(this);">
										<!-- render lista de planes -->
									</select>
								</div>
							</div>
							<div class="col-xs-12 col-md-4">
								<div class="form-group">
									<label for="suscription_end">Caduca el</label>
									<input type="date" data-validate="true" name="suscription_end" class="form-control caduca">
								</div>
								
							</div>

							<div class="col-xs-12 col-md-2">
								<div class="form-group">
									<label for="monto">Monto</label>
									<input type="number" data-validate="true" name="monto" class="form-control precio_plan" >
							</div>
								
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="medio">Medio</label>
									<select name="medio" class="form-control">
										<option value="RC">RC</option>
										<option value="TM">TM</option>
										<option value="DA">DA</option>
									</select>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<div class="form-group">
									<label for="modalidad">Modalidad</label>
									<select name="modalidad" class="form-control">
										<option value="D">Digital</option>
										<option value="F">Física</option>
										<option value="NA">Ninguna</option>
									</select>
								</div>
							</div>

							<div class="col-xs-12 col-md-12">
								<div class="form-group">
									<label for="modalidad">Gestor</label>
									<select name="gestor_a" id="gestores" class="form-control">
									</select>
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

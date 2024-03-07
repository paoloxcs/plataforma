<!-- Modal formulario de asignacion -->
<div class="modal" id="modalasign1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Formulario de asignación de curso</h4>
            </div>
            <form action="#" onsubmit="saveAsignationc(this);" method="POST" id="form-asign-c">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label for="nro_comprobante">Nro Comprobante</label>
                                <input type="text" name="nro_comprobante" class="form-control"
                                    placeholder="Ej: EB01-XXXXXXX" required="">
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label for="nro_comprobante">Moneda</label>
                                <select name="moneda" class="form-control" required="">
                                    <option value="PEN">Soles</option>
                                    <option value="USD">Dólares</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="form-group">
                                <label for="nro_comprobante">Suscripción </label>
                                <div class="form-check form-check-inline">

                                    <input class="form-check-input" name="cortesia" type="radio" value="0">
                                    <label class="form-check-label">Gratuito</label>


                                    <input class="form-check-input" name="cortesia" type="radio" value="1"
                                        checked>
                                    <label class="form-check-label">Pagado</label>
                                </div>



                            </div>
                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="nro_comprobante">Gestor</label>
                                <select name="gestor_a" class="form-control" required="">

                                </select>
                            </div>
                        </div>



                        {{-- New Campos Form --}}
                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="num_operacion">Nro de Operación</label>
                                <input type="text" name="num_operacion" class="form-control"
                                    placeholder="Ingrese el num de operacion" required>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" name="user_id">
                                <label for="gestor">Curso</label>
                                <div class="input-group">

                                    <select name="gestor" class="form-control">

                                    </select>

                                    {{-- <span class="input-group-btn">
                                   <button type="submit" class="btn btn-success" type="button">ASIGNAR</button>
                               </span> --}}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-12">
                            <div class="form-group">
                                <label for="pago_monto">Monto</label>
                                <input type="text" name="pago_monto" class="form-control"
                                    placeholder="Ingrese el monto del curso" required>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button> --}}
                    <button type="submit" class="btn btn-success">ASIGNAR</button>
                </div>
            </form>
        </div>
    </div>
</div>

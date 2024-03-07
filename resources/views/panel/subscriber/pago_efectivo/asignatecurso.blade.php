<!-- Modal formulario de asignacion -->
<div class="modal" id="modalasign1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Formulario de asignaci&oacute;n de curso</h4>
      </div>
      <div class="modal-body">
        <form action="#" onsubmit="saveAsignationc(this);" method="POST" id="form-asign-c">
        	<div class="row">
        		{{ csrf_field() }}
              <div class="col-xs-12 col-md-4">
                <div class="form-group">
                  <label for="nro_comprobante">Nro Comprobante</label>
                  <input type="text"  name="nro_comprobante" class="form-control" placeholder="Ej: EB01-XXXXXXX" required="">
                </div>
              </div>

              <div class="col-xs-12 col-md-4">
                <div class="form-group">
                  <label for="nro_comprobante">Moneda</label>
                 <select name="moneda"  class="form-control" required="">
                   <option value="PEN">Soles</option>
                   <option value="USD">Dólares</option>
                 </select>
                </div>
              </div>

              <div class="col-xs-12 col-md-4">
                <div class="form-group">        
                <label for="nro_comprobante">Suscripci&oacute;n </label> 
                  <div class="form-check form-check-inline">
                    
                    <input class="form-check-input" name="cortesia" type="radio" value="0" >
                    <label class="form-check-label" >Gratuito</label>


                    <input class="form-check-input" name="cortesia" type="radio" value="1" checked>
                    <label class="form-check-label" >Pagado</label>
                  </div>

                 
                  
                </div>
              </div>
              
             <div class="col-xs-12 col-md-12">
                <div class="form-group">
                  <label for="nro_comprobante">Gestor</label>
                <select name="gestor_a"  class="form-control" required="">
                  
                </select>
                </div>
            </div>

        	  <div class="col-md-12">
              <input type="hidden" name="user_id">
              <input type="hidden" name="pago_id">
              <input type="hidden" name="culqi_id">
                
                <label for="gestor">Curso</label>
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
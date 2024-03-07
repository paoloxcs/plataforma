<!-- Small modal -->

<div class="modal" id="modal_pagos" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header"> 
        <div class="modal-title">Reporte de pago de: <strong id="pagosde_user"></strong> 
          <p class="text-right" style="margin-top: -20px;"> Orden pago : <strong id="sig_pago"></strong></p>   
        </div>
      </div>

      <div class="modal-body">
        <table class="table table-hover table-condensed table-striped">
          <thead> 
            <th>Fecha Creada</th>
            <th>Fecha Expira</th>            
            <th>Fecha Cargo</th>
            <th>Código de Pago CIP</th>
            <th>Estado</th>
            <th>Monto</th>
          </thead>
          <tbody id="dataPagos">
            
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
         <div class="form-group">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          </div>
      </div>
      
    </div>
  </div>
</div>
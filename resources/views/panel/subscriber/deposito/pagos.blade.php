<!-- Small modal -->

<div class="modal" id="modal_pagos" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title">Lista de pagos de: <strong id="pagosde_user"></strong></div>
        </div>
      <div class="modal-body">
        <table class="table table-hover table-condensed table-striped">
          <thead>
            <th>PagoId</th>
            <th>Monto</th>
            <th>Tipo</th>
            <th>Método de pago</th>
            <th>Comprobante</th>
            <th>Nro Comprobante</th>
            <th>Fecha Pago</th>
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
<!-- Small modal -->

<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title">Nueva categoría</div>
      </div>
      <form method="POST" onsubmit="saveCategory(this)" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="modal-body">
          <div class="form-group">
            <input type="text" class="form-control" name="nombrecategoria" placeholder="Ingrese nueva categoría">
          </div>
        </div>
        <div class="modal-footer">
           <div class="form-group">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
       </form>
    </div>
  </div>
</div>
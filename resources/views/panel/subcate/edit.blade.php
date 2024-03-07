<!-- Small modal -->

<div class="modal" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="modal-title">Editar sub-categoría</div>
        </div>
    <form method="POST" onsubmit="updateSubcate(this)" enctype="multipart/form-data" id="form-edit">
      {{ csrf_field() }}
      {{ method_field('PUT') }}
      <div class="modal-body">
        <div class="form-group">
          <input type="hidden" name="idsubcate">
          <input type="text" class="form-control" name="nombresubcategoria" placeholder="Ingrese nueva Sub-categoría">
        </div>
      </div>
      <div class="modal-footer">
         <div class="form-group">
          <button type="submit"  class="btn btn-primary">Actualizar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
      </div>
     </form>
    </div>
  </div>
</div>
<!-- Small modal -->
<div class="modal" id="modal_create" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
    	<div class="modal-header">
      	<div class="modal-title">Nuevo rubro</div>
      	</div>
		<form method="POST" onsubmit="saveRubro(this)" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="modal-body row col-md-12">

				<div class="form-group col-md-6 col-xs-12">
					 <label for="">Nombre</label>
					<input type="text" class="form-control" name="nombrerubro" placeholder="Ingrese nuevo rubro" required>
				</div>

				<div class="form-group col-md-6 col-xs-12">
                        <label for="">Estado</label>
                        <select name="estado"  class="form-control rubros" required>
                           <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                        </select>
                </div>  

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Curso (300px * 265px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_curso" required>
                </div>

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Capacitación (300px * 265px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_capacitacion" required>
                </div>

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Revista (300px * 265px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_revista" required>
                </div>

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Artículo (300px * 265px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_articulo" required>
                </div>

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Suplemento (300px * 265px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_suplemento">
                </div>

                <div class="form-group col-md-6 col-xs-12">
                      <label for="">Subir Imagen de Beneficio (529px * 453px | 100KB) </label>
                      <input type="file" accept="image/*" name="img_beneficio" required>
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

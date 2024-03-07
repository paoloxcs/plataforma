<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="width:135%;">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><span class=" text-primary">Nuevo Colaborador</span></font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container">
        <form action="{{route('colaborador.store')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-row">
            <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Nombre</label>
                <input name="nombre" id="nombre"  class="form-control" placeholder="Nombre del Colaborador" required></input>
              </div>
            </div>

              <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Rubro</label>
                 <select name="rubro_id"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                          @foreach($rubros as  $rubro)
                          <option value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @endforeach
                 </select>
              </div>
            </div>

             <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Prioridad</label>
                 <select name="prioridad"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                         
                          <option value="1">Principal</option>
                          <option value="0">General</option>
                          
                 </select>
              </div>
            </div>

            <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Estado</label>
                 <select name="estado"  class="form-control rubros" required>
                          <option selected disabled><< Seleccione >></option>
                         
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                          
                 </select>
              </div>
            </div>

              <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Orden</label>
                <input type="number" name="orden" id="orden"  class="form-control" placeholder="Orden" required></input>
              </div>
            </div>

             <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="">Descripción (opcional)</label>
                <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese Descripción"></textarea>

              </div>
            </div>
            
            <div class="col-xs-12 col-md-12">
                <div class="form-group  col-md-4">
                    <label for="">Subir Logo</label>
                    <input type="file" accept="image/*" name="url_logo" required>
                 </div>
            </div>        

             <div class="col-xs-12 col-md-12">
                <div class="form-group  col-md-4">
                    <label for="">Subir Logo (White)</label>
                    <input type="file" accept="image/*" name="url_logo_w" required>
                 </div>
            </div> 

          <div class="col-xs-12 col-md-12">
                <div class="form-group  col-md-4">
                  <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Guardar</button> 
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i></i> Volver</button>
                </div>
          </div>

        </div>
  </form>
      </div>
    </div>
  </div>
</div>
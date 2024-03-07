<div class="modal fade bd-example-modal-sm12" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="width:135%;">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;"><span class=" text-primary">Nuevo Contacto</span></font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container">
        <form action="{{route('sponsorcontact.create')}}" method="POST" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-row">
            <input type="hidden" name="sponsor_id"  class="form-control" value="{{$sponsor->id}}" required></input>
            <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-4">
                <label for="inputAddress2">Nombre</label>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre del contacto"></input>
              </div>
            </div>
            <div class="col-xs-12 col-md-12">  
             <div class="form-group  col-md-4">
                      <label for="inputAddress2">email</label>
                      <input type="email" name="email" class="form-control" placeholder="email del contacto" required></input>
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
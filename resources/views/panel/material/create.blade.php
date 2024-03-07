<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="width:415px;">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nuevo Material</font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container">
        <form action="{{route('material.create')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-4">
                    <div class="form-group">
                        <label for="titulo">Nombre Documento</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Título aquí" autofocus required>
                     </div>
                </div>
                     
              </div>

              <div class="row">
                
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir archivo PDF, WORD o EXCEL</label>
                      <input type="file" accept="application/pdf,application/vnd.ms-excel,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" name="file" >
                  </div> 
                </div>
              </div>
              <input type="hidden" value="{{$curso->id}}" name="curso_id">
              
              </div>
              <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>   
       
          
        
      </form>
      </div>
    </div>
  </div>
</div>
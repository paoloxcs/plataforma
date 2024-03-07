<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4" id="myExtraLargeModalLabel"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">Nuevo Cuestionario</font></font></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerca">
          <span aria-hidden="true"><font style="vertical-align: inherit;"><font style="vertical-align: inherit;">×</font></font></span>
        </button>
      </div>
      <div class="container" style="margin-left:5%;">
        <form action="{{route('cuestionario.create')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row mx-auto">
                <div class="col-xs-12 col-md-10 mx-auto" >
                    <div class="form-group">
                        <label for="pregunta">Pregunta</label>
                        <input type="text" class="form-control" name="pregunta" placeholder="Título aquí" autofocus required>
                     </div>
                     
                     
                </div>
               
              </div>

             
              <input type="hidden" value="{{$evaluacion->id}}" name="evaluacion_id">
              
              </div>
              <div class="form-group flex-row-reverse " style="margin-left:1%;">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cerrar</button>
              </div>
            </div>   
       
          
        
      </form>
      </div>
    </div>
  </div>
</div>
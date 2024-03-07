@extends('layouts.app')
@section('titulo','cuestionario')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar cuestionario
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('cuestionario.update',$cuestionario->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="pregunta">Pregunta</label>
                        <input type="text" class="form-control" name="pregunta" placeholder="Título aquí" autofocus value="{{old('pregunta',$cuestionario->pregunta)}}">
                     </div>
                    
                </div>
                
              </div>

              
              
              </div>
              <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
              </div>
            </div>   
       
          
        
      </form>
    </div>
   
</div>

@endsection
@section('extra_scripts')

@endsection
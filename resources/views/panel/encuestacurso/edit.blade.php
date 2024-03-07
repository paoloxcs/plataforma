@extends('layouts.app')
@section('titulo','encuesta')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar encuesta
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('encuesta_curso.update',$encuesta->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus value="{{old('titulo',$encuesta->titulo)}}">
                     </div>
                    
                </div>
                 <div class="form-group col-xs-12 col-md-12">
                         <label for="infoadd">Descripción (opcional)</label>
                         <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese Descripción">{{old('descripcion',$encuesta->descripcion)}}</textarea>
                </div>
           
              </div>

              
                 <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
              </div>
              </div>
             
            </div>   
       
          
        
      </form>
    </div>
   
</div>

@endsection
@section('extra_scripts')

@endsection
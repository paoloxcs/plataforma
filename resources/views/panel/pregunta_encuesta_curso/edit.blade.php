@extends('layouts.app')
@section('titulo','pregunta')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar pregunta
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('pregunta_encuesta_curso.update',$pregunta->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-12">
                    <div class="form-group">
                        <label for="pregunta">Pregunta</label>
                        <input type="text" class="form-control" name="pregunta" placeholder="Título aquí" autofocus value="{{old('pregunta',$pregunta->pregunta)}}">
                     </div>

                     <div class="form-group">
                        <label for="tipo_respuesta">Tipo de respuesta</label>
                        <select name="tipo_respuesta"  class="form-control rubros" required>
                          @if($pregunta->tipo_respuesta==0)
                          <option value="0" selected="">VALOR</option>
                          <option value="1">TEXTO</option>
                          @else
                          <option value="0">VALOR</option>
                          <option value="1" selected="">TEXTO</option>
                          @endif
                          
                          
                        </select>
                     </div>
                    
                </div>
                  <div class="form-group col-xs-12 col-md-12">
                         <label for="infoadd">Descripción (opcional)</label>
                         <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese Descripción">{{old('descripcion',$pregunta->descripcion)}}</textarea>
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
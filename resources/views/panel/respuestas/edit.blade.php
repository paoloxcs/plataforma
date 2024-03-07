@extends('layouts.app')
@section('titulo','respuestas')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar respuesta
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('respuestas.update',$respuestas->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Respuesta</label>
                        <input type="text" class="form-control" name="respuesta" placeholder="Respuesta aquí" autofocus value="{{old('respuesta',$respuestas->respuesta)}}">
                     </div>
                    
                </div>
                <div class="col-xs-12 col-md-3">
                    
                      <div class="form-group">
                        <label for="">Opcion</label>
                        <select name="correcto"  class="form-control rubros">
                           @if($respuestas->correcto == 1)
                            <option selected value="1">Correcto</option>
                            <option value="0">Incorrecto</option>
                            @elseif($respuestas->correcto == 0)
                            <option  value="1">Correcto</option>
                            <option selected value="0">Incorrecto</option>

                            @endif
                        </select>
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
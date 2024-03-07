@extends('layouts.app')
@section('titulo','evaluacion')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar evaluacion
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('evaluacion.update',$evaluacion->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus value="{{old('titulo',$evaluacion->titulo)}}">
                     </div>
                    
                </div>
                <div class="col-xs-12 col-md-3">
                    
                      <div class="form-group">
                        <label for="titulo">Fecha de Expiración</label>
                        <input type="date" class="form-control" name="fecha" autofocus
                        value="{{old('fecha',$evaluacion->fecha)}}" required>
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
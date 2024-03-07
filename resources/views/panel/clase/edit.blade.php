@extends('layouts.app')
@section('titulo','clases')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar clase
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('clase.update',$clase->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus value="{{old('titulo',$clase->titulo)}}">
                     </div>
                     <div class="form-group">
                         <label for="infoadd">Información</label>
                         <textarea name="informacion" data-validate="true" class="form-control ckeditor"  cols="30" rows="5"   cols="30" rows="8"  placeholder="Ingrese información" required>{{old('informacion',$clase->informacion)}}</textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-3">
                      <div class="form-group">
                        <label for="titulo">Código Zoom</label>
                        <input type="text" class="form-control" name="codigo_zoom" placeholder="Código de Zoom aquí" autofocus value="{{old('codigo_zoom',$clase->zoom_codigo_url)}}">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Video Código</label>
                        <input type="text" class="form-control" name="codigo_video" placeholder="Código de video aquí" autofocus value="{{old('codigo_video',$clase->video_codigo)}}">
                     </div>

                     <div class="form-group">
                        <label for="">Estado</label>
                        <select name="estado"  class="form-control rubros">
                           @if($clase->estado == 1)
                            <option selected value="1">Activo</option>
                            <option value="0">Inactivo</option>
                            @elseif($clase->estado == 0)
                            <option  value="1">Activo</option>
                            <option selected value="0">Inactivo</option>

                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Fecha</label>
                        <input type="date" class="form-control" name="fecha" autofocus
                        value="{{old('fecha',$clase->fecha)}}" required>
                     </div>

                      <div class="form-group">
                        <label for="time">Hora</label>
                        <input type="time" class="form-control" name="time" autofocus value="{{old('time',$clase->time)}}" 
                        required>
                     </div>

                    <div class="form-group">
                        <label for="">Hora Expiración</label>
                        <input type="time" class="form-control" name="time_exp" autofocus value="{{old('time',$clase->time_exp)}}">
                    </div>
                    
                </div>
              </div>

              <div class="row">
                
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir Portada</label>
                      <input type="file" accept="image/*" name="portada">
                  </div>
                </div>
                
              </div>
              
              
              </div>
              <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
              </div>
            </div>   
       
          
        
      </form>
    </div>
   
</div>

@endsection
@section('extra_scripts')

@endsection
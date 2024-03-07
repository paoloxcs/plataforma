@extends('layouts.app')
@section('titulo','Cursos')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar curso
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('curso.update',$curso->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus value="{{old('titulo',$curso->titulo)}}">
                     </div>
                    
                     <div class="form-group">
                         <label for="infoadd">Información</label>
                         <textarea name="informacion"  cols="30" rows="5" class="form-control" placeholder="Ingrese información">{{old('informacion',$curso->informacion)}}</textarea>
                     </div>

                      <div class="form-group">
                         <label for="infoadd">Descripción</label>
                         <textarea name="descripcion"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese descripcion" required>{{old('descripcion',$curso->descripcion)}}</textarea>
                     </div>

                      <div class="form-group">
                         <label for="infoadd">Objetivos</label>
                         <textarea name="objetivos"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese objetivos" required>{{old('descripcion',$curso->objetivos)}}</textarea>
                     </div>

                     <div class="form-group">
                         <label for="infoadd">Público</label>
                         <textarea name="publico"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese publico" required>{{old('descripcion',$curso->publico)}}</textarea>
                     </div>


                     

                      <div class="form-group">
                         <label for="infoadd">Beneficios</label>
                         <textarea name="beneficios"  data-validate="true" class="form-control ckeditor"  cols="30" rows="5"  placeholder="Ingrese beneficios" required>{{old('beneficios',$curso->beneficios)}}</textarea>
                     </div>


                      <div class="row">
                
                
                
              </div>
                </div>
                <div class="col-xs-12 col-md-3">
                    <div class="form-group">
                        <label for="">Elegir rubro</label>
                        <select name="rubro_id"  class="form-control rubros">
                          <option selected disabled><< Seleccione >></option>
                          @foreach($rubros as  $rubro)
                          @if($curso->rubro_id == $rubro->idrubro)
                          <option selected value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @else
                          <option value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @endif
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Elegir Docente</label>
                        <select name="autor_id"  class="form-control rubros">
                          <option selected disabled><< Seleccione >></option>
                          @foreach($autores as  $autor)
                          @if($curso->autor_id == $autor->idautor)
                          <option selected value="{{$autor->idautor}}">{{$autor->nombre}}</option>
                          @else
                          <option value="{{$autor->idautor}}">{{$autor->nombre}}</option>
                          @endif
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Soles)</label>
                        <input type="number" class="form-control" name="precio" placeholder="Precio no suscriptor aquí (PEN)" autofocus value="{{old('precio',$curso->precio)}}" required="">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Soles)</label>
                        <input type="number" class="form-control" name="promocion" placeholder="Precio suscriptor aquí (PEN)" autofocus value="{{old('promocion',$curso->promocion)}}" required="">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Dólares)</label>
                        <input type="number" class="form-control" name="precio_d" placeholder="Precio no suscriptor aquí (USD)" autofocus required value="{{old('precio_d',$curso->precio_d)}}" >
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Dólares)</label>
                        <input type="number" class="form-control" name="promocion_d" placeholder="Precio suscriptor aquí (USD)" autofocus required="" value="{{old('promocion_d',$curso->promocion_d)}}" >
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio No suscriptor (Culminado)</label>
                        <input type="number" class="form-control" name="precio_c" placeholder="Precio no suscriptor una vez culminado el curso" autofocus value="{{old('precio_c',$curso->precio_c)}}" >
                     </div>

                     <div class="form-group">
                        <label for="titulo">Precio Suscriptor (Culminado)</label>
                        <input type="number" class="form-control" name="promocion_c" placeholder="Precio suscriptor una vez culminado el curso" autofocus value="{{old('promocion_c',$curso->promocion_c)}}" >
                     </div>

                     <div class="form-group">
                        <label for="">Estado</label>
                        <select name="estado"  class="form-control rubros">
                           @if($curso->estado == 1)
                            <option selected value="1">Activo</option>
                            <option value="0">Inactivo</option>
                            @elseif($curso->estado == 0)
                            <option  value="1">Activo</option>
                            <option selected value="0">Inactivo</option>

                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="titulo">Fecha</label>
                        <input type="date" class="form-control" name="fecha" autofocus value="{{old('fecha',$curso->fecha)}}">
                     </div>

                     <div class="form-group">
                        <label for="time">Hora</label>
                        <input type="time" class="form-control" name="time" autofocus value="{{old('time',$curso->time)}}" 
                        required>
                     </div>

                     <div class="form-group">
                        <label for="titulo">Fecha de culminación</label>
                        <input type="date" class="form-control" name="fecha_culminacion" autofocus value="{{old('fecha_culminacion',$curso->fecha_culminacion)}}">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Fecha de expiración</label>
                        <input type="date" class="form-control" name="expira" autofocus value="{{old('expira',$curso->expira)}}">
                     </div>

                     <div class="form-group">
                        <label for="titulo">Url video preview</label>
                        <input type="text" class="form-control" name="url_video_preview"  value="{{old('url_video_preview',$curso->url_video_preview)}}" >
                    </div>

                    <hr>
                    <h5 style="text-align: center;color:#dc3545;font-weight: 900">Descuento para cursos en vivo</h5>
                    <div class="form-group">
                        <label for="porcentaje_d_v">Porcentaje</label>
                        <input type="number" class="form-control" name="porcentaje_d_v"  value="{{old('porcentaje_d_v',$curso->porcentaje_d_v)}}">
                    </div>


                    <div class="form-group">
                        <label for="fecha_d_v">Fecha límite</label>
                        <input type="date" class="form-control" name="fecha_d_v"  value="{{old('fecha_d_v',$curso->fecha_d_v)}}">
                    </div>
                   
                    
                </div>
              </div>
              <div class="row col-xs-12 col-md-11" >
                     

              </div>    
              <div class="row"> 
                <div class="col-xs-12 col-md-4">
                     <div class="form-group">
                        <label for="">Subir Portada (opcional)</label>
                        <input type="file" accept="image/*" name="portada" >
                    </div>
                </div>

                 <div class="col-xs-12 col-md-4">
                         <div class="form-group">
                            <label for="">Subir Certificado</label>
                            <input type="file" accept="image/*" name="certificado" >
                        </div>
                </div>
              </div>

              
              <h4>---- Banner ----</h4>
              <div class="row">
                
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir Portada (1350px * 500px | 100KB) opcional</label>
                      <input type="file" accept="image/*" name="banner_portada" >
                  </div>
                </div>
                
              </div>
                <div class="row">
                  <div  class="col-xs-12 col-md-10">
                       <label for="infoadd">Descripción</label>
                      <input type="text" name="banner_descripcion"  class="form-control" placeholder="Ingrese descripción" value="{{old('banner_descripcion',$curso->banner_descripcion)}}" required></input>
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
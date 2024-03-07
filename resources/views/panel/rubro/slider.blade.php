@extends('layouts.app')
@section('titulo','Cursos')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Slider Rubro
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('rubro.slider.create')}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
              <div class="row">
                 <input type="hidden" name="idrubro"   value="{{$rubro->idrubro}}">
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" class="form-control" name="titulo" placeholder="Título aquí" autofocus value="">
                     </div>

                     <div class="form-group">
                         <label for="infoadd">Descripcion</label>
                         <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese descripcion"></textarea>
                     </div>
                </div>
                <div class="col-xs-12 col-md-3">

                    <div class="form-group">
                        <label for="">URL</label>
                        <input type="text" class="form-control" name="url" placeholder="url" autofocus value="">
                    </div>

                    <div class="form-group">
                        <label for="">Orden</label>
                        <input type="number" class="form-control" name="orden" placeholder="orden" autofocus value="">
                    </div>

                    <div class="form-group">
                        <label for="">Estado</label>
                        <select name="estado"  class="form-control rubros">
                          
                            <option selected value="1">Activo</option>
                            <option value="0">Inactivo</option>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Visualización para</label>
                        <select name="acceso"  class="form-control rubros">
                          
                            <option selected value="1">Todos</option>
                            <option value="0">Solo Free</option>
                            
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Tipo</label>
                        <select name="type"  class="form-control rubros">
                          
                            <option selected value="principal">Principal</option>
                            <option value="curso">Curso</option>
                            <option value="capacitacion">Capacitación</option>
                            <option value="serie">Serie</option>
                            <option value="revista">Revista</option>
                            <option value="articulo">Artículo</option>
                            <option value="suplemento">Suplemento</option>

                            
                        </select>
                    </div>



                    
                   
                    
                </div>
              </div>
              
              <h4>---- Imágenes ----</h4>
              <div class="row">
                
                <div class="col-xs-12 col-md-6">
                   <div class="form-group">
                      <label for="">Subir Portada(Desktop) (1350px * 392px | 200KB)</label>
                      <input type="file" accept="image/*" name="img_desktop" >
                  </div>
                </div>

                <div class="col-xs-12 col-md-6">
                   <div class="form-group">
                      <label for="">Subir Portada(Phone) (360px * 501px | 100KB)</label>
                      <input type="file" accept="image/*" name="img_phone" >
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

<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i>Lista de Sliders
      </li>
    </ol>
    <div class="panel panel-success">
      
        <div class="modal-body">
              
              <div class="table-responsive" id="contenedor">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>Estado</th>
                          <th>Id</th>
                          <th>Tipo</th>
                          <th>título</th>
                          <th>Img Desktop</th>
                          <th>Img Phone</th>
                          <th>Acción</th>
                  </thead>
                  @foreach($sliders as  $slider)
                  <tbody>
                       <tr>
                        @if($slider->estado==1)
                    <td><i class="fa fa-check"></i></td>
                    @else
                  <td><i class="fa fa-times"></i></td>
                    @endif
                    <td>{{$slider->id}}</td>
                    <td>{{$slider->type}}</td>
                    <td>{{$slider->titulo}}</td>
                    <td>
                    <img class="img-responsive" width="100" src="{{asset('imgRubro/'.$slider->img_desktop)}}" alt="">
                    </td>
                    <td>
                    <img class="img-responsive" width="100" src="{{asset('imgRubro/'.$slider->img_phone)}}" alt="">
                    </td>

                    <td width="200">
                    <a href="{{route('rubro.geteditSlider',$slider->id)}}" class="btn btn-success btn-sm"><i class="fa fa-trash" ></i> Editar</a>

                    <a onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" href="{{route('slider.delete',$slider->id)}}" onclick="return confirm('ADVERTENCIA:\n¿Seguro de eliminar el registro?')" class="btn btn-danger btn-sm"><i class="fa fa-trash" ></i> Eliminar</a>
                   
                    
                  </td>
                  </tr>
                  </tbody>
                  @endforeach
                 
              </table>
          </div>
          <div class="row">
             <div class="col-xs-12 col-md-4">
                 <div class="input-group custom-pagination">
                  <!-- Render pagination here -->
                  {{$sliders->render()}}
                 </div>
              </div>
          </div>
                
              
              
        </div>
                
       
          
        
    
    </div>
    
   
</div>
@endsection
@section('extra_scripts')

@endsection
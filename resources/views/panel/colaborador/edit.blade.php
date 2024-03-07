@extends('layouts.app')
@section('content')
<div class="container">
   <h3 class="text-center">Editar Registro</h3>
   <br>
   <div class="col-xs-12 col-md-12 col-sm-12 row" >
   <div class="col-xs-8  mx-auto" style="margin: 0 27%;">
       <div class="panel-title text-center h4"></div>
              
        <form action="{{route('colaborador.update',$colaborador->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
          
         <div class="form-group col-md-12">
            <div class="form-group col-md-8">
                <label for="inputAddress2">Nombre</label>
                <input name="nombre"  class="form-control" placeholder="Nombre del patrocinador" required value="{{old('nombre',$colaborador->nombre)}}"></input>
              </div>
         </div>

         
              <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-8">
                <label for="inputAddress2">Rubro</label>
                 <select name="rubro_id"  class="form-control rubros" required>
                          
                          @foreach($rubros as  $rubro)
                          @if($colaborador->rubro_id==$rubro->idrubro)
                          <option selected value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @else
                           <option value="{{$rubro->idrubro}}">{{$rubro->nombrerubro}}</option>
                          @endif
                         
                          @endforeach
                 </select>
              </div>
            </div>

             <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-8">
                <label for="inputAddress2">Prioridad</label>
                <select name="prioridad"  class="form-control rubros">
                           @if($colaborador->prioridad == 1)
                            <option selected value="1">Principal</option>
                            <option value="0">General</option>
                            @elseif($colaborador->prioridad == 0)
                            <option  value="1">Principal</option>
                            <option selected value="0">General</option>

                            @endif
                        </select>
              </div>
            </div>

            <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-8">
                <label for="inputAddress2">Estado</label>
                <select name="estado"  class="form-control rubros">
                           @if($colaborador->estado == 1)
                            <option selected value="1">Activo</option>
                            <option value="0">Inactivo</option>
                            @elseif($colaborador->estado == 0)
                            <option  value="1">Activo</option>
                            <option selected value="0">Inactivo</option>

                            @endif
                        </select>
              </div>
            </div>

              <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-8">
                <label for="inputAddress2">Orden</label>
                <input type="number" name="orden" id="orden"  class="form-control" placeholder="Orden" required value="{{old('orden',$colaborador->orden)}}"></input>
              </div>
            </div>

             <div class="col-xs-12 col-md-12">
             <div class="form-group col-md-8">
                <label for="">Descripción (opcional)</label>
                <textarea name="descripcion"  cols="30" rows="5" class="form-control" placeholder="Ingrese Descripción">{{old('descripcion',$colaborador->descripcion)}}</textarea>

              </div>
            </div>


         <div class="form-group col-md-12">
             <div class="form-group  col-md-8">
                    <label for="">Subir Logo</label>
                    <input type="file" accept="image/*" name="url_logo">
                 </div>
         </div>

         <div class="form-group col-md-12">
             <div class="form-group  col-md-8">
                    <label for="">Subir Logo (White)</label>
                    <input type="file" accept="image/*" name="url_logo_w">
                 </div>
         </div>



          <div class="col-xs-12 col-md-12">
                  <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Actualizar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
                  </div>
                </div>
        </form>
          </div>
</div>
    </div>
@endsection
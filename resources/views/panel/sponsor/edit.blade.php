@extends('layouts.app')
@section('content')
<div class="container">
   <h3 class="text-center">Editar Registro</h3>
   <br>
   <div class="col-xs-12 col-md-12 col-sm-12 row" >
   <div class="col-xs-8  mx-auto" style="margin: 0 27%;">
       <div class="panel-title text-center h4"></div>
              
        <form action="{{route('sponsor.update',$sponsor->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
          
         <div class="form-group col-md-12">
            <div class="form-group col-md-8">
                <label for="inputAddress2">Nombre</label>
                <input name="nombre"  class="form-control" placeholder="Nombre del patrocinador" required value="{{old('nombre',$sponsor->nombre)}}"></input>
              </div>
         </div>

          <div class="form-group col-md-12">
            <div class="form-group col-md-8">
                <label for="inputAddress2">url Web</label>
                <input name="url_web"   class="form-control" placeholder="url web" required value="{{old('url_web',$sponsor->url_web)}}"></input>
              </div>
         </div>


         <div class="form-group col-md-12">
             <div class="form-group  col-md-4">
                    <label for="">Subir Logo</label>
                    <input type="file" accept="image/*" name="url_logo">
                 </div>
         </div>


          <div class="col-xs-12 col-md-12">
                  <div class="form-group col-md-10">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
                  </div>
                </div>
        </form>
          </div>
</div>
    </div>
@endsection
@extends('layouts.app')
@section('content')
<div class="container">
   <h3 class="text-center">Editar Registro</h3>
   <br>
   <div class="col-xs-12 col-md-12 col-sm-12 row" >
   <div class="col-xs-8  mx-auto" style="margin: 0 27%;">
       <div class="panel-title text-center h4"></div>
              
        <form action="{{route('sponsormaterial.update',$sponsormaterial->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
          
         <div class="form-group col-md-12">
            <div class="form-group col-md-8">
                <label for="inputAddress2">Nombre</label>
                <input name="nombre"  class="form-control" placeholder="Nombre del contacto" value="{{old('nombre',$sponsormaterial->doc_name)}}" required></input>
              </div>
         </div>

          <div class="form-group col-md-12">
            <div class="form-group col-md-8">
                <label for="">Subir archivo PDF</label>
                <input type="file" accept="application/pdf" name="file">
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
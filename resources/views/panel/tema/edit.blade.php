@extends('layouts.app')
@section('content')
<div class="container">
   <h3 class="text-center">Editar Registro</h3>
   <br>
   <div class="col-xs-12 col-md-12 col-sm-12 row" >
   <div class="col-xs-8  mx-auto" style="margin: 0 17%;">
       <div class="panel-title text-center h4"></div>
              
        <form action="{{route('tema.update',$tema->id)}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
          <div class="form-group">

            <input type="hidden" class="form-control" id="curso_id" name="curso_id" aria-describedby="emailHelp" value="{{($tema->curso_id)}}">
            <small id="emailHelp" class="form-text text-muted"></small>
          </div>
                <div class="form-group col-md-12">
                  <label for="inputAddress2">Descripción</label>
                  <textarea name="descripcion" id="descripcion" rows="4" class="form-control" placeholder="Descripción del tema"  style="margin-top: 0px; margin-bottom: 0px; height: 93px;" required>{{old('descripcion',$tema->descripcion)}}</textarea>
                </div>
          <div class="col-xs-12 col-md-12">
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                <a href="javascript:history.back();" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Regresar</a>
                  </div>
                </div>
        </form>
          </div>
</div>
    </div>
@endsection
@extends('layouts.app')
@section('titulo','materiales')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Editar material
      </li>
    </ol>
    <div class="panel panel-success">
        
        <form action="{{route('material.update',$material->id)}}" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
      
        <div class="modal-body">
           <div class="row" >
                <div class="col-xs-12 col-md-8">
                    <div class="form-group">
                        <label for="titulo">Nombre Documento</label>
                        <input type="text" class="form-control" name="nombre" placeholder="Título aquí" autofocus required value="{{old('nombre',$material->nombre_documento)}}">
                     </div>
                </div>
                     
             
                
                <div class="col-xs-12 col-md-4">
                   <div class="form-group">
                      <label for="">Subir archivo PDF</label>
                      <input type="file" accept="application/pdf,application/vnd.ms-excel,.doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document"  name="file" >
                  </div> 
                </div>
              
              </div>
          <div class="row" style="margin-left:0.3%;">
              <div class="form-group flex-row-reverse ">
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
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
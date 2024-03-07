@extends('layouts.front')
@section('titulo','Reportar')
@section('content')
<div class="container">
  <div class="col-xs-12 col-md-6 mx-auto mt-3 mb-3">
    <div class="card">
      <div class="card-header">
        <div class="card-title text-center">REPORTAR PROBLEMA</div>
      </div>
      <div class="card-body">
        <form method="POST" action="{{route('reportbug')}}">
          {{ csrf_field() }}
          <div class="form-group">
            <label for="subject">Asunto</label>
            <input type="text" name="asunto" class="form-control" id="asunto" aria-describedby="subject" placeholder="Ingrese asunto">                  
          </div>
          <div class="form-group">
            <label for="exampleInputPassword1">Mensaje</label>
            <textarea name="mensaje" class="form-control" rows="5" placeholder="Detalle el problema siendo lo más específico posible. Tener en cuenta que si tiene inconvenientes al descargar Suplemento Técnico, por favor indique la edición."></textarea>
          </div>
          <div class="mt-2 text-center">
            <button type="submit" class="btn btn-blue">Enviar</button>
          </div>               
          
        </form>  
      </div>
    </div>
  </div>
</div>
@endsection
@extends('layouts.front')
@section('titulo')
{{"Participando ". $curso->titulo}}
@endsection
@section('content')

<section class="col-md-12 bg-gris" style="padding-bottom: 5%; ">
 <div class="card-success bg-white mt-5 col-md-4 col-xs-11 mx-auto">
    <p class="text-center "><i class="fas fa-check-circle i-check"></i></p>
    <h1 class="text-center font-weight">¡LISTO!</h1>
    <h5 class="text-center">Ya puedes acceder a tu curso</h5>
    <p class="text-center mt-5"><a href="{{route('getcurso',$curso->slug)}}" class="btn-pago">IR A MI CURSO</a></p>
 </div>
</section>

@endsection
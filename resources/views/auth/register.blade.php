@extends('layouts.front')
@section('titulo', 'Crear cuenta')
@section('content')

    <div class="bg-gris">


        <div class="modal-body col-md-7 mx-auto row pbm-0 mt-5 mt-0-mob bg-white">
            <section class="col-md-5 none-mobile pbm-0" style="margin:0">
                {{-- <img class=" pbm-0" src="{{asset('images/img-login.png')}}" width="100%"> --}}
                {{-- Form Age_Profession --}}
                <img class="pbm-0 img__Access" src="{{ asset('images/img-login.png') }}" width="100%">
            </section>
            <section class="col-md-6 mx-auto   col-xs-12 pbm-0 ">
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="position:absolute;top: 1%;right: 1%"></button> --}}

                <p class="text-center mt-5 mt-2-mob"><i class="fas fa-user" style="font-size: 30px"></i>
                </p>
                <h3 class="font-weight text-center mt-5-mob ">Crea una cuenta</h3>
                {{-- <p class="text-center">Lorem ipsum dolor sit amet, consectetur. </p> --}}
                {{-- <a href="" class="btn-100 btn-f" style="width: 80%;margin-left: 10%"><i class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Regístrate con Facebook</a>
                <a href="" class="btn-100 btn-g" style="width: 80%;margin-left: 10%"><i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Regístrate con Google</a>
                <p class="font-weight text-center mt-4">o también</p> --}}
                <form action="{{ route('register') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row col-md-12 pbm-0">
                        @include('components.form_registro')

                        <button type="submit" class="btn-100 btn-green mt-2" id="btn_registro"
                            style="width: 90%;margin-left: 5%">REGISTRARME</button>
                    </div>
                </form>
                {{-- NEW NAV --}}
                <p class="text-center font-weight mt-2">¿Ya tienes cuenta?
                    <a class="font-a-crear" type="button"href="{{ route('login') }}"> Ingresa aquí</a>
                </p>

            </section>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}


        </div>

        <div class="none-mobile">
            <br>
            <br>
        </div>


    </div>
@endsection

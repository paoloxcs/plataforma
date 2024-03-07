@extends('layouts.front')
@section('titulo', 'Regístrate Gratis')
@section('content')

    <div class="bg-gris">


        {{-- <div class="modal-body col-md-7 mx-auto row pbm-0 mt-5 mt-0-mob bg-white" > --}}
        <div class="modal-body col-md-9 mx-auto row pbm-0 mt-5 mt-0-mob bg-white">
            <section class="col-md-5 pbm-0 none-mobile">
                {{-- Form Age_Profession --}}
                <img class="pbm-0 img__Access"src="{{ asset('images/img-create.png') }}" width="105%">
            </section>
            <section class="col-md-7 col-xs-12 pbm-0 s-login">
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}

                <p class="text-center mt-5 mt-2-mob"><i class="fas fa-user" style="font-size: 30px"></i>
                </p>
                <h3 class="font-weight text-center mt-2">Bienvenido a Plataforma Constructivo</h3>
                {{-- <p class="text-center">Disfruta la experiencia con nosotros</p> --}}
                <a href="{{ url('login/facebook') }}" class="btn-100 btn-f"><i
                        class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Ingresar con Facebook</a> 
                <a href="{{ url('login/google') }}" class="btn-100 btn-g"><i
                        class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Ingresar con Google</a>
                <p class="font-weight text-center mt-3">o también</p>
                <form class="mt-5" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input class="form-control btn-100 form-btn-login {{ $errors->has('email') ? ' is-invalid' : '' }}"
                            id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp"
                            placeholder="Correo eléctronico" value="{{ old('email') }}" autofocus>
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input
                            class="form-control btn-100 form-btn-login {{ $errors->has('password') ? ' is-invalid' : '' }}"
                            id="exampleInputPassword1" name="password" type="password" placeholder="Contraseña">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="form-check form-check-login">
                            <label class="form-check-label">
                                <input class="form-check-input " type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                Recordar contraseña</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-100 btn-green mt-4">INICIAR SESIÓN</button>

                </form>
                {{-- NEW NAV --}}
                <p class="text-center font-weight mt-5">¿Olvidaste tu contraseña?
                    <a class="font-a-crear" type="button" type="button" data-bs-toggle="modal"
                        data-bs-target="#modal-recuperar"> Ingresa aquí</a>
                </p>
                <hr>
                <p class="text-center">
                    <a class="font-a-crear text-lg" type="button"href="{{ route('register') }}">O crea tu cuenta gratis</a>
                </p>

            </section>
        </div>

        <div class="none-mobile">
            <br>
            <br>
        </div>


    </div>
@endsection

@extends('layouts.front')
@section('titulo','Regístrate Gratis')
@section('content')

<div class="bg-gris">
  
     
    <div class="modal-body col-md-7 mx-auto row pbm-0 mt-5 mt-0-mob bg-white" >
        <section class="col-md-5 none-mobile pbm-0" style="margin:0">
           <img class=" pbm-0" src="{{asset('images/img-login.png')}}" width="100%">
        </section>
        <section class="col-md-6 mx-auto   col-xs-12 pbm-0 bg-white ">
      
           <p class="text-center mt-5 mt-2-mob"><i class="fas fa-user" style="font-size: 30px" ></i></p>
           <h3 class="font-weight text-center mt-5-mob ">Crea una cuenta</h3>
           {{--<p class="text-center">Lorem ipsum dolor sit amet, consectetur. </p> --}}
           {{--<a href="" class="btn-100 btn-f" style="width: 80%;margin-left: 10%"><i class="fab fa-facebook-f"></i>&nbsp;&nbsp;&nbsp;Regístrate con Facebook</a>
            <a href="" class="btn-100 btn-g" style="width: 80%;margin-left: 10%"><i class="fab fa-google"></i>&nbsp;&nbsp;&nbsp;Regístrate con Google</a>
            <p class="font-weight text-center mt-4">o también</p>--}}
            <form action="{{route('register')}}" method="POST"> 
              {{ csrf_field() }}
            <!-- <div class="row col-md-12 pbm-0">
              <div class="form-group col-xs-12 col-md-6">
                  <input class="form-control btn-100 {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" aria-describedby="nameHelp" placeholder="Nombres" autofocus value="{{old('name')}}">
                   @if ($errors->has('name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('name') }}</strong>
                     </span>
                  @endif
              </div>
              <div class="form-group col-xs-12 col-md-6">
                  <input class="form-control btn-100 {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" aria-describedby="nameHelp" placeholder="Apellidos" value="{{old('last_name')}}">
                   @if ($errors->has('last_name'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('last_name') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                <input class="form-control btn-100 {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" aria-describedby="emailHelp" placeholder="Correo electrónico" value="{{old('email')}}">
                 @if ($errors->has('email'))
                   <span class="invalid-feedback">
                       <strong>{{ $errors->first('email') }}</strong>
                   </span>
                @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <input type="number" name="phone_number" class="form-control btn-100 {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="Telf. / Movil">
                   @if ($errors->has('phone_number'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('phone_number') }}</strong>
                     </span>
                  @endif
              </div>
              
              <div class="form-group col-xs-12 col-md-6">
                  <input id="password" type="password" class="form-control btn-100 {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña">
                   @if ($errors->has('password'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('password') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <input id="password-confirm" type="password" class="form-control btn-100" name="password_confirmation" placeholder="Confirmar contraseña">
                </div>

              <div class="form-group col-xs-12 col-md-6">
                  <select  name="pais" class="form-select form-select-sm select-suple btn-100 form-control btn-100 {{ $errors->has('pais') ? ' is-invalid' : '' }}" >
                  <option disabled="" selected="">País</option>
                  <option value="Argentina">Argentina</option>
                          <option value="Bolivia">Bolivia</option>
                          <option value="Chile">Chile</option>
                          <option value="Colombia">Colombia</option>
                          <option value="Ecuador">Ecuador</option>
                          <option value="México">México</option>
                          <option value="Perú">Perú</option>
                          <option value="Otro">Otro</option>
                </select>
                @if ($errors->has('pais'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('pais') }}</strong>
                     </span>
                  @endif
              </div>

              <div class="form-group col-xs-12 col-md-6">
                  <select  name="medio" class="form-select form-select-sm select-suple btn-100 form-control btn-100 {{ $errors->has('medio') ? ' is-invalid' : '' }}" >
                    <option disabled="" selected="">Área de interés</option>
                    <option value="1">Construcción</option>
                    <option value="2">Arquitectura y Diseño</option>
                    <option value="3">Minería</option>
                </select>
                @if ($errors->has('medio'))
                     <span class="invalid-feedback">
                         <strong>{{ $errors->first('medio') }}</strong>
                     </span>
                  @endif
              </div>


                <button type="submit" class="btn-100 btn-green mt-2" style="width: 90%;margin-left: 5%">REGISTRARME</button> --> 
                <div class="row col-md-12 pbm-0">
                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input class="form-control btn-100 form-btn-i {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text" name="name" aria-describedby="nameHelp" placeholder="Nombres" autofocus value="{{old('name')}}">
                        @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input class="form-control btn-100 form-btn-i {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text" name="last_name" aria-describedby="nameHelp" placeholder="Apellidos" value="{{old('last_name')}}">
                        @if ($errors->has('last_name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('last_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input class="form-control btn-100 form-btn-i {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email" name="email" aria-describedby="emailHelp" placeholder="Correo electrónico" value="{{old('email')}}">
                        @if ($errors->has('email'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input type="number" name="phone_number" class="form-control btn-100 form-btn-i {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder="Telf. / Movil">
                        @if ($errors->has('phone_number'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('phone_number') }}</strong>
                            </span>
                        @endif
                    </div>
                    
                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <select name="pais" class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('pais') ? ' is-invalid' : '' }}" >
                            <option disabled="" selected="">País</option>
                            <option value="Argentina">Argentina</option>
                                    <option value="Bolivia">Bolivia</option>
                                    <option value="Chile">Chile</option>
                                    <option value="Colombia">Colombia</option>
                                    <option value="Ecuador">Ecuador</option>
                                    <option value="México">México</option>
                                    <option value="Perú" selected>Perú</option>
                                    <option value="Otro">Otro</option>
                        </select>
                        @if ($errors->has('pais'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('pais') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <select  name="medio" class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('medio') ? ' is-invalid' : '' }}" >
                            <option disabled="" selected="">Área de interés</option>
                            <option value="1">Construcción</option>
                            <option value="2">Arquitectura y Diseño</option>
                            <option value="3">Minería</option>
                        </select>
                        @if ($errors->has('medio'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('medio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input id="password" type="password" class="form-control btn-100 form-btn-i {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="Contraseña">
                        @if ($errors->has('password'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group col-xs-12 col-md-6 form-col-p">
                        <input id="password-confirm" type="password" class="form-control btn-100 form-btn-i" name="password_confirmation" placeholder="Confirmar contraseña">
                    </div>

                    <button type="submit" class="btn-100 btn-green mt-2" style="width: 90%;margin-left: 5%">REGISTRARME</button>
                </div>

            </form>

            <p class="text-center font-weight mt-2">¿Ya tienes cuenta? <a class="font-weight" type="button"  data-bs-toggle="modal" data-bs-target="#modal-login"> Ingresa aquí</a></p>

        </section>
        {{--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}

       
      </div>

      <div class="none-mobile">
         <br>
      <br>
      </div>
     

</div>
@endsection
<form action="{{ route('register.uni.store') }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="name" class="">Nombres (*)</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text"
                name="name" id="name" aria-describedby="nameHelp" placeholder="Nombres" autofocus
                value="{{ old('name') }}">
            @if ($errors->has('name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="last_name" class="">Apellidos (*)</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('last_name') ? ' is-invalid' : '' }}"
                type="text" name="last_name" id="last_name" aria-describedby="nameHelp" placeholder="Apellidos"
                value="{{ old('last_name') }}">
            @if ($errors->has('last_name'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('last_name') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-4 relative">
            {{-- <label for="phone_number" class="label-form">Telf. / Movil (*)</label> --}}
            <input type="number" name="phone_number" id="phone_number"
                class="form-control btn-100 form-btn-i {{ $errors->has('phone_number') ? ' is-invalid' : '' }}"
                placeholder="Teléfono" value="{{ old('phone_number') }}">
            @if ($errors->has('phone_number'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('phone_number') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-8 relative">
            {{-- <label for="correo" class="label-form">Correo electrónico (*)</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('email') ? ' is-invalid' : '' }}"
                type="email" name="email" id="correo" aria-describedby="emailHelp"
                placeholder="Correo electrónico" value="{{ old('email') }}">
            @if ($errors->has('email'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-8 relative">
            {{-- <label for="address" class="label-form">Correo electrónico (*)</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('address') ? ' is-invalid' : '' }}"
                type="text" name="address" id="address" placeholder="Dirección" value="{{ old('address') }}">
            @if ($errors->has('address'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group col-xs-12 col-md-4 relative">
            {{-- <label for="medio" class="label-form">Área de interés (*)</label> --}}
            <select name="medio" id="medio"
                class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('medio') ? ' is-invalid' : '' }}">
                <option disabled selected>Área de interés</option>
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

        <div class="form-group col-xs-12 col-md-4 relative">
            {{-- <label for="doc_number" class="label-form">Correo electrónico (*)</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('doc_number') ? ' is-invalid' : '' }}"
                type="text" name="doc_number" id="doc_number" placeholder="DNI/Pasaporte/RUC"
                value="{{ old('doc_number') }}">
            @if ($errors->has('doc_number'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('doc_number') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-4 relative">
            {{-- <label for="age" class="label-form">Fecha de Nacimiento</label> --}}
            <?php $fecha = date('Y-m-d'); ?>
            <input type="date" name="age" id="age"
                class="form-control btn-100 form-btn-i {{ $errors->has('age') ? ' is-invalid' : '' }}" placeholder=""
                value="{{ old('age') }}" max="{{ $fecha }}" onchange="fecha_nacimiento(this.value)">
            @if ($errors->has('age'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('age') }}</strong>
                </span>
            @endif
            <span class="invalid-feedback" id="invalid_FN">
            </span>
        </div>


        <div class="form-group col-xs-12 col-md-4 relative">
            {{-- <label for="pais" class="label-form">País (*)</label> --}}
            <select name="pais" id="pais"
                class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('pais') ? ' is-invalid' : '' }}">
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

        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="profession" class="label-form">Profesión</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('profession') ? ' is-invalid' : '' }}"
                type="text" name="profession" id="profession" placeholder="Profesión"
                value="{{ old('profession') }}">
            @if ($errors->has('profession'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('profession') }}</strong>
                </span>
            @endif
        </div>


        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="cargo_user" class="label-form">Profesión</label> --}}
            <input class="form-control btn-100 form-btn-i {{ $errors->has('cargo_user') ? ' is-invalid' : '' }}"
                type="text" name="cargo_user" id="cargo_user" placeholder="Programa/Carrera"
                value="{{ old('cargo_user') }}">
            @if ($errors->has('cargo_user'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('cargo_user') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="password" class="label-form">Contraseña (*)</label> --}}
            <input id="password" type="password"
                class="form-control btn-100 form-btn-i {{ $errors->has('password') ? ' is-invalid' : '' }}"
                name="password" placeholder="Contraseña">
            @if ($errors->has('password'))
                <span class="invalid-feedback">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
        </div>

        <div class="form-group col-xs-12 col-md-6 relative">
            {{-- <label for="password-confirm" class="label-form">Confirmar contraseña (*)</label> --}}
            <input id="password-confirm" type="password" class="form-control btn-100 form-btn-i "
                name="password_confirmation" placeholder="Confirmar contraseña">
        </div>


        @if (isset($active_uni))
            <input type="hidden" name="active_uni" value="{{ $active_uni }}">
        @endif

        <div class="px-4">
            <button type="submit" class="btn btn-register-uni my-5 py-3 br-5 w-100" id="btn_registro"  >
                Activar suscripción por 6 meses
            </button>

        </div>
    </div>
</form>

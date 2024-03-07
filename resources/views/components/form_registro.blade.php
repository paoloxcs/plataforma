<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="name" class="label-form">Nombres (*)</label>
    <input class="form-control btn-100 form-btn-i {{ $errors->has('name') ? ' is-invalid' : '' }}" type="text"
        name="name" id="name" aria-describedby="nameHelp" placeholder="" autofocus value="{{ old('name') }}">
    @if ($errors->has('name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </span>
    @endif
</div>
<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="last_name" class="label-form">Apellidos (*)</label>
    <input class="form-control btn-100 form-btn-i {{ $errors->has('last_name') ? ' is-invalid' : '' }}" type="text"
        name="last_name" id="last_name" aria-describedby="nameHelp" placeholder="" value="{{ old('last_name') }}">
    @if ($errors->has('last_name'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('last_name') }}</strong>
        </span>
    @endif
</div>

<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="correo" class="label-form">Correo electrónico (*)</label>
    <input class="form-control btn-100 form-btn-i {{ $errors->has('email') ? ' is-invalid' : '' }}" type="email"
        name="email" id="correo" aria-describedby="emailHelp" placeholder="" value="{{ old('email') }}">
    @if ($errors->has('email'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('email') }}</strong>
        </span>
    @endif
</div>

{{-- Form Age_Profession --}}
<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="phone_number" class="label-form">Telf. / Movil (*)</label>
    <input type="number" name="phone_number" id="phone_number"
        class="form-control btn-100 form-btn-i {{ $errors->has('phone_number') ? ' is-invalid' : '' }}" placeholder=""
        value="{{ old('phone_number') }}">
    @if ($errors->has('phone_number'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('phone_number') }}</strong>
        </span>
    @endif
</div>

<div class="form-group col-xs-12 col-md-6 form-col-p relative d-none d-lg-block">
    <label for="pais" class="label-form">País (*)</label>
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

<div class="form-group col-xs-12 col-md-6 form-col-p relative d-none d-lg-block">
    <label for="medio" class="label-form">Área de interés (*)</label>
    <select name="medio" id="medio"
        class="form-select form-select-sm select-suple btn-100 form-control btn-100 form-btn-s {{ $errors->has('medio') ? ' is-invalid' : '' }}">
        <option disabled="" selected="">Área de interés (*)</option>
        <option value="1" selected>Construcción</option>
        <option value="2">Arquitectura y Diseño</option>
        <option value="3">Minería</option>
    </select>
    @if ($errors->has('medio'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('medio') }}</strong>
        </span>
    @endif
</div>

{{-- Form Age_Profession --}}
<div class="form-group col-xs-12 col-md-6 form-col-p relative d-none d-lg-block">
    <label for="age" class="label-form">Fecha de Nacimiento</label>
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

<div class="form-group col-xs-12 col-md-6 form-col-p relative d-none d-lg-block">
    <label for="profession" class="label-form">Profesión</label>
    <input class="form-control btn-100 form-btn-i {{ $errors->has('profession') ? ' is-invalid' : '' }}" type="text"
        name="profession" id="profession" placeholder="" value="{{ old('profession') }}">
    @if ($errors->has('profession'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('profession') }}</strong>
        </span>
    @endif
</div>

<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="password" class="label-form">Contraseña (*)</label>
    <input id="password" type="password"
        class="form-control btn-100 form-btn-i {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"
        placeholder="">
    @if ($errors->has('password'))
        <span class="invalid-feedback">
            <strong>{{ $errors->first('password') }}</strong>
        </span>
    @endif
</div>

<div class="form-group col-xs-12 col-md-6 form-col-p relative">
    <label for="password-confirm" class="label-form">Confirmar contraseña (*)</label>
    <input id="password-confirm" type="password" class="form-control btn-100 form-btn-i "
        name="password_confirmation" placeholder="">
</div>
<script>
    function fecha_nacimiento(value) {
        var fecha_seleccionada = value;
        var fecha_nacimiento = new Date(fecha_seleccionada);
        var fecha_Actual = new Date();
        var edad = (parseInt((fecha_Actual - fecha_nacimiento) / (1000 * 60 * 60 * 24 * 365)));
        if (edad < 18) {
            document.getElementById("invalid_FN").style.display = "block";
            document.getElementById("invalid_FN").innerHTML = "<strong>La fecha de nacimineto es menor de 18+</strong>";
            document.getElementById("btn_registro").disabled = true;
        } else if (edad > 151) {
            document.getElementById("invalid_FN").style.display = "block";
            document.getElementById("invalid_FN").innerHTML =
                "<strong>La fecha de nacimineto no puede exeder de 150</strong>";
            document.getElementById("btn_registro").disabled = true;
        } else {
            document.getElementById("invalid_FN").style.display = "none";
            document.getElementById("invalid_FN").innerHTML = " ";
            document.getElementById("btn_registro").disabled = false;
        }
    }
</script>

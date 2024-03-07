<div class="card-suplemento card-boxp col-md-11 row card-curso mt-2">
    <div class="item-card col-md-12 col-xs-12 px-2 py-3">
        <div class="div_PlusInfo" onclick="plus_info()">
            <h5 class="text_PlusInfo">
                Necesito más información
                <div class="border__cursosText"></div>
            </h5>

            <i class="fas fa-angle-down"></i>
            <i class="fas fa-angle-up"></i>
        </div>
        {{-- <i class="fas fa-angle-down"></i>
        <i class="fas fa-angle-up"></i> --}}
        {{-- </div> --}}
        {{-- @include('alerts.success') --}}

        @php
            if (Auth::user()) {
                $name = auth()
                    ->user()
                    ->fullName();
                $email = auth()->user()->email;
                $phone_number = auth()->user()->phone_number;
            } else {
                $name = null;
                $email = null;
                $phone_number = null;
            }
        @endphp
        <div class="hidden lg:block px-2">
            <form action="{{ route('mailCursoInteres') }}">
                <div class="form-group px-1 py-1">
                    <input type="hidden" name="slug" value="{{ $curso->slug }}">
                    <label for="name" class="font-weight">Nombre y Apellidos:</label>
                    <input type="text" name="name" id="name" class="form-control btn-100 input__FormCurso"
                        placeholder="Nombre y Apellidos" value="{{ old('name', $name) }}">
                </div>
                <div class="form-group px-2 py-1">
                    <label for="email" class="font-weight">Correo Eléctronico:</label>
                    <input type="email" name="email" id="email" class="form-control btn-100 input__FormCurso"
                        placeholder="Correo Eléctronico" value="{{ old('email', $email) }}">
                </div>
                <div class="form-group px-2 py-1">
                    <label for="phone" class="font-weight">Télefono / Móvil:</label>
                    <input type="number" name="phone" id="phone" class="form-control btn-100 input__FormCurso"
                        placeholder="Télefono / Móvil" value="{{ old('phone', $phone_number) }}">
                </div>

                <div class="form-group mt-2 px-4">
                    <button type="submit" class="btn-100 btn-green btn__FormCurso">ENVIAR</button>
                </div>
            </form>
        </div>

    </div>
</div>

@if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d'))
    <div class="d_descuento_p col-xs-12 mt-4 py-2">
        <div class="col-md-11 row mx-auto">
           <div class="col-md-4 col-xs-4 pbm-0">
                <p class="c-white p-porcentaje pbm-0" style="text-align: center !important;">{{ $curso->porcentaje_d_v }}%</p>
            </div>
            <div class="col-md-8 col-xs-8 pbm-0 d-flex justify-content-center align-items-start flex-column">
                <p class="c-white pbm-0">De descuento en el curso</p>
                <p class="font-weight c-white pbm-0">Válido hasta el {{ $dia_n }} de
                    {{ $mes }} {{ $año_n }}</p>
            </div> 
        </div>
    </div>
@endif
    {{-- FORM INFO --}}
    @if ($curso->fecha_culminacion >= date('Y-m-d'))
        <div class="hidden lg:block">
            @include('web.form-curso')
        </div>
    @endif
    {{-- @else --}}
    {{-- FORM INFO --}}
    {{-- @if ($curso->fecha_culminacion >= date('Y-m-d'))
        <div class="hidden lg:block">
            @include('web.form-curso')
        </div>
    @endif --}}

<div class="sticky top-28 pb-z lg:pb-16">

    @if ($curso->fecha_culminacion <= date('Y-m-d'))
        @if ($curso->precio_c != null)
            @if (!\Auth::guest())
                @if (Auth()->user()->isPremium())
                    <div class="card-suplemento  mt-3" id="card-suplemento">
                        <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                        <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>

                            @if ($descuento > 0)
                                <p class="text-center pbm-0 font-weight"><span class="p-sus">{{ $descuento }}%
                                        Dscto.
                                        <span style="font-size: 17px; text-decoration: line-through">S/.
                                            {{ $curso->precio_c }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </span></p>
                            @endif

                            <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;">
                                <span class="s-simbolo">S/</span>&nbsp;&nbsp;{{ $curso->promocion_c }}
                            </h2>


                            <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar"
                                    style="font-size:18px">
                                    Solo para suscriptores</span></p>






                            <p class="text-center mt-2"><a href="{{ url('/curso/card/' . $curso->slug . '/' . 'pen') }}"
                                    class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR
                                    CURSO</a></p>


                        </div>


                    </div>
                @else
                    <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                        <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                        <div class="bla mt-3">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>

                            @if ($descuento > 0)
                                <p class="text-center pbm-0 font-weight"><span class="p-sus">{{ $descuento }}%
                                        Dscto.
                                        <span style="font-size: 17px; text-decoration: line-through">S/.
                                            {{ $curso->precio_c }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                    </span></p>
                            @endif

                            <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;">
                                <span class="s-simbolo">S/</span>&nbsp;&nbsp;{{ $curso->promocion_c }}
                            </h2>


                            <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar"
                                    style="font-size:18px">
                                    Solo para suscriptores</span></p>





                            @if (!\Auth::guest())
                                <a class="a-menu a-menu-b nav-link text-center mt-3"
                                    href="{{ route('planes', $curso->rubro->slug) }}" style="cursor:pointer">COMPRAR
                                    CURSO</a>
                            @else
                                <p class="text-center mt-2"><a
                                        href="{{ url('/login?redirect_to=' . route('planes', $curso->rubro->slug)) }}"
                                        class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR
                                        CURSO</a></p>
                            @endif
                        </div>


                    </div>


                    {{-- <div class="card-suplemento mt-3 mt-5-mob card-suplemento">
                        <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en
                            todos los cursos</h5>
                        <div class=" mt-3">
                            <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de
                                capacitaciones, publicaciones y mucho más!</p>

                            <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion"
                                    class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase"
                                    style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>


                        </div>


                    </div> --}}
                @endif
            @else
                <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                    <h4 class="text-center font-weight">PRECIO SUSCRIPTOR</h4>
                    <div class="bla mt-3">
                        <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>


                        @if ($descuento > 0)
                            <p class="text-center pbm-0 font-weight"><span class="p-sus">{{ $descuento }}%
                                    Dscto. <span style="font-size: 17px; text-decoration: line-through">S/.
                                        {{ $curso->precio_c }}</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                                </span></p>
                        @endif

                        <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;">
                            <span class="s-simbolo">S/</span>&nbsp;&nbsp;{{ $curso->promocion_c }}
                        </h2>


                        <p class="text-center pbm-0 font-weight"><span class="font-weight v-dolar"
                                style="font-size:18px">
                                Solo para suscriptores</span></p>





                        @if (!\Auth::guest())
                            <a class="a-menu a-menu-b nav-link text-center mt-3"
                                href="{{ url('/curso/card/' . $curso->slug . '/' . 'pen') }}"
                                style="cursor:pointer">COMPRAR CURSO</a>
                        @else
                            <p class="text-center mt-2"><a
                                    href="{{ url('/login?redirect_to=' . url('/curso/card/' . $curso->slug . '/' . 'pen')) }}"
                                    class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR
                                    CURSO</a></p>
                        @endif
                    </div>


                </div>

                {{-- <div class="card-suplemento mt-3 mt-5-mob card-suplemento">
                    <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en
                        todos los cursos</h5>
                    <div class=" mt-3">
                        <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de
                            capacitaciones, publicaciones y mucho más!</p>

                        <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion"
                                class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase"
                                style="cursor:pointer">¡Quiero ser Suscriptor!</a></p>


                    </div>


                </div> --}}


            @endif
        @endif
    @else
        @if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d'))
            {{-- <div class="d_descuento_p col-xs-12 mt-4 py-2">
                <div class="col-md-11 row mx-auto">
                    <div class="col-md-4 col-xs-4 pbm-0">
                        <p class="c-white p-porcentaje pbm-0">{{ $curso->porcentaje_d_v }}%</p>
                    </div>
                    <div class="col-md-8 col-xs-8 pbm-0"
                        style="
                    justify-content: center;
                    align-items: start;
                    display: flex;
                    flex-direction: column;">
                        <p class="c-white pbm-0">De descuento en el curso</p>
                        <p class="font-weight c-white pbm-0">Válido hasta el {{ $dia_n }} de
                            {{ $mes }} {{ $año_n }}</p>
                    </div>
                </div>
    
            </div> --}}

            {{-- FORM INFO --}}
            {{-- @if ($curso->fecha_culminacion >= date('Y-m-d'))
                <div class="hidden lg:block">
                    @include('web.form-curso')
                </div> 
            @endif --}}

            <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                <h4 class="text-center font-weight">Inscríbete ahora en este curso
                    <div class="bla mt-3 row mx-1">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
                            <div class="px-2">
                                <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>
                                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight"
                                        style="text-decoration:line-through;">S/ {{ $curso->precio }}</span></p>
                                <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;">
                                    <span class="s-simbolo">S/</span>&nbsp;&nbsp;{{ $precio_d_f_s }}
                                </h2>

                               @if ($curso->slug != 'conferencia-internacional-la-creatividad-consciente-en-el-diseno-interior-645359122cdf9')
                                    {{-- 2023-03-31 18:00:53 --}}
                                    @php
                                        // $fecha_curso = strtotime($curso->created_at->format('Y-m-d'));
                                        $fecha_curso = strtotime($curso->created_at);
                                        // $fecha_web = strtotime(date('Y-m-d h:i:s'));
                                        $fecha_web = strtotime('2023-03-31 18:00:53');
                                    @endphp
                                    @if (
                                        $curso->rubro->slug == 'construccion' or
                                            $curso->rubro->slug == 'mineria' or
                                            $curso->rubro->slug != 'arquitectura-y-diseno')
                                        @if ($fecha_curso >= $fecha_web)
                                            <p class="mt-1 text-center mb-1" style="font-size:15px">Incluye 1 año en la
                                                Plataforma Constructivo</p>
                                        @endif
                                    @endif
                                @endif

                                <p class="text-center pbm-0"><a type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>

                            </div>

                            <div class="px-2">
                                <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>
                                <p class="text-center pbm-0 p-antes p-antes-c">Antes: <span class="font-weight"
                                        style="text-decoration:line-through;">S/ {{ $curso->promocion }}</span></p>
                                <p class="text-center pbm-0 font-weight"><span class="p-sus">S/
                                        {{ $promocion_d_p_s }}<span></span></p>
                                {{-- @if ($curso->rubro->slug == 'arquitectura-y-diseno')
                                <p class="text-center pbm-0"><a href="{{ route('planes', $rubro->slug) }}"
                                        class="v-dolar v-planes">Ver nuestros planes</a></p>
                            @endif --}}
                            </div>
                        </div>

                        {{-- @if ($curso->rubro->slug == 'construccion' or $curso->rubro->slug == 'mineria')
                        <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                        <p class="mt-3 text-center">Incluye 1 año en la Plataforma Constructivo</p>
                    @endif --}}




                        @if (!\Auth::guest())
                            <a class="a-menu a-menu-b nav-link text-center mt-3"
                                href="{{ url('/curso/card/' . $curso->slug . '/' . 'pen') }}"
                                style="cursor:pointer">COMPRAR
                                CURSO</a>
                        @else
                            <p class="text-center mt-2"><a
                                    href="{{ url('/login?redirect_to=' . url('/curso/card/' . $curso->slug . '/' . 'pen')) }}"
                                    class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR
                                    CURSO</a></p>
                        @endif
                    </div>

            </div>
            {{-- CAMBIOS JHED --}}
            @include('web.card-pay')
            {{-- CAMBIOS JHED --}}
        @else
            {{-- Validacion que no funciona --}}
            {{-- FORM INFO --}}
            {{-- @if ($curso->fecha_culminacion >= date('Y-m-d'))
                <div class="hidden lg:block">
                    @include('web.form-curso')
                </div> 
            @endif --}}
            <div class="card-suplemento mt-3 mt-5-mob" id="card-suplemento">
                <h4 class="text-center font-weight">Inscríbete ahora en este curso</h4>
                <div class="bla mt-3 row mx-1">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1 gap-6">
                        <div class="px-2">
                            <h4 class="font-weight pbm-0 text-center">Precio del curso</h4>

                            <h2 class="font-weight mt-2 text-center" style="padding-bottom: 0px;margin-bottom:0px;">
                                <span class="s-simbolo">S/</span>&nbsp;&nbsp;{{ $curso->precio }}
                            </h2>

                           @if ($curso->slug != 'conferencia-internacional-la-creatividad-consciente-en-el-diseno-interior-645359122cdf9')
                                    {{-- 2023-03-31 18:00:53 --}}
                                    @php
                                        // $fecha_curso = strtotime($curso->created_at->format('Y-m-d'));
                                        $fecha_curso = strtotime($curso->created_at);
                                        // $fecha_web = strtotime(date('Y-m-d h:i:s'));
                                        $fecha_web = strtotime('2023-03-31 18:00:53');
                                    @endphp
                                    @if (
                                        $curso->rubro->slug == 'construccion' or
                                            $curso->rubro->slug == 'mineria' or
                                            $curso->rubro->slug != 'arquitectura-y-diseno')
                                        @if ($fecha_curso >= $fecha_web)
                                            <p class="mt-1 text-center mb-1" style="font-size:15px">Incluye 1 año en la
                                                Plataforma Constructivo</p>
                                        @endif
                                    @endif
                                @endif

                                <p class="text-center pbm-0"><a type="button" data-bs-toggle="modal"
                                        data-bs-target="#modal-precioD" class="v-dolar">Ver en dólares</a></p>
                        </div>


                        <div class="px-2">
                            <h5 class="text-center mt-3 pbm-0 font-weight">Precio suscriptor </h5>

                            <p class="text-center pbm-0 font-weight"><span class="p-sus">S/
                                    {{ $curso->promocion }}<span></span></p>
                            {{-- @if ($curso->rubro->slug == 'arquitectura-y-diseno')
                                <p class="text-center pbm-0"><a href="{{ route('planes', $rubro->slug) }}"
                                        class="v-dolar v-planes">Ver nuestros planes</a></p>
                            @endif --}}
                        </div>
                    </div>

                    {{-- @if ($curso->rubro->slug == 'construccion' or $curso->rubro->slug == 'mineria')
                        <p class="mt-3 text-center-mob">Incluye 1 año en la Plataforma Constructivo</p>
                        <p class="mt-3 text-center">Incluye 1 año en la Plataforma Constructivo</p>
                    @endif --}}


                    @if (!\Auth::guest())
                        <a class="a-menu a-menu-b nav-link text-center mt-3"
                            href="{{ url('/curso/card/' . $curso->slug . '/' . 'pen') }}"
                            style="cursor:pointer">COMPRAR
                            CURSO</a>
                    @else
                        <p class="text-center mt-2"><a
                                href="{{ url('/login?redirect_to=' . url('/curso/card/' . $curso->slug . '/' . 'pen')) }}"
                                class="a-menu a-menu-b nav-link text-center mt-3" style="cursor:pointer">COMPRAR
                                CURSO</a></p>
                    @endif
                </div>


            </div>
            {{-- CAMBIOS JHED --}}
            @include('web.card-pay')
            {{-- CAMBIOS JHED --}}
        @endif

        {{-- @if ($curso->rubro->slug == 'arquitectura-y-diseno')
            <div class="card-suplemento mt-3 mt-5-mob card-suplemento">
                <h5 class="text-center font-weight c-gris-black">Vuélvete Suscriptor y obtén descuentos en todos
                    los cursos</h5>
                <div class=" mt-3">
                    <p class="font-weight pbm-0 text-center c-gris-black">¡Además accede a videos de
                        capacitaciones, publicaciones y mucho más!</p>

                    <p class="text-center mt-2"><a href="/planes-de-suscripcion/construccion"
                            class="a-menu a-menu-b nav-link text-center mt-3 tt-uppercase"
                            style="cursor:pointer">¡Quiero
                            ser Suscriptor!</a></p>


                </div>


            </div>
        @endif --}}
    @endif
</div>

@extends('layouts.front')
@section('titulo')
    Check out
@endsection
@section('content')
    <section class="col-md-12 bg-gris" style="padding-bottom: 5%; ">
        <div class="d-flex justify-content-center">
            <img class="max-w-full" src="{{ asset('images/gracias.png') }}" alt="">
        </div>
        @if (session('success_pay'))
            @php
                $payment = session('success_pay');
                $curso = $payment['course'];
                $plan = $payment['plan'];
                $purchasenumber = $payment['purchasenumber'];
                $simbolo = $payment['simbolo'];
                $precio_r = $payment['precio_r'];
                $precio = $payment['precio'];
                $descuento = $payment['descuento'];
                $method = $payment['method'];
                $suscriptor_recurrente = $payment['suscriptor_recurrente'];
            @endphp

            <section class="col-md-10 col-xs-12 mt-4 mx-auto">
                {{-- <h2 class="font-weight text-center-mob">Gracias por tu compra</h2> --}}
                <h5 class="text-center-mob">Resumen de la compra</h5>
            </section>

            <section class="col-12 mt-3 px-3-1 md:px-28">
                <div class="card-pago bg-white mt-2-mob" style="padding: 2.5% 5% 2.5% 5%;">

                    @if ($plan)
                        <div class="div-sub">
                            <p>Subtotal</p>
                            <p class="p-right">{{ $simbolo }} {{ $precio }}</p>
                        </div>

                        <div class="div-sub mt-2">
                            <p>Descuento</p>
                            <p class="p-right">{{ $simbolo }} 00.00</p>
                        </div>
                        <hr>

                        <div class="div-sub mt-2">
                            <p>TOTAL</p>
                            <p class="p-right">{{ $simbolo }} {{ $precio }}</p>
                        </div>
                        <hr>
                    @else
                        <div class="div-sub">
                            <p>Subtotal</p>
                            @if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d'))
                                <p class="p-right">{{ $simbolo }} {{ $precio_r }}</p>
                            @else
                                <p class="p-right">{{ $simbolo }} {{ $precio_r }}</p>
                            @endif
                        </div>

                        <div class="div-sub mt-2">
                            <p>Descuento</p>
                            @if ($curso->porcentaje_d_v > 0 and $curso->fecha_d_v >= date('Y-m-d'))
                                <p class="p-right">{{ $simbolo }} {{ $descuento }} </p>
                            @else
                                <p class="p-right">{{ $simbolo }} {{ $descuento }} </p>
                            @endif
                        </div>
                        <hr>

                        <div class="div-sub mt-2">
                            <p>TOTAL</p>
                            <p class="p-right">{{ $simbolo }} {{ $precio }}</p>
                        </div>
                        <hr>
                    @endif

                </div>
            </section>

            <section class="mt-3 px-3-1 md:px-28">
                <div class="grid grid-cols-1 lg:grid-cols-2">
                    <div class="card-pago bg-white mt-2-mob m-2 px-4 py-2">
                        <h4 class="font-weight text-center-mob">Datos del usuario</h4>
                        <div class="py-2">
                            <strong>Nombre:</strong>
                            <span>{{ auth()->user()->fullname() }}</span>
                        </div>
                        <div class="py-2">
                            <strong>Correo:</strong>
                            <span>{{ auth()->user()->email }}</span>
                        </div>
                        <div class="py-2">
                            <strong>Teléfono:</strong>
                            <span>{{ auth()->user()->phone_number }}</span>
                        </div>
                    </div>
                    <div class="card-pago bg-white mt-2-mob m-2 px-4 py-2">
                        <h4 class="font-weight text-center-mob">Datos de la compra</h4>
                        @if ($plan)
                            <div class="py-2">
                                <strong>Plan:</strong>
                                <span>
                                    {{ $plan->name }}
                                    / por {{ $plan->meses }} meses
                                </span>
                            </div>
                            <div class="py-2">
                                <strong>Fecha Inicio:</strong>
                                <span> {{ $suscriptor_recurrente->suscription_init }}</span>
                            </div>
                            <div class="py-2">
                                <strong>Fecha Culmina:</strong>
                                <span> {{ $suscriptor_recurrente->suscription_end }}</span>
                            </div>
                        @else
                            <div class="py-2">
                                <strong>Curso:</strong>
                                <span>
                                    {{ $curso->titulo }}
                                </span>
                            </div>
                            <div class="py-2">
                                <strong>Rubro:</strong>
                                <span>
                                    {{ $curso->rubro->nombrerubro }}
                                </span>
                            </div>
                            <div class="py-2">
                                <strong>Autor:</strong>
                                <a href="{{ route('getAutor', $curso->autor->slug) }}" class="td-none">
                                    {{ $curso->autor->nombre }}
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </section>


            <section class="mt-3 px-3-1 md:px-28">
                <div class="card-pago bg-white mt-2-mob text-center py-2">
                    <strong>Se le ha enviado un correo con los datos de su compra a
                        <a href="mailto:{{ auth()->user()->email }}"
                            style="text-decoration: none">{{ auth()->user()->email }}</a>
                    </strong>
                </div>
            </section>


            <section class="mt-3 px-3-1 md:px-28 text-center">
                @if ($plan)
                    <a href="{{ route('home') }}" class="a-menu-b " style="text-decoration: none;color:#fff">
                        Ir al inicio</a>
                @else
                    <a href="{{ route('getcurso', $curso->slug) }}" class="a-menu-b "
                        style="text-decoration: none;color:#fff">
                        Ir al curso</a>
                @endif
            </section>

            @section('script-extra')
                <script>
                    var email = '{{ auth()->user()->email }}';
                    var value = '{{ $precio }}'; 
                    var transaction_id = '{{ $purchasenumber }}';
                    var phone_number = '{{ auth()->user()->phone_number }}';


                    dataLayer.push({
                        'event': 'purchase',
                        'value': value,
                        'transaction_id': transaction_id,
                        'email': email,
                        'phone_number': phone_number
                    })
                </script>
            @endsection


        @endif
    </section>
@endsection

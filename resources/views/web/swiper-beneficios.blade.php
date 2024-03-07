@section('style-extra')
    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}">
@endsection

{{-- <section class="col-md-5 text pbm-0">
    <h1 class="font-weight mt-5  mt-2-mob h1-40 text-center-mob" style="">Disfruta de los Beneficios qué te Ofrece
        Plataforma Constructivo:</h1>
    <section class="col-md-11">
        <div class="swiper mySwiper" id="swiper4">
            <div class="swiper-wrapper">
                <section class="col-md-11 swiper-slide">
                    <section class="">
                        <section class="">
                            <img class="" src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">A TU PROPIO RITMO: </span>Todo el contenido desde la comodidad
                                de tu hogar, tiempo libre en tu oficina.</p>

                        </section>

                    </section>
                    <section class="">
                        <section class="">
                            <img src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">CONTENIDO DESCARGABLE: </span>Descarga el contenido a tu
                                dispositivo Móvil o PC para verlo sin conexión.</p>

                        </section>
                    </section>
                    <section class="">
                        <section class="">
                            <img src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">COMUNIDAD: </span>Aplica el contenido aprendido en tus propios
                                proyectos profesionales.</p>

                        </section>
                    </section>

                </section>

                <section class="col-md-11 swiper-slide">
                    <section class="">
                        <section class="">
                            <img src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">EN CUALQUIER LUGAR: </span>Accede a todo el contenido desde tu
                                PC, tablet o smartphone.</p>
                        </section>

                    </section>
                    <section class="">
                        <section class="">
                            <img src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">APRENDE AÚN MÁS: </span>Comenta tus dudas, pide feedback y/o
                                aporta soluciones.</p>
                        </section>
                    </section>
                    <section class="">
                        <section class="">
                            <img src="{{ asset('images/icon1.png') }}">
                        </section>
                        <section class="px-4">
                            <p><span class="font-weight">MÁS CONTENIDO: </span>Capacítate según tus intereses y el orden
                                de tu preferencia.</p>
                        </section>
                    </section>

                </section>

            </div>
            <br><br>
            <div class="swiper-pagination" id="swiper-pagination4"></div>
        </div>
    </section>
</section> --}}

<div class="px-2 md:px-12">
    <h1 class="font-weight mt-2 md:mt-5  mt-2-mob h1-40 text-center-mob" style="">Disfruta de los Beneficios qué te Ofrece
        Plataforma Constructivo:</h1>
    <div class="slide-container ">
        <div class="flex flex-row relative">
            <div class="slide-content-benef swiper">
                <div class=" swiper-wrapper">
                    {{-- Content part 1 --}}
                    <section class="swiper-slide">
                        <section class="flex py-2">
                            <section class="">
                                <img class="" src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">A TU PROPIO RITMO: </span>Todo el contenido desde la
                                    comodidad
                                    de tu hogar, tiempo libre en tu oficina.</p>

                            </section>

                        </section>
                        <section class="flex py-2">
                            <section class="">
                                <img src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">CONTENIDO DESCARGABLE: </span>Descarga el contenido a tu
                                    dispositivo Móvil o PC para verlo sin conexión.</p>

                            </section>
                        </section>
                        <section class="flex py-2">
                            <section class="">
                                <img src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">COMUNIDAD: </span>Aplica el contenido aprendido en tus
                                    propios
                                    proyectos profesionales.</p>

                            </section>
                        </section>

                    </section>
                    {{-- Content part 2 --}}
                    <section class="swiper-slide">
                        <section class="flex py-2">
                            <section class="">
                                <img src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">EN CUALQUIER LUGAR: </span>Accede a todo el contenido desde
                                    tu
                                    PC, tablet o smartphone.</p>
                            </section>

                        </section>
                        <section class="flex py-2">
                            <section class="">
                                <img src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">APRENDE AÚN MÁS: </span>Comenta tus dudas, pide feedback
                                    y/o
                                    aporta soluciones.</p>
                            </section>
                        </section>
                        <section class="flex py-2">
                            <section class="">
                                <img src="{{ asset('images/icon1.png') }}">
                            </section>
                            <section class="px-4">
                                <p><span class="font-weight">MÁS CONTENIDO: </span>Capacítate según tus intereses y el
                                    orden
                                    de tu preferencia.</p>
                            </section>
                        </section>

                    </section>

                </div>

                <div class="d-flex justify-content-center mt-4" style="margin-left: 7rem">
                    <div class="swiper-pagination-benef px-4"></div>
                </div>
            </div>
            {{-- <br><br>
            <div class="swiper-pagination" id="swiper-pagination4"></div> --}}
        </div>
    </div>
</div>


@section('script-extra')
    <!-- Swiper JS -->
    {{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

    <!-- JavaScript -->
    <script src="{{ asset('swiper/js/script.js') }}"></script>
@endsection
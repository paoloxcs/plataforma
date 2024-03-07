{{-- <section class="col-md-10 col-xs-10 row pbm-0 swiper" id="swiper">
    <section class="swiper-wrapper pbm-0-mob">

        <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
            <div class="c-tipo">
                <a href={{ route('getcursosP', $rubro->slug) }}><img
                        src="{{ asset('imgRubro/' . $rubro->img_curso) }}" width="100%"></a>
                <div class="text text-center-mob text-center">
                    <p><a href="{{ route('getcursosP', $rubro->slug) }}" class="td-none c-white">CURSOS EN
                            VIVO</a></p>
                    <p class="left-green none-mobile"><a href="{{ route('getcursosP', $rubro->slug) }}"><i
                                class="fas fa-chevron-right"></i></a></p>
                </div>
            </div>
        </div>
        @if ($rubro->slug == 'arquitectura-y-diseno')
            <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
                <div class="c-tipo">
                    <a href="{{ route('serieRubro', $rubro->slug) }}"><img
                            src="{{ asset('imgRubro/series.jpg') }}" width="100%"></a>
                    <div class="text text-center-mob text-center">
                        <p><a class="td-none c-white"
                                href="{{ route('serieRubro', $rubro->slug) }}">SERIES</a></p>
                        <p class="left-green none-mobile"><a
                                href="{{ route('serieRubro', $rubro->slug) }}"><i
                                    class="fas fa-chevron-right"></i></a></p>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
            <div class="c-tipo">
                <a href="{{ route('videoRubro', $rubro->slug) }}"><img
                        src="{{ asset('imgRubro/' . $rubro->img_capacitacion) }}" width="100%"></a>
                <div class="text text-center-mob text-center">
                    <p><a class="td-none c-white"
                            href="{{ route('videoRubro', $rubro->slug) }}">CAPACITACIÓN</a></p>
                    <p class="left-green none-mobile"><a href="{{ route('videoRubro', $rubro->slug) }}"><i
                                class="fas fa-chevron-right"></i></a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
            <div class="c-tipo">
                <a href="{{ route('revistas', $medio) }}"><img
                        src="{{ asset('imgRubro/' . $rubro->img_revista) }}" width="100%"></a>
                <div class="text text-center-mob text-center">
                    <p><a class="td-none c-white" href="{{ route('revistas', $medio) }}">REVISTAS</a></p>
                    <p class="left-green none-mobile"><a href="{{ route('revistas', $medio) }}"><i
                                class="fas fa-chevron-right"></i></a></p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
            <div class="c-tipo">
                <a href="{{ route('articuloRubro', $rubro->slug) }}"><img
                        src="{{ asset('imgRubro/' . $rubro->img_articulo) }}" width="100%"></a>
                <div class="text text-center-mob text-center">
                    <p><a class="td-none c-white"
                            href="{{ route('articuloRubro', $rubro->slug) }}">ARTÍCULOS</a></p>
                    <p class="left-green none-mobile"><a
                            href="{{ route('articuloRubro', $rubro->slug) }}"><i
                                class="fas fa-chevron-right"></i></a></p>
                </div>
            </div>
        </div>

        @if ($rubro->slug == 'construccion')
            <div class="col-md-3 col-xs-12 swiper-slide pbm-0-mob">
                <div class="c-tipo">
                    <a href="{{ route('suplementos') }}"><img
                            src="{{ asset('imgRubro/' . $rubro->img_suplemento) }}" width="100%"></a>
                    <div class="text text-center-mob text-center">
                        <p><a class="td-none c-white" href="{{ route('suplementos') }}">SUPLEMENTO</a>
                        </p>
                        <p class="left-green none-mobile"><a href="{{ route('suplementos') }}"><i
                                    class="fas fa-chevron-right"></i></a></p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</section> --}}

@section('style-extra')
    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
    <!-- CSS -->
    {{-- <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}"> --}}
@endsection

<div class="slide-container swiper">
    <div class="flex flex-row relative">
        <div class="slide-content-contenido">
            <div class="card-wrapper swiper-wrapper">
                <div class="swiper-slide">
                    <div class="c-tipo">
                        <a href={{ route('getcursosP', $rubro->slug) }}><img
                                src="{{ asset('imgRubro/' . $rubro->img_curso) }}" width="100%"></a>
                        <div class="text text-center-mob text-center">
                            <p><a href="{{ route('getcursosP', $rubro->slug) }}" class="td-none c-white">CURSOS EN
                                    VIVO</a></p>
                            <p class="left-green none-mobile"><a href="{{ route('getcursosP', $rubro->slug) }}"><i
                                        class="fas fa-chevron-right"></i></a></p>
                        </div>
                    </div>
                </div>
                @if ($rubro->slug == 'arquitectura-y-diseno')
                    <div class="swiper-slide">
                        <div class="c-tipo">
                            <a href="{{ route('serieRubro', $rubro->slug) }}"><img
                                    src="{{ asset('imgRubro/series.jpg') }}" width="100%"></a>
                            <div class="text text-center-mob text-center">
                                <p><a class="td-none c-white" href="{{ route('serieRubro', $rubro->slug) }}">SERIES</a>
                                </p>
                                <p class="left-green none-mobile"><a href="{{ route('serieRubro', $rubro->slug) }}"><i
                                            class="fas fa-chevron-right"></i></a></p>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="swiper-slide">
                    <div class="c-tipo">
                        <a href="{{ route('videoRubro', $rubro->slug) }}"><img
                                src="{{ asset('imgRubro/' . $rubro->img_capacitacion) }}" width="100%"></a>
                        <div class="text text-center-mob text-center">
                            <p><a class="td-none c-white"
                                    href="{{ route('videoRubro', $rubro->slug) }}">CAPACITACIÓN</a></p>
                            <p class="left-green none-mobile"><a href="{{ route('videoRubro', $rubro->slug) }}"><i
                                        class="fas fa-chevron-right"></i></a></p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="c-tipo">
                        <a href="{{ route('revistas', $medio) }}"><img
                                src="{{ asset('imgRubro/' . $rubro->img_revista) }}" width="100%"></a>
                        <div class="text text-center-mob text-center">
                            <p><a class="td-none c-white" href="{{ route('revistas', $medio) }}">REVISTAS</a></p>
                            <p class="left-green none-mobile"><a href="{{ route('revistas', $medio) }}"><i
                                        class="fas fa-chevron-right"></i></a></p>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="c-tipo">
                        <a href="{{ route('articuloRubro', $rubro->slug) }}"><img
                                src="{{ asset('imgRubro/' . $rubro->img_articulo) }}" width="100%"></a>
                        <div class="text text-center-mob text-center">
                            <p><a class="td-none c-white"
                                    href="{{ route('articuloRubro', $rubro->slug) }}">ARTÍCULOS</a></p>
                            <p class="left-green none-mobile"><a href="{{ route('articuloRubro', $rubro->slug) }}"><i
                                        class="fas fa-chevron-right"></i></a></p>
                        </div>
                    </div>
                </div>

                @if ($rubro->slug == 'construccion')
                    <div class="swiper-slide">
                        <div class="c-tipo">
                            <a href="{{ route('suplementos') }}"><img
                                    src="{{ asset('imgRubro/' . $rubro->img_suplemento) }}" width="100%"></a>
                            <div class="text text-center-mob text-center">
                                <p><a class="td-none c-white" href="{{ route('suplementos') }}">SUPLEMENTO</a>
                                </p>
                                <p class="left-green none-mobile"><a href="{{ route('suplementos') }}"><i
                                            class="fas fa-chevron-right"></i></a></p>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>


        <div class="absolute inset-y-0 left-0 z-10 flex items-center ml-6">
            <span class="swiper-btn-prev pbm-0-mob left-g">
                <i class="fas fa-chevron-left"></i>
            </span>
        </div>

        <div class="absolute inset-y-0 right-0 z-10 flex items-center mr-6">
            <span class="swiper-btn-next pbm-0-mob left-g">
                <i class="fas fa-chevron-right"></i>
            </span>
        </div>
    </div>
</div>

@section('script-extra')
    <!-- Swiper JS -->
    {{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

    <!-- JavaScript -->
    <script src="{{ asset('swiper/js/script.js') }}"></script> 
@endsection

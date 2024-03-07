@section('style-extra')
    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}">
@endsection

{{-- @foreach ($colaboradores as $colaborador)
        <section class="col-md-3 col-xs-12 img-l img-l-mob swiper-slide">
            <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" height="">
        </section>
    @endforeach	--}}

{{-- <div class="slide-container-sector_colab swiper">
    <div class="slide-content-sector_colab">
        <div class="card-wrapper swiper-wrapper">
            @foreach ($colaboradores as $colaborador) 
            <div class="card-sector_colab swiper-slide">
                <div class="image-content"> 

                    <div class="card-image-sector_colab img-l "> 
                        <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" alt=""> 
                    </div>
                </div> 
            </div>
            @endforeach 
        </div>
    </div>

    <div class="swiper-button-next swiper-navBtn"></div>
    <div class="swiper-button-prev swiper-navBtn"></div>
    <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
    <div class="swiper-pagination-sector_colab"></div>
    </div>
</div> --}}
<div class="tab-content  mt-5 pb-3" id="myTabContent">
    @foreach ($rubros as $rubro)
        @if ($loop->iteration == 1)
            <div class="none">{{ $active = 'active' }}</div>
        @else
            <div class="none">{{ $active = '' }}</div>
        @endif
        <div class="{{ 'tab-pane fade show ' . $active }}" id="{{ $rubro->slug }}" role="tabpanel"
            aria-labelledby="{{ $rubro->slug . '-tab' }}">

            <div class="swiper">
                {{-- <div class="slide-content-curso_rubro"> --}}
                <div class="slide-content-{{ $rubro->slug }}">
                    <div class="card-wrapper swiper-wrapper">
                        @foreach ($rubro->videos(6) as $post)
                            <div class="card swiper-slide" style="border-radius: 0%;">
                                <div class="img ">
                                    <a href="{{ route('getvideo', $post->pslug) }}">
                                        <img src="{{ asset('posts/' . $post->image) }}" width="100%">
                                    </a>
                                </div>
                                {{-- <div class="card-content" style="align-items: start">                       --}}
                                {{-- <a href="{{route('getAutor',$autor->slug)}}" class="td-none"> 
                                        <h2 class="name">{{$autor->nombre}}</h2>
                                        </a>
                                        <p class="description">{{$autor->cargo}} - {{$autor->nacionalidad}}</p> --}}
                                <div class="text card-content" style="align-items: start">
                                    <h2 class="p-rubro" style="text-transform: uppercase;">{{ $rubro->nombrerubro }}
                                    </h2>
                                    <a href="{{ route('getvideo', $post->pslug) }}" style="text-decoration: none;">
                                        <p class="title" style="font-weight: bold">{{ $post->titulo }}</p>
                                    </a>
                                    <a href="{{ route('getAutor', $post->auslug) }}" class="td-none">
                                        <p class="name-d icon-user-p">
                                            <span class="mr-3"><i
                                                    class="fas fa-user-tie"></i></span>{{ $post->nombreautor }}
                                        </p>
                                    </a>
                                </div>
                                {{-- <button class="button">View More</button> --}}
                                {{-- </div> --}}
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                        <div class="swiper-pagination-autor"></div>
                    </div>
                </div>

                <div class="flex w-100 justify-center">
                    <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
                        <button
                            class="swiper-btn-prev bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="inset-y-0 right-0 z-10 flex items-center ml-3">
                        <button
                            class="swiper-btn-next bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green-400">
                            <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>
                </div>

            </div>

        </div>
    @endforeach
</div>

@section('script-extra')
    <!-- Swiper JS -->
    {{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

    <!-- JavaScript -->
    <script src="{{ asset('swiper/js/script.js') }}"></script>
@endsection

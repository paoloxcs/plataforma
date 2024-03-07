@section('style-extra')
    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}">
@endsection
<div class="col-md-8 slide-container swiper">
    <div class="slide-content-empresa" >
        <div class="card-wrapper swiper-wrapper">
            @foreach ($colaboradores as $colaborador)
                <div class="card-colaborador swiper-slide">
                    {{-- <div class="image-content" style="padding: 0 !important">  --}}
                    <div class="" style="padding: 0 !important">
                        {{-- <div class="card-img img-l img-l-mob "> --}}
                        <div class="img-l img-l-mob ">
                            <img src="{{ asset('imgColaboradores/' . $colaborador->url_logo) }}" alt=""
                                class="card-img" height="100px">
                            {{-- <img src="{{asset('imgColaboradores/'.$colaborador->url_logo_w)}}" height="100px" > --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
        <div class="swiper-pagination-empresa"></div>
    </div> --}}
    <p class="text-center btn-slider p-i-g">
        <a class="swiper-button-prev" style="text-decoration: none;" id="swiper-button-prev1">
            <i class="fas fa-chevron-left "></i>
        </a>
        <a class="swiper-button-next" style="text-decoration: none" id="swiper-button-next1">
            <i class="fas fa-chevron-right"></i>
        </a>
    </p>

</div>
@section('script-extra')
    <!-- Swiper JS -->
    {{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

    <!-- JavaScript -->
    <script src="{{ asset('swiper/js/script.js') }}"></script>
@endsection

@section('style-extra')
<!-- Swiper CSS -->
{{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
<!-- CSS -->
<link rel="stylesheet" href="{{asset('swiper/css/style.css')}}">                                        
@endsection

{{-- @foreach($colaboradores as $colaborador)
        <section class="col-md-3 col-xs-12 img-l img-l-mob swiper-slide">
            <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" height="">
        </section>
    @endforeach	--}}

<div class="slide-container-sector_colab swiper pb-4">
    <div class="slide-content-sector_colab -mb-card pt-2">
        <div class="card-wrapper swiper-wrapper">
            @foreach($colaboradores as $colaborador) 
            <div class="card-sector_colab swiper-slide">
                <div class="image-content"> 

                    <div class="card-image-sector_colab img-l "> 
                        <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" alt="">
                        {{-- <img src="{{asset('imgColaboradores/'.$colaborador->url_logo)}}" height=""> --}} 
                    </div>
                </div> 
            </div>
            @endforeach 
        </div>
    </div>
 
    <div class="flex w-100 justify-center">
        <div class="inset-y-0 left-0 z-10 flex items-center mr-3">
            <button class="swiper-btn_sectcolab-prev border-button bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green">
                <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
        
        <div class="inset-y-0 right-0 z-10 flex items-center ml-3" >
            <button class="swiper-btn_sectcolab-next border-button bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green">
                <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                </svg>
            </button>
        </div> 
    </div>
    </div>
</div>

@section('script-extra')
<!-- Swiper JS -->
{{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

<!-- JavaScript -->
<script src="{{asset('swiper/js/script.js')}}"></script>
@endsection

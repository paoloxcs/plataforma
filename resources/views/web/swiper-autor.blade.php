@section('style-extra')
    <!-- Swiper CSS -->
    {{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('swiper/css/style.css') }}">
@endsection


{{-- @foreach ($autores as $autor) 
        <section class="col-md-3 col-xs-12 card-curso swiper-slide pbm-0-mob" >
            <a href="{{route('getAutor',$autor->slug)}}">
              <div class="img img-background" style="background-image: url({{asset('posts/'.$autor->imagen)}});width: 100%;height: 350px;" >
            Comentar
            <a href="{{route('getAutor',$autor->slug)}}"><img src="{{asset('posts/'.$autor->imagen)}}" width="100%" height="350px"></a>
              
            </div></a>
            <div class="text">
              <p class="subrayado"></p>Comentar
              <a href="{{route('getAutor',$autor->slug)}}" class="td-none">
                <p class="title text-center font-weight">{{$autor->nombre}}</p></a>
              <p class="name-d text-center" >{{$autor->cargo}} - {{$autor->nacionalidad}}  </p>
            @if ($autor->cursoR() != '[]')
              <p class=" text-center " ><span class="p-rubro">{{$autor->curso[0]->rubro->nombrerubro}}
              @endif

              </span>  </p>
            </div>
            
        </section> 
      @endforeach --}}

<div class="slide-container swiper">
    <div class="flex flex-row relative">
        <div class="slide-content">
            <div class="card-wrapper swiper-wrapper">
                @foreach ($autores as $autor)
                    @if ($autor->cursoR() != '[]')
                        <div class="card swiper-slide">
                            <div class="image-content">
                                <span class="overlay"></span>

                                <div class="card-image">
                                    <a href="{{ route('getAutor', $autor->slug) }}">
                                        <img src="{{ url('posts/' . $autor->imagen) }}" alt="" class="card-img">
                                    </a>
                                </div>
                            </div>

                            <div class="card-content">

                                <a href="{{ route('getAutor', $autor->slug) }}" class="td-none">
                                    <h2 class="name">{{ $autor->nombre }}</h2>
                                </a>
                                <p class="description">{{ $autor->cargo }} - {{ $autor->nacionalidad }}</p>

                                {{-- <button class="button">View More</button> --}}
                                {{-- @if ($autor->cursoR() != '[]') --}}
                                <span class="button p-rubro">{{ $autor->curso[0]->rubro->nombrerubro }}</span>
                                {{-- @else
                                    <span class="button p-rubro">---</span>
                                @endif --}}
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
                <div class="swiper-pagination-autor"></div>
            </div>
        </div>

        <div class="absolute inset-y-0 left-0 z-10 flex items-center ml-6">
            <button
                class="swiper-btn-prev border-button bg-white -ml-3 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green">
                <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>

        <div class="absolute inset-y-0 right-0 z-10 flex items-center mr-6">
            <button
                class="swiper-btn-next border-button bg-white -mr-3 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none text-green">
                <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6">
                    <path fill-rule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clip-rule="evenodd"></path>
                </svg>
            </button>
        </div>
    </div>
</div>

@section('script-extra')
    <!-- Swiper JS -->
    {{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

    <!-- JavaScript -->
    <script src="{{ asset('swiper/js/script.js') }}"></script>
@endsection

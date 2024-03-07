
@section('style-extra')
<!-- Swiper CSS -->
{{-- <link rel="stylesheet" href="{{asset('swiper/css/swiper-bundle.min.css')}}"> --}}
<!-- CSS -->
<link rel="stylesheet" href="{{asset('swiper/css/style.css')}}">                                        
@endsection

{{-- @foreach($colaboradores as $colaboradores)
<section class="col-md-3  img-l swiper-slide col-xs-12">
  <img src="{{asset('imgColaboradores/'.$colaborador->url_logo_w)}}" height="100px" >
</section>
@endforeach --}}

<div class="slide-container-colaborador swiper">
<div class="slide-content-colaborador">
    <div class="card-wrapper swiper-wrapper">
        @foreach($colaboradores as $colaborador) 
          <div class="card-colaborador swiper-slide">
              <div class="image-content" style="padding: 0 !important"> 

                  <div class="card-image-colaborador"> 
                      <img src="{{asset('imgColaboradores/'.$colaborador->url_logo_w)}}" alt="" class="card-img">
                      {{-- <img src="{{asset('imgColaboradores/'.$colaborador->url_logo_w)}}" height="100px" > --}} 
                  </div>
              </div> 
          </div>
        @endforeach 
    </div>
</div>

{{-- <div class="swiper-button-next swiper-navBtn"></div>
<div class="swiper-button-prev swiper-navBtn"></div> --}}
<div class="d-flex justify-content-center mt-4" style="margin-left: 5rem">
  <div class="swiper-pagination-colaborador"></div>
</div>
</div>

@section('script-extra')
<!-- Swiper JS -->
{{-- <script src="{{asset('swiper/js/swiper-bundle.min.js')}}"></script> --}}

<!-- JavaScript -->
<script src="{{asset('swiper/js/script.js')}}"></script>
@endsection

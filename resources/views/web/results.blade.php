@extends('layouts.front')
@section('titulo','Resultados de búsqueda')
@section('content')
<section class="col-md-12 bg-gris padding-1" style="padding:3% 0 5% 0;">

	{{--<section class="col-md-10 mx-auto row">
		<div class="col-md-12">
			
			<ul class="pbm-0">
				<li style="list-style: none">
					<a href="" class="btn-rubros-s btn-active-rubros">Construcción</a>
					<a href="" class="btn-rubros-s">Minería</a>
					<a href="" class="btn-rubros-s">Construcción</a>
					<a href="" class="btn-rubros-s">Minería</a>
					<a href="" class="btn-rubros-s">Construcción</a>
					<a href="" class="btn-rubros-s">Minería</a>
				</li>
			</ul>
		</div>

		
	</section>--}}
     <!-- <section class="col-md-4 col-xs-12 mx-auto">
            <form class="" action="{{url('search')}}" method="GET">
                      {{ csrf_field() }}
                      <div class="input-group mb-3 mt-2 i-buscador">
                          <input type="text" class="form-control" name="text" placeholder="Buscar . . ." >
                          <button class="btn" type="submit" id="button-addon2"><i class="fas fa-search"></i></button>
                       
                      </div>
                   </form>
          </section> -->
	
    
     <section class="col-md-10 mx-auto row pbm-0">
    <h5 class="font-weight mt-3">CURSOS</h5>
        @if($cursos->count()>0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach ($cursos as $curso)
                        {{-- <section class="col-md-3 col-xs-12 card-curso padding-1 mt-2-mob" > --}}
                        <section class="card mob card-curso card-curso-p"
                            style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125); padding-bottom: 0 !important">
                            <div class="img">
                                <a href="{{ route('getcurso', $curso->slug) }}"><img
                                        src="{{ asset('imgCurso/' . $curso->url_portada) }}" width="100%"></a>
                                @if ($curso->fecha_culminacion >= date('Y-m-d'))
                                    <span class="s-disponible s-proximamente">EN VIVO</span>
                                @else
                                    <span class="s-disponible">REALIZADOS</span>
                                @endif
                            </div>
                            {{-- <div class="text"> --}}
                            <div class="card-body pb-0 text">
                                <a href="{{ route('getRubro', $curso->rubro->slug) }}" style="color:black"
                                    class="td-none"><span class="p-rubro"
                                        style="text-transform: uppercase;">{{ $curso->rubro->nombrerubro }}</span></a>
                                <a href="{{ route('getcurso', $curso->slug) }}" class="td-none">
                                    <h4 class="title font-weight">{{ $curso->titulo }}</h4>
                                </a>
                                <a href="{{ route('getAutor', $curso->autor->slug) }}" class="td-none">
                                    <p class="name-d"><span><i class="fas fa-user-tie"></i></span>
                                        &nbsp;{{ $curso->autor->nombre }}</p>
                                </a>

                                <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{ $curso->countAlumnos() }}</p>
                                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i>
                                    {{ $curso->CountValoracion() }}</p>


                                {{-- <section class="s-button">
                                <p class="text-center-mob"><a href="{{ route('getcurso', $curso->slug) }}"
                                        class="a-transparent-g">VER CURSO</a></p>
                            </section> --}}
                            </div>
                            <div class="card-footer bg-white text-center bt-0 mt-4" style="border: none;">
                                <p class="text-center-mob"><a href="{{ route('getcurso', $curso->slug) }}"
                                        class="a-transparent-g">VER CURSO</a></p>
                            </div>

                        </section>
                    @endforeach
                </div>
        @else
        <p>Sin resultados</p>
        @endif
        <hr>
     </section>
   
          

     
     <section class="col-md-10 mx-auto row pbm-0">
    <h5 class="font-weight mt-3">SERIES</h5>
          @if($series->count()>0)
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach ($series as $post)
                        {{-- <section class="col-md-3 col-xs-12 card-curso mt-2-mob"> --}}
                        <section class="card mob card-curso card-curso-p"
                            style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125); padding-bottom: 0 !important">
                            <div class="img">
                                <a href="{{ route('getserie', $post->slug) }}"><img
                                        src="{{ asset('posts/' . $post->image) }}" width="100%"></a>
                                {{-- <span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span> --}}
                            </div>
                            {{-- <div class="text"> --}}
                            <div class="card-body pb-0 text">
                                <a href="{{ route('getRubro', $post->subcategoria->categoria->rubro->slug) }}"
                                    style="color:black" class="td-none"><span class="p-rubro"
                                        style="text-transform: uppercase;">{{ $post->subcategoria->categoria->rubro->nombrerubro }}</span></a>
                                <a href="{{ route('getserie', $post->slug) }}" class="td-none">
                                    <h4 class="title font-weight">{{ $post->titulo }}</h4>
                                </a>
                                <a href="{{ route('getAutor', $post->autor->slug) }}" class="td-none">
                                    <p class="name-d"><span><i class="fas fa-user-tie"></i></span>
                                        &nbsp;{{ $post->autor->nombre }}</p>
                                </a>
                                {{-- <p>{!!substr($post->infoadd,0,75)!!}. . . </p> --}}
                                <p class="p-inline p-c-i"><i class="far fa-eye"></i> {{ $post->CountVistas() }}</p>
                                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i>
                                    {{ $post->CountValoracion() }}</p>
                                {{-- <section class="s-button">
                                <p class="text-center-mob"><a href="{{ route('getserie', $post->slug) }}"
                                        class="a-transparent-g">VER SERIE</a></p>
                            </section> --}}
                            </div>

                            <div class="card-footer bg-white text-center bt-0 mt-4" style="border: none;">
                                <p class="text-center-mob"><a href="{{ route('getserie', $post->slug) }}"
                                        class="a-transparent-g">VER SERIE</a></p>
                            </div>
                        </section>
                    @endforeach
                </div>
            @else
            <p>Sin resultados</p>
            @endif

     <hr>
     </section>

     <section class="col-md-10 mx-auto row pbm-0">
    <h5 class="font-weight mt-3">VIDEOS</h5>
          @if($videos->count()>0)
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach ($videos as $post)
                        {{--  <section class="col-md-3 col-xs-12 card-curso mt-2-mob"> --}}
                        <section class="card mob card-curso card-curso-p"
                            style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125); padding-bottom: 0 !important">
                            <div class="img">
                                <a href="{{ route('getvideo', $post->slug) }}"><img
                                        src="{{ asset('posts/' . $post->image) }}" width="100%"></a>
                                {{-- <span><a href="{{route('getvideo',$post->pslug)}}" class="a-icon"><i class="fas fa-play-circle"></i></a></span> --}}
                            </div>
                            {{-- <div class="text"> --}}
                            <div class="card-body pb-0 text">
                                <a href="{{ route('getRubro', $post->subcategoria->categoria->rubro->slug) }}"
                                    style="color:black" class="td-none"><span class="p-rubro"
                                        style="text-transform: uppercase;">{{ $post->subcategoria->categoria->rubro->nombrerubro }}</span></a>
                                <a href="{{ route('getvideo', $post->slug) }}" class="td-none">
                                    <h4 class="title font-weight">{{ $post->titulo }}</h4>
                                </a>
                                <a href="{{ route('getAutor', $post->autor->slug) }}" class="td-none">
                                    <p class="name-d"><span><i class="fas fa-user-tie"></i></span>
                                        &nbsp;{{ $post->autor->nombre }}</p>
                                </a>
                                {{-- <p>{!!substr($post->infoadd,0,75)!!}. . . </p> --}}
                                <p class="p-inline p-c-i"><i class="fas fa-user"></i> {{ $post->CountVistas() }}</p>
                                <p class="p-inline p-c-i p-m-l"><i class="fas fa-thumbs-up "></i>
                                    {{ $post->CountValoracion() }}</p>

                                {{-- <section class="s-button">
                                <p class="text-center-mob"><a href="{{ route('getvideo', $post->slug) }}"
                                        class="a-transparent-g">VER CAPACITACIÓN</a></p>
                            </section> --}}
                            </div>
                            <div class="card-footer bg-white text-center bt-0 mt-4" style="border: none;">
                                <p class="text-center-mob"><a href="{{ route('getvideo', $post->slug) }}"
                                        class="a-transparent-g">VER CAPACITACIÓN</a></p>
                            </div>
                        </section>
                    @endforeach
                </div>
            @else
            <p>Sin resultados</p>
            @endif

     <hr>
     </section>

     <section class="col-md-10 mx-auto row pbm-0">
    <h5 class="font-weight mt-3">ARTÍCULOS</h5>
          @if($articulos->count()>0)
           <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    @foreach ($articulos as $post)
                        {{-- <section class="col-md-3 col-xs-12 card-curso mt-2-mob"> --}}
                        <section class="card mob card-curso card-curso-p"
                            style="border-radius: 0%;border: 1px solid rgba(0,0,0,.125); padding-bottom: 0 !important">
                            {{-- <div class="text"> --}}
                            <div class="card-body pb-0 text">
                                <a href="{{ route('getarticulo', $post->slug) }}"><img class="img-pdf"
                                        src="{{ asset('images/pdf-a.png') }}"></a>
                                <br>
                                <a href="{{ route('getRubro', $post->subcategoria->categoria->rubro->slug) }}"
                                    style="color:black" class="td-none"><span class="p-rubro"
                                        style="text-transform: uppercase;">{{ $post->subcategoria->categoria->rubro->nombrerubro }}</span></a>
                                <a href="{{ route('getarticulo', $post->slug) }}" style="text-decoration:none">
                                    <h4 class="title font-weight">{{ $post->titulo }}</h4>
                                </a>
                                <p><span class="s-clock" style="margin-left: -10px"><i class="fas fa-calendar-alt"></i>
                                        {{ date('d/m/Y', strtotime($post->paper->fechaimp)) }}</span></p>
                                <p class="p-inline p-c-i"><i class="fas fa-thumbs-up "></i>
                                    {{ $post->CountValoracion() }}
                                </p>
                                <p class="p-inline p-c-i p-m-l"><i class="fas fa-eye"></i> {{ $post->CountVistas() }}</p>
                                <p class="p-inline p-c-i p-m-l"><i class="fas fa-download"></i>
                                    {{ $post->downloads()->count() }}</p>
                                {{-- <section class="s-button">
                                <p class="text-center-mob"><a href="{{ route('getarticulo', $post->slug) }}"
                                        class="a-transparent-g">VER</a></p>
                            </section> --}}
                            </div>
                            <div class="card-footer bg-white text-center bt-0 mt-4" style="border: none;">
                                <p class="text-center-mob"><a href="{{ route('getarticulo', $post->slug) }}"
                                        class="a-transparent-g">VER ARTÍCULO</a></p>
                            </div>
                        </section>
                    @endforeach
                </div>
            @else
            <p>Sin resultados</p>
            @endif

     <hr>
     </section>
     



	
</section>
@endsection


        {{-- MENU MOVIL --}}
        <div class="modal fade hidden xl:hidden bg-gray-600" id="modal-menu-mobil">
            {{-- <div class="modal fade " id="modal-menu" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> --}}
            <div class="modal-dialog modal-dialog modal-xs modal-dialog w-full md:w-1/2"
                style="max-width: 100%;width: 100%;margin:0;left: 0;right: 0;height:100%!important;">
                {{-- <div class="modal-dialog modal-dialog modal-xs modal-dialog "
                    style="max-width: 100%;width: 100%;margin:0;left: 0;right: 0;height:100%!important;"> --}}
                <div class="modal-content bg-gris-black" style="min-height:100%!important;">
                    <div class="modal-body col-md-12 row pbm-0">

                        <section class="col-md-12 col-xs-12 pbm-0 s-login">
                            {{-- <button type="button" class="btn-close c-white font-weight"
                                style="font-size: 25px!important" data-bs-dismiss="modal" aria-label="Close"><i
                                    class="fas fa-times"></i></button> --}}
                            <button type="button" class="btn-close c-white font-weight" onclick="showModal()"
                                style="font-size: 25px!important"><i class="fas fa-times"></i>
                            </button>
                            <br>
                            <a href="/" class="mt-5"><img src="{{ asset('images/logo-white.png') }}"
                                    class="img-logo"></a>

                            <ul class="mt-5 menu-ul-mob">


                                <li class="">
                                    <a class="c-white" data-bs-toggle="collapse" href="#collapseExample" role="button"
                                        aria-expanded="false" aria-controls="collapseExample">
                                        CATEGORÍAS
                                        <i class="fas fa-angle-down c-green font-weight" style="font-size: 20px"></i>
                                    </a>
                                </li>
                                <div class="collapse  bg-gris-black" id="collapseExample">
                                    <div class="card card-body bg-gris-black">
                                        <ul class=" menu-ul-mob">
                                            {{-- <li> <a href="/rubro/construccion" class="c-white">CONSTRUCCIÓN</a></li> --}}
                                            <li>
                                                <a href="/rubro/construccion" class="c-white">CONSTRUCCIÓN</a>
                                                <a class="c-white" data-bs-toggle="collapse"
                                                    href="#collapseConstruccion" role="button" aria-expanded="false"
                                                    aria-controls="collapseConstruccion">
                                                    <i class="fas fa-angle-down c-green font-weight"
                                                        style="font-size: 22px;margin-left: 10px;"></i>
                                                </a>
                                            </li>
                                            <div class="collapse  bg-gris-black" id="collapseConstruccion">
                                                <div class="card card-body bg-gris-black">
                                                    <ul class=" menu-ul-mob">
                                                        <li><a href="{{ route('getcursosP', 'construccion') }}"
                                                                class="c-white">CURSOS </a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/videos/rubro/construccion"
                                                                class="c-white">CAPACITACION</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/revistas/RC" class="c-white ">REVISTAS</a>
                                                        </li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/articulos/rubro/construccion"
                                                                class="c-white">ARTÍCULOS</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/suplemento-tecnico"
                                                                class="c-white">SUPLEMENTO</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="hr-nav">
                                            {{-- <li> <a href="/rubro/mineria" class="c-white">MINERÍA</a></li> --}}
                                            <li>
                                                <a href="/rubro/mineria" class="c-white">MINERÍA</a>
                                                <a class="c-white" data-bs-toggle="collapse" href="#collapseMineria"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="collapseMineria">
                                                    <i class="fas fa-angle-down c-green font-weight"
                                                        style="font-size: 22px;margin-left: 10px;"></i>
                                                </a>
                                            </li>
                                            <div class="collapse  bg-gris-black" id="collapseMineria">
                                                <div class="card card-body bg-gris-black">
                                                    <ul class=" menu-ul-mob">
                                                        <li><a href="{{ route('getcursosP', 'mineria') }}"
                                                                class="c-white">CURSOS</i></a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/videos/rubro/mineria"
                                                                class="c-white">CAPACITACION</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/revistas/TM" class="c-white">REVISTAS</i></a>
                                                        </li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/articulos/rubro/mineria"
                                                                class="c-white">ARTÍCULOS</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <hr class="hr-nav">
                                            {{-- <li> <a href="/rubro/arquitectura-y-diseno" class="c-white">ARQUITECTURA Y DISEÑO</a></li> --}}
                                            <li>
                                                <a href="/rubro/arquitectura-y-diseno" class="c-white">ARQUITECTURA Y
                                                    DISEÑO</a>
                                                <a class="c-white" data-bs-toggle="collapse" href="#collapseArqDis"
                                                    role="button" aria-expanded="false"
                                                    aria-controls="collapseArqDis">
                                                    <i class="fas fa-angle-down c-green font-weight"
                                                        style="font-size: 22px;margin-left: 10px;"></i>
                                                </a>
                                            </li>
                                            <div class="collapse  bg-gris-black" id="collapseArqDis">
                                                <div class="card card-body bg-gris-black">
                                                    <ul class=" menu-ul-mob">
                                                        <li><a href="{{ route('getcursosP', 'arquitectura-y-diseno') }}"
                                                                class="c-white">CURSOS</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/series/rubro/arquitectura-y-diseno"
                                                                class="c-white">SERIES</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/videos/rubro/arquitectura-y-diseno"
                                                                class="c-white">CAPACITACION</a></li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/revistas/DA" class="c-white">REVISTAS</a>
                                                        </li>
                                                        <hr class="hr-nav">
                                                        <li><a href="/articulos/rubro/arquitectura-y-diseno"
                                                                class="c-white">ARTÍCULOS</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                                <hr class="hr-nav">
                                <li class=""><a href="/planes-de-suscripcion/construccion"
                                        class="c-white">PLANES</a></li>
                                <hr class="hr-nav">
                                <li class=""><a href="/empresas" class="c-white">PARA EMPRESAS</a></li>
                                <hr class="hr-nav">
                                <div class="flex-1 relative">
                                    <form class="" action="{{ url('search') }}" method="GET">
                                        {{ csrf_field() }}
                                        <div class="input-group i-buscador">
                                            <input type="text" class="form-control" name="text"
                                                placeholder="Buscar . . .">
                                            <button class="btn bg-white" style="border-left: 1px solid #1d3039"
                                                type="submit" id="button-addon2"><i
                                                    class="fas fa-search"></i></button>

                                        </div>
                                    </form>
                                </div>
                                <hr class="hr-nav">
                            </ul>



                            @if (Auth::guest())
                                 {{-- <button type="button" data-bs-toggle="modal" data-bs-target="#modal-login"
                            class="btn-100 btn-trans mt-5">INGRESAR</button>

                        <button type="button" data-bs-toggle="modal" data-bs-target="#modal-create"
                            class="btn-100 btn-green">CREAR CUENTA</button> --}}
                            
                        <a type="button" href="{{ route('login') }}" class="btn btn-100 btn-trans mt-5 text-white">INGRESAR</a>

                        <a type="button" href="{{ route('register') }}" class="btn btn-100 btn-green">CREAR CUENTA</a>
                            @endif


                        </section>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}


                    </div>
                </div>
            </div>
        </div>
<section class="col-md-8 row mx-auto plan-col pt-4">
    @foreach ($planes as $plan)
        {{-- <section class="col-md-6 col-xs-12 s-plan"> --}}
        <section class="col-md-6 col-xs-12 s-plan sec-plan">
            {{-- PLANES 2x1 --}}
            @if (strpos($plan->slug, 'anual'))
                <div class="memberships-card__free-time">
                    <div>-50%</div>
                </div>
            @endif
            <h3 class="font-weight" style="text-transform: uppercase">{{ $plan->name }}</h3>
            {{-- <p class="font-weight pbm-0">Ahora</p> --}}
            @if ($plan->promocion > 0)
                {{-- <div class="col-md-12 row pbm-0">
                    <div class="col-md-4 col-xs-12 pbm-0">
                    <p class="c-green font-weight p-precio"><span>S/</span>{{$plan->promocion}}</p>
                    </div>
                    <div class="col-md-3 col-xs-6 pbm-0 d-antes">
                    <p class="p-antes">Antes</p>
                    <p class="p-antes line-through">S/ {{$plan->precio}}</p>
                    </div>
                    <div class="col-md-5 col-xs-6 pbm-0 d-antes" style="position: relative;">
                    <a type="button" class="nav-link a-menu pbm-0 text-center-mob"  data-bs-toggle="modal" data-bs-target="#modal-planD" style="position:absolute;bottom: 20%;background: black;color:white;padding:1% 3%; "><i class="fas fa-dollar-sign" ></i> Ver Precio (Dólares)</a>
                    </div>
                </div> --}}
                <div class="col-md-12 row pbm-0 container-precio">
                    <div class="col-12 row pbm-0 price-center">
                        <div class="col-md-6 col-xs-6 pbm-0">
                            <p class="font-weight pbm-0" style="text-align: start;">Ahora</p>
                            <p class="c-green font-weight p-precio"><span>S/</span>{{ $plan->promocion }}</p>
                        </div>
                        <div class="col-md-6 col-xs-6 pbm-0 d-antes p-antes-precio">
                            <p class="p-antes" style="text-align: start;">Antes</p>
                            <p class="p-antes line-through">S/ {{ $plan->precio }}</p>
                        </div>
                    </div>

                    <div class="col-md-12 col-xs-12 pbm-0 d-antes precio-dolar-modal" style="position: relative;">
                        <a type="button" class="nav-link a-menu pbm-0 text-center-mob" data-bs-toggle="modal"
                            data-bs-target="#modal-planD"
                            style="position:absolute;bottom: 20%;background: black;color:white;padding:1% 3%; "><i
                                class="fas fa-dollar-sign"></i> Ver Precio (Dólares)</a>
                    </div>
                </div>
            @else
                <div class="col-md-12 row pbm-0 container-precio">
                    <div class="col-12 row pbm-0 price-center">
                        <div class="col-md-6 col-xs-6 pbm-0">
                            <p class="font-weight pbm-0" style="text-align: start;">Ahora</p>
                            <p class="c-green font-weight p-precio"><span>S/</span>{{ $plan->precio }}</p>
                        </div>
                    </div>
                    <div class="col-md-12 col-xs-12 pbm-0 d-antes precio-dolar-modal" style="position: relative;">
                        <a type="button" class="nav-link a-menu pbm-0 text-center-mob" data-bs-toggle="modal"
                            data-bs-target="#modal-planD"
                            style="position:absolute;bottom:20%;background: black;color:white;padding:1% 3%; "><i
                                class="fas fa-dollar-sign"></i> Ver Precio (Dólares)</a>
                    </div>
                </div>
            @endif
            {{-- <p class="p-rubro font-weight p-membresia">Membresía por {{$plan->meses}} meses</p>
                <section class="col-md-12 row pbm-0 mt-3 plan-item-features">          
                    {!!$plan->descripcion!!}          
                </section> --}}
            <div class="p-rubro text-center">
                <p class="font-weight p-membresia">Membresía por {{ $plan->meses }} meses</p>
            </div>
            <section class="col-md-12 row pbm-0 mt-3 plan-item-features">
                {!! $plan->descripcion !!}
            </section>
            @if (!\Auth::guest())
                {{-- <p class="text-center mt-2 li-be-n"><a href="{{route('getPlan',$plan->slug)}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p> --}}
                <p class="text-elegirplan text-center mt-2 li-be-n"><a href="{{ route('getPlan', $plan->slug) }}"
                        class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
            @else
                {{-- <p class="text-center mt-2 li-be-n"><a href="{{url('/login?redirect_to='.route('getPlan',$plan->slug))}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p> --}}
                <p class="text-elegirplan text-center mt-2 li-be-n"><a
                        href="{{ url('/login?redirect_to=' . route('getPlan', $plan->slug)) }}"
                        class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
            @endif
        </section>
    @endforeach

    {{-- PLANES 2x1 --}}
    {{-- <div class="memberships__promo pb-4">
              <div class="container">
                  <div class="row">
                      <div class="col-xl-12">
                          <div class="two-for-one"><i class="fas fa-info-circle"></i>
                              <p>
                                  <b>Así habilitas tu 2x1 en tu plan Anual:</b><br>
                                  Escríbenos a <a href="mailto:info2@constructivo.com"><b>info2@constructivo.com</b></a>
                                  adjuntando el voucher de compra y
                                  los datos de la otra persona que usará la cuenta. Nosotros nos encargaremos de otorgarle
                                  el acceso Premium en un plazo no mayor de 48 horas.<br>
                                  <b>Importante: las otras personas también deben tener una cuenta registrada en
                                      plataforma.</b>
                              </p>
                          </div>
                      </div>
                  </div>
              </div>
          </div> --}}

    {{-- JHED PREMIUM --}}
    @include('components.items-pay', [
        'column' => false,
    ])
    {{-- JHED PREMIUM --}}
    <!--<div class="bg-white col-md-12 col-xs-12 card-pay-plan">-->
    <!--    <div class="col-md-12 col-xs-10 mx-auto d-flex flex-wrap align-items-center justify-content-center">-->
    <!--        <div class="text-center-title"><span class="text-center-mob" style="font-weight: bold">Pague aquí-->
    <!--                con:</span></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/visa.png') }}" class="img-fluid" alt="Visa">-->
    <!--        </div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/mastercard.png') }}" class="img-fluid"-->
    <!--                alt="Mastercard"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/diners.png') }}" class="img-fluid"-->
    <!--                alt="Diners Club"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/american.png') }}" class="img-fluid"-->
    <!--                alt="American Express"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/unionpay.png') }}" class="img-fluid"-->
    <!--                alt="Union Pay"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/ripley.png') }}" class="img-fluid" alt="Ripley">-->
    <!--        </div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/cmr.png') }}" class="img-fluid"-->
    <!--                alt="Saga Falabella"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/oh.png') }}" class="img-fluid" alt="Tarjeta Oh!">-->
    <!--        </div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/cencosud.png') }}" class="img-fluid"-->
    <!--                alt="Cencosud"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/presta.png') }}" class="img-fluid" alt="Presta">-->
    <!--        </div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/pagoefectivo.png') }}" class="img-fluid"-->
    <!--                alt="Pago Efectivo"></div>-->
    <!--        <div class="cardicon-curso2"><img src="{{ asset('images/yape.png') }}" class="img-fluid" alt="Yape">-->
    <!--        </div>-->
    <!--    </div>-->
    <!--</div>-->
</section>
{{-- </section> --}}


<div class="modal fade" id="modal-planD" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog modal-xl modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:   15px">

            <div class="modal-body col-md-12 row pbm-0">

                <section class="col-md-12 s-planes" style="border-radius:   15px">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        style="position:absolute;right:3px;top:3px"></button>

                    <h1 class="text-center font-weight">PLANES</h1>
                    <p class="text-center">Nuestros planes de suscripción incluye por un solo pago todo el material de:
                        Construcción, Minería y Arquitectura & Diseño.</p>

                    <section class="col-md-12 row mx-auto">
                        @foreach ($planesD as $plan)
                            <section class="col-md-6 col-xs-12 s-plan">
                                <h3 class="font-weight" style="text-transform: uppercase">{{ $plan->name }}</h3>
                                {{-- <p class="font-weight pbm-0">Ahora</p> --}}
                                @if ($plan->promocion > 0)
                                    {{-- <div class="col-md-12  row pbm-0">
            <div class="col-md-4 col-xs-6 pbm-0">
               <p class="c-green font-weight p-precio"><span>$</span>{{$plan->promocion}}</p>
            </div>
            <div class="col-md-8  col-xs-6 pbm-0 d-antes">
              <p class="p-antes">Antes</p>
              <p class="p-antes line-through">$ {{$plan->precio}}</p>
            </div>
          </div> --}}
                                    <div class="col-12 row pbm-0 price-center">
                                        <div class="col-md-6 col-xs-6 pbm-0">
                                            <p class="font-weight pbm-0" style="text-align: start;">Ahora</p>
                                            <p class="c-green font-weight p-precio">
                                                <span>$</span>{{ $plan->promocion }}</p>
                                        </div>
                                        <div class="col-md-6 col-xs-6 pbm-0 d-antes p-antes-precio">
                                            <p class="p-antes" style="text-align: start;">Antes</p>
                                            <p class="p-antes line-through">$ {{ $plan->precio }}</p>
                                        </div>
                                    </div>
                                @else
                                    {{-- <div class="col-md-12 row pbm-0">
            <div class="col-md-4 col-xs-12 pbm-0">
               <p class="c-green font-weight p-precio"><span>$</span>{{$plan->precio}}</p>
            </div>
          </div> --}}
                                    <div class="col-12 row pbm-0 price-center">
                                        <div class="col-md-6 col-xs-6 pbm-0">
                                            <p class="font-weight pbm-0" style="text-align: start;">Ahora</p>
                                            <p class="c-green font-weight p-precio"><span>$</span>{{ $plan->precio }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
                                {{-- <p class="p-rubro font-weight p-membresia">Membresía por {{$plan->meses}} meses</p>
          <section class="col-md-12 row pbm-0 mt-3 plan-item-features">              
            {!!$plan->descripcion!!}              
          </section> --}}
                                <div class="p-rubro text-center">
                                    <p class="font-weight p-membresia">Membresía por {{ $plan->meses }} meses</p>
                                </div>
                                <section class="col-md-12 row pbm-0 mt-3 plan-item-features">
                                    {!! $plan->descripcion !!}
                                </section>
                                @if (!\Auth::guest())
                                    {{-- <p class="text-center mt-2 li-be-n"><a href="{{route('getPlan',$plan->slug)}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p> --}}
                                    <p class="text-elegirplan text-center mt-2 li-be-n"><a
                                            href="{{ route('getPlan', $plan->slug) }}"
                                            class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
                                @else
                                    {{-- <p class="text-center mt-2 li-be-n"><a href="{{url('/login?redirect_to='.route('getPlan',$plan->slug))}}" class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p> --}}
                                    <p class="text-elegirplan text-center mt-2 li-be-n"><a
                                            href="{{ url('/login?redirect_to=' . route('getPlan', $plan->slug)) }}"
                                            class="a-menu a-menu-b a-personal a-plan">ELEGIR PLAN</a></p>
                                @endif
                            </section>
                        @endforeach

                    </section>
                </section>


            </div>
        </div>
    </div>
</div>

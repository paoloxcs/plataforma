<div class="{{ !$column ? '' : 'card-suplemento mt-3 mt-5-mob' }}">
    <section class="bg-white d-flex flex-column shadow-md rounded-xl mb-auto p-4 lg:p-5">
        <div class="d-flex flex-column gap-2 h-full">
            <div class="d-flex align-items-center justify-content-between">
                <h2 class="lg:text-xl font-semibold text-base">Pague con:
                    {{-- ¿Como puedo pagar? --}} <div class="bg-[#72154C] h-1 rounded-xl w-20 mt-2"></div>
                </h2>
            </div>
            <div class="grid {{ !$column ? 'lg:grid-cols-2 gap-4' : 'gap-2' }} pl-1 flex-col">
                <div class="bg-[#F9FAFB] d-flex flex-column shadow-md rounded-lg col-12">
                    <div class="my-3 text-center">
                        <span class="text-[#444444] text-sm font-semibold">
                            Tarjetas de crédito - débito
                        </span>
                        <div class="d-flex justify-content-center gap-7 mt-3"  style="flex-wrap: wrap; row-gap: 0.75rem; column-gap: 1.25rem;">
                            <img class="sm:w-10 w-8" src="{{ asset('images/pagos/visa.png') }}" alt="Imagen de pago">
                            <img class="sm:w-10 w-8" src="{{ asset('images/pagos/mastercard.png') }}"
                                alt="Imagen de pago">
                            <img class="sm:w-8 w-6" src="{{ asset('images/pagos/diners-club.png') }}"
                                alt="Imagen de pago">
                            <img class="sm:w-12 w-10" src="{{ asset('images/pagos/american-express.png') }}"
                                alt="Imagen de pago">
                        </div>
                    </div>
                </div>

                <div class="bg-[#F9FAFB] d-flex flex-column shadow-md rounded-lg col-12">
                    <div class="my-3 text-center">
                        <span class="text-[#444444] text-sm font-semibold">
                            Transferencias bancarias (Perú)
                        </span>
                        <div class="d-flex justify-content-center gap-6 mt-3"  style="flex-wrap: wrap; row-gap: 0.75rem; column-gap: 1.25rem;">
                            <img class="sm:w-14 w-11" src="{{ asset('images/pagos/bcp.png') }}" alt="Imagen de pago">
                            <img class="sm:w-14 w-11" src="{{ asset('images/pagos/interbank.png') }}"
                                alt="Imagen de pago">
                            <img class="sm:w-14 w-11" src="{{ asset('images/pagos/bbva.png') }}" alt="Imagen de pago">
                            <img class="sm:w-14 w-11" src="{{ asset('images/pagos/banco-de-la-nacion.png') }}"
                                alt="Imagen de pago">
                            <img class="sm:w-14 w-11" src="{{ asset('images/pagos/pagoefectivo.png') }}"
                                alt="Imagen de pago">
                        </div>
                    </div>
                </div>

                <div class="bg-[#F9FAFB] d-flex flex-column shadow-md rounded-lg col-12">
                    <div class="my-3 text-center">
                        <span class="text-[#444444] text-sm font-semibold">
                            Aplicaciones móviles
                        </span>
                        <div class="d-flex justify-content-center gap-10 mt-3">
                            <img class="w-[34px]" src="{{ asset('images/pagos/yape.png') }}" alt="Imagen de pago">
                            <img class="w-[34px]" src="{{ asset('images/pagos/plin.png') }}" alt="Imagen de pago">
                        </div>
                    </div>
                </div>

                <div class="bg-[#F9FAFB] d-flex flex-column shadow-md rounded-lg col-12">
                    <div class="my-3 text-center">
                        <span class="text-[#444444] text-sm font-semibold">
                            Pagos internacionales
                        </span>
                        <div class="d-flex justify-content-center gap-10 mt-3">
                            <img class="w-20 lg:w-24" src="{{ asset('images/pagos/paypal.png') }}"
                                alt="Imagen de pago">
                        </div>
                    </div>
                </div>
            </div>
        </div class="flex flex-col gap-4 h-full">
    </section>
</div>

<!-- Small modal -->
<div class="modal" id="modal_new_filter" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-title">
                    <h4>Aplicar filtros</h4>
                </div>
            </div>
            {{-- <form onsubmit="applyFilter();" method="POST" id="form_filter" action="#"> --}}
            <form action="{{ route('subscribers.pago_efectivo') }}" class="row col-10"
                style="margin-right: 2rem ; margin-left: 2rem">

                <div class="modal-body">
                    <div class="row">

                        @if (request('search'))
                            <input type="hidden" name="search" value="{{ request('search') }}">
                        @endif


                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-secondary">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por:</div>
                                </div>
                                <div class="panel-body">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="order" checked value="new">
                                            Más nuevos
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="order"
                                                @if (request('order') == 'old') checked @endif value="old">
                                            Más antiguo
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por Planes (Activos):</div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($planes as $plan)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="plan"
                                                    @if (request('plan') == $plan->id) checked @endif
                                                    value="{{ $plan->id }}">
                                                {{ $plan->name }} ({{ $plan->moneda . ' - ' . $plan->meses }} meses)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por Planes (Inactivos):</div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($planes_off as $planoff)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="plan"
                                                    @if (request('plan') == $planoff->id) checked @endif
                                                    value="{{ $planoff->id }}">
                                                {{ $planoff->name }} ({{ $planoff->moneda . ' - ' . $planoff->meses }}
                                                meses)
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        {{-- <div class="col-xs-12 col-md-4">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por Metodo:</div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($metodo_pagos as $item)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="modpago"
                                                    @if (request('modpago') == $item->id) checked @endif
                                                    value="{{ $item->id }}">
                                                {{ $item->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div> --}}

                        {{-- <div class="col-xs-12 col-md-4">
                            <div class="panel panel-warning">
                                <div class="panel-heading">
                                    <div class="panel-title">Por estado</div>
                                </div>
                                <div class="panel-body">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="1"
                                                @if (request('status') == '1') checked @endif>
                                            Vigente
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="status" value="2"
                                                @if (request('status') == '2') checked @endif>
                                            Expirado
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div> --}}

                    </div>
                    {{-- <div class="col-xs-12 col-md-2" style="padding-bottom: 1rem">
						<p> Ordenar por:</p>
	
						<select name="order" class="form-control">
							<option value="new" @if (request('order') == 'new') selected @endif>Más nuevos</option>
							<option value="old" @if (request('order') == 'old') selected @endif>Más antiguo
							</option>
						</select>
					</div> --}}

                    {{-- <div class="col-xs-12 col-md-3" style="padding-bottom: 1rem">
						<p> Ordenar por Planes:</p>
						<select name="plan" class="form-control">
							<option value=" ">Seleccionar plan</option>
							@foreach ($planes as $plan)
								<option value="{{ $plan->id }}" @if (request('plan') == $plan->id) selected @endif>
									{{ $plan->name }} ({{ $plan->moneda . ' - ' . $plan->meses }} meses)</option>
							@endforeach
						</select>
					</div> --}}

                    {{-- <div class="col-xs-12 col-md-3" style="padding-bottom: 1rem">
						<p> Ordenar por metodo:</p>
						<select name="modpago" class="form-control">
							<option value=" ">Seleccionar metodo</option>
							@foreach ($metodo_pagos as $item)
								<option value="{{ $item->id }}" @if (request('modpago') == $plan->id) selected @endif>
									{{ $item->name }} </option>
							@endforeach
						</select>
					</div> --}}


                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Aplicar filtro</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

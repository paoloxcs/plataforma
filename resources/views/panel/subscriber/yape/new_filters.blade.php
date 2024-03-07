<!-- Small modal -->
<div class="modal" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <div class="modal-title">
                    <h4>Aplicar filtros</h4>
                </div>
            </div>
            <form action="{{ route('subscribers.pago_yape') }}" class="row col-10"
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
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Aplicar filtros</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

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
            <form action="{{ route('video.index') }}" class="row col-10" style="margin-right: 2rem ; margin-left: 2rem">

                <div class="modal-body">
                    <div class="row">

                        @if (request('search'))
                            <input type="hidden" name="search" id="search_text" value="{{ request('search') }}">
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
                                    <div class="panel-title">Ordenar por Rubro</div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($rubros as $rubro)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="r"
                                                    @if (request('r') == $rubro->idrubro) checked @endif
                                                    value="{{ $rubro->idrubro }}">
                                                {{ $rubro->nombrerubro }}
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
                        <button type="submit" class="btn btn-success">Aplicar filtro</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

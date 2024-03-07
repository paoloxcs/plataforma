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
            {{-- <form onsubmit="applyFilter();" method="POST" id="form_filter" action="#"> --}}
            <form action="{{ route('subscribers.cursos') }}" class="row col-10"
                style="margin-right: 2rem ; margin-left: 2rem">
                <div class="modal-body">
                    <div class="row">
                        @if (request('search'))
                            <input type="hidden" name="search" style="" value="{{ request('search') }}">
                        @endif

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por Cursos:</div>
                                    <input type="text" name="buscador_cursos" id="buscador_cursos"
                                        style="width: 100%; margin: 1rem 0 0 0; padding: 5px; outline: none; border: 2px solid #CCD1E4; color:black; border-radius: 15px; font-weight: 600;"
                                        placeholder="Buscar curso...">
                                </div>
                                <div class="panel-body panel-curso" style="overflow-y: auto;max-height: 45rem;">
                                    @foreach ($cursos as $curso)
                                        <div class="radio radio-curso" id="radio-curso-{{ $curso->id }}">
                                            <label class="label-curso" id="label-curso-{{ $curso->id }}">
                                                <input type="radio" name="curso" id="curso-{{ $curso->id }}"
                                                    @if (request('curso') == $curso->id) checked @endif
                                                    value="{{ $curso->id }}">
                                                {{ $curso->titulo }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-4">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                    <div class="panel-title">Ordenar por Gestor:</div>
                                </div>
                                <div class="panel-body">
                                    @foreach ($gestores as $gestor)
                                        <div class="radio radio-gestor">
                                            <label>
                                                <input type="radio" name="gestor"
                                                    @if (request('gestor') == $gestor->id) checked @endif
                                                    value="{{ $gestor->id }}">
                                                {{ $gestor->name . ' ' . $gestor->last_name }}
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

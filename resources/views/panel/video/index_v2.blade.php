@extends('layouts.app')
@section('titulo', 'Videos')
@section('extra_style')
    <style>
        .btn_editPost {
            /* text-decoration: none; */
            color: rgb(4, 82, 172);
            /* background: rgb(4, 82, 172); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(4, 82, 172);
        }

        .btn_editPost:hover {
            color: #fff;
            background: rgb(3, 64, 134);
        }

        .btn_destroyPost {
            /* text-decoration: none; */
            color: rgb(172, 4, 4);
            /* background: rgb(4, 82, 172); */
            background: transparent;
            padding: .5rem 1rem;
            border-radius: 25%;
            border: 1px solid rgb(172, 4, 4);
        }

        .btn_destroyPost:hover {
            color: #fff;
            background: rgb(134, 3, 3);
        }

        .span_off {
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgba(255, 179, 179, 0.582);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1rem;
            line-height: 1;
            padding-top: .25rem;
            padding-bottom: .25rem;
            padding-left: .5rem;
            padding-right: .5rem;
            color: rgb(255, 0, 0);
        }

        .span_on {
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgb(210, 252, 199);
            border-radius: 9999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1.25rem;
            line-height: 1;
            padding-top: .25rem;
            padding-bottom: .25rem;
            padding-left: .5rem;
            padding-right: .5rem;
            color: rgb(32, 153, 1);
        }

        .span_mini_off {
            color: rgba(74, 85, 104, 1);
            line-height: 1.5;
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgba(229, 62, 62, 1);
            border-radius: 9999px;
            display: inline-block;
            height: .5rem;
            margin-right: .5rem;
            width: .5rem;
        }

        .span_mini_on {
            color: rgba(74, 85, 104, 1);
            line-height: 1.5;
            box-sizing: border-box;
            border: 0 solid #e2e8f0;
            background-color: rgb(95, 229, 62);
            border-radius: 9999px;
            display: inline-block;
            height: .5rem;
            margin-right: .5rem;
            width: .5rem;
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item active">
                <i class="fa fa-list-ol"></i> Videos
            </li>
        </ol>
        @include('alerts.success')
        <div class="panel panel-success">
            <div class="panel-body">
                <div class="row">
                    {{-- <div class="col-xs-12 col-md-6">
               <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" class="form-control" onkeyup="buscar(this);" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione enter">
               </div>
            </div> --}}
                    <form action="{{ route('video.index') }}" class="row col-10"
                        style="margin-right: 2rem ; margin-left: 2rem">

                        <div class="col-xs-12 col-md-12" style="padding-bottom: 1rem">
                            <p> Buscador: </p>
                            <div class="input-group has-success">
                                <span class="input-group-addon" id="basic-addon3"><i class="fa fa-search"></i></span>
                                <input type="text" name="search" class="form-control"
                                    value="{{ old('search', request('search')) }}" aria-describedby="basic-addon3"
                                    placeholder="Escriba aquí">
                            </div>
                        </div>

                        <div class="col-xs-12 col-md-2" style="padding-bottom: 1rem">
                            <p> Ordenar por:</p>

                            <select name="order" class="form-control">
                                <option value="new" @if (request('order') == 'new') selected @endif>Más nuevos</option>
                                <option value="old" @if (request('order') == 'old') selected @endif>Más antiguo
                                </option>
                            </select>
                        </div>

                        {{-- <div class="col-xs-12 col-md-3" style="padding-bottom: 1rem">
                            <p> Ordenar por Sub categoria:</p>
                            <select name="sub_c" class="form-control">
                                <option value=" ">Seleccionar subcategoria</option>
                                @foreach ($subcategorias as $subcategoria)
                                    <option value="{{ $subcategoria->idsubcategoria }}"
                                        @if (request('sub_c') == $subcategoria->idsubcategoria) selected @endif>
                                        {{ $subcategoria->nombresubcategoria }} </option>
                                @endforeach
                            </select>
                        </div> --}}

                        <div class="col-xs-12 col-md-3" style="padding-bottom: 1rem">
                            <p> Ordenar por Categoria:</p>
                            <select name="rubro" class="form-control">
                                <option value=" ">Seleccionar rubro</option>
                                @foreach ($rubros as $rubro)
                                    <option value="{{ $rubro->idrubro }}" @if (request('rubro') == $rubro->idrubro) selected @endif>
                                        {{ $rubro->nombrerubro }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-xs-12 col-md-3" style="display: flex; flex-direction: column">
                            <div style="display: flex">
                                <button type="submit" class="btn btn-success" style="margin: 1rem 1rem 0 0;flex: 1 1 0%;">
                                    Aplicar
                                    filtro</button>
                                <a href="{{ route('video.index') }}" class="btn btn-danger" style="margin-top: 1rem"> <i
                                        class="fa fa-trash" aria-hidden="true"></i> </a>
                            </div>
                            @if ($videos_count > 0)
                                <span class="badge" style="margin-top: 1rem" id="totalReg">
                                    {{ $videos_count }} Registros
                                </span>
                            @endif

                            <a onclick="createVideo();" class="btn btn-success pull-right" style="margin-top: 1rem"><i
                                    class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>

                        </div>
                    </form>

                    {{-- <div class="col-xs-12 col-md-6">
               <button onclick="createVideo();" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
            </div> --}}
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>Activo</th>
                                <th>Título</th>
                                <th>Sub-Categoría</th>
                                <th>Portada</th>
                                <th>Duración</th>
                                <th>Orden</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($videos as $video)
                                <tr>
                                    <td>
                                        {{-- {{ $video->post->is_active ? 'On' : 'Off' }} --}}
                                        @if ($video->post->is_active)
                                            <span class="span_on">
                                                <span class="span_mini_on"></span>On</span>
                                        @else
                                            <span class="span_off">
                                                <span class="span_mini_off"></span>Off</span>
                                        @endif
                                    </td>
                                    <td>{{ $video->post->titulo }}</td>
                                    <td>{{ $video->post->subcategoria->nombresubcategoria }}</td>
                                    <td><a target="_blank"
                                            href="https://player.vimeo.com/video/{{ $video->post->ruta }}"><img
                                                class="img-responsive" width="100"
                                                src="../posts/{{ $video->post->image }}" alt=""></a></td>
                                    <td>{{ $video->duracion }} min.</td>
                                    <td>{{ $video->post->orden === 1 ? 'Principal' : 'General' }}</td>

                                    <td>
                                        <div style="display: flex">
                                            <button onclick='editVideo({{ $video }})'
                                                class="btn btn-primary btn-sm btn_editPost" title="Editar Video"><i
                                                    class="fa fa-pencil" aria-hidden="true"></i></button>
                                            <button onclick="destroyPost({{ $video->post->idpost }})"
                                                class="btn btn-danger btn-sm btn_destroyPost" title="Eliminar Video"><i
                                                    class="fa fa-trash" aria-hidden="true"></i> </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="col-xs-12 col-md-4">
                        <div class="input-group custom-pagination">
                            <!-- Render pagination here -->
                            {{ $videos->appends(['search' => request('search'), 'order' => request('order'), 'sub_c' => request('sub_c'), 'rubro' => request('rubro')])->render() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @include('panel.video.create')
        @include('panel.video.edit')
    </div>

@endsection
@section('extra_scripts')
    <script src="{{ asset('js/categorization_control.js') }}"></script>
    <script>
        // $(document).ready(function(){
        //    getVideos();

        // });
        let props = {
            ruta: '',
            tbVideos: $("#videos"),
            modal_create: $("#modal_create"),
            modal_edit: $("#modal_edit"),
        }

        function getVideos(page = 0) {
            props.ruta = '/panel/videos-data';
            if (page != 0) props.ruta = `/panel/videos-data/?page=${page}`;
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res => {
                    spinner.hide();
                    props.tbVideos.empty();
                    res.data.forEach(video => {
                        props.tbVideos.append(`
                     <tr>
                        <td>${video.post.titulo}</td>
                        <td>${video.post.subcategoria.nombresubcategoria}</td>
                        <td><a target="_blank" href="https://player.vimeo.com/video/${video.post.ruta}"><img class="img-responsive" width="100" src="../posts/${video.post.image}" alt=""></a></td>
                        <td>${video.duracion} min.</td>
                        <td>${video.post.orden === 1 ? 'Principal' : 'General'}</td>
                        <td>
                           <button onclick='editVideo(${JSON.stringify(video)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                           <button onclick="destroyPost(${video.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                        </td>
                     </tr>
                  `);
                    });

                    renderPagination(res, 'getVideos');
                },
                error: error => {
                    console.log(error);
                }
            });
        }

        function buscar(input) {
            if (input.value != '') {
                if (event.keyCode == 13) {
                    spinner.show()
                    props.ruta = `/panel/searchVideo/${input.value}`;
                    $.ajax({
                        url: props.ruta,
                        type: 'GET',
                        dataType: 'JSON',
                        success: data => {
                            spinner.hide();
                            $(".custom-pagination").empty();
                            props.tbVideos.empty();
                            data.forEach(video => {
                                props.tbVideos.append(`
                           <tr>
                              <td>${video.post.titulo}</td>
                              <td>${video.post.subcategoria.nombresubcategoria}</td>
                              <td><a target="_blank" href="https://player.vimeo.com/video/${video.post.ruta}"><img class="img-responsive" width="100" src="../posts/${video.post.image}" alt=""></a></td>
                              <td>${video.duracion} min.</td>
                              <td>${video.post.orden === 1 ? 'Principal' : 'General'}</td>
                              <td>
                                 <button onclick='editVideo(${JSON.stringify(video)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                                 <button onclick="destroyPost(${video.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                              </td>
                           </tr>
                        `);
                            });
                        },
                        error: error => {
                            console.log(error);
                        }
                    });
                }
            } else {
                getVideos();
            }
        }

        function createVideo() {
            getRubros();
            getAutores();
            props.modal_create.modal();
        }

        function editVideo(video) {
            get_rubros_to_edit(video);
            get_autores_to_edit(video);
            let form_edit = $("#form-edit")[0];
            form_edit.post_id.value = video.post.idpost;
            console.log(video.post.idpost);
            form_edit.titulo.value = video.post.titulo;
            CKEDITOR.instances[form_edit.infoadd.name].setData(video.post.infoadd);
            form_edit.url_video.value = video.post.ruta;
            form_edit.url_preview.value = video.url_preview;
            form_edit.duracion.value = video.duracion;

            $(form_edit.orden).empty();
            $(form_edit.orden).append(`
            <option ${video.post.orden == 0 ? 'selected' : ''} value="0">General</option>
            <option ${video.post.orden == 1 ? 'selected' : ''} value="1">Principal</option>
         `);
            $(form_edit.acceso).empty();
            $(form_edit.acceso).append(`
            <option ${video.post.acceso == 0 ? 'selected' : ''} value="0">Si</option>
            <option ${video.post.acceso == 1 ? 'selected' : ''} value="1">No</option>
         `);
            // Is_active_capacitacion
            $(form_edit.is_active).empty();
            $(form_edit.is_active).append(`
            <option ${video.post.is_active == 1 ? 'selected' : ''} value="1">Si</option>
            <option ${video.post.is_active == 0 ? 'selected' : ''} value="0">No</option>
         `);
            props.modal_edit.modal();
        }

        function saveVideo(form) {
            event.preventDefault();
            props.ruta = '/panel/video';
            let data = new FormData($(form)[0]);
            data.set('infoaddc', CKEDITOR.instances[form.infoaddc.name].getData());
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form._token.value
                },
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: res => {
                    spinner.hide();
                    props.modal_create.modal('hide');
                    //   getVideos();
                    toastr.success(res.message);
                    $(form).trigger('reset');
                    setTimeout(
                        function() {
                            location.reload();
                        }, 0001);
                },
                error: error => {
                    if (error.status == 422) {
                        spinner.hide();
                        let errors = Object.values(error.responseJSON.errors);
                        for (var error in errors) {
                            toastr.error(errors[error][0]);
                        }

                    } else {
                        console.log(error);
                    }
                }
            });
        }

        function updateVideo(form) {
            event.preventDefault();
            let data = new FormData($(form)[0]);

            let url = "{{ route('video.index') }}";
            props.ruta = `/panel/video/${form.post_id.value}`;
            spinner.show();
            data.set('infoadd', CKEDITOR.instances[form.infoadd.name].getData());
            $.ajax({
                url: props.ruta,
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': form._token.value
                },
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: res => {
                    spinner.hide();
                    props.modal_edit.modal('hide');
                    //   getVideos($("#current_page").val());
                    toastr.success(res.message);
                    //   window.location.href = url;
                    setTimeout(
                        function() {
                            location.reload();
                        }, 0001);
                },
                error: error => {
                    if (error.status == 422) {
                        spinner.hide();
                        let errors = Object.values(error.responseJSON.errors);
                        for (var error in errors) {
                            toastr.error(errors[error][0]);
                        }
                    } else {
                        console.log(error);
                    }
                }
            });
        }

        function destroyPost(post_id) {
            props.ruta = `/panel/video/${post_id}/destroy`;
            if (confirm('¿Seguro de elimninar el registro?')) {
                spinner.show();
                $.ajax({
                    url: props.ruta,
                    type: 'GET',
                    dataType: 'JSON',
                    success: res => {
                        spinner.hide();
                        // getVideos($("#current_page").val());
                        toastr.success(res.message);
                        setTimeout(
                            function() {
                                location.reload();
                            }, 0001);
                    },
                    error: error => {
                        console.log(error);
                    }
                });
            }
        }
    </script>
@endsection

@extends('layouts.app')
@section('titulo','Categorias')
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('rubros.index')}}"><i class="fa fa-list-ol"></i> Lista de rubros</a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fa fa-list-ol"></i> Categorías de  {{$rubro->nombrerubro}}
        </li>
    </ol>
    @include('alerts.success')
    @include('panel.categoria.create')
    @include('panel.categoria.edit')
    <div class="panel panel-success">
        <div class="panel-body">
        <div class="row">
            <div class="col-md-2 pull-right">
                <button data-toggle="modal" data-target="#modal_create" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
            </div>
        </div>
        <hr>
            <div class="table-responsive">
                <table class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre de Categoría</th>
                            <th>URL</th>
                            <th>&nbsp;</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="categorias">
                    

                    </tbody>
                </table>
            </div>
            <div class="row">
               <div class="col-xs-12 col-md-4">
                   <div class="input-group custom-pagination">
                    <!-- Render pagination here -->
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('extra_scripts')
<script>
    $(document).ready(function(){
        getCategorias();
    });
    //data para insertar
    let props = {
        idrubro : {{$rubro->idrubro}},
        ruta: '',
        tbCategorias : $("#categorias"),
        modal_create : $("#modal_create"),
        modal_edit: $("#modal_edit"),
    }

    function getCategorias(page = 0) {
        props.ruta = `/panel/categorias-data/?rubroid=${props.idrubro}`;
        if(page != 0) props.ruta = `/panel/categorias-data/?rubroid=${props.idrubro}&page=${page}`;
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: res =>{
                spinner.hide();
                props.tbCategorias.empty();
                if(res.total > 0){
                    res.data.forEach(categ =>{
                        props.tbCategorias.append(`
                                <tr>
                                    <td>${categ.idcategoria}</td>
                                    <td>${categ.nombrecategoria}</td>
                                    <td>${categ.slug}</td>
                                    <td>
                                        <span class="badge">${categ.subcategorias.length}</span><a href="/panel/subcates/categ/${categ.idcategoria}" class="btn btn-link">SubCategorías</a>
                                    </td>
                                    <td>
                                        <button onclick='editCategory(${JSON.stringify(categ)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                                        <button onclick="destroyCategory(${categ.idcategoria})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                                    </td>
                                </tr>
                            `);
                    });
                    renderPagination(res, 'getCategorias');
                }else{
                    props.tbCategorias.text('No hay registros...');
                }
            },
            error: error =>{
                console.log(error);
            }
        });
    }

    function saveCategory(form) {
        event.preventDefault();
        let data = $(form).serialize();
        props.ruta = '/panel/categorias';
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: `${data}&idrubro=${props.idrubro}`,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_create.modal('hide');
                    $(form).trigger('reset');
                    toastr.success(res.message);
                    getCategorias();
                }

                if (res.status == 422) {
                    //Error validations fields
                    for (var error in res.errors){
                        toastr.error(res.errors[error][0],'Advertencia');
                    }
                }
            },
            error: error =>{
                console.log(error);
            }

        });
    }

    function editCategory(category) {
        let frmedit = $("#form-edit")[0];
        frmedit.idcategoria.value = category.idcategoria;
        frmedit.nombrecategoria.value = category.nombrecategoria;
        props.modal_edit.modal();
    }

    function updateCategory(form) {
        event.preventDefault();
        let data = $(form).serialize();
        props.ruta = `/panel/categorias/${form.idcategoria.value}`;
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: `${data}&idrubro=${props.idrubro}`,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_edit.modal('hide');
                    $(form).trigger('reset');
                    getCategorias($("#current_page").val());
                    toastr.success(res.message);
                }

                if (res.status == 422) {
                    //Error validations fields
                    for (var error in res.errors){
                        toastr.error(res.errors[error][0],'Advertencia');
                    }
                }
            },
            error: error=>{
                console.log(error);
            }
        });
    }

    function destroyCategory(categ_id) {
        if(confirm('¿Seguro de eliminar el registro?')){
            spinner.show();
            props.ruta = `/panel/categorias/${categ_id}/destroy`;
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType:'JSON',
                success: res =>{
                    spinner.hide();
                    toastr.success(res.message);
                    getCategorias($("#current_page").val());
                },
                error: error=>{
                    console.log(error);
                }
            });
        }
    }
</script>
@endsection
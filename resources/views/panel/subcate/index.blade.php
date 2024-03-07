@extends('layouts.app')
@section('titulo','Sub Categorías')
@section('content')
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('rubros.index')}}"><i class="fa fa-list-ol"></i> Rubros</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('categorias.index',$categoria->rubro->idrubro)}}"><i class="fa fa-list-ol"></i> Categorías de  {{$categoria->rubro->nombrerubro}}</a>
        </li>
        <li class="breadcrumb-item active">
            <i class="fa fa-list-ol"></i> Sub categorías de {{$categoria->nombrecategoria}}
        </li>
    </ol>
    @include('alerts.success')
    @include('panel.subcate.create')
    @include('panel.subcate.edit')
        
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
                        <th>Nombre de Sub Categoría</th>
                        <th>&nbsp;</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="subcates">

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
        getSubcates();
    });
    //data para insertar
    let props = {
        idcategoria : {{$categoria->idcategoria}},
        ruta : '',
        tbSubcates : $("#subcates"),
        modal_create : $("#modal_create"),
        modal_edit : $("#modal_edit"),
    }

    function getSubcates(page = 0) {
        props.ruta = `/panel/subcates-data/?categid=${props.idcategoria}`;
        if(page != 0) props.ruta = `/panel/subcates-data/?categid=${props.idcategoria}&page=${page}`;
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: res =>{
                spinner.hide();
                props.tbSubcates.empty();
                if(res.total > 0){
                    res.data.forEach(subcate =>{
                        props.tbSubcates.append(`
                                <tr>
                                    <td>${subcate.idsubcategoria}</td>
                                    <td>${subcate.nombresubcategoria}</td>
                                    <td><span class="badge">${subcate.posts.length} Posts</span></td>
                                    <td>
                                        <button onclick='editSubcate(${JSON.stringify(subcate)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                                        <button onclick="destroySubcate(${subcate.idsubcategoria})"  class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                                    </td>
                                </tr>
                            `);
                    });
                    renderPagination(res, 'getSubcates');
                }else{
                    props.tbSubcates.text('No hay registros...');
                }
            },
            error: error =>{
                console.log(error);
            }
        });
    }


    function saveSubcate(form) {
        event.preventDefault();
        let data = $(form).serialize();
        props.ruta = '/panel/subcates';
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: `${data}&idcategoria=${props.idcategoria}`,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_create.modal('hide');
                    $(form).trigger('reset');
                    getSubcates();
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

    function editSubcate(subcate) {
        let frmedit = $("#form-edit")[0];
        frmedit.idsubcate.value = subcate.idsubcategoria;
        frmedit.nombresubcategoria.value = subcate.nombresubcategoria;
        props.modal_edit.modal();
    }

    function updateSubcate(form) {
        event.preventDefault();
        props.ruta = `/panel/subcates/${form.idsubcate.value}`;
        let data = $(form).serialize();
        spinner.show();
        $.ajax({
            url: props.ruta,
            type:'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: `${data}&idcategoria=${props.idcategoria}`,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_edit.modal('hide');
                    $(form).trigger('reset');
                    getSubcates($("#current_page").val());
                    toastr.success(res.message);
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

    function destroySubcate(subcate_id) {
        if(confirm('¿Seguro de eliminar el registro?')){
            spinner.show();
            props.ruta = `/panel/subcates/${subcate_id}/destroy`;
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res =>{
                    spinner.hide();
                    toastr.success(res.message);
                    getSubcates($("#current_page").val());
                },
                error: error=>{
                    console.log(error);
                }
            }); 
        }
    }
</script>
@endsection
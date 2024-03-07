@extends('layouts.app')
@section('titulo','Rubros')
@section('content')
<div class="container">
    @include('alerts.success')
    @include('panel.rubro.create')
    @include('panel.rubro.edit')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            <i class="fa fa-list-ol"></i> Lista de rubros
        </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
        <div class="row">
            <div class="col-md-2 pull-right">
                <a href="#" data-toggle="modal" data-target="#modal_create" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</a>
            </div>
        </div>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-condensed table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Nombre de Rubro</th>
                        <th>&nbsp;</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="rubros">
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
        getRubros();
    });
    let props = {
        ruta: '',
        tbRubros: $("#rubros"),
        modal_create: $("#modal_create"),
        modal_edit : $("#modal_edit"),
    }

    function getRubros(page = 0) {
        props.ruta = '/panel/rubros-data';
        if(page != 0) props.ruta = `/panel/rubros-data/?page=${page}`;
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: res =>{
                spinner.hide();
                props.tbRubros.empty();
                res.data.forEach(rubro =>{
                    props.tbRubros.append(`
                            <tr>
                                <td>${rubro.idrubro}</td>
                                <td>${rubro.nombrerubro}</td>
                                <td>
                                    <span class="badge">${rubro.categorias.length}</span><a href="/panel/categorias/rubro/${rubro.idrubro}" class="btn btn-link">Categorías</a>
                                </td>
                                <td>
                                    <button onclick='editRubro(${JSON.stringify(rubro)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                                    <a  href="/panel/rubro/sliders/${rubro.slug}" class="btn btn-info btn-sm"><i class="fa fa-clipboard"></i> Sliders</a>
                                    <button onclick="destroyRubro(${rubro.idrubro})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                                </td>
                            </tr>
                        `);
                });

                renderPagination(res,'getRubros');
            },
            error: error =>{
                console.log(error);
            }
        });
    }

    function editRubro(rubro) {
        let frmedit = $("#form-edit")[0];
        frmedit.idrubro.value = rubro.idrubro;
        frmedit.nombrerubro.value = rubro.nombrerubro;
         $(frmedit.estado).empty();
      $(frmedit.estado).append(`
            <option ${rubro.estado == 1 ? 'selected' : ''} value="1">Activo</option>
            <option ${rubro.estado == 0 ? 'selected' : ''} value="0">Inactivo</option>
         `);
        props.modal_edit.modal();
    }

    function saveRubro(form) {
        event.preventDefault();

        props.ruta = `/panel/rubros`;
        let data = new FormData($(form)[0]);
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: data,
            cache: false,
         processData: false,
         contentType: false,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_create.modal('hide');
                    $(form).trigger('reset');
                    toastr.success(res.message);
                    getRubros();
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

    function updateRubro(form) {
        event.preventDefault();
        props.ruta = `/panel/rubros/${form.idrubro.value}`;
        let data = new FormData($(form)[0]);
        spinner.show();
        $.ajax({
            url: props.ruta,
            type: 'POST',
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': form._token.value},
            data: data,
            
            cache: false,
         processData: false,
         contentType: false,
            success: res =>{
                spinner.hide();
                if (res.status == 200) {
                    props.modal_edit.modal('hide');
                    toastr.success(res.message);
                    getRubros($("#current_page").val());
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

    function destroyRubro(idrubro) {
        if(confirm('¿Seguro de eliminar el registro?')){
            props.ruta = `/panel/rubros/${idrubro}/destroy`;
            spinner.show();
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: res =>{
                    spinner.hide();
                    getRubros($("#current_page").val());
                    toastr.success(res.message);
                },
                error: error =>{
                    console.log(error);
                }
            });
        }
    }
</script>
@endsection


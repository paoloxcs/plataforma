@extends('layouts.app')
@section('titulo','Autores')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Autores
      </li>
    </ol>
    
    <div class="panel panel-success">
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control"  aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>

                <div class="col-md-2 pull-right">
                    <button data-toggle="modal" data-target="#modal_create" class="btn btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
                </div>
            </div>
        <hr>
        <div class="table-responsive" id="contenedor">
            
            <table class="table table-condensed table-hover table-bordered">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Autor</th>
                        <th>País</th>
                        <th>Cargo</th>
                        <th>Principal</th>
                        <th>Foto</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="autores">
                    <!-- Render data here -->
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
@include('panel.autor.create')
@include('panel.autor.edit')
@endsection
@section('extra_scripts')
<script>

    window.addEventListener('load',function(){
        document.getElementById("texto").addEventListener("keyup", () => {
            if((document.getElementById("texto").value.length)>=1)
                fetch(`{{route('autor.buscador')}}?texto=${document.getElementById("texto").value}`,{ method:'get' })
                .then(response  =>  response.text() )
                .then(html      =>  {   document.getElementById("contenedor").innerHTML = html  })
            else
                location.reload();
        })
    }); 


$(document).ready(function(){
    getAutores();
});
let props ={
    modal_create : $("#modal_create"),
    modal_edit : $("#modal_edit"),
    tbAutores : $("#autores"),
    ruta : '',
}

function getAutores(page = 0) {
    spinner.show();
    props.ruta ='/panel/autores-data';
    if(page != 0) props.ruta =`/panel/autores-data/?page=${page}`;
    fetch(props.ruta)
    .then(response => response.json())
    .then(response => {
        props.tbAutores.empty();
        spinner.hide();
        response.data.forEach((autor,index) =>{
            props.tbAutores.append(
                `<tr>
                    <td>${autor.idautor}</td>
                    <td>${autor.nombre}</td>
                    <td>${autor.nacionalidad}</td>
                    <td>${autor.cargo}</td>
                    <td>${autor.principal==1 ? '<i class="fa fa-check"></i>' : '<i class="fa fa-times"></i>'}</td>
                    <td>
                        <img width="40" style="border-radius : 50%;" src="/posts/${autor.imagen}">
                    </td>
                    <td>
                        <button onclick='editAutor(${autor.idautor})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                        <button onclick='deleteAutor(${autor.idautor})' class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                </tr>`);
        });

        renderPagination(response,'getAutores'); // Invoca la funcion de paginacion
    })
    .catch(error =>{
        console.log(error);
    })
}

// Agregar autor
function saveAutor(form) {
    event.preventDefault();
    
    if(validateForm(form)){ // Validacion del formulario
        spinner.show();
        props.ruta = '/panel/autores';
        let token = '{{ csrf_token() }}', // Creacion de variable token csrf
            data = new FormData($(form)[0]); // creacion de la variable data

        data.set('bio', CKEDITOR.instances[form.bio.name].getData()); // updating data

        $.ajax({
            url: props.ruta,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            cache: false,
            data: data,
            contentType: false,
            processData: false,
            success: data =>{
                spinner.hide();
                if(data.status == 200){
                    props.modal_create.modal('hide');
                    getAutores();
                    toastr.success(data.message,'Exito');
                    $(form).trigger('reset');
                }

                if(data.status == 422){
                    for (var error in data.errors){
                        toastr.error(data.errors[error][0],'Advertencia');
                    }
                }
                console.log(data);
            },
            error : error =>{
                console.log(error);
            }
        });
    }
}

function editAutor(autor_id) {
    var formEdit = $("#editform")[0];
    spinner.show();
    props.ruta = `/panel/autores/${autor_id}`;
    $.ajax({
        url: props.ruta,
        dataType: 'JSON',
        type: 'GET',
        success: res =>{
            console.log(res);
            formEdit.idautor.value = res.idautor;
            formEdit.nombre.value = res.nombre;
            CKEDITOR.instances[formEdit.bioedit.name].setData(res.bio);
            formEdit.pais.value = res.nacionalidad;
            formEdit.cargo.value = res.cargo;

             $(formEdit.principal).empty();
              $(formEdit.principal).append(`
                    <option ${res.principal == 1 ? 'selected' : ''} value="1">Principal</option>
                    <option ${res.principal == 0 ? 'selected' : ''} value="0">General</option>
                 `);

            props.modal_edit.modal();
            spinner.hide();
        },
        error: error =>{
            console.log(error);
        }
    });


    
    
}

function updateAutor(form) {
    event.preventDefault();
    if (validateForm(form)) {
        spinner.show();
        props.ruta  = `/panel/autores/${form.idautor.value}`;
        let token = form.token.value,
            data = new FormData($(form)[0]);

        data.set('bioedit', CKEDITOR.instances[form.bioedit.name].getData());
        data.append('_method', 'PUT');

            $.ajax({
                url: props.ruta,
                type: 'POST',
                headers: {'X-CSRF-TOKEN': token},
                data: data,
                cache: false,
                processData: false,
                contentType: false,
                success: data => {
                    spinner.hide();
                    if(data.status == 200){
                        
                        props.modal_edit.modal('hide');
                        getAutores($("#current_page").val());
                        toastr.success(data.message,'Exito');
                    }
                    if(data.status == 422){
                        for (var error in data.errors){
                            toastr.error(data.errors[error][0],'Advertencia');
                        }
                    }
                    console.log(data);
                },
                error: error =>{
                    console.log(error);
                }
            });
    }
}

function deleteAutor(idautor) {
    if(confirm('¿Seguro de eliminar el registro?')){
        props.ruta = `/panel/autores/${idautor}/destroy/`;
        $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: data =>{
                if(data.status == 200){
                    getAutores($("#current_page").val());
                    toastr.success(data.message,'Exito');
                }
                console.log(data);
            },
            error: error =>{
                console.log(error);
            }
        });
    }
}
</script>
@endsection
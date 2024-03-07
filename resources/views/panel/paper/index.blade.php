@extends('layouts.app')
@section('titulo','Artículos')
@section('content')
<div class="container">
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">
        <i class="fa fa-list-ol"></i> Artículos
      </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
          <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" id="texto" class="form-control" onkeyup="buscar(this);" id="basic-url" aria-describedby="basic-addon3" placeholder="Escriba aquí">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <button onclick="createArticle()" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
              </div>
          </div>
          <hr>
          <div class="table-responsive">
              <table class="table table-condensed table-hover table-bordered">
                  <thead>
                          <th>&nbsp;</th>
                          <th>Título</th>
                          <th>Subcategoría</th>
                          <th>Fec. creación</th>
                           <th>Orden</th>
                          <th>Acción</th>
                  </thead>
                  <tbody id="articulos">
                      
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
    @include('panel.paper.create')
    @include('panel.paper.edit')
</div>

@endsection
@section('extra_scripts')
<script src="{{asset('js/categorization_control.js')}}"></script>
<script>
  $(document).ready(function(){
    getArticles();
  });
  let props = {
    ruta : '',
    tbArticles : $("#articulos"),
    modal_create : $("#modal_create"),
    modal_edit : $("#modal_edit")

  }
  function getArticles(page = 0) {
    props.ruta = '/panel/articulos-data';
    if(page != 0) props.ruta = `/panel/articulos-data/?page=${page}`;
    spinner.show();
    $.ajax({
      url: props.ruta,
      type: 'GET',
      timeout: 2000,
      dataType: 'JSON',
      success: res =>{
        spinner.hide();
        props.tbArticles.empty();
        res.data.forEach(art =>{
          props.tbArticles.append(`
              <tr>
                <td><i class="fa fa-check"></i></td>
                <td width="400">${art.post.titulo}</td>
                <td>${art.post.subcategoria.nombresubcategoria}</td>
                <td>${dateFormat(art.fechaimp)}</td>
                <td>${art.post.orden == 1 ? 'Principal' : 'General'}</td>
                <td>
                    <button onclick='editArticle(${JSON.stringify(art)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                    <button onclick="destroyPost(${art.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                </td>
              </tr>
            `);
        });
        renderPagination(res, 'getArticles');
      },
      error : error =>{
        if(error.statusText === 'timeout'){
          spinner.hide();
          toastr.warning(`Imposible listar los articulos <br/><button onclick="getArticles(${$("#current_page").val() || 0})" class="btn btn-default btn-sm">Intentar de nuevo</button>`,'Servidor no responde');
        }
        console.log(error);
      }
    });
  }
  function buscar(input) {
    if(input.value != ''){
      if(event.keyCode == 13){
        spinner.show();
        props.ruta = `/panel/articulos/search/${input.value}`;
        $.ajax({
          url: props.ruta,
          type: 'GET',
          dataType: 'JSON',
          success: res =>{
            spinner.hide();
            $(".custom-pagination").empty();
            props.tbArticles.empty();
            res.forEach(art =>{
              props.tbArticles.append(`
                  <tr>
                    <td><i class="fa fa-check"></i></td>
                    <td width="400">${art.post.titulo}</td>
                    <td>${art.post.subcategoria.nombresubcategoria}</td>
                    <td>${dateFormat(art.fechaimp)}</td>
                    <td>${art.post.orden == 1 ? 'Principal' : 'General'}</td>
                    <td>
                        <button onclick='editArticle(${JSON.stringify(art)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> Editar</button>
                        <button onclick="destroyPost(${art.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Eliminar</button>
                    </td>
                  </tr>
                `);
            });
          },
          error: error =>{
            console.log(error);
          }
        });
      }

    }else{
      getArticles();
    }

  }

  function createArticle() {
    getRubros();
    getAutores();
    props.modal_create.modal();
  }
  function editArticle(article) {
    get_rubros_to_edit(article);
    get_autores_to_edit(article);
    let form_edit = $("#form-edit")[0];
    form_edit.post_id.value = article.post.idpost;
    form_edit.titulo.value = article.post.titulo;
    form_edit.infoadd.value = article.post.infoadd;
    form_edit.pages.value = article.pages;
    $(form_edit.idioma).empty();
    $(form_edit.idioma).append(`
        <option ${article.post.idioma == 'ES' ? 'selected' : ''} value="ES">Español</option>
        <option ${article.post.idioma == 'EN' ? 'selected' : ''} value="EN">Ingles</option>
      `);
    $(form_edit.orden).empty();
    $(form_edit.orden).append(`
        <option ${article.post.orden == 0 ? 'selected' : ''} value="0">General</option>
        <option ${article.post.orden == 1 ? 'selected' : ''} value="1">Principal</option>
      `);
    $(form_edit.acceso).empty();
    $(form_edit.acceso).append(`
        <option ${article.post.acceso == 0 ? 'selected' : ''} value="0">Si</option>
        <option ${article.post.acceso == 1 ? 'selected' : ''} value="1">No</option>
      `);
    props.modal_edit.modal();
  }
  function saveArticle(form) {
    event.preventDefault();
    props.ruta = '/panel/articulos';
    let data = new FormData($(form)[0]);
    spinner.show();
    $.ajax({
      url: props.ruta,
      type: 'POST',
      headers: {'X-CSRF-TOKEN': form._token.value},
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: res =>{
        spinner.hide();
        props.modal_create.modal('hide');
        getArticles();
        toastr.success(res.message);
        $(form).trigger('reset');
      },
      error : error =>{
        if (error.status == 422){
           spinner.hide();
           let errors = Object.values(error.responseJSON.errors);
           for (var error in errors){
               toastr.error(errors[error][0]);
           }

        }else{
           console.log(error);
        }
      }
    });
  }

  function updateArticle(form) {
    event.preventDefault();
    let data = new FormData($(form)[0]);
    props.ruta = `/panel/articulos/${form.post_id.value}`;
    spinner.show();
    $.ajax({
      url: props.ruta,
      type: 'POST',
      headers: {'X-CSRF-TOKEN': form._token.value},
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: res =>{
        spinner.hide();
        props.modal_edit.modal('hide');
        getArticles($("#current_page").val());
        toastr.success(res.message);
      },
      error : error =>{
        if (error.status == 422){
           spinner.hide();
           let errors = Object.values(error.responseJSON.errors);
           for (var error in errors){
               toastr.error(errors[error][0]);
           }

        }else{
           console.log(error);
        }
      }
    });
  }
  function destroyPost(post_id) {
    if(confirm('¿Seguro de eliminar el registro?')){
      props.ruta = `/panel/articulos/${post_id}/destroy`;
      spinner.show();
      $.ajax({
        url: props.ruta,
        type: 'GET',
        dataType: 'JSON',
        success: res =>{
          spinner.hide();
          getArticles($("#current_page").val());
          toastr.success(res.message);
        },
        error : error =>{
          console.log(error);
        }
      });
    }
  }
</script>
@endsection
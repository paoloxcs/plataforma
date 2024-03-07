@extends('layouts.app')
@section('titulo','Series')
@section('content')
<div class="container">
   <ol class="breadcrumb">
      <li class="breadcrumb-item active">
         <i class="fa fa-list-ol"></i> Series
       </li>
   </ol>
   @include('alerts.success')
   <div class="panel panel-success">
       <div class="panel-body">
         <div class="row">
            <div class="col-xs-12 col-md-6">
               <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" class="form-control" onkeyup="buscar(this);" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione enter">
               </div>
            </div>
            <div class="col-xs-12 col-md-6">
               <button onclick="createSerie();" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
            </div>
         </div>
         <hr>
         <div class="table-responsive">
            <table class="table table-condensed table-hover table-bordered">
               <thead>
                  <tr>
                     <th>Título</th>
                     <th>Sub-Categoría</th>
                     <th>Portada</th>
                     <th>Duración</th>
                     <th>Orden</th>
                     <th>Acción</th>
                  </tr>
               </thead>
               <tbody id="series">
                  
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
   @include('panel.serie.create')
   @include('panel.serie.edit')
</div>

@endsection
@section('extra_scripts')
<script src="{{asset('js/categorization_control.js')}}"></script>
<script>
   $(document).ready(function(){
      getSeries();

   });
   let props = {
      ruta: '',
      tbSeries : $("#series"),
      modal_create : $("#modal_create"),
      modal_edit : $("#modal_edit"),
   }

   function getSeries(page = 0) {
      props.ruta = '/panel/series-data';
      if(page != 0) props.ruta = `/panel/series-data/?page=${page}`;
      spinner.show();
      $.ajax({
         url: props.ruta,
         type: 'GET',
         dataType: 'JSON',
         success: res=>{
            spinner.hide();
            props.tbSeries.empty();
            res.data.forEach(serie =>{
               props.tbSeries.append(`
                     <tr>
                        <td>${serie.post.titulo}</td>
                        <td>${serie.post.subcategoria.nombresubcategoria}</td>
                        <td><a target="_blank" href="https://player.vimeo.com/serie/${serie.post.ruta}"><img class="img-responsive" width="100" src="../posts/${serie.post.image}" alt=""></a></td>
                        <td>${serie.duracion} min.</td>
                        <td>${serie.post.orden === 1 ? 'Principal' : 'General'}</td>
                        <td>
                           <button onclick='editSerie(${JSON.stringify(serie)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                           <button onclick="destroyPost(${serie.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
                        </td>
                     </tr>
                  `);
            });

            renderPagination(res, 'getSeries');
         },
         error: error =>{
            console.log(error);
         }
      });
   }
   function buscar(input) {
      if(input.value != ''){
         if(event.keyCode == 13){
            spinner.show()
            props.ruta =`/panel/searchSerie/${input.value}`;
            $.ajax({
               url: props.ruta,
               type: 'GET',
               dataType: 'JSON',
               success:data =>{
                  spinner.hide();
                  $(".custom-pagination").empty();
                  props.tbSeries.empty();
                  data.forEach(serie =>{
                     props.tbSeries.append(`
                           <tr>
                              <td>${serie.post.titulo}</td>
                              <td>${serie.post.subcategoria.nombresubcategoria}</td>
                              <td><a target="_blank" href="https://player.vimeo.com/serie/${serie.post.ruta}"><img class="img-responsive" width="100" src="../posts/${serie.post.image}" alt=""></a></td>
                              <td>${serie.duracion} min.</td>
                              <td>${serie.post.orden === 1 ? 'Principal' : 'General'}</td>
                              <td>
                                 <button onclick='editSerie(${JSON.stringify(serie)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil" aria-hidden="true"></i> Editar</button>
                                 <button onclick="destroyPost(${serie.post.idpost})" class="btn btn-danger btn-sm"><i class="fa fa-trash" aria-hidden="true"></i> Eliminar</button>
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
         getSeries();
      }
   }

   function createSerie() {
      getRubros();
      getAutores();
      props.modal_create.modal();
   }

   function editSerie(serie) {
      get_rubros_to_edit(serie);
      get_autores_to_edit(serie);
      let form_edit = $("#form-edit")[0];
      form_edit.post_id.value = serie.post.idpost;
      form_edit.titulo.value = serie.post.titulo;
      CKEDITOR.instances[form_edit.infoadd.name].setData(serie.post.infoadd);
      form_edit.url_video.value = serie.post.ruta;
      form_edit.url_preview.value = serie.url_preview;
      form_edit.duracion.value = serie.duracion;

      $(form_edit.orden).empty();
      $(form_edit.orden).append(`
            <option ${serie.post.orden == 0 ? 'selected' : ''} value="0">General</option>
            <option ${serie.post.orden == 1 ? 'selected' : ''} value="1">Principal</option>
         `);
      $(form_edit.acceso).empty();
      $(form_edit.acceso).append(`
            <option ${serie.post.acceso == 0 ? 'selected' : ''} value="0">Si</option>
            <option ${serie.post.acceso == 1 ? 'selected' : ''} value="1">No</option>
         `);
      props.modal_edit.modal();
   }

   function saveSerie(form) {
      event.preventDefault();
      props.ruta = '/panel/serie';
      let data = new FormData($(form)[0]);
      data.set('infoaddc', CKEDITOR.instances[form.infoaddc.name].getData());
      spinner.show();
      $.ajax({
         url: props.ruta,
         type: 'POST',
         headers: {'X-CSRF-TOKEN' : form._token.value},
         data: data,
         cache: false,
         processData: false,
         contentType: false,
         success: res =>{
            spinner.hide();
            props.modal_create.modal('hide');
            getSeries();
            toastr.success(res.message);
            $(form).trigger('reset');
         },
         error: error =>{
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

   function updateSerie(form) {
      event.preventDefault();
      let data = new FormData($(form)[0]);
      
      props.ruta = `/panel/serie/${form.post_id.value}`;
      spinner.show();
      data.set('infoadd', CKEDITOR.instances[form.infoadd.name].getData());
      $.ajax({
         url: props.ruta,
         type: 'POST',
         headers: {'X-CSRF-TOKEN' : form._token.value},
         data: data,
         cache: false,
         processData: false,
         contentType: false,
         success: res =>{
            spinner.hide();
            props.modal_edit.modal('hide');
            getSeries($("#current_page").val());
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
      props.ruta = `/panel/serie/${post_id}/destroy`;
      if(confirm('¿Seguro de elimninar el registro?')){
         spinner.show();
         $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: res =>{
               spinner.hide();
               getSeries($("#current_page").val());
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
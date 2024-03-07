@extends('layouts.app')
@section('titulo','Videos')
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
            <div class="col-xs-12 col-md-6">
               <div class="input-group has-success">
                  <span class="input-group-addon" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                  <input type="text" class="form-control" onkeyup="buscar(this);" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione enter">
               </div>
            </div>
            <div class="col-xs-12 col-md-6">
               <button onclick="createVideo();" class="btn btn-success pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo registro</button>
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
               <tbody id="videos">
                  
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
   @include('panel.video.create')
   @include('panel.video.edit')
</div>

@endsection
@section('extra_scripts')
<script src="{{asset('js/categorization_control.js')}}"></script>
<script>
   $(document).ready(function(){
      getVideos();

   });
   let props = {
      ruta: '',
      tbVideos : $("#videos"),
      modal_create : $("#modal_create"),
      modal_edit : $("#modal_edit"),
   }

   function getVideos(page = 0) {
      props.ruta = '/panel/videos-data';
      if(page != 0) props.ruta = `/panel/videos-data/?page=${page}`;
      spinner.show();
      $.ajax({
         url: props.ruta,
         type: 'GET',
         dataType: 'JSON',
         success: res=>{
            spinner.hide();
            props.tbVideos.empty();
            res.data.forEach(video =>{
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
         error: error =>{
            console.log(error);
         }
      });
   }
   function buscar(input) {
      if(input.value != ''){
         if(event.keyCode == 13){
            spinner.show()
            props.ruta =`/panel/searchVideo/${input.value}`;
            $.ajax({
               url: props.ruta,
               type: 'GET',
               dataType: 'JSON',
               success:data =>{
                  spinner.hide();
                  $(".custom-pagination").empty();
                  props.tbVideos.empty();
                  data.forEach(video =>{
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
               error: error =>{
                  console.log(error);
               }
            });
         }
      }else{
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
         headers: {'X-CSRF-TOKEN' : form._token.value},
         data: data,
         cache: false,
         processData: false,
         contentType: false,
         success: res =>{
            spinner.hide();
            props.modal_create.modal('hide');
            getVideos();
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

   function updateVideo(form) {
      event.preventDefault();
      let data = new FormData($(form)[0]);
      
      props.ruta = `/panel/video/${form.post_id.value}`;
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
            getVideos($("#current_page").val());
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
      props.ruta = `/panel/video/${post_id}/destroy`;
      if(confirm('¿Seguro de elimninar el registro?')){
         spinner.show();
         $.ajax({
            url: props.ruta,
            type: 'GET',
            dataType: 'JSON',
            success: res =>{
               spinner.hide();
               getVideos($("#current_page").val());
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
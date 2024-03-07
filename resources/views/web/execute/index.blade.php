@extends('layouts.front')
@section('titulo','Clientes')
@section('content')
@section('style-extra')

  <style>
    .modal-content,.popover{background-clip:padding-box}.modal{display:none;position:fixed;z-index:1050;-webkit-overflow-scrolling:touch;outline:0}.modal-footer:after,.modal-footer:before,.modal-header:after,.modal-header:before{display:table;content:" "}.modal.fade .modal-dialog{-webkit-transform:translate(0,-25%);transform:translate(0,-25%);transition:-webkit-transform .3s ease-out;transition:transform .3s ease-out;transition:transform .3s ease-out,-webkit-transform .3s ease-out}.modal.in .modal-dialog{-webkit-transform:translate(0,0);transform:translate(0,0)}.modal-open .modal{overflow-x:hidden;overflow-y:auto}.modal-dialog{position:relative;width:auto;margin:10px}.modal-content{position:relative;background-color:#fff;border:1px solid #999;border:1px solid rgba(0,0,0,.2);border-radius:6px;box-shadow:0 3px 9px rgba(0,0,0,.5);outline:0}.modal-backdrop{position:fixed;z-index:1040;background-color:#000}.modal-backdrop.fade{opacity:0;filter:alpha(opacity=0)}.modal-backdrop.in{opacity:.5;filter:alpha(opacity=50)}.modal-header{padding:15px;border-bottom:1px solid #e5e5e5}.modal-header .close{margin-top:-2px}.modal-title{margin:0;line-height:1.6}.modal-body{position:relative;padding:15px}.modal-footer{padding:15px;text-align:right;border-top:1px solid #e5e5e5}.modal-footer .btn+.btn{margin-left:5px;margin-bottom:0}.modal-footer .btn-group .btn+.btn{margin-left:-1px}.modal-footer .btn-block+.btn-block{margin-left:0}.modal-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}@media (min-width:768px){.modal-dialog{width:600px;margin:30px auto}.modal-content{box-shadow:0 5px 15px rgba(0,0,0,.5)}.modal-sm{width:300px}}@media (min-width:992px){.modal-lg{width:900px}}
  </style> 
@endsection

  
<div class="container">
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">
            Clientes
        </li>
    </ol>
    <div class="panel panel-success">
        <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 col-md-6">
                        <div class="input-group-exec has-success">
                          <span class="input-group-addon-exec" id="basic-addon3">Buscador <i class="fa fa-search"></i></span>
                          <input type="text" name="texto" class="form-control" onkeyup="buscar(this)" id="basic-url" aria-describedby="basic-addon3" placeholder="Escriba aquí y presione Enter">
                        </div>
                        
                    </div>
                    <div class="col-xs-12 col-md-6">
                        
                        <button   class="btn btn-success" onclick="crearClienteExecute({{Auth()->user()->id}});">Nuevo registro <i class="fa fa-plus" aria-hidden="true"></i></button>
                        
                        <button onclick="openModalFilter();" class="btn btn-warning">
                        <i class="fa fa-filter" aria-hidden="true"></i> Filtros
                    </button>
                    <button onclick="getClientes();" class="btn btn-default"><i class="fa fa-bars" aria-hidden="true"></i> Mostrar todo</button>
                        <span class="badge" id="totalReg"></span>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-condensed table-hover table-bordered">
                          <thead>
                              <th>Id</th>
                              <th>Nombres y Apellidos</th>
                              <th>Correo electrónico</th>
                              <th>F. Registro</th>
                              <th>F. Caducidad</th>
                              <th>Ejecutivo</th>
                              <th>Estado</th>
                              <th>Control</th>
                          </thead>
                          <tbody id="clientes">
                              
                          </tbody>
                      </table>
                </div>
                
                  <div class="row">
                     <div class="col-xs-12 col-md-4">
                         <div class="input-group-exec custom-pagination">
                          <!-- Render pagination here -->
                         </div>
                       </div>
                       <div class="col-xs-12 col-md-8">
                    {{-- <button onclick="exportExcel()" class="btn btn-link"><i class="fa fa-file-excel-o"></i> Exportar a Excel</button> --}}
                </div>
                  </div>

        </div>
    </div>

        @include('web.execute.filters') 
        @include('web.execute.create')
        @include('web.execute.edit')


</div>
  
 
@endsection

    @section('script-extra')
    <script>
        $(document).ready(function(){
            getClientes();
        });
    
        let props = {
            modal_create_execute :$("#modal_create_execute"), 
            modal_edit : $("#modal_edit"),
            tbClientes : $("#clientes"),
            counter : $("#totalReg"),
            ruta : ''
        }

        function closeCreateClienteExecute() {
            props.modal_create_execute.modal('hide');
        }
        function closeEditClienteExecute() {
            props.modal_edit.modal('hide');
        }
        function closeFilterExecute() {
            $("#modal_filter").modal('hide');
        } 
    
        function getClientes(page = 0) {
            spinner.show();
            props.ruta = '/executive/clientes-data';
            if(page != 0) props.ruta = `/executive/clientes-data/?page=${page}`;
    
            fetch(props.ruta)
            .then(response => response.json())
            .then(response =>{
                // if(response.data.ejecutivo[0].idejecutivo == {{Auth()->user()->id}}){
                props.tbClientes.empty();
                spinner.hide();
                props.counter.text(`${response.total} Registros`);
                console.log(response);
                response.data.forEach(cliente =>{
                    props.tbClientes.append(`
						<tr>
							<td>${cliente.user_id}</td>
							<td>${cliente.user_name} ${cliente.user_last_name}</td>
							<td>${cliente.user_email}</td>
							<td>${dateFormat(cliente.fecha_registro)}</td>
							<td>${dateFormat(cliente.fecha_caducidad)}</td>
							<td>${cliente.ejecutivo_nombres} ${cliente.ejecutivo_apellidos}</td>
							<td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
							<td>
								<button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
								<button onclick="destroyClient(${cliente.user_id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
							</td>
						</tr>
					`);

                        // props.tbClientes.append(`
                        //     <tr>
                        //         <td>${cliente.user.id}</td>
                        //         <td>${cliente.user.name} ${cliente.user.last_name}</td>
                        //         <td>${cliente.user.email}</td>
                        //         <td>${dateFormat(cliente.fecha_registro)}</td>
                        //         <td>${dateFormat(cliente.fecha_caducidad)}</td>
                        //         <td>${cliente.ejecutivo[0].nombres} ${cliente.ejecutivo[0].apellidos}</td>
                        //         <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
                        //         <td>
                        //             <button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
                        //                                   <i class="fa fa-plus" aria-hidden="true"></i> Curso
                        //                         </button>
                        //             <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
                        //             <button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                        //         </td>
                        //     </tr>
                        // `);
                    
                });
    
                renderPagination(response,'getClientes');
                
            // }
            })
            .catch(error =>{
                console.log(error);
            });
        } 

        function buscar(input) {
            if(input.value != ''){
                if (event.keyCode == 13){
                    spinner.show();
                    props.ruta = `/executive/clientes/search?text=${input.value}`;
                    $.ajax({
                        url: props.ruta,
                        type: 'GET',
                        dataType: 'JSON',
                        success:function(data){
                            props.tbClientes.empty();
                            props.counter.empty();
                            $(".custom-pagination").empty();
                            spinner.hide();
    
                            if(data.length > 0){
                                data.forEach(cliente =>{
                                    props.tbClientes.append(`
                                        <tr>
                                            <td>${cliente.user_id}</td>
                                            <td>${cliente.user_name} ${cliente.user_last_name}</td>
                                            <td>${cliente.user_email}</td>
                                            <td>${dateFormat(cliente.fecha_registro)}</td>
                                            <td>${dateFormat(cliente.fecha_caducidad)}</td>
                                            <td>${cliente.ejecutivo_nombres} ${cliente.ejecutivo_apellidos}</td>
                                            <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
                                            <td>
                                                <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
                                                <button onclick="destroyClient(${cliente.user_id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                            </td>
                                        </tr>
                                    `);
                                // props.tbClientes.append(`
                                //         <tr>
                                //             <td>${cliente.user.id}</td>
                                //             <td>${cliente.user.name} ${cliente.user.last_name}</td>
                                //             <td>${cliente.user.email}</td>
                                //             <td>${dateFormat(cliente.fecha_registro)}</td>
                                //             <td>${dateFormat(cliente.fecha_caducidad)}</td>
                                //             <td>${cliente.ejecutivo[0].nombres} ${cliente.ejecutivo[0].apellidos}</td>
                                //             <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
                                //             <td>
                                //                 <button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
                                //                           <i class="fa fa-plus" aria-hidden="true"></i> Curso
                                //                 </button>
                                //                 <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
                                //                 <button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                //             </td>
                                //         </tr>
                                //     `);
                                });
                            }else{
                                props.tbClientes.append('<span>Busqueda sin resultados</span>');
                            }
    
                        },
                        error: error =>{
                            spinner.hide();
                            console.log(error);
                            toastr.error(error.statusText,error.status);
                        }
                    });
                    
                }
            }else{
                getClientes();
            }
    
        }
    
        function crearClienteExecute(idejecutivo) {
            // props.modal_create_execute.modal();
            props.modal_create_execute.modal('show');
            let formCreateExec = $("#createFormExec")[0];
            props.ruta = '/executive/ejecutivos-all';
            fetch(props.ruta)
            .then(response => response.json())
            .then(response => {
                // $("#ejecutivos_create").empty();
                // response.forEach(ejec =>{
                //     $("#ejecutivos_create").append(`
                //             <option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
                //         `);
                // });     
                    formCreateExec.ejecutivos_name.value = response.nombres+" "+response.apellidos;      
            })
            .catch(error =>{
                console.log(error);
            });
            
            formCreateExec.idejecutivo.value = idejecutivo;       
            
            
        }
    
        function saveCliente(form) {
            event.preventDefault();
            if(validateForm(form)){
                spinner.show();
                props.ruta = '/executive';
                let	token = '{{ csrf_token() }}',
                    data = $(form).serialize();
                $.ajax({
                    url: props.ruta,
                    type: 'POST',
                    headers:{'X-CSRF-TOKEN': token},
                    data: data,
                    dataType: 'JSON',
                    success: data =>{
                        spinner.hide();
                        if(data.status == 200){
                            props.modal_create_execute.modal('hide');
    
                            getClientes();
                            
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
                    error: error =>{
                        console.log(error);
                    }
                });
            }
        }
    
        function editCliente(cliente) {
            // props.modal_edit.modal();
            props.modal_edit.modal('show');
            props.ruta = '/executive/ejecutivos-all';
            fetch(props.ruta)
            .then(response => response.json())
            .then(response => {
                $("#ejecutivos_edit").empty();
                // response.forEach(ejec =>{
                //     if(cliente.ejecutivo){    
                //         if(cliente.ejecutivo[0].idejecutivo == ejec.idejecutivo){
                //         $("#ejecutivos_edit").append(`
                //                 <option selected value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
                //             `);
                //         }else{
                //             $("#ejecutivos_edit").append(`
                //                     <option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
                //                 `);
                //         }
                //     }else{       
                //         $("#ejecutivos_edit").append(`
                //                 <option value="${ejec.idejecutivo}">${ejec.nombres} ${ejec.apellidos}</option>
                //             `);
                //     }     
                // });
            })
            .catch(error =>{
                console.log(error);
            });
            
            let formEdit = $("#editform")[0];
            // formEdit.user_id.value = cliente.user.id;
            // formEdit.name.value = cliente.user.name;
            // formEdit.last_name.value = cliente.user.last_name;
            // formEdit.email.value = cliente.user.email;
            // formEdit.phone_number.value = cliente.user.phone_number;
            // formEdit.doc_number.value = cliente.user.doc_number;
            // formEdit.address.value = cliente.user.address;
            // formEdit.empresa.value = cliente.empresa;
            // formEdit.caducidad.value = cliente.fecha_caducidad;
            // $(formEdit.status).empty();
            // $(formEdit.status).append(`
            //         <option ${cliente.status == 0 ? 'selected' : ''} value="0">Inactivo</option>
            //         <option ${cliente.status == 1 ? 'selected' : ''} value="1">Activo</option>
            //     `);
            // $(formEdit.medio).empty();
            // $(formEdit.medio).append(`
            //         <option ${cliente.medio == 'RC' ? 'selected' : ''} value="RC">RC</option>
            //         <option ${cliente.medio == 'TM' ? 'selected' : ''} value="TM">TM</option>
            //         <option ${cliente.medio == 'DA' ? 'selected' : ''} value="DA">DA</option>
            //     `); 
            formEdit.user_id.value = cliente.user_id;
            formEdit.idejecutivo.value = cliente.idejecutivo;
            formEdit.ejecutivos_name.value = cliente.ejecutivo_nombres+" "+cliente.ejecutivo_apellidos;            
            formEdit.name.value = cliente.user_name;
            formEdit.last_name.value = cliente.user_last_name;
            formEdit.email.value = cliente.user_email;
            formEdit.phone_number.value = cliente.user_phone_number;
            formEdit.doc_number.value = cliente.user_doc_number;
            formEdit.address.value = cliente.user_address;
            formEdit.empresa.value = cliente.empresa;
            formEdit.caducidad.value = cliente.fecha_caducidad;
            $(formEdit.status).empty();
            $(formEdit.status).append(`
                    <option ${cliente.status == 0 ? 'selected' : ''} value="0">Inactivo</option>
                    <option ${cliente.status == 1 ? 'selected' : ''} value="1">Activo</option>
                `);
            $(formEdit.medio).empty();
            $(formEdit.medio).append(`
                    <option ${cliente.medio == 'RC' ? 'selected' : ''} value="RC">RC</option>
                    <option ${cliente.medio == 'TM' ? 'selected' : ''} value="TM">TM</option>
                    <option ${cliente.medio == 'DA' ? 'selected' : ''} value="DA">DA</option>
                `);
    
        }
    
        function updateCliente(form) {
            event.preventDefault();
            if(validateForm(form)){
                spinner.show();
                props.ruta = `/executive/${form.user_id.value}`;
                let	token = '{{ csrf_token() }}',
                    data = $(form).serialize();
                $.ajax({
                    url: props.ruta,
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    dataType: 'JSON',
                    success: data =>{
                        spinner.hide();
                        if(data.status == 200){
                            props.modal_edit.modal('hide');
    
                            getClientes($("#current_page").val());
                            
                            toastr.success(data.message,'Exito');
                            $(form).trigger('reset');
                        }
    
                        if(data.status == 422) {
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

        //  function openModalAsignC(userId) {
        //     let formAsign = $("#form-asign-c")[0];
        //     props.ruta = '/panel/cursos-data';
        //     $.ajax({
        //         url: props.ruta,
        //         type: 'GET',
        //         dataType: 'JSON',
        //         success: res =>{
        //             console.log("aaaa");
        //             console.log(res);
        //             $(formAsign.gestor).empty();
        //             res.cursos.forEach(curso =>{
        //                 $(formAsign.gestor).append(`
        //                         <option value="${curso.id}">${curso.titulo}</option>
        //                     `);
        //             });
    
        //             $(formAsign.gestor_a).empty();
        //             res.gestores.forEach(user =>{
        //                 $(formAsign.gestor_a).append(`
        //                         <option value="${user.id}">${user.name} ${user.last_name}</option>
        //                     `);
        //             });
    
    
        //         },
        //         error: error =>{
        //             console.log(error);
        //         }
        //     });
    
        //     $(formAsign.user_id).val(userId);
        //     $('#modalasign1').modal();
        // }
    
        // function saveAsignationc(form) {
        //     event.preventDefault();
        //     props.ruta = '/panel/asignatecurso';
        //     let	data = $(form).serialize();
        //         spinner.show();
        //     $.ajax({
        //         url: props.ruta,
        //         type:'POST',
        //         dataType: 'JSON',
        //         data: data,
        //         success: res =>{
        //             spinner.hide();
        //             $('#modalasign1').modal('hide');
    
        //             getSubscribers($("#current_page").val());
        //             toastr.success(res.message,'Exito');
        //         },
        //         error: error =>{
        //             console.log(error);
        //         }
        //     });
        // }
    
        function destroyClient(userId) {
            if(confirm('¿Seguro de eliminar el registro?')){
                spinner.show();
                props.ruta = `/executive/user/${userId}/destroy-json`;
                $.ajax({
                    url: props.ruta,
                    type: 'GET',
                    dataType: 'JSON',
                    success: res =>{
                        spinner.hide();
                        getClientes($("#current_page").val());
                        toastr.success(res.message,'Exito');
    
                    },
                    error: error =>{
                        console.log(error);
                    }
    
                });
            }
        }

        function getPrevInfo() {
            props.ruta = '/panel/filters-to-clients';
            $.ajax({
                url: props.ruta,
                type: 'GET',
                dataType: 'JSON',
                success: data =>{
                    $("#ejecutivos-filter").empty();
                    $("#ejecutivos-filter").append(`
                        <div class="radio">
                          <label>
                            <input type="radio" name="ejecutivo" id="ejecutivox" value="0" checked>
                               Todo
                          </label>
                        </div>
                        `);
                    data.ejecutivos.forEach((ejec, index )=>{
                        $("#ejecutivos-filter").append(`
                            <div class="radio">
                              <label>
                                <input type="radio" name="ejecutivo" id="ejecutivo${ejec.idejecutivo}" value="${ejec.idejecutivo}">
                                   ${ejec.nombres} ${ejec.apellidos}
                              </label>
                            </div>
                            `);
                    });
                },
                error: error =>{
                    console.log(error);
                }
            });
        }
    
        function openModalFilter() {
            // $("#modal_filter").modal();
            $("#modal_filter").modal('show');
        }
    
        function applyFilter(page = 0) {
            event.preventDefault();
    
            if(page != 0){
                props.ruta = `/executive/filter/?page=${page}`;
            }else{
                props.ruta = '/executive/filter/';
            }
            let data = $("#form_filter").serialize(),
                token = '{{csrf_token()}}';
    
            spinner.show();
    
            $.ajax({
                url: props.ruta,
                type: 'GET',
                headers: {'X-CSRF-TOKEN': token},
                data: data,
                dataType: 'JSON',
                success: response =>{
                    props.counter.text(`${response.total} Registros`);
                    if(Array.isArray(response.data)){
                        clientes = response.data;
                    }else{
                        clientes = Object.values(response.data);
                    }
                    props.tbClientes.empty();
                    $("#modal_filter").modal('hide');
                    spinner.hide();
                        if(clientes.length > 0){
                                clientes.forEach(cliente =>{
                                    props.tbClientes.append(`
                                        <tr>
                                            <td>${cliente.user_id}</td>
                                            <td>${cliente.user_name} ${cliente.user_last_name}</td>
                                            <td>${cliente.user_email}</td>
                                            <td>${dateFormat(cliente.fecha_registro)}</td>
                                            <td>${dateFormat(cliente.fecha_caducidad)}</td>
                                            <td>${cliente.ejecutivo_nombres} ${cliente.ejecutivo_apellidos}</td>
                                            <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
                                            <td>
                                                <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
                                                <button onclick="destroyClient(${cliente.user_id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                            </td>
                                        </tr>
                                    `);
                                    // props.tbClientes.append(`
                                    //     <tr>
                                    //         <td>${cliente.user.id}</td>
                                    //         <td>${cliente.user.name} ${cliente.user.last_name}</td>
                                    //         <td>${cliente.user.email}</td>
                                    //         <td>${dateFormat(cliente.fecha_registro)}</td>
                                    //         <td>${dateFormat(cliente.fecha_caducidad)}</td>
                                    //         <td>${cliente.ejecutivo[0] ? cliente.ejecutivo[0].nombres + " " +cliente.ejecutivo[0].apellidos : "-" } </td>
                                    //         <td>${cliente.status == 1 ? 'Activo' : 'Inactivo'}</td>
                                    //         <td>
                                    //             <button type="button" onclick='openModalAsignC(${cliente.user.id})' class="btn btn-light btn-sm" title="Asignar Curso">
                                    //                                   <i class="fa fa-plus" aria-hidden="true"></i> Curso
                                    //                         </button>
                                    //             <button onclick='editCliente(${JSON.stringify(cliente)})' class="btn btn-primary btn-sm"><i class="fa fa-pencil-alt"></i> Editar</button>
                                    //             <button onclick="destroyClient(${cliente.user.id});" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Borrar</button>
                                    //         </td>
                                    //     </tr>
                                    //     `)
                                });
    
                            renderPagination(response,'applyFilter');
                        }else{
                            props.tbClientes.append('<span>Filtro sin registros</span>');
                            $(".custom-pagination").empty();
                        }
    
                },	
                error: error =>{
                    console.log(error);
                }
            });
    
        }
    
        function exportExcel() {
    
            let data = $("#form_filter").serialize();
            let url_download = `/executive/download?${data}`;
    
            window.location = url_download;
    
        }
    
    </script>
            
    <script type="text/javascript">
            $(document).ready(function(){
          /*    spinner.show();*/
            });
            
            $("#switch").on('click',function(){
                $("#morevids").toggle('slow');
                $("#switch").hide();
            });
    </script>


@endsection

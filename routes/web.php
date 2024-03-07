<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------

*/
//Ruta para los visitantes sin login
Route::get('/','FrontController@index')->name('home');

Route::get('login/{driver}', 'SocialProfileController@redirectToProvider');
Route::get('login/{driver}/callback', 'SocialProfileController@handleGoogleCallback');

/*Route::get('/login-facebook','FrontController@LoginFacebook')->name('login-facebook');

Route::get('/facebook-callback','FrontController@FacebookCallback')->name('facebook-callback');*/

Route::get('planes-de-suscripcion/{slug}','FrontController@getPlanes')->name('planes');
Route::get('revistas/{medio?}', 'FrontController@getrevistas')->name('revistas');
//Route::get('landing/{medio}','FrontController@landing')->name('registrarcliente');

//Route::get('agradecimiento','FrontController@agradecimiento')->name('agradecimiento');


//Route::get('agradecimiento/deposito','FrontController@agradecimientode')->name('agradecimientode');
//Route::get('envio/','FrontController@agradecimiento')->name('agradecimiento');

Route::get('mailCursoInteres', 'FrontController@mailCursoInteres')->name('mailCursoInteres');

//Route::get('eventos-proximos','FrontController@getEventos')->name('eventos');
//cambios
Route::get('agradecimiento','FrontController@agradecimiento')->name('agradecimiento');
Route::get('rubro/{slug}','FrontController@getRubro')->name('getRubro');

Route::get('empresas','FrontController@empresas')->name('empresas');
Route::post('empresa/suscription','FrontController@empresasuscrip')->name('empresasuscrip');

//Ruta para listar aticulos por rubro,categoriapzf
Route::get('eventos/rubro/{slug}','FrontController@eventosRubro');

Route::get('plan/{slug}','FrontController@getplan')->name('getPlan');

//Ruta para cursos
Route::get('cursos/rubro/{slug}','FrontController@cursosRubro')->name('getcursosP');
Route::get('cursos-vivo/rubro/{slug}','FrontController@cursosVivo')->name('getCursoV');
Route::get('cursos-realizados/rubro/{slug}','FrontController@cursosReal')->name('getCursoR');
Route::get('curso/{slug}','FrontController@getcurso')->name('getcurso');

Route::get('curso/card/{slug}/{moneda}','FrontController@getcursocard')->name('getcursocard');
Route::get('curso/success/card/{slug}','FrontController@getcursosuccess')->name('getcursosuccess');
Route::get('curso/success/{slug}','FrontController@cursosuccess')->name('cursosuccess');

Route::get('clase/{slug}','FrontController@getclase')->name('getclase');
Route::get('clase1/{slug}','FrontController@getclase1')->name('getclase1');

Route::get('preguntas-frecuentes','FrontController@getprefrecuentes')->name('getprefrecuentes');


//Ruta para listar aticulos por rubro,categoria
Route::get('articulos/rubro/{slug}','FrontController@articulosRubro')->name('articuloRubro');
Route::get('articulos/categoria/{slug}','FrontController@articulosCategoria')->name('articuloCat');;
Route::get('articulos/subcategoria/{slug}','FrontController@articulosSubCategoria')->name('articuloSCat');
//Ruta para listar articulos por autores
Route::get('articulos/autor/{autor}','FrontController@articulosAutor');


//Ruta para listar videos por rubro
Route::get('videos/rubro/{slug}','FrontController@videosRubro')->name('videoRubro');

Route::get('videos/categoria/{slug}','FrontController@videosCategoria')->name('videoCat');
Route::get('videos/subcategoria/{slug}','FrontController@videosSubCategoria')->name('videoSCat');
Route::get('videos/autor/{slug}/{rubro}','FrontController@videosAutor');

Route::get('cursos/autor/{slug}/{rubro}','FrontController@cursosAutor');

Route::get('autor/{slug}','FrontController@getAutor')->name('getAutor');

//Ruta para listar series por rubro
Route::get('series', 'FrontController@getseries')->name('series');
Route::get('series/rubro/{slug}','FrontController@seriesRubro')->name('serieRubro');

Route::get('series/categoria/{slug}','FrontController@seriesCategoria')->name('serieCat');
Route::get('series/subcategoria/{slug}','FrontController@seriesSubCategoria')->name('serieSCat');
Route::get('series/autor/{slug}','FrontController@seriesAutor');
Route::get('serie/{slug}','FrontController@getSerie')->name('getserie')->middleware('checkacceso');


//Ruta para buscar
Route::get('search','FrontController@searchQuery')->name('search');

Route::get('{slug}/search','FrontController@searchQueryRubro');
//Ruta para ver el detalle de un video
Route::get('video/{slug}','FrontController@getVideo')->name('getvideo')->middleware('checkacceso');

//Ruta para detalle de articulo
Route::get('articulo/{slug}','FrontController@getArticulo')->name('getarticulo')->middleware('checkacceso');

//Ruta para abrir una edicion de revista
Route::get('revista/{medio}/{edicion}','FrontController@getRevista')->name('getrevista')->middleware('checkacceso');

// Ruta para suplemento tecnico
Route::get('suplemento-tecnico/success','FrontController@getsuplementos')->name('suplemento-success');

Route::get('suplemento-tecnico','FrontController@getsuplemento')->name('suplementos')->middleware('checkacceso');


Route::get('nosotros','FrontController@getnosotros')->name('nosotros');
Route::get('privacidad','FrontController@getprivacidad')->name('privacidad');
Route::get('terminos','FrontController@getterminos')->name('terminos');
Route::get('contacto','FrontController@getcontacto')->name('contacto');

Route::post('contacto','HomeController@sendContacto')->name('contacto');

//Ruta para mostrar promocion activa
Route::get('promo/{slug}','DashboardController@getPromo')->name('promo.active');
// Ruta para listar revistas por Medio API
Route::get('revistas-data/{medio}','RevistaController@getRevistas');

//University
Route::get('/register/ucal', 'UniversityController@get_register_ucal')->name('register.uni.ucal');
Route::post('/register/ucal', 'UniversityController@store')->name('register.uni.store');

//Toda las rutas para autenticacion de usuarios
Auth::routes();
// JHED EJECUTIVO
//Grupo de ruta para ejecutivos
Route::group(['middleware' => 'auth'], function () {
	Route::get('executive', 'ExecuteController@index')->name('executive.index');
 	//Ruta para listar clientes suscritas
	Route::post('executive', 'ExecuteController@store');
	//Ruta para actualizar datos del cliente
	Route::get('executive/clientes-data/{page?}', 'ExecuteController@getClientes');
	//Ruta para buscar clientes ExecuteController por nombre
	Route::get('executive/clientes/search', 'ExecuteController@search');
	//Ruta para guadar cliente
	Route::put('executive/{id}', 'ExecuteController@update');
	//Ruta para convertir a suscriptor free a cliente (en desuso)
	Route::get('convertoclient/{id}', 'ExecuteController@frmConvert')->name('convertoclient.create');
	Route::put('convertoclient/{id}', 'ExecuteController@convertStore')->name('convertoclient');
	//filtros de clientes
	Route::get('filters-to-clients', 'ExecuteController@getFiltterToClients');

	Route::get('executive/filter/', 'ExecuteController@applyFilters');

	Route::get('executive/download', 'ExecuteController@downloadDataFilter');
	Route::get('executive/user/{id}/destroy-json', 'ExecuteController@destroyByAjax'); 
	
	Route::get('executive/ejecutivos-all', 'ExecuteController@getEjecutivosAll');
});
// JHED EJECUTIVO
//Grupo de ruta para suscriptores
Route::group(['middleware'=>'auth'],function(){

	//ruta para encviar solicitud para la promocion
	Route::get('sendmailpromo/{id}','DashboardController@sendMailpromo')->name('sendmail.promo');

	Route::post('solicitudeposito','FrontController@solicituDeposito')->name('solicitudeposito');

	//Rutas para crear suscripcion a un plan
	Route::get('plan/{slug}/{promo_id?}','FrontController@frmSuscription')->name('plan');
	Route::post('createcargo','FrontController@createCargo');
	Route::post('createcargo/promo','FrontController@createCargoPromo');
	Route::post('createrenovacion','FrontController@createRenovacion');
	//PAGOS YAPE
	Route::post('paySuscYape', 'SusbYapeController@pay_susc_yape');
	// PAGOS PAYPAL
	Route::post('suscripcionPaypalRecurrente', 'PaypalController@suscripcionPaypalRecurrente');
	//PAGOS PAYPAL
	Route::post('suscripcionPaypalCurso', 'PaypalController@suscripcionPaypalCurso');

	//ruta para cancelar suscripci車n
	Route::get('cancelsus','FrontController@cancelsus')->name('cancelsus');

	Route::post('createsus','FrontController@createsus')->name('createsus');

	
	//Ruta para descargar articulo
	Route::get('downloadarticulo/{idpost}','FrontController@downloadArticulo')->name('downloadarticulo');
	//Ruta para guardar like del usuario
	Route::post('savelikepost','FrontController@saveLikePost')->name('savelikepost');
	//Ruta para guardar comentario
	Route::post('savecoment','FrontController@saveComent')->name('savecoment');
	//Ruata para guardar respuesta del comentario
	Route::post('saverespuesta','FrontController@saveRespuesta')->name('saverespuesta');
	//Ruta para guardar favorito
	Route::post('savemarker','FrontController@saveMarker')->name('savemarker');
	
	//Ruta para suplemento tecnico
	
	Route::get('changesuplemento','FrontController@changeSuplemento')->name('changesuplemento');
	Route::get('downloadsumplemento/{edicion}/{filename}','FrontController@downloadSuplemento')->name('downloadsumplemento')->middleware('checkacceso');
	//Ruta para reportar algun problema en la plataforma
	Route::get('report',function(){
		return view('web.reportar');
	})->name('report');
	Route::post('reportbug','HomeController@sendReportbug')->name('reportbug');

	Route::get('cursos/beneficios','FrontController@beneficios')->name('getbeneficios');
	Route::get('curso/beneficio/{slug}','FrontController@beneficiocurso')->name('getbeneficio');
	Route::post('curso/beneficio','FrontController@beneficiocreate')->name('postbeneficio');

    //crear suscripcion curso
	Route::post('suscripcioncurso','FrontController@suscripcioncurso');
	
	// PAGOS YAPE
	Route::post('payCursoYape', 'SusbYapeController@pay_curso_yape');
	Route::post('paySubscriptionYape', 'SusbYapeController@pay_subscription_yape');

	Route::get('cursos/miscursos','FrontController@getmiscursos')->name('getmiscursos');

	Route::get('cursos/misintereses','FrontController@getmisintereses')->name('getmisintereses');


	Route::get('clases/{slug}','FrontController@getclases')->name('getclases');

	Route::get('evaluacion/{slug}','FrontController@getevaluacion')->name('getevaluacion');

	Route::post('enviarcuestionario','FrontController@envcuestionario')->name('envcuestionario');
	Route::get('resultado/{slug}','FrontController@getresultado')->name('getresultado');

	Route::post('savelikecurso','FrontController@saveLikeCurso')->name('savelikecurso');

	Route::post('saveInterescurso','FrontController@saveInteresCurso')->name('saveInterescurso');

	//Ruta para guardar comentario curso
	Route::post('savecomentcurso','FrontController@saveComentcurso')->name('savecomentcurso');
	//Ruata para guardar respuesta del comentario curso
	Route::post('saverespuestacurso','FrontController@saveRespuestacurso')->name('saverespuestacurso');

	Route::post('formcertificado','FrontController@SaveCertificado')->name('savecertificado');

 	Route::post('encuesta_user','FrontController@encuesta_user')->name('encuesta_user');
 	
	//checkout
	Route::get('checkout',   'FrontController@checkout')->name('checkout');
    Route::get('/gracias',   'FrontController@new_checkout')->name('new_checkout');
	
	//Grupo de rutas para dashboard del usuario
	Route::group(['prefix'=>'/profile'],function(){
		
		
		Route::get('mi-cuenta','FrontController@getmicuenta')->name('getmicuenta');
		Route::get('mis-cursos','FrontController@getmiscursosp')->name('getmiscursosp');
		Route::get('/','DashboardController@getProfile')->name('profile');
		Route::get('changepassword','DashboardController@frmChangePassword')->name('changepassword');
		Route::post('updatepassword','DashboardController@changePassword')->name('updatepassword');
		Route::get('edituser','DashboardController@editUser')->name('edituser');
		Route::put('updateuser/{id}','DashboardController@updateUser')->name('updateuser');
		Route::get('suscription','DashboardController@editSuscription')->name('suscription');
		Route::get('favoritos','DashboardController@editFavoritos')->name('favoritos');
		Route::get('generateboleta/{pago_id}','DashboardController@generateBoleta')->name('generate.boleta');
		Route::get('voucher/create/{pago_id}','DashboardController@frmVoucher')->name('voucher.create');
		Route::post('solicitudvoucher','DashboardController@solicitudVoucher')->name('solicitudvoucher');

		//Rutas para el manejo de notificaciones
		Route::post('notifications','NotificationController@store')->name('notifications.store');

		// Ruta para mostrar vista de chat
		Route::get('chat','ChatController@index')->name('chat.index');
		Route::get('messages', 'ChatController@getMessages');
		Route::post('message','ChatController@store');

		//Ruta para obtener cargos del plan desde culqi
			Route::get('cargos','FrontController@getcargos')->name('cargos');
			Route::get('cargos/cargos-data','DashboardController@datacargos');
			Route::get('cargos/vaucher/{date}','DashboardController@vauchercargorecurrente');

	});

	//Grupo de ruta para usuarios miembro del sistema
	Route::group(['prefix'=>'/panel'],function(){
		Route::get('cargos','FrontController@getcargos')->name('cargos');
			Route::get('cargos/cargos-data','DashboardController@datacargos');
			Route::get('cargos/vaucher/{date}','DashboardController@vauchercargorecurrente');

		Route::get('/','HomeController@index');
		Route::get('planes-data','HomeController@getPlanesJSON');
		Route::get('planes-gestor-data','HomeController@getPlanesGestorJSON');
		Route::get('filters-to-subscribers','HomeController@getFiltterToSubscribers');
		
		// PAGOS YAPE
		Route::get('data_plan_gestor_yape', 'SusbYapeController@getPlanGestorJSON');

		Route::get('filters-to-subscribers-cursos','HomeController@getFiltterToSubscribersCursos');

		// Mostrar historial en el Dashboard
		Route::get('logs-data','RecordController@getLogs');
		//Lista los asesores de suscripcion
		Route::get('asesores-data','UserController@getAsesores');

		//Lista los asesores de suscripcion
		Route::get('cursos-data','FrontController@getCursos');
		Route::get('cursos-precio', 'HomeController@gerCursoPrecio');

		Route::group(['middleware'=>'permiso:mod_content'],function(){
			// Lista categorias del rubro elegido
			Route::get('getcategs/{id}','HomeController@getcategs');
			// Lista subcategorias de la categoria elegida
			Route::get('getsubcates/{id}','HomeController@getsubcates');
			//Ruta para Rubros
			Route::resource('rubros','RubroController');
			Route::get('rubros-data','RubroController@getRubros');
			Route::get('rubros-all','RubroController@getRubrosAll');
			Route::get('rubros/{id}/destroy','RubroController@destroy')->name('rubro.destroy');

			Route::get('rubro/sliders/{slug}','RubroController@slider')->name('rubro.slider');
			Route::get('rubro/slider-edit/{id}','RubroController@geteditSlider')->name('rubro.geteditSlider');
			Route::post('rubro/slider-create','RubroController@storeSlider')->name('rubro.slider.create');

			Route::post('rubro/slider-edit','RubroController@editSlider')->name('rubro.slider.edit');

			Route::get('slider/delete/{id}','RubroController@destroySlider')->name('slider.delete');

			//Ruta para categorias
			Route::get('categorias/rubro/{rub_id}','CategoriaController@index')->name('categorias.index');
			Route::get('categorias-data','CategoriaController@getCategorias');
			Route::resource('categorias','CategoriaController',['except'=>'index']);
			Route::get('categorias/{id}/destroy','CategoriaController@destroy');

			//Ruta para sub-categorias
			Route::get('subcates/categ/{categ_id}','SubcateController@index')->name('subcate.index');
			Route::get('subcates-data','SubcateController@getSubcates');
			Route::resource('subcates','SubcateController',['except'=>'index']);
			Route::get('subcates/{id}/destroy','SubcateController@destroy')->name('subcate.destroy');

			//Ruta para Editoriales (En desuso)
			Route::resource('editorial','EditorialController');

			//Ruta para Autores
			Route::get('autores','AutorController@index')->name('autores.index');
			Route::get('autores/{id}','AutorController@getAutor');
			Route::get('autores-data/{page?}','AutorController@getAutores');
			Route::get('autores-all','AutorController@getAutorsAll');
			Route::post('autores','AutorController@store');
			Route::put('autores/{id}','AutorController@update');
			Route::get('autores/{id}/destroy','AutorController@destroy')->name('autor.destroy');

			

			//Ruta para videos
			Route::get('videos-data','VideoController@getVideos');
			Route::resource('video','VideoController');
			Route::get('video/{id}/destroy','VideoController@destroy')->name('video.destroy');
			Route::get('searchVideo/{texto}','VideoController@search');

			//Ruta para series
			Route::get('series-data','SerieController@getSeries');
			Route::resource('serie','SerieController');
			Route::get('serie/{id}/destroy','SerieController@destroy')->name('serie.destroy');
			Route::get('searchSerie/{texto}','SerieController@search');

			//Ruta para Art赤culos
			Route::get('articulos','ArticleController@index')->name('articulos.index');
			Route::get('articulos-data','ArticleController@getArticles');
			Route::post('articulos','ArticleController@store');
			Route::put('articulos/{id}','ArticleController@update');
			Route::get('articulos/search/{texto}','ArticleController@search');
			Route::get('articulos/{id}/destroy','ArticleController@destroy');

			//Ruta para CRUD de secci車n de eventos
			Route::get('eventos', 'EventController@index')->name('events.index');
			Route::get('eventos-data', 'EventController@getEvents');
			Route::post('eventos', 'EventController@store');
			Route::put('eventos/{id}', 'EventController@update');
			Route::get('eventos/{id}/destroy', 'EventController@destroy');

			//Ruta para obtener tipos de eventos
			Route::get('event-type-data', 'EventController@getTypeEvents');
			
			
			
		//Ruta para cursos
			Route::get('cursos','CursoController@index')->name('cursos');
			Route::get('curso/create','CursoController@create')->name('curso.create');
			Route::post('curso/store','CursoController@store')->name('curso.store');
			Route::get('curso/edit/{id}','CursoController@edit')->name('curso.editar');
			Route::post('curso/update/{id}','CursoController@update')->name('curso.update');
			Route::get('curso/delete/{id}','CursoController@destroy')->name('curso.delete');
			
			Route::get('curso/buscador','CursoController@buscador')->name('curso.buscador');

         //Ruta para temas   
			Route::get('curso/temas/{id}','TemaController@tema')->name('temas');
			Route::get('tema/create','TemaController@create')->name('tema.create');
			Route::post('tema/store','TemaController@store')->name('tema.store');
			Route::get('tema/edit/{id}','TemaController@edit')->name('tema.editar');
			Route::post('tema/update/{id}','TemaController@update')->name('tema.update');
			Route::get('tema/delete/{id}','TemaController@destroy')->name('tema.delete');


			//Ruta para clases
			Route::post('clase/create','ClaseController@store')->name('clase.create');
			Route::get('curso/clases/{id}','ClaseController@clase')->name('clase');
			Route::get('clase/edit/{id}','ClaseController@edit')->name('clase.editar');
			Route::post('clase/update/{id}','ClaseController@update')->name('clase.update');
			Route::get('clase/delete/{id}','ClaseController@destroy')->name('clase.delete');
			Route::get('clase/buscador','ClaseController@buscador')->name('clase.buscador');

			//Ruta para materiales
			Route::post('material/create','MaterialController@store')->name('material.create');
			Route::get('curso/materiales/{id}','MaterialController@material')->name('material');
			Route::get('material/edit/{id}','MaterialController@edit')->name('material.editar');
			Route::post('material/update/{id}','MaterialController@update')->name('material.update');
			Route::get('material/delete/{id}','MaterialController@destroy')->name('material.delete');
			Route::get('material/buscador','MaterialController@buscador')->name('material.buscador');


			//Ruta para evaluación
			Route::post('evaluacion/create','EvaluacionController@store')->name('evaluacion.create');
			Route::get('curso/evaluaciones/{id}','EvaluacionController@evaluacion')->name('evaluacion');
			Route::get('evaluacion/edit/{id}','EvaluacionController@edit')->name('evaluacion.editar');
			Route::post('evaluacion/update/{id}','EvaluacionController@update')->name('evaluacion.update');
			Route::get('evaluacion/delete/{id}','EvaluacionController@destroy')->name('evaluacion.delete');
			Route::get('evaluacion/buscador','EvaluacionController@buscador')->name('evaluacion.buscador');

			//Ruta para cuestionario
			Route::post('cuestionario/create','CuestionarioController@store')->name('cuestionario.create');
			Route::get('evaluacion/cuestionarios/{id}','CuestionarioController@cuestionario')->name('cuestionario');
			Route::get('cuestionario/edit/{id}','CuestionarioController@edit')->name('cuestionario.editar');
			Route::post('cuestionario/update/{id}','CuestionarioController@update')->name('cuestionario.update');
			Route::get('cuestionario/delete/{id}','CuestionarioController@destroy')->name('cuestionario.delete');
			Route::get('cuestionario/buscador','CuestionarioController@buscador')->name('cuestionario.buscador');


			//Ruta para respuesta
			Route::post('respuesta/create','RespuestasController@store')->name('respuestas.create');
			Route::get('cuestionario/respuestas/{id}','RespuestasController@respuestas')->name('respuestas');
			Route::get('respuesta/edit/{id}','RespuestasController@edit')->name('respuestas.editar');
			Route::post('respuesta/update/{id}','RespuestasController@update')->name('respuestas.update');
			Route::get('respuesta/delete/{id}','RespuestasController@destroy')->name('respuestas.delete');
			Route::get('respuesta/buscador','RespuestasController@buscador')->name('respuestas.buscador');


			//Ruta para patrocinadores
			Route::get('sponsors','SponsorController@index')->name('sponsors');
			Route::get('sponsor/create','SponsorController@create')->name('sponsor.create');
			Route::post('sponsor/store','SponsorController@store')->name('sponsor.store');
			Route::get('sponsor/edit/{id}','SponsorController@edit')->name('sponsor.editar');
			Route::post('sponsor/update/{id}','SponsorController@update')->name('sponsor.update');
			Route::get('sponsor/delete/{id}','SponsorController@destroy')->name('sponsor.delete');
			
			Route::get('sponsor/buscador','SponsorController@buscador')->name('sponsor.buscador');


			//Ruta para patrocinadores
			Route::get('colaboradores','ColaboradoresController@index')->name('colaboradores');
			Route::get('colaborador/create','ColaboradoresController@create')->name('colaborador.create');
			Route::post('colaborador/store','ColaboradoresController@store')->name('colaborador.store');
			Route::get('colaborador/edit/{id}','ColaboradoresController@edit')->name('colaborador.editar');
			Route::post('colaborador/update/{id}','ColaboradoresController@update')->name('colaborador.update');
			Route::get('colaborador/delete/{id}','ColaboradoresController@destroy')->name('colaborador.delete');
			
			Route::get('colaborador/buscador','ColaboradoresController@buscador')->name('colaborador.buscador');


			//Ruta para contactos patrocinadores
			Route::post('sponsorcontact/create','SponsorContactController@store')->name('sponsorcontact.create');
			Route::get('sponsors/contactos/{id}','SponsorContactController@contactos')->name('sponsorcontact');
			Route::get('sponsorcontact/edit/{id}','SponsorContactController@edit')->name('sponsorcontact.editar');
			Route::post('sponsorcontact/update/{id}','SponsorContactController@update')->name('sponsorcontact.update');
			Route::get('sponsorcontact/delete/{id}','SponsorContactController@destroy')->name('sponsorcontact.delete');
			Route::get('sponsorcontact/buscador','SponsorContactController@buscador')->name('sponsorcontact.buscador');


			//Ruta para material patrocinadores
			Route::post('sponsormaterial/create','SponsorMaterialController@store')->name('sponsormaterial.create');
			Route::get('sponsors/material/{id}','SponsorMaterialController@sponsormaterial')->name('sponsormaterial');
			Route::get('sponsormaterial/edit/{id}','SponsorMaterialController@edit')->name('sponsormaterial.editar');
			Route::post('sponsormaterial/update/{id}','SponsorMaterialController@update')->name('sponsormaterial.update');
			Route::get('sponsormaterial/delete/{id}','SponsorMaterialController@destroy')->name('sponsormaterial.delete');
			Route::get('sponsormaterial/buscador','SponsorMaterialController@buscador')->name('sponsormaterial.buscador');


			//Ruta para curso-patrocinadores
			Route::post('sponsorcurso/create','SponsorCursoController@store')->name('sponsorcurso.create');
			Route::get('sponsors/curso','SponsorCursoController@sponsorcurso')->name('sponsorcurso');
			Route::get('sponsorcurso/edit/{id}','SponsorCursoController@edit')->name('sponsorcurso.editar');
			Route::post('sponsorcurso/update/{id}','SponsorCursoController@update')->name('sponsorcurso.update');
			Route::get('sponsorcurso/delete/{id}','SponsorCursoController@destroy')->name('sponsorcurso.delete');
			Route::get('sponsorcurso/buscador','SponsorCursoController@buscador')->name('sponsorcurso.buscador');


			Route::get('autor/buscador','AutorController@buscador')->name('autor.buscador');



				//Ruta para encuesta_curso
			Route::post('encuesta_curso/create','Encuesta_cursoController@store')->name('encuesta_curso.create');
			Route::get('curso/encuesta_curso/{id}','Encuesta_cursoController@encuesta_curso')->name('encuesta_curso');
			Route::get('encuesta_curso/edit/{id}','Encuesta_cursoController@edit')->name('encuesta_curso.editar');
			Route::post('encuesta_curso/update/{id}','Encuesta_cursoController@update')->name('encuesta_curso.update');
			Route::get('encuesta_curso/delete/{id}','Encuesta_cursoController@destroy')->name('encuesta_curso.delete');
			Route::get('encuesta_curso/buscador','Encuesta_cursoController@buscador')->name('encuesta_curso.buscador');

			//Ruta para pregunta_encuesta_curso
			Route::post('pregunta_encuesta_curso/create','Preguntas_Encuestas_CursoController@store')->name('pregunta_encuesta_curso.create');
			Route::get('Encuesta/pregunta_encuesta_curso/{id}','Preguntas_Encuestas_CursoController@pregunta_encuesta_curso')->name('pregunta_encuesta_curso');
			Route::get('pregunta_encuesta_curso/edit/{id}','Preguntas_Encuestas_CursoController@edit')->name('pregunta_encuesta_curso.editar');
			Route::post('pregunta_encuesta_curso/update/{id}','Preguntas_Encuestas_CursoController@update')->name('pregunta_encuesta_curso.update');
			Route::get('pregunta_encuesta_curso/delete/{id}','Preguntas_Encuestas_CursoController@destroy')->name('pregunta_encuesta_curso.delete');
			Route::get('pregunta_encuesta_curso/buscador','Preguntas_Encuestas_CursoController@buscador')->name('pregunta_encuesta_curso.buscador');


		});

		Route::group(['middleware'=>'permiso:mod_suscription'],function(){
			//Ruta para ejecutivos
			Route::resource('ejecutivos','EjecutivoController');
			// Ruta para eliminar un usuario de cualquier lugar de la aplicacion
			Route::get('user/{id}/destroy-json','UserController@destroyByAjax');

			
			Route::get('ejecutivos/{id}/destroy','EjecutivoController@destroy')->name('ejecutivos.destroy');
			//Grupo de ruta listar suscriptores
		    //Route::get('subscribers/free', 'SubscriberController@getFree')->name('subscribers.free');
			 Route::get('subscribers/free', 'SubscriberController@getFreeList')->name('subscribers.free');
			// Route::get('subscribers-free/download', 'SubscriberController@downloadDataFilterF');
			Route::get('subscribers-free/download', 'SubscriberController@downloadDataFreeFilter');
			Route::get('subscribers/free-data','SubscriberController@getFreeData');

			// Obtener lista de suscriptores por asesor
			Route::get('subscribers/byasesor','SubscriberController@getSubcribersByAsesor');
			
			
			//Rutas para buscar suscriptor por nombre free
			Route::get('searchSubscriberfree','SubscriberController@searchFree');

			//Ruta para listar el historial del usuario en modal (en desuso)
			Route::get('history-user/{id}','RecordController@getRecords');

			//Ruta para CRUD promociones
			Route::resource('promos','PromoController');
			Route::get('promos/{id}/destroy','PromoController@destroy')->name('promos.destroy');

			//Ruta para obtener cargos realizado desde culqui
			Route::get('culqi/cargos','HomeController@culqiCharges')->name('culqi.cargos');
			Route::get('culqi/cargos-data','HomeController@culqiChargesData');
			Route::get('culqi/cargos/search/{email?}','HomeController@culqiChargesSearch');

			



			// Ruta para descargar suscriptores
			// Route::get('subscribers-premium/download', 'SubscriberController@downloadDataFilter');
			Route::get('subscribers-premium/download', 'SubscriberController@dowloadDataPremiumFilter');

			// Ruta para descargar suscriptores Recurrentes
			//Route::get('subscribers-premium-recurrente/download', 'SubscriberController@downloadDataFilterR');
            Route::get('subscribers-premium-recurrente/download', 'SubscriberController@dowloadDataRecurrenteFilter');

			// Ruta para descargar suscriptores
			// Route::get('subscribers-cursos/download', 'SubscriberController@downloadDataFilterCursos');
			Route::get('subscribers-cursos/download', 'SubscriberController@dowloadDataCursoFilter');

				


				//Ruta para mostrar las encuestas contestadas
			Route::get('encuestas','Encuesta_cursoController@encuestas')->name('encuestas');
			Route::get('encuestas/buscador','Encuesta_cursoController@encuestasbuscador')->name('encuestas.buscador');
			

		});
		Route::group(['middleware'=>'permiso:mod_support'],function(){
		    
		    Route::get('subscribers-support/download','SubscriberController@downloadDataFilterS');

			Route::get('ejecutivos-all','EjecutivoController@getEjecutivosAll');
			Route::put('userupdate/{id}','SubscriberController@userUpdate')->name('userupdate');

			// Ruta para suscriptores premium Recurrente
			// Route::get('subscribers/premium/recurrente', 'SubscriberController@getRecurrente')->name('subscribers.recurrente');
			Route::get('subscribers/premium/recurrente', 'SubscriberController@getRecurrenteList')->name('subscribers.recurrente');
			Route::get('subscribers/premium-data-recurrente/{page?}','SubscriberController@getPremiumDataRecurrente');
			Route::get('cargos/cargos-data-recurrente/{id}','FrontController@getPremiumDataRecurrente');
			Route::get('subscribers-premium-recurrente/{id}/destroy','FrontController@destroyPremiumrecurrente');

			// Ruta para suscriptores premium
			// Route::get('subscribers/premium', 'SubscriberController@getPremium')->name('subscribers.premium');
			Route::get('subscribers/premium', 'SubscriberController@getPremiumList')->name('subscribers.premium');
			Route::get('subscribers/premium-data/{page?}','SubscriberController@getPremiumData');
			Route::post('subscribers/premium','SubscriberController@storePremium');
			Route::get('subscribers-premium/{id}/destroy','SubscriberController@destroyPremium');
			Route::put('subscribers/premium/{id}','SubscriberController@updatePremium');

			// Universidad Admin
			Route::get('subscribers/premium_uni', 'UniversityController@getPremiumList')->name('subscribers.premium_uni'); 
			Route::post('subscribers/premium_uni', 'UniversityController@storePremium');
			Route::get('subscribers-premium_uni/{id}/destroy', 'UniversityController@destroyPremium');
			Route::put('subscribers/premium_uni/{id}', 'UniversityController@updatePremium');
			Route::get('subscribers-premium_uni/download', 'UniversityController@dowloadDataPremiumFilter');
			
			Route::get('subscribers/data-recurrente/filter/', 'SubscriberController@applyFiltersRecurrente');


			Route::post('subscribers/free','SubscriberController@storeFree');

			// Ruta para suscriptores cursos
			// Route::get('subscribers/cursos', 'SubscriberController@getcursos')->name('subscribers.cursos');
			Route::get('subscribers/cursos', 'SubscriberController@getCursosList')->name('subscribers.cursos');
			Route::get('subscribers/data-curso/{page?}','SubscriberController@getDataCurso');
			
			Route::get('subscribers-curso/search','SubscriberController@searchCurso');
			Route::get('subscribers-curso/filter/','SubscriberController@applyFiltersCurso');
			Route::get('subscribers-curso/{id}/destroy','SubscriberController@destroyCurso');


			// Ruta para solicitudes de certificado
			Route::get('subscribers/certificado','SubscriberController@getcertificado')->name('certificado');
			Route::get('subscribers/data-certificado/{page?}','SubscriberController@getDataCertificado');
			Route::get('subscribers-certificado/search','SubscriberController@searchCertificado');
			Route::get('subscribers-certificado/filter/','SubscriberController@applyFiltersCertificado');

			Route::post('certificadoestado','SubscriberController@certificadoestado')->name('certificadoestado');


           // Ruta para suscriptores pago efectivo
		
			// Route::get('subscribers/pago_efectivo', 'SubscriberController@getPagoEfectivo')->name('subscribers.pago_efectivo');
			Route::get('subscribers/pago_efectivo', 'SubscriberController@getPagoEfectivoList')->name('subscribers.pago_efectivo');
			Route::get('subscribers/pago_efectivo_data/{page?}', 'SubscriberController@getPagoEfectivoData');
			Route::get('cargos/cargos_pago_efectivo/{id}/{id_culqi}', 'FrontController@getCargoPagoEfectivoData');
			// Ruta para buscar suscriptor efectivo
			Route::get('subscribers/pago_efectivo/search', 'SubscriberController@searchPagoEfectivoCurso');
			Route::get('subscribers/pago_efectivo/filter/', 'SubscriberController@applyFiltersPagoEfectivoCurso');
			Route::get('subscribers/pago_efectivo/{id}/destroy', 'SubscriberController@destroyPagoEfectivo');
			Route::post('statusPagoEfectivo', 'SubscriberController@statusPagoEfectivo')->name('statusPagoEfectivo');
			Route::get('subscribers/pago_efectivo/{id}/notificate', 'SubscriberController@notificationPagoEfectivo');
			Route::get('subscribers/pago_efectivo/cursos-data', 'SubscriberController@getCursosData');
			Route::post('subscribers/pago_efectivo/asignatecurso', 'SubscriberController@asignatecurso');
			
			Route::get('subscribers/pago_efectivo/{id}/notificate_premium', 'SubscriberController@notificationPagoEfectivoPremium');
            Route::put('subscribers/pago_efectivo_premium/{id}', 'SubscriberController@storePagoEfectivoPremium'); ;
 
			// Ruta para actualizar el estado de emision de comprobante para el pago
			// Paramentro id pago
			Route::get('updatestatuscomprobante/{id}','SubscriberController@updateStatusComprobante');
			// Ruta para plicar filtros
			Route::get('subscribers-premium/filter/','SubscriberController@applyFilters');
			// Ruta para buscar suscriptor
			Route::get('subscribers-premium/search','SubscriberController@searchPremium');
			// Ruta para buscar suscriptor Recurrente
			Route::get('subscribers-premium-recurrente/search','SubscriberController@searchPremiumR');


			// PAGOS YAPE
			Route::get('subscribers/pago_yape', 'SusbYapeController@index')->name('subscribers.pago_yape');
			Route::get('subscribers/pago_yape_data/{page?}', 'SusbYapeController@getPagoYapeData');
			Route::get('subscribers/pago_yape/search', 'SusbYapeController@searchPagoYapeCurso');
			Route::put('subscribers/pago_yape/{id}', 'SusbYapeController@storePagoYapePremium');//Asiganar susc
			Route::get('subscribers/pago_yape/{id}/destroy', 'SusbYapeController@destroyPagoYape');
			Route::get('subscribers/pago_yape/filter/', 'SusbYapeController@applyFiltersPagoYapeCurso');
			Route::get('subscribers/pago_yape/cursos-data', 'SusbYapeController@getCursosData');
			Route::post('subscribers/pago_yape/asignatecurso', 'SusbYapeController@asignatecurso');	//Asignar curso
			

			//Ruta para listar clientes suscritas
			Route::get('clientes','ClienteController@index')->name('clientes.index');
			
			Route::post('clientes','ClienteController@store');	
			//Ruta para actualizar datos del cliente
			Route::get('clientes-data/{page?}','ClienteController@getClientes');
			//Ruta para buscar clientes suscritas por nombre
			Route::get('clientes/search','ClienteController@search');
			//Ruta para guadar cliente
			
			Route::put('clientes/{id}','ClienteController@update');


			//Ruta para convertir a suscriptor free a cliente (en desuso)
			Route::get('convertoclient/{id}','ClienteController@frmConvert')->name('convertoclient.create');
			Route::put('convertoclient/{id}','ClienteController@convertStore')->name('convertoclient');

			//filtros de clientes
			Route::get('filters-to-clients','ClienteController@getFiltterToClients');

			Route::get('clientes/filter/','ClienteController@applyFilters');

			Route::get('clientes/download','ClienteController@downloadDataFilter');


			//Ruta para convertir suscriptor free a suscriptor premium
			Route::put('convertosuscrip/{id}','SubscriberController@convertStore')->name('convertosuscrip');
			//Rutas para notificaciones
			Route::get('notifications','NotificationController@index')->name('notifications.index');
			Route::get('notifications-data','NotificationController@getNotifications');
			Route::get('notifications/read/{id}','NotificationController@updateReaded')->name('notifications.read');

			//Ruta para asignaciones
			Route::post('asignateto','HomeController@asignateTo');

			//Ruta para asignaciones de curso
			Route::post('asignatecurso','HomeController@asignatecurso');


			// Ruta para mostrar asignaciones por gestor
			Route::get('users/asignations','UserController@asignationsView')->name('users.asignations');
			Route::get('users/asignations-data','UserController@getAsignations');
			//desasignar
			// parametro id del suscriptor free
			Route::get('destroyasination/{id}','HomeController@destryoAsignation');
			//Busqueda para la lista de asignados
			Route::get('users/asignations/search/{text}','UserController@searchAsignations');

			//Rutas para manejar el hitorial de suscriptores
			Route::get('subscribers/{id}/records','RecordController@index')->name('subscribers.records');
			Route::post('recordsave','RecordController@store')->name('record.store');
			Route::get('record-destroy/{id}','RecordController@destroy')->name('record.destroy');

		});
		//Ruta para usuarios admin del sistema
		Route::group(['middleware'=>'permiso:mod_admin'],function(){
		
			
				
			//Ruta para usuarios
			Route::resource('users','UserController');
			Route::get('users/{id}/destroy','UserController@destroy')->name('users.destroy');
			Route::get('users-online','UserController@getOnline')->name('users.online');

			Route::resource('roles','RoleController');
			Route::put('auditpermiso/{id}','RoleController@auditPermiso')->name('auditpermiso');

			//Ruta para administrar planes
			Route::resource('planes','PlanController');
			Route::get('planes/{id}/destroy','PlanController@destroy')->name('planes.destroy');

		});
	});
});

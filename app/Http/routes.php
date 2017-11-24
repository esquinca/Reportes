<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
Route::get('/', function () {
    return view('welcome');
});
*/

Route::get('/', function () {
	return View::make('auth.login');
});

Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/', function() {
	 	return view('home');
	 });
	//Asignar Concierge.
	Route::get('/assign',  'AssignConciergeController@index');
	Route::post('/usershowd','AssignConciergeController@show');
	Route::post('/config_asig_car_edit','AssignConciergeController@recargar');
	Route::post('/config_hotel','AssignConciergeController@update');

	//Generar Reporte.
	Route::get('/generate', 'GenerateController@index');
	//Visualizar Reportes por it, prog, admin.
	Route::get('/viewreports', 'ViewReportsController@index');
	//Visualizar Reportes por cliente.
	Route::get('/viewreport', 'ViewReportController@index');
	//Generar wlam.
	Route::get('/wlan', 'WlanController@index');
	Route::post('/reg_wlan','WlanController@create');
	Route::post('/wlanstatus','WlanController@show');
	Route::post('/config_stat_wlan','WlanController@showtwo');
	Route::post('/conf_estado_wlan','WlanController@updatestatus');
	Route::post('/config_wlan_mo','WlanController@showthree');

	Route::post('/ext_wlan','WlanController@exitent');
	//Perfil
	Route::get('/profile', 'ProfileController@profile');
	Route::post('/profile','ProfileController@update_avatar');
	Route::get('/profiles','ProfileController@data_user');
	Route::post('/updatedatas', 'ProfileController@update');
	Route::post('/upd_password', 'ProfileController@updatetwo');
	//configuracion de usuarios
	Route::get('/config_one', 'UserController@index');
	Route::post('/config_two_c', 'UserController@create');
	Route::get('/usershow', 'UserController@show');
	Route::post('/config_two_e', 'UserController@editar');

	Route::post('/config_two_ed', 'UserController@edit');
	Route::post('/config_two_exit', 'UserController@editDos');
	Route::post('/config_two_sobre', 'UserController@update');
	//Captura por medio de SNMP
	Route::post('/verifiCaptura', 'GenerateController@vdata');
	Route::post('/insertCaptura', 'GenerateController@rdata');
	//Generar Reportes
	Route::post('/typereport','ViewReportsController@typerep');
	Route::post('/generar_comp','ViewReportsController@tableShowComp');
	//Generar Observaciones
	Route::get('/observation', 'observationController@index');
	Route::post('/verifObserv','observationController@verfObMes');
	Route::post('/observationdata','observationController@obsdata');
	//Generar vista reportes
	Route::post('/consultmes','ViewReportsController@store');
	Route::post('/consultcuadros','ViewReportsController@contenido');
	Route::post('/consultnivelreport','ViewReportsController@nvreport');

	Route::post('/consultnivelreportpermit','ViewReportsController@nvreport');
	Route::post('/consultnivelreportadmin','ViewReportsController@nvreportadmin');


	Route::post('/consultshowgrafone','ViewReportsController@show_graf_one');
	Route::post('/consultshowgrafgbdia','ViewReportsController@show_graf_gb');
	Route::post('/consultshowgraftwo','ViewReportsController@show_graf_two');
	Route::post('/consultshowgrafthree','ViewReportsController@show_graf_three');
	Route::post('/consultshowgraffour','ViewReportsController@show_graf_four');

	Route::post('/consultshowdetaps','ViewReportsController@show_ap_det');
	Route::post('/consultshowconcep','ViewReportsController@info_hotel');
	Route::post('/consultshowobserv','ViewReportsController@info_observation');

	Route::post('/consultshowinfo','ViewReportsController@info_cuad');
	//configuracion clientes
	Route::get('/assigncl', 'assignclientController@index');
	Route::post('/assignclreg', 'assignclientController@create');
	Route::post('/assignclshow', 'assignclientController@show');
	Route::post('/assignclold', 'assignclientController@store');
	Route::post('/assignclupdate', 'assignclientController@update');
	Route::post('/assigncldelete', 'assignclientController@destroy');

	Route::get('/pthehe', 'AssignConciergeController@rutaestadoserver');
	Route::get('/acm1pt', 'AssignConciergeController@curlZen');
	Route::get('/acm1pt2', 'AssignConciergeController@sqltest');
	//Route::post('/acm1pt3', 'ImportController@insertExcel');

	//Captura individual
	Route::get('/individual', 'IndividualController@index');
	Route::post('/transgb', 'IndividualController@storegb');
	Route::post('/transuser', 'IndividualController@storeuser');
	Route::post('/transaps', 'IndividualController@storeaps');
	Route::post('/transwlan', 'IndividualController@storewlan');
	//importar
	Route::get('/import', 'ImportController@index');
	//Route::post('/uploaddoc', 'ImportController@subir');
	//Route::post('/uploaddoc', 'ImportController@create');
	//Route::post('/uploaddoc', 'ImportController@subir2');
	Route::post('/uploaddoc', 'ImportController@insertExcel');
	//Cuestionario
	//Route::get('/survey_questions', 'QuizQuestionsController@index');
	Route::get('/survey_results', 'QuizResultsController@index');
	Route::post('/survey_viewresult', 'QuizResultsController@view');
	Route::post('/show_comments', 'QuizResultsController@store');

	Route::post('/survey_form', 'QuizQuestionsController@store');
	//configuracion clientes
	Route::get('/config_two', 'UserClientController@index');
	Route::post('/config_two_store', 'UserClientController@store');
	Route::post('config_two_validation', 'UserClientController@validatePriv');
	Route::get('/conchesumare', 'UserClientController@validatePriv');
	Route::get('/usershowclien', 'UserClientController@show');
	Route::post('/config_showmodal', 'UserClientController@edit');
	Route::post('/config_cliente_data_chang','UserClientController@editdata');

	Route::post('/config_two_client_asign', 'UserClientController@create');
	Route::get('/usershowrhe_client','UserClientController@showTable');
	Route::post('/config_rec_rel_hotenc_cliente', 'UserClientController@showclient');
	Route::post('/config_rec_data_obj_cliente', 'UserClientController@edithotelclien');
	Route::post('/config_hotelclient_chang', 'UserClientController@changehotelclien');
	Route::post('/config_two_delet_cliente', 'UserClientController@delete');

	//configuracion encuestados
	Route::get('/config_three', 'UserQuizController@index');
	Route::get('/usershowenc', 'UserQuizController@show');
	Route::post('/config_two_edit', 'UserQuizController@editar');
	Route::post('/config_two_rand', 'UserQuizController@nrand');
	Route::post('/config_two_data_chang', 'UserQuizController@editdata');
	Route::post('/config_two_ccmail', 'UserQuizController@copiamail');

	Route::post('/config_reg_verfmail', 'UserQuizController@emailverf');
	Route::get('/usershowrhe', 'UserQuizController@store');
	Route::post('/config_two_asignreg', 'UserQuizController@create');
	Route::post('/config_two_delet', 'UserQuizController@delete');
	Route::post('/config_rec_rel_hotenc', 'UserQuizController@showclient');
	Route::post('/config_rec_data_obj', 'UserQuizController@edithotelenc');
	Route::post('/config_hotelenc_chang', 'UserQuizController@changehotelenc');
	Route::post('/config_two_rand_all', 'UserQuizController@changeuserenckeys');

	//Pruebas encuesta con key
	Route::get('/survey_questions/{id}', 'QuizQuestionsController@index');
	// Route::get('/survey_questions/{id}', function ($id) {
  //   return 'User '.$id;
	// });
	Route::get('/shalala/{id}', 'QuizQuestionsController@index2');

	//configuracion de commentarios
	Route::get('/survey_comments', 'QuizCommentsController@index');
	Route::post('/result_filter_comments', 'QuizCommentsController@store');
	//Encuestado en Admin
	Route::get('/survey_user', 'QuizQuestionsAdminController@index');
	Route::post('/searchencuestad', 'QuizQuestionsAdminController@search');
	Route::post('/info_register_calf', 'QuizQuestionsAdminController@infocalf');
	Route::post('/quizencuestamanual', 'QuizQuestionsAdminController@registrandocalif');
	//Editar Encuesta.
	Route::get('/survey_edit', 'QuizEditController@index');
	Route::post('/info_edit_register', 'QuizEditController@edit');
	Route::post('/info_search_register', 'QuizEditController@editar');
	//Aprovacion
	Route::get('/approval', 'ApprovalController@index');
	Route::get('/approvals', 'ApprovalController@index2');

	Route::post('/approvalcreateone', 'ApprovalController@createone');
	Route::post('/approvalcreatetwo', 'ApprovalController@createtwo');

	Route::post('/typereportnew','ApprovalController@typerep');
	Route::post('/showtypereports','ApprovalController@show');
	Route::post('/delete_register_aprobation','ApprovalController@destroy');

	Route::post('/showpendient','ApprovalController@showpendientes');
	Route::post('/changependientactive','ApprovalController@pendientesapproval');
	Route::post('/changependientdesactive','ApprovalController@pendientesdesapproval');
	Route::post('/changependientall','ApprovalController@pendientesallapproval');
	Route::post('/result_filter_approval','ApprovalController@filterapproval');

	//Para el reporte nuevos cambios
	Route::post('/consultnivelreport2','ViewReportsController@table_month_vs_month_previous');
	Route::post('/consultimgzd','ViewReportsController@consultexitimg');
	Route::post('/restartimgzd','ViewReportsController@consultrouteimg');

	Route::post('/imagenband','IndividualController@update_avatar');
	Route::get('/type_report', 'AssignTypeController@index');

	Route::post('/typecreateone', 'AssignTypeController@create');
	Route::post('/showtypehotel','AssignTypeController@show');
	Route::post('/delete_register_tipo', 'AssignTypeController@destroy');
	//Nuevas rutas
	Route::post('/info_recargar_calif', 'QuizEditController@update');
	Route::post('/quiz_data_ifn', 'QuizQuestionsController@createdata');
	//Editar Reporte
	Route::get('/edit_report', 'EditReportController@index');
	Route::post('/obt_gb_report', 'EditReportController@searchone');
	Route::post('/obt_user_report', 'EditReportController@searchtwo');
	Route::post('/gb_edit_report', 'EditReportController@create');
	Route::post('/user_edit_report', 'EditReportController@creates');
	Route::post('/editimagentypeband','EditReportController@update_edit_type_avatar');
	Route::post('/resetimagenband','EditReportController@update_edit_band_avatar');

	Route::post('/imagentypeband','IndividualController@update_type_avatar');
	//Type device
	Route::post('/consultimgtype','ViewReportsController@consultypeimg');
	Route::post('/restartimgtype','ViewReportsController@consultrouteimgtype');
	//TESTEO ZD
	Route::get('/testzone', 'TestIpController@index');
	Route::post('/testzonedir', 'TestIpController@store');

});

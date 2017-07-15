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

	Route::post('/consultshowgrafone','ViewReportsController@show_graf_one');
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

	Route::get('/putohehe', 'AssignConciergeController@rutaestadoserver');

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
		Route::post('/uploaddoc', 'ImportController@subir2');
	//Cuestionario
	Route::get('/survey_questions', 'QuizQuestionsController@index');
	Route::get('/survey_results', 'QuizResultsController@index');

});

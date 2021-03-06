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
*/

Route::get('/', 'WelcomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('events','eventController');
Route::resource('radio','RadioController');

Route::post('api/access_token', function(){
	return Response::json(Authorizer::issueAccessToken());
});

Route::get('api/events', ["before" =>'oauth', function(){
	$events = App\event::all();
	$length = $events->count();
	return Response::json(["events" => $events]);
}]);

Route::get('api/radio/{id}', ["before" =>'oauth', function($id){
	$radio = \App\Radio::find($id);
	if(isset($radio["logo_url"])){
		$radio["logo"] = base64_encode(File::get('uploads/'. $radio["logo_url"])); 
		unset($radio["logo_url"]);
	}
	return Response::json($radio);
}]);

Route::get('test', function(){

	dd($app->environment());
    //
});


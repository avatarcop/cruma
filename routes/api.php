<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     // return $request->user();
//     return "WOW";
// });

Route::group(['middleware' => 'auth:api'], function()
{
	Route::post('login2', 'HomeController@login2');
	Route::post('get_data_diri', 'HomeController@getdatadiri');
	Route::post('get_scrummarket', 'HomeController@get_scrummarket');
	Route::post('get_progress', 'HomeController@get_progress');
	Route::post('get_waiting', 'HomeController@get_waiting');
	Route::post('get_finetuning', 'HomeController@get_finetuning');
	Route::post('get_close', 'HomeController@get_close');
	Route::post('get_scrumdetail', 'HomeController@get_scrumdetail');

	Route::post('get_image', 'HomeController@get_image');

	Route::post('take_scrum', 'HomeController@take_scrum');
	Route::post('finish_scrum', 'HomeController@finish_scrum');
	Route::post('finish_scrum_ana', 'HomeController@finish_scrum_ana');
	Route::post('remove_scrum', 'HomeController@remove_scrum');
	Route::post('finetuning_scrum', 'HomeController@finetuning_scrum');
	Route::post('finetuning_scrum_ana', 'HomeController@finetuning_scrum_ana');
	Route::post('close_scrum', 'HomeController@close_scrum');


	Route::post('test', 'HomeController@test');

});



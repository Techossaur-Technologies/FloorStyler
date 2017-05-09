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

Route::auth();

Route::group(['middleware' => 'auth'], function () {
	// Dashboard
	Route::get('/', 'dashboardController@index');

	// Assignment
	Route::get('assignment', 'assignmentController@index');
	Route::get('assignment/add', ['uses'=>'assignmentController@add', 'as'=> 'addassignment']);
	Route::post('assignment/create', 'assignmentController@create');
	Route::post('assignment/delete', 'assignmentController@delete');
	Route::get('assignment/edit/{name}/{id}', ['as'=>'assignment.edit', 'uses'=>'assignmentController@getEdit']);
	Route::get('assignment/view/{name}/{id}', 'assignmentController@view');
	Route::get('assignment/addfp/{name}/{id}', ['as'=>'assignment.addfp', 'uses'=>'assignmentController@add_fp']);
	Route::get('assignment/addcomment/{name}/{id}', ['as'=>'assignment.addcomment', 'uses'=>'assignmentController@addcomment']);
	Route::post('assignment/update', 'assignmentController@update');
	Route::post('assignment/update_fp', 'assignmentController@update_fp');
	Route::post('assignment/update_addcomment', 'assignmentController@update_addcomment');
	Route::post('postagency', 'assignmentController@postagency');
	Route::post('addBoligAppID', 'assignmentController@addBoligAppID');
	Route::post('assignment/status', 'assignmentController@status');
	Route::post('assignment/list', 'assignmentController@list');



	// Organization
	Route::get('organization', 'organizationController@index');

	// Agency
	Route::get('agency', 'agencyController@index');
	Route::get('agency/add', ['uses'=>'agencyController@add', 'as'=> 'addagency']);
	Route::post('agency/create', 'agencyController@create');
	Route::get('agency/delete/{id}', 'agencyController@destroy');
	Route::get('agency/status/{id}', 'agencyController@status');
	Route::get('agency/edit/{name}/{id}', 'agencyController@edit');
	Route::post('agency/update', 'agencyController@update');

	// Settings
	Route::get('profile', 'settingsController@editProfile');
	Route::post('profile_update', 'settingsController@update_profile');
	Route::get('password_change', 'settingsController@password_change');
	Route::post('updatePassword', 'settingsController@updatePassword');
	Route::get('email_template', 'settingsController@email_template');

});

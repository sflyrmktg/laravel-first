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

Route::get('/', function () {
    return view('welcome');
});
Route::resource('records', 'RecordsController');
Route::post('records/partialupdate', array('as' => 'records.partialupdate', 'uses' => 'RecordsController@partialUpdate'));
Route::post('records/clone', array('as' => 'records.clone', 'uses' => 'RecordsController@clone'));

Route::resource('methods','MethodsController');
Route::resource('methods/{method}/records','RecordsController@indexMethod');

Route::resource('concepts','ConceptsController');
Route::resource('concepts/{concept}/records','RecordsController@indexConcept');


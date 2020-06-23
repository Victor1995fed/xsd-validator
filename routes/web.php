<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MainController@index');

Route::get('/help', 'MainController@help');

Route::post('validator', 'ValidatorController@check');
Route::get('validator', 'ValidatorController@index');
//Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/xsd', 'XsdController');
Route::get('/file/{uuid}', 'FileController@download');
Route::get('/xsd/test/{id}', 'XsdController@testXml');
Route::post('/xsd/test/{id}', 'XsdController@runTestXml');
Route::post('/file/get-list-zip', 'FileController@getListFilesZip');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

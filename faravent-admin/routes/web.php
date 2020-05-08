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

Route::get('/',
['as' => 'index', 'uses' => 'AdminController@index']);

Route::get('/deleteTopic',
['as' => 'deleteTopic','uses' => 'AdminController@deleteTopic']);

Route::get('/addTopic',
['as' => 'addTopic','uses' => 'AdminController@addTopic']);

Route::get('/publish',
['as' => 'publish','uses' => 'AdminController@publish']);

Route::post('/uploadBinary',
['as' => 'uploadBinary','uses' => 'AdminController@uploadBinary']);

Route::post('/api/uploadBinary',
['uses' => 'AdminController@uploadBinary']);

Route::get('/deployBinary',
['as' => 'deployBinary','uses' => 'AdminController@deployBinary']);

Route::get('/deleteBinary',
['as' => 'deleteBinary','uses' => 'AdminController@deleteBinary']);

Route::get('/addDevice',
['as' => 'addDevice','uses' => 'AdminController@addDevice']);

Route::get('/removeDevice',
['as' => 'removeDevice','uses' => 'AdminController@removeDevice']);

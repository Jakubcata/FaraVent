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
Route::middleware('auth')->group(function () {
    Route::get('/', 'MqttController@index')->name('index');

    Route::group(['prefix' => 'ota'], function () {
        Route::get('/', 'OtaUpdateController@index')->name('ota');
        Route::get('/binary/deploy', 'OtaUpdateController@deployBinary')->name('deployBinary');
        Route::post('/binary/upload', 'OtaUpdateController@uploadBinary')->name('uploadBinary');
        Route::get('/binary/delete', 'OtaUpdateController@deleteBinary')->name('deleteBinary');
    });


    Route::group(['prefix' => 'devices'], function () {
        Route::get('/', 'DeviceController@index')->name('devicesList');
        Route::get('/add', 'DeviceController@addDevice')->name('addDevice');
        Route::get('/remove', 'DeviceController@removeDevice')->name('removeDevice');
        Route::get('/show', 'DeviceController@showDevice')->name('showDevice');
    });
});
Route::get('/login', 'Auth\LoginController@getLogin')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('postLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

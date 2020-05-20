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

Route::get(
    '/',
    ['as' => 'index', 'uses' => 'MqttController@index']
);



Route::group(['prefix' => 'ota'], function () {
    Route::get(
        '/',
        ['as' => 'ota', 'uses' => 'OtaUpdateController@index']
    );
    Route::get(
        '/binary/deploy',
        ['as' => 'deployBinary','uses' => 'OtaUpdateController@deployBinary']
    );

    Route::post(
        '/binary/upload',
        ['as' => 'uploadBinary','uses' => 'OtaUpdateController@uploadBinary']
    );

    Route::get(
        '/binary/delete',
        ['as' => 'deleteBinary','uses' => 'OtaUpdateController@deleteBinary']
    );
});


Route::group(['prefix' => 'devices'], function () {
    Route::get(
        '/',
        ['as' => 'devicesList', 'uses' => 'DeviceController@index']
    );

    Route::get(
        '/add',
        ['as' => 'addDevice','uses' => 'DeviceController@addDevice']
    );

    Route::get(
        '/remove',
        ['as' => 'removeDevice','uses' => 'DeviceController@removeDevice']
    );

    Route::get(
        '/show',
        ['as' => 'showDevice','uses' => 'DeviceController@showDevice']
    );
});

Route::get('/login', 'Auth\LoginController@getLogin')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('postLogin');
Route::get('/logout', 'Auth\LoginController@logout')->name('logout');

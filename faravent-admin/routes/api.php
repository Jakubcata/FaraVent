<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'mqtt'], function () {
        Route::get('/message/send', 'MqttController@sendMessage')->name('sendMessage');
        Route::get('/topic/delete', 'MqttController@deleteTopic')->name('deleteTopic');
        Route::get('/topic/add', 'MqttController@addTopic')->name('addTopic');
        Route::get('/topic/list', 'MqttController@topicsSnippet')->name('topicsSnippet');
        Route::get('/lastMessagesSnippet', 'MqttController@lastMessagesSnippet')->name('lastMessagesSnippet');
    });

    Route::group(['prefix' => 'device'], function () {
        Route::get('/sensorChart', 'MqttController@sensorChart')->name('sensorChart');
    });

    Route::group(['prefix' => 'device'], function () {
        Route::get('/lastMessagesSnippet', 'DeviceController@lastMessagesSnippet')->name('deviceLastMessagesSnippet');
    });
});

# Old deprecated upload binary url
Route::post(
    '/uploadBinary',
    ['uses' => 'OtaUpdateController@uploadBinary']
);

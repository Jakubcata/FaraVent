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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'mqtt'], function () {
    Route::get(
        '/message/send',
        ['as' => 'sendMessage','uses' => 'MqttController@sendMessage']
    );

    Route::get(
        '/topic/delete',
        ['as' => 'deleteTopic','uses' => 'MqttController@deleteTopic']
    );

    Route::get(
        '/topic/add',
        ['as' => 'addTopic','uses' => 'MqttController@addTopic']
    );

    Route::get(
        '/topic/list',
        ['as' => 'topicsSnippet','uses' => 'MqttController@topicsSnippet']
    );

    Route::get(
        '/lastMessagesSnippet',
        ['as' => 'lastMessagesSnippet','uses' => 'MqttController@lastMessagesSnippet']
    );
});


Route::group(['prefix' => 'device'], function () {
    Route::get(
        '/lastMessagesSnippet',
        ['as' => 'deviceLastMessagesSnippet','uses' => 'DeviceController@lastMessagesSnippet']
    );
});

# Old deprecated upload binary url
Route::post(
    '/uploadBinary',
    ['uses' => 'OtaUpdateController@uploadBinary']
);

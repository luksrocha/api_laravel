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

Route::post('/register','HomeController@register');

Route::post('/login', 'APILoginController@login');

Route::middleware('auth:api')->get('/me', 'UserController@meProfile');

Route::group(['middleware' => 'auth:api','prefix'=>'/users'],function(){
    Route::middleware('auth:api')->get('', 'UserController@getUsers');
    Route::middleware('auth:api')->get('{id}', 'UserController@show');
    Route::middleware('auth:api')->patch('{id}','UserController@update');
    });
    
Route::middleware('auth:api')->post('/todos','TodoController@store');

Route::middleware('auth:api')->get('/todos','TodoController@index');

Route::middleware('auth:api')->get('/todos/{id}','TodoController@show');

Route::middleware('auth:api')->patch('/todos/{id}','TodoController@update');

Route::middleware('auth:api')->delete('/todos/{id}','TodoController@destroy');

Route::post('/role','RolesController@createRole');
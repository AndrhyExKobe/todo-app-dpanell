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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 */

Route::get('/task/list', ['as' => 'api.task.list', 'uses' => 'App\Http\Controllers\TaskController@list']);
Route::post('/task/create', ['as' => 'api.task.create', 'uses' => 'App\Http\Controllers\TaskController@create']);
Route::put('/task/update/{id}', ['as' => 'api.task.update', 'uses' => 'App\Http\Controllers\TaskController@update']);
Route::delete('/task/delete/{id}', ['as' => 'api.task.delete', 'uses' => 'App\Http\Controllers\TaskController@delete']);

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([ 'middleware' => 'jwt.verify', 'prefix' => 'auth' ], function ($router) {
    
    Route::post('logout', 'AuthController@logout');

    Route::get('dashboard/{token}', 'AuthController@dashboard');

    Route::get('addDispatchPage/{token}', 'AuthController@addDispatchPage');
    Route::post('saveDispatch', 'AuthController@saveDispatch');
    Route::get('getDispatchItems/{limit}', 'AuthController@getDispatchItems');

    Route::get('searchDispatch/{search}', 'AuthController@searchDispatch');
    Route::get('sortDispatch/{sortBy}', 'AuthController@sortDispatch');

    Route::get('file-export/{token}', 'AuthController@fileExport');

});

Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//I have used resource routing method so I will be providing all routes in documents as well for your ease
//I have added 'App\Http\Controllers' namespace in RouteServiceProvider class so it will set as the URL generator's root namespace and some more mapping features for web and api routes
Route::group(['namespace' => 'Api'], function() {
    Route::resource('user', 'Api_UserController');
});

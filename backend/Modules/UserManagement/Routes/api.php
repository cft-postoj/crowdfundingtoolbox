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

Route::middleware('auth:api')->get('/usermanagement', function (Request $request) {
    return $request->user();
});
//
//Route::get('portal-users/all', '\Modules\UserManagement\Http\Controllers\PortalUsersController@all');
//Route::get('portal-users/{id}', '\Modules\UserManagement\Http\Controllers\PortalUsersController@getById');
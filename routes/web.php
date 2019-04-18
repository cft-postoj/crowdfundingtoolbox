<?php

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/portal/login', function() {
   return view('portal-templates.login');
});

Route::any('{slug}', function($slug)
{
    return View('welcome');
})->where('slug', '^(?!storage).*$');

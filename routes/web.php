<?php
use \Illuminate\Http\Request;
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

/* Testing portal routes -- in PROD mode they will not working, all logic from these (included scripts, placeholders)
 will be in portal templates */
Route::get('/portal/postoj', function() {
   return view('portal-templates.postoj');
});
Route::get('/portal/my-account', function() {
    return view('portal-templates.myaccount');
});
/*******************************************************/

/* Part of routes, which will be showed by some action via JS */
Route::get('/portal/login', function() {
    return view('portal-templates.login');
});
Route::get('/portal/set-generated-password', function() {
    return view('portal-templates.setGeneratedPassword');
});
/**************************************/

Route::any('{slug}', function($slug)
{
    return View('welcome');
})->where('slug', '^(?!storage).*$');

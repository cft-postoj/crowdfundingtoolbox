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
    return view('portal-templates.parts.login');
});
Route::get('/portal/register', function() {
   return view('portal-templates.parts.register');
});
Route::get('/portal/set-generated-password', function() {
    return view('portal-templates.parts.setGeneratedPassword');
});

// MY ACCOUNT
Route::get('/portal/my-account', function() {
    return view('portal-templates.myAccount.index');
});
// MY ACCOUNT parts
Route::get('/portal/my-account/preview', function() {
    return view('portal-templates.myAccount.parts.preview');
});
Route::get('/portal/my-account/newsletter', function() {
   return view('portal-templates.myAccount.parts.newsletter');
});
Route::get('/portal/my-account/saved-articles', function() {
   return view('portal-templates.myAccount.parts.savedArticles');
});
Route::get('/portal/my-account/donation', function() {
   return view('portal-templates.myAccount.parts.donation');
});
Route::get('/portal/my-account/orders', function() {
   return view('portal-templates.myAccount.parts.orders');
});
Route::get('/portal/my-account/account', function() {
   return view('portal-templates.myAccount.parts.account');
});
Route::get('/portal/my-account/bad-request', function() {
    return view('portal-templates.myAccount.badRequest');
});


/**************************************/

Route::any('{slug}', function($slug)
{
    return View('welcome');
})->where('slug', '^(?!storage).*$');

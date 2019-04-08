<?php

use Illuminate\Support\Facades\Route;
use \Illuminate\Http\Request;

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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, X-Requested-With, Origin, Authorization');

// Backoffice routes
Route::group([
    'prefix' => 'backoffice'
], function () {
    Route::post('login', 'API\UserService@authenticate');


    // Languages and Translations
//    Route::get('default-strings', 'BackOfficeAPI\TranslationsController@getDefault');
//    Route::get('languages', 'BackOfficeAPI\LanguagesController@get');
//    Route::post('language', 'BackOfficeAPI\LanguagesController@create');
//    Route::put('language', 'BackOfficeAPI\LanguagesController@update');
//    Route::delete('language', 'BackOfficeAPI\LanguagesController@delete');
//
//    Route::get('translation/{id}', function ($id) {
//        return App\Http\Controllers\BackOfficeAPI\TranslationsController::getTranslationsById($id);
//    });
//
//    Route::get('test', 'BackOfficeAPI\WidgetsController@create');

    /*
     * WIDGETS
     */
    // widget categories
//    Route::get('widget-categories', 'BackOfficeAPI\WidgetsCategoryController@getAll');
//    Route::get('widget-category/{id}', function ($id) {
//        return App\Http\Controllers\BackOfficeAPI\WidgetsCategoryController::getCategory($id);
//    });
//    Route::post('widget-category', 'BackOfficeAPI\WidgetsCategoryController@create');
//    Route::put('widget-category', 'BackOfficeAPI\WidgetsCategoryController@update');
//    Route::delete('widget-category', 'BackOfficeAPI\WidgetsCategoryController@delete');
//    // widgets
//    Route::get('widgets', 'BackOfficeAPI\WidgetsController@getAll');
//    Route::get('widget/{id}', function ($id) {
//        return App\Http\Controllers\BackOfficeAPI\WidgetsController::getWidget($id);
//    });
//    Route::post('widget', 'BackOfficeAPI\WidgetsController@create');
//    Route::put('widget', 'BackOfficeAPI\WidgetsController@update');
//    Route::delete('widget', 'BackOfficeAPI\WidgetsController@delete');

    Route::post('register', 'API\UserService@create');

    Route::group(['middleware' => ['jwt.verify']], function () {
        // Create new user - only admin role can do this

        // Sign out backoffice user
        Route::get('logout', 'BackOfficeAPI\UsersController@logout');
        // Stay logged in
        Route::get('refresh-token', 'BackOfficeAPI\UsersController@refresh');
        // Delete user - only for admin role
        Route::delete('remove-user', 'BackOfficeAPI\UsersController@delete');
        // Get all users
        Route::get('users', 'BackOfficeAPI\UsersController@getAll');

        // General Crowdfunding settings
        //Route::put('crowdfunding-settings', 'BackOfficeAPI\CrowdfundingSettingsController@index');
        Route::get('crowdfunding-settings/all', 'BackOfficeAPI\CampaignsConfigurationController@get');
        Route::get('crowdfunding-settings/colors', 'BackOfficeAPI\CampaignsConfigurationController@getColors');
        Route::get('crowdfunding-settings/fonts', 'BackOfficeAPI\CampaignsConfigurationController@getFonts');
        Route::put('crowdfunding-settings/general-page-settings', 'BackOfficeAPI\CampaignsConfigurationController@updateGeneralPageSettings');
        Route::put('crowdfunding-settings/cta-settings', 'BackOfficeAPI\CampaignsConfigurationController@updateCallToActionSettings');
        Route::put('crowdfunding-settings/widgets-settings', 'BackOfficeAPI\CampaignsConfigurationController@updateWidgetSettings');


        // Campaigns
        Route::post('campaigns', 'BackOfficeAPI\CampaignController@create');
        Route::put('campaigns/{id}', 'BackOfficeAPI\CampaignController@update');
        Route::put('campaigns/{id}/smart-settings', 'BackOfficeAPI\CampaignController@smartCampaignUpdate');
        Route::get('campaigns/all', 'BackOfficeAPI\CampaignController@all');
        Route::get('campaigns/{id}', 'BackOfficeAPI\CampaignController@show');
        Route::delete('campaigns/{id}', 'BackOfficeAPI\CampaignController@delete');
        Route::put('campaigns/{id}/result', 'BackOfficeAPI\CampaignController@updateResult');
        Route::get('campaigns/{id}/clone', 'BackOfficeAPI\CampaignController@cloneCampaign');

        // Widgets
        Route::get('campaigns/{campaignId}/widgets', 'BackOfficeAPI\WidgetsController@getWidgetsByCampaignId');
        Route::get('widgets/{id}', 'BackOfficeAPI\WidgetsController@show');
        Route::put('widgets/{id}', 'BackOfficeAPI\WidgetsController@update');
        Route::get('widgets/{id}/settings-from-campaign', 'BackOfficeAPI\WidgetsController@updateSettingsFromCampaign');
        Route::put('widgets/{id}/result', 'BackOfficeAPI\WidgetsController@updateResult');
        Route::put('widgets/{id}/smart-settings', 'BackOfficeAPI\WidgetsController@smartWidgetUpdate');


        // Upload image
        Route::post('upload', 'BackOfficeAPI\ImagesController@upload');
    });

    Route::group([
        'middleware' => ['multiauth:backOfficeUser']
    ], function () {
//        Route::get('tokenExpired', 'BackOfficeAPI\UsersController@tokenExpired');
//        Route::get('all', 'BackOfficeAPI\UsersController@getAll');
//        Route::get('user-info', 'BackOfficeAPI\UsersController@show');

    });

});

Route::group([
    'prefix'    =>  'portal'
], function() {
   Route::get('widgets', 'BackOfficeAPI\WidgetsController@getWidgets');
});



// Portal routes
Route::group([], function () {
    //Route::post('register', 'API\UserService@create');

    Route::group(['middleware' => ['api', 'multiauth:api']], function () {
        //Route::post('login', 'API\UserService@login');
        //Route::get('user-info', 'API\UserService@show');
    });
});

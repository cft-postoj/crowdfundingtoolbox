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
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, X-Requested-With, Origin, Authorization, X-CSRF-TOKEN');


// Backoffice routes
Route::group([
    'prefix' => 'backoffice'
], function () {
    Route::post('login', '\Modules\UserManagement\Http\Controllers\UserServiceController@authenticate');
    Route::post('check-generated-reset-token', '\Modules\UserManagement\Http\Controllers\BackOfficeUsersController@checkGeneratedToken');

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


    Route::post('register', '\Modules\UserManagement\Http\Controllers\UserServiceController@create');
    //Route::get('test', 'BackOfficeAPI\CampaignsConfigurationController@getFonts');
    //Route::get('test', 'BackOfficeAPI\WidgetsController@getGeneralSettings');

    Route::group(['middleware' => ['jwt.verify']], function () {
        // Create new user - only admin role can do this
        Route::get('user-detail', '\Modules\UserManagement\Http\Controllers\BackOfficeUsersController@get');
        Route::put('user-detail', '\Modules\UserManagement\Http\Controllers\BackOfficeUsersController@update');
        Route::post('user-detail', '\Modules\UserManagement\Http\Controllers\BackOfficeUsersController@create');

        // Sign out backoffice user
        Route::get('logout', '\Modules\UserManagement\Http\Controllers\UserServiceController@logout');
        // Stay logged in
        Route::get('refresh-token', '\Modules\UserManagement\Http\Controllers\UserServiceController@refresh');
        // Delete user - only for admin role
        Route::delete('remove-user', '\Modules\UserManagement\Http\Controllers\UserServiceController@delete');
        // Get all users
        Route::get('users', '\Modules\UserManagement\Http\Controllers\UserServiceController@getAll');

        // General Crowdfunding settings
        //Route::put('crowdfunding-settings', 'BackOfficeAPI\CrowdfundingSettingsController@index');
        Route::get('crowdfunding-settings/all', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@get');
        Route::get('crowdfunding-settings/colors', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@getColors');
        Route::get('crowdfunding-settings/fonts', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@getFonts');
        Route::get('crowdfunding-settings/general-page-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@getGeneralPageSettings');
        Route::get('crowdfunding-settings/cta-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@getCtaSettings');
        Route::get('crowdfunding-settings/widgets-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@getWidgetSettings');

        Route::put('crowdfunding-settings/general-page-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@updateGeneralPageSettings');
        Route::put('crowdfunding-settings/cta-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@updateCallToActionSettings');
        Route::put('crowdfunding-settings/widgets-settings', '\Modules\Campaigns\Http\Controllers\CampaignsConfigurationController@updateWidgetSettings');


        // Campaigns
        Route::post('campaigns', '\Modules\Campaigns\Http\Controllers\CampaignsController@create');
        Route::put('campaigns/{id}', '\Modules\Campaigns\Http\Controllers\CampaignsController@update');
        Route::put('campaigns/{id}/smart-settings', '\Modules\Campaigns\Http\Controllers\CampaignsController@smartCampaignUpdate');
        Route::get('campaigns/all', '\Modules\Campaigns\Http\Controllers\CampaignsController@all');
        Route::get('campaigns/{id}', '\Modules\Campaigns\Http\Controllers\CampaignsController@show');
        Route::delete('campaigns/{id}', '\Modules\Campaigns\Http\Controllers\CampaignsController@delete');
        Route::put('campaigns/{id}/result', '\Modules\Campaigns\Http\Controllers\CampaignsController@updateResult');
        Route::get('campaigns/{id}/clone', '\Modules\Campaigns\Http\Controllers\CampaignsController@cloneCampaign');
        Route::get('campaigns/widget/{id}', '\Modules\Campaigns\Http\Controllers\CampaignsController@getCampaignByWidgetId');

        // Campaign Targeting
        Route::post('campaign-targeting/users', '\Modules\Targeting\Http\Controllers\CampaignTargetingController@getUsersCount');

        // Widgets
        Route::get('campaigns/{campaignId}/widgets', '\Modules\Campaigns\Http\Controllers\WidgetsController@getWidgetsByCampaignId');
        Route::get('widgets/{id}', '\Modules\Campaigns\Http\Controllers\WidgetsController@show');
        Route::put('widgets/{id}', '\Modules\Campaigns\Http\Controllers\WidgetsController@update');
        Route::put('widgets/{id}/result', '\Modules\Campaigns\Http\Controllers\WidgetsController@updateResult');
        Route::put('widgets/{id}/smart-settings', '\Modules\Campaigns\Http\Controllers\WidgetsController@smartWidgetUpdate');


        // Upload image
        Route::post('upload', '\Modules\Campaigns\Http\Controllers\ImagesController@upload');

        // Statistics
        Route::get('statistics/donations/group', '\Modules\Statistics\Http\Controllers\StatisticsController@getDonationsGroup');
        Route::get('statistics/donations/all', '\Modules\Statistics\Http\Controllers\StatisticsController@getDonationsAll');
        Route::get('statistics/donors/group', '\Modules\Statistics\Http\Controllers\StatisticsController@getDonorsGroup');
        Route::get('statistics/donors/all', '\Modules\Statistics\Http\Controllers\StatisticsController@donorsAll');

        Route::get('statistics/donation-and-donor-total', '\Modules\Statistics\Http\Controllers\StatisticsController@getDonorsAndDonationTotal');


        // *********************************************
        // DONATIONS
        Route::get('donations/{id}', '\Modules\Payment\Http\Controllers\DonationController@getDetail');


        // *********************************************
        // PAYMENT
        Route::get('payment-methods', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getAllMethods');

        Route::get('payment/bank-transfer-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getBankTransferDetails');
        Route::post('payment/bank-transfer-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@setBankTransferDetails');
        Route::put('payment/bank-transfer-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@setBankTransferDetails');
        Route::delete('payment/bank-transfer-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@deleteBankTransferDetails');

        Route::get('payment/card-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getCardDetails');
        Route::post('payment/card-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@createCardDetails');
        Route::put('payment/card-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@updateCardDetails');
        Route::delete('payment/card-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@deleteCardDetails');

        Route::get('payment/pay-by-square-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getPayBySquareDetails');
        Route::post('payment/pay-by-square-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@setPayBySquareDetails');
        Route::put('payment/pay-by-square-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@setPayBySquareDetails');
        Route::delete('payment/pay-by-square-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@deletePayBySquareDetails');

        Route::get('payment/google-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getGooglePayDetails');
        Route::post('payment/google-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@createGooglePayDetails');
        Route::put('payment/google-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@updateGooglePayDetails');
        Route::delete('payment/google-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@deleteGooglePayDetails');

        Route::get('payment/apple-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@getApplePayDetails');
        Route::post('payment/apple-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@createApplePayDetails');
        Route::put('payment/apple-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@updateApplePayDetails');
        Route::delete('payment/apple-pay-details', '\Modules\Payment\Http\Controllers\PaymentBackOfficeController@deleteApplePayDetails');

        // *********************************************

        Route::get('portal-users/all', '\Modules\UserManagement\Http\Controllers\PortalUsersController@all');
        Route::get('portal-users/{id}', '\Modules\UserManagement\Http\Controllers\PortalUsersController@getById');
        Route::put('edit-portal-user/{id}', '\Modules\UserManagement\Http\Controllers\UserDetailsController@updatePortalUserFromBackoffice');
        Route::post('edit-portal-user/{portalUserId}/exclude-from-campaigns-targeting', '\Modules\UserManagement\Http\Controllers\PortalUsersController@excludeFromCampaignsTargeting');

    });


});

Route::group([
    'prefix' => 'portal'
], function () {
    Route::post('widgets', '\Modules\Campaigns\Http\Controllers\WidgetsController@getWidgets');
    //get Campaign
    Route::get('campaign', '\Modules\Campaigns\Http\Controllers\CampaignsController@getCampaignWidgets');
    Route::post('register', '\Modules\UserManagement\Http\Controllers\PortalUsersController@create');
    Route::post('login', '\Modules\UserManagement\Http\Controllers\PortalUsersController@authenticate');
    //Route::post('login', '\Modules\UserManagement\Http\Controllers\UserServiceController@authenticate');
    Route::post('forgotten-password', '\Modules\UserManagement\Http\Controllers\PortalUsersController@resetPassword');
    Route::post('has-user-generated-token', '\Modules\UserManagement\Http\Controllers\GeneratedUserTokenController@hasUserGeneratedToken');
    Route::post('change-password', '\Modules\UserManagement\Http\Controllers\UserServiceController@changePassword');


    Route::group(['middleware' => ['jwt.auth']], function () {
      Route::get('is-user-logged-in', '\Modules\UserManagement\Http\Controllers\PortalUsersController@isUserLoggedIn');
      Route::get('user-details', '\Modules\UserManagement\Http\Controllers\UserDetailsController@get');
      Route::put('update-user-details', '\Modules\UserManagement\Http\Controllers\UserDetailsController@update');
      Route::get('base-user-data', '\Modules\UserManagement\Http\Controllers\UserDetailsController@getBase');
      Route::get('logout', '\Modules\UserManagement\Http\Controllers\PortalUsersController@logout');

        // *********************************************
        // PAYMENT
        Route::get('payment/bank-transfer-details', '\Modules\Payment\Http\Controllers\PaymentController@getBankTransferDetails');
        Route::post('payment/pay-via-bank-transfer', '\Modules\Payment\Http\Controllers\PaymentController@payViaBankTransfer');

        Route::get('payment/card-details', '\Modules\Payment\Http\Controllers\PaymentController@getCardDetails');
        Route::post('payment/pay-via-card', '\Modules\Payment\Http\Controllers\PaymentController@payViaCard');

        Route::get('payment/pay-by-square-details', '\Modules\Payment\Http\Controllers\PaymentController@getPayBySquareDetails');
        Route::post('payment/pay-via-pay-by-square', '\Modules\Payment\Http\Controllers\PaymentController@payViaPayBySquare');

        Route::get('payment/google-pay-details', '\Modules\Payment\Http\Controllers\PaymentController@getGooglePayDetails');
        Route::post('payment/pay-via-google-pay', '\Modules\Payment\Http\Controllers\PaymentController@payViaGooglePay');

        Route::get('payment/apple-pay-details', '\Modules\Payment\Http\Controllers\PaymentController@getApplePayDetails');
        Route::post('payment/pay-via-apple-pay', '\Modules\Payment\Http\Controllers\PaymentController@payViaApplePay');

        // *********************************************
    });


    Route::post('tracking/click', '\Modules\UserManagement\Http\Controllers\TrackingController@click');
    Route::post('tracking/insertValue', '\Modules\UserManagement\Http\Controllers\TrackingController@insertValue');
    Route::post('tracking/insertEmail', '\Modules\UserManagement\Http\Controllers\TrackingController@insertEmail');
    Route::post('tracking/initialize-donation-invalid', '\Modules\UserManagement\Http\Controllers\TrackingController@initializeDonationInvalid');

    Route::post('donation/initialize', '\Modules\Payment\Http\Controllers\DonationController@initialize');


});


// Portal routes
Route::group([], function () {
    //Route::post('register', 'API\UserService@create');

    Route::group(['middleware' => ['api', 'multiauth:api']], function () {
        //Route::post('register', 'API\UserService@create');
        //Route::post('login', 'API\UserService@login');
        //Route::get('user-info', 'API\UserService@show');
    });
});

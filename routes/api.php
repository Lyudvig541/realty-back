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


Route::group(['middleware' => 'api'], function ($router) {

    Route::post('register', 'Api\JWTAuthController@register');
    Route::post('login', 'Api\JWTAuthController@login');
    Route::post('social-login', 'Api\JWTAuthController@socialLogin');
    Route::post('logout', 'Api\JWTAuthController@logout');
    Route::post('refresh', 'Api\JWTAuthController@refresh');
    Route::get('profile', 'Api\JWTAuthController@profile');

    Route::post('brokers', 'Api\BrokerController@index');
    Route::post('brokers-names', 'Api\BrokerController@getNames');
    Route::post('super-brokers', 'Api\BrokerController@superBrokers');
    Route::post('super-brokers-names', 'Api\BrokerController@getSuperBrokerNames');
    Route::post('broker', 'Api\BrokerController@broker');
    Route::post('brokers_list', 'Api\BrokerController@brokersList');
    Route::post('search_agent', 'Api\BrokerController@search');
    Route::get('auth', 'Api\JWTAuthController@getAuthenticatedUser');

    Route::post('api-agent-request', 'Api\JWTAuthController@agentRequest');

    Route::post('agenciesAll', 'Api\AgencyController@index');
    Route::post('agencies', 'Api\AgencyController@agencies');
    Route::post('agency', 'Api\AgencyController@agency');
    Route::post('top_agencies', 'Api\AgencyController@topAgencies');
    Route::post('agency-announcements', 'Api\AgencyController@agencyAnnoucements');
    Route::post('agency-brokers-announcements', 'Api\AgencyController@agencyBrokersAnnoucements');


    Route::post('partners', 'Api\PartnerController@index');
    Route::post('top_companies', 'Api\CreditCompanyController@topCompanies');
    Route::post('company', 'Api\CreditCompanyController@company');
    Route::post('all_companies', 'Api\CreditCompanyController@allCompanies');

    Route::post('types', 'Api\TypeController@index');
    Route::post('types', 'Api\TypeController@index');

    Route::post('announcements', 'Api\AnnouncementController@index');
    Route::post('get_announcement', 'Api\AnnouncementController@announcement');
    Route::post('remove-announcement-image', 'Api\AnnouncementController@removeImage');
    Route::post('search_announcement', 'Api\AnnouncementController@search');

    Route::post('additional', 'Api\AnnouncementController@additionalInform');
    Route::post('facilities', 'Api\AnnouncementController@facilitiesInform');

    Route::post('categories', 'Api\CategoryController@index');

    Route::post('add_bank_request', 'Api\BankRequestController@create');

    Route::post('get_user_favorite', 'Api\AnnouncementController@favorites');
    Route::post('bank_request', 'Api\BankRequestController@create');
    Route::post('text_pages', 'Api\TextPageController@pages');
    Route::post('text_page', 'Api\TextPageController@page');
    Route::post('construction', 'Api\ConstructorController@constructor');
    Route::post('constructions', 'Api\ConstructorController@constructors');
    Route::post('all-constructions', 'Api\ConstructorController@allConstructors');
    Route::post('states', 'Api\AnnouncementController@states');
    Route::post('cities', 'Api\AnnouncementController@cities');
    Route::post('use-states', 'Api\RegionController@useStates');
    Route::post('use-cities', 'Api\RegionController@useCities');
    Route::get('unread-notifications', 'Api\NotificationController@index');
    Route::get('notifications', 'Api\NotificationController@notifications');
    Route::get('read-notification/{id}', 'Api\NotificationController@readNotification');
    Route::get('read-all-notifications', 'Api\NotificationController@readAllNotification');
    Route::post('notification', 'Api\NotificationController@notification');
    Route::post('create_notification', 'Api\NotificationController@createNotification');
    Route::post('/add-broker-announcement', 'Api\AnnouncementController@addBrokerAnnouncement');
    Route::post('date-picker', 'Api\AnnouncementController@changeDatePicker');
    Route::post('validate_listing', 'Api\AnnouncementController@validateListing');
    Route::post('/add-favorite', 'Api\FavoriteController@create');
    Route::post('/remove-favorite', 'Api\FavoriteController@destroy');
    Route::post('/favorites', 'Api\FavoriteController@index');
    Route::post('user_announcements', 'Api\AnnouncementController@userAnnouncements');
    Route::post('add_comment', 'Api\CommentController@create');
    Route::post('user_comments', 'Api\CommentController@userCommetns');
    Route::post('user_renting_announcements', 'Api\AnnouncementController@userRentAnnouncements');
    Route::post('user_unverified_announcements', 'Api\AnnouncementController@userUnverifiedAnnouncements');
    Route::post('user_archived_announcements', 'Api\AnnouncementController@userArchivedAnnouncements');
    Route::post('/edit_user', 'Api\UserController@update');
    Route::post('/delete_announcement', 'Api\AnnouncementController@destroy');
    Route::post('/de_archiving_announcement', 'Api\AnnouncementController@deArcheving');
    Route::post('offers_and_closings', 'Api\AnnouncementController@offersAndClosings');
    Route::post('add_archive', 'Api\AnnouncementController@addArchive');
    Route::post('completed', 'Api\AnnouncementController@completed');
    Route::post('renew', 'Api\AnnouncementController@renew');
    Route::post('text', 'Admin\TextController@text');
    Route::post('currencies', 'Admin\CurrencyController@currencies');
    Route::post('/edit_user_image', 'Api\UserController@edit_user_image');
    Route::post('/phone-number-verification-code', 'Api\PhoneVerificationController@getCode');
    Route::post('/check-verification-code', 'Api\PhoneVerificationController@checkCode');
    Route::post('add-announcement', 'Api\AnnouncementController@create');
    Route::post('edit-announcement', 'Api\AnnouncementController@edit');
    Route::post('similar-announcements', 'Api\AnnouncementController@similar');
    Route::post('/places', 'Api\RegionController@useStates');
    Route::post('/constructor_agency', 'Api\ConstAgencyController@constAgency');
    Route::post('/constructor_agencies', 'Api\ConstAgencyController@all');
    Route::post('/forgot_password', 'Api\LoginController@forgotPassword');
    Route::post('/reset_password', 'Api\LoginController@resetPassword');
    Route::post('send-message', 'Api\MessageController@store');
    Route::post('get-messages', 'Api\MessageController@index');
    Route::post('get-user-broker-messages', 'Api\MessageController@userBrokerMessages');
    Route::post('unread-messages', 'Api\MessageController@unreadMessages');
    Route::post('user', 'Api\UserController@user');

});

Route::group(['middleware' => 'auth:api'], function() {
//    Route::post('announcements', 'Api\AnnouncementController@index');
//    Route::post('/add-favorite', 'Api\FavoriteController@create');
//    Route::post('/remove-favorite', 'Api\FavoriteController@destroy');
//    Route::post('/favorites', 'Api\FavoriteController@index');
});

<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Auth::routes();

Route::get('locale/{locale}', function ($locale) {
    \Session::put('locale', $locale);
    return redirect()->back();
});

Route::group(['middleware' => ['auth','role:user']], function () {
    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('admin/')->group(function () {
        Route::group(['middleware' => ['permission:users-crud']], function () {
            /**
             * User routes
             */
            Route::prefix('users')->group(function () {
                Route::get('/', 'Admin\UserController@index')->name('users');
                Route::get('/create', 'Admin\UserController@create')->name('create_user');
                Route::post('/store', 'Admin\UserController@store')->name('store_user');
                Route::get('/update/{id}', 'Admin\UserController@edit')->name('edit_user');
                Route::post('/edit/{id}', 'Admin\UserController@update')->name('update_user');
                Route::get('/destroy/{id}', 'Admin\UserController@destroy')->name('delete_user');
            });
        });

        /**
         * Categories routes
         */
        Route::prefix('categories')->group(function () {
            Route::group(['middleware' => 'permission:categories-crud'], function () {
                Route::get('/', 'Admin\CategoryController@index')->name('categories');
                Route::get('/create', 'Admin\CategoryController@create')->name('create_category');
                Route::post('/store', 'Admin\CategoryController@store')->name('store_category');
                Route::get('/edit/{id}', 'Admin\CategoryController@edit')->name('find_category');
                Route::post('/update/{id}', 'Admin\CategoryController@update')->name('edit_category');
                Route::get('/destroy/{id}', 'Admin\CategoryController@destroy')->name('delete_category');
                Route::post('/remove-category-image', 'Admin\CategoryController@removeImage')->name('remove_category_image');
            });
        });

        /**
         * Categories routes
         */
        Route::prefix('agents-requests')->group(function () {
            Route::group(['middleware' => 'permission:agents-requests-crud'], function () {
                Route::get('/', 'Admin\AgentRequestController@index')->name('agents_requests');
            });
        });

        /**
         * Broker routes
         */
        Route::prefix('brokers')->group(function () {
            Route::group(['middleware' => 'permission:brokers-crud'], function () {
                Route::get('/', 'Admin\BrokerController@index')->name('brokers');
                Route::get('/create', 'Admin\BrokerController@create')->name('create_broker');
                Route::post('/store', 'Admin\BrokerController@store')->name('store_broker');
                Route::get('/edit/{id}', 'Admin\BrokerController@edit')->name('find_broker');
                Route::post('/update/{id}', 'Admin\BrokerController@update')->name('edit_broker');
                Route::get('/destroy/{id}', 'Admin\BrokerController@destroy')->name('delete_broker');
                Route::post('/remove-image', 'Admin\BrokerController@removeImage')->name('remove_image');
                Route::group(['middleware' => 'role:admin'], function () {
                    Route::get('/super-brokers', 'Admin\BrokerController@superBrokers')->name('super_brokers');
                    Route::get('/super-brokers/create', 'Admin\BrokerController@createSuperBroker')->name('create_super_broker');
                    Route::post('/super-brokers/store', 'Admin\BrokerController@storeSuperBroker')->name('store_super_broker');
                    Route::get('/super-brokers/edit/{id}', 'Admin\BrokerController@editSuperBroker')->name('find_super_broker');
                    Route::post('/super-brokers/update/{id}', 'Admin\BrokerController@updateSuperBroker')->name('edit_super_broker');
                    Route::get('/super-brokers/destroy/{id}', 'Admin\BrokerController@destroySuperBroker')->name('delete_super_broker');
                });
            });
        });
        /**
         * Banners routes
         */
        Route::prefix('pages')->group(function () {
            Route::get('/', 'Admin\PageController@index')->name('pages');
            Route::get('/create', 'Admin\PageController@create')->name('create_page');
            Route::post('/store', 'Admin\PageController@store')->name('store_page');
            Route::get('/edit/{id}', 'Admin\PageController@edit')->name('find_page');
            Route::post('/update/{id}', 'Admin\PageController@update')->name('edit_page');
            Route::get('/destroy/{id}', 'Admin\PageController@destroy')->name('delete_page');
            Route::post('/remove-image', 'Admin\PageController@removeImage')->name('remove_image');
        });
        /**
         * Company routes
         */
        Route::prefix('credit_companies')->group(function () {
            Route::group(['middleware' => 'permission:companies-crud'], function () {
                Route::get('/', 'Admin\CreditCompanyController@index')->name('credit_companies');
                Route::get('/create', 'Admin\CreditCompanyController@create')->name('create_company');
                Route::post('/store', 'Admin\CreditCompanyController@store')->name('store_company');
                Route::get('/edit/{id}', 'Admin\CreditCompanyController@edit')->name('find_company');
                Route::post('/update/{id}', 'Admin\CreditCompanyController@update')->name('edit_company');
                Route::get('/destroy/{id}', 'Admin\CreditCompanyController@destroy')->name('delete_company');
                Route::post('/remove-image', 'Admin\CreditCompanyController@removeImage')->name('remove_image');
            });
        });

        /**
         * Partners routes
         */
        Route::prefix('partners')->group(function () {
            Route::group(['middleware' => 'permission:partners-crud'], function () {
                Route::get('/', 'Admin\PartnerController@index')->name('partners');
                Route::get('/create', 'Admin\PartnerController@create')->name('create_partner');
                Route::post('/store', 'Admin\PartnerController@store')->name('store_partner');
                Route::get('/edit/{id}', 'Admin\PartnerController@edit')->name('find_partner');
                Route::post('/update/{id}', 'Admin\PartnerController@update')->name('edit_partner');
                Route::get('/destroy/{id}', 'Admin\PartnerController@destroy')->name('delete_partner');
                Route::post('/remove-image', 'Admin\PartnerController@removeImage')->name('remove_image');
            });
        });

        /**
         * Agency routes
         */
        Route::prefix('agencies')->group(function () {
            Route::group(['middleware' => 'permission:agencies-crud'], function () {
                Route::get('/', 'Admin\AgencyController@index')->name('agencies');
                Route::get('/create', 'Admin\AgencyController@create')->name('create_agency');
                Route::post('/store', 'Admin\AgencyController@store')->name('store_agency');
                Route::get('/edit/{id}', 'Admin\AgencyController@edit')->name('find_agency');
                Route::post('/update/{id}', 'Admin\AgencyController@update')->name('edit_agency');
                Route::get('/destroy/{id}', 'Admin\AgencyController@destroy')->name('delete_agency');
                Route::post('/remove-image', 'Admin\AgencyController@removeImage')->name('remove_image');
            });
        });
        /**
         * Constructor Agency routes
         */
        Route::prefix('constructor_agencies')->group(function () {
            Route::group(['middleware' => 'permission:agencies-crud'], function () {
                Route::get('/', 'Admin\ConstAgencyController@index')->name('constructor_agencies');
                Route::get('/create', 'Admin\ConstAgencyController@create')->name('create_constructor_agency');
                Route::post('/store', 'Admin\ConstAgencyController@store')->name('store_constructor_agency');
                Route::get('/edit/{id}', 'Admin\ConstAgencyController@edit')->name('find_constructor_agency');
                Route::post('/update/{id}', 'Admin\ConstAgencyController@update')->name('edit_constructor_agency');
                Route::get('/destroy/{id}', 'Admin\ConstAgencyController@destroy')->name('delete_constructor_agency');
                Route::post('/remove-image', 'Admin\ConstAgencyController@removeImage')->name('remove_image');
            });
        });

        /**
         * Announcement routes
         */
        Route::prefix('announcements')->group(function () {
            Route::group(['middleware' => 'permission:announcements-crud'], function () {
                Route::get('/', 'Admin\AnnouncementController@index')->name('announcements');
                Route::get('/archives', 'Admin\AnnouncementController@archives')->name('archive_announcements');
                Route::get('/create/{category}/{type}', 'Admin\AnnouncementController@create')->name('create_announcement');

                /**
                 * store announcements according type
                */
                Route::post('/store-house/{category}/{type}', 'Admin\AnnouncementController@storeHome')->name('store-house');
                Route::post('/store-apartment/{category}/{type}', 'Admin\AnnouncementController@storeApartment')->name('store-apartment');
                Route::post('/store-commercial/{category}/{type}', 'Admin\AnnouncementController@storeCommercial')->name('store-commercial');
                Route::post('/store-land/{category}/{type}', 'Admin\AnnouncementController@storeLand')->name('store_land_announcement');

                Route::get('/edit/{id}', 'Admin\AnnouncementController@edit')->name('find_announcement');

                /**
                 * update announcements according type
                 */
                Route::post('/update-land/{id}', 'Admin\AnnouncementController@updateLand')->name('update-land');
                Route::post('/update-house/{id}', 'Admin\AnnouncementController@updateHouse')->name('update-house');
                Route::post('/update-apartment/{id}', 'Admin\AnnouncementController@updateApartment')->name('update-apartment');
                Route::post('/update-commercial/{id}', 'Admin\AnnouncementController@updateCommercial')->name('update-commercial');

                Route::get('/destroy/{id}', 'Admin\AnnouncementController@destroy')->name('delete_announcement');
                Route::post('/remove-image', 'Admin\AnnouncementController@removeImage')->name('remove_image');
                Route::get('/choose-category', 'Admin\AnnouncementController@chooseCategory')->name('choose-category');
                Route::get('/choose-type/{category}', 'Admin\AnnouncementController@chooseType')->name('choose-type');
                Route::get('/attached-announcements', 'Admin\AnnouncementController@attachedAnnouncements')->name('attached_announcements');
                Route::get('/accept-announcement/{id}', 'Admin\AnnouncementController@acceptAnnouncements')->name('accept_announcement');
                Route::get('/decline-announcement/{id}', 'Admin\AnnouncementController@declineAnnouncements')->name('decline_announcement');
                Route::get('/view-announcement/{id}', 'Admin\AnnouncementController@viewAnnouncements')->name('view_announcement');
                Route::get('/show-announcement/{id}', 'Admin\AnnouncementController@showAnnouncements')->name('show_announcement');
                Route::get('/free-announcements', 'Admin\AnnouncementController@freeAnnouncements')->name('free_announcements');
                Route::get('/take_announcement/{id}', 'Admin\AnnouncementController@take')->name('take_announcement');

                Route::post('/reject-announcements/{id}', 'Admin\AnnouncementController@rejectAnnouncements')->name('reject_announcements');
                Route::get('/archive-announcements/{id}', 'Admin\AnnouncementController@archiveAnnouncements')->name('archive_announcement');
                Route::get('/completed_announcement/{id}', 'Admin\AnnouncementController@completedAnnouncements')->name('completed_announcement');

                Route::group(['middleware' => 'role:super_broker'], function () {
                    Route::get('/brokers_announcements', 'Admin\AnnouncementController@brokersAnnouncements')->name('brokers_announcements');
                });

                Route::group(['middleware' => 'role:admin'], function () {
                    Route::get('/verify', 'Admin\AnnouncementController@verifys')->name('verify_announcements');
                    Route::post('/verify/{id}', 'Admin\AnnouncementController@verify')->name('verify_announcement');
                });
            });
        });

        /**
         * Announcement additional information
         */
        Route::prefix('additional_infos')->group(function () {
            Route::group(['middleware' => 'permission:announcements-crud'], function () {
                Route::get('/', 'Admin\AdditionalInfoController@index')->name('additional_infos');
                Route::get('/create', 'Admin\AdditionalInfoController@create')->name('create_additional_info');
                Route::post('/store', 'Admin\AdditionalInfoController@store')->name('store_additional_info');
                Route::get('/edit/{id}', 'Admin\AdditionalInfoController@edit')->name('find_additional_info');
                Route::post('/update/{id}', 'Admin\AdditionalInfoController@update')->name('edit_additional_info');
                Route::get('/destroy/{id}', 'Admin\AdditionalInfoController@destroy')->name('delete_additional_info');
                Route::post('/remove-image', 'Admin\AdditionalInfoController@removeImage')->name('remove_image');

            });
        });
        /**
         * Announcement Facilities
         */
        Route::prefix('facilities')->group(function () {
            Route::group(['middleware' => 'permission:announcements-crud'], function () {
                Route::get('/', 'Admin\FacilityController@index')->name('facilities');
                Route::get('/create', 'Admin\FacilityController@create')->name('create_facility');
                Route::post('/store', 'Admin\FacilityController@store')->name('store_facility');
                Route::get('/edit/{id}', 'Admin\FacilityController@edit')->name('find_facility');
                Route::post('/update/{id}', 'Admin\FacilityController@update')->name('edit_facility');
                Route::get('/destroy/{id}', 'Admin\FacilityController@destroy')->name('delete_facility');
                Route::post('/remove-image', 'Admin\FacilityController@removeImage')->name('remove_image');

            });
        });

        /**
         * Type routes
         */
        Route::prefix('types')->group(function () {
            Route::group(['middleware' => 'permission:types-crud'], function () {
                Route::get('/', 'Admin\TypeController@index')->name('types');
                Route::get('/create', 'Admin\TypeController@create')->name('create_type');
                Route::post('/store', 'Admin\TypeController@store')->name('store_type');
                Route::get('/edit/{id}', 'Admin\TypeController@edit')->name('find_type');
                Route::post('/update/{id}', 'Admin\TypeController@update')->name('edit_type');
                Route::get('/destroy/{id}', 'Admin\TypeController@destroy')->name('delete_type');
                Route::post('/remove-image', 'Admin\TypeController@removeImage')->name('remove_image');
            });
        });
        /**
         * Text routes
         */
        Route::prefix('texts')->group(function () {
            Route::group(['middleware' => 'permission:types-crud'], function () {
                Route::get('/', 'Admin\TextController@index')->name('texts');
                Route::get('/create', 'Admin\TextController@create')->name('create_text');
                Route::post('/store', 'Admin\TextController@store')->name('store_text');
                Route::get('/edit/{id}', 'Admin\TextController@edit')->name('find_text');
                Route::post('/update/{id}', 'Admin\TextController@update')->name('edit_text');
                Route::get('/destroy/{id}', 'Admin\TextController@destroy')->name('delete_text');
            });
        });
        /**
         * Currency routes
         */
        Route::prefix('currencies')->group(function () {
            Route::group(['middleware' => 'permission:types-crud'], function () {
                Route::get('/', 'Admin\CurrencyController@index')->name('currencies');
                Route::get('/create', 'Admin\CurrencyController@create')->name('create_currency');
                Route::post('/store', 'Admin\CurrencyController@store')->name('store_currency');
                Route::get('/edit/{id}', 'Admin\CurrencyController@edit')->name('find_currency');
                Route::post('/update/{id}', 'Admin\CurrencyController@update')->name('edit_currency');
                Route::get('/destroy/{id}', 'Admin\CurrencyController@destroy')->name('delete_currency');
            });
        });
        /**
         * Comments routes
         */
        Route::prefix('comments')->group(function () {
            Route::get('/', 'Admin\CommentController@index')->name('comments');
            Route::get('/create', 'Admin\CommentController@create')->name('create_comment');
            Route::post('/store', 'Admin\CommentController@store')->name('store_comment');
            Route::get('/edit/{id}', 'Admin\CommentController@edit')->name('find_comment');
            Route::post('/update/{id}', 'Admin\CommentController@update')->name('edit_comment');
            Route::get('/destroy/{id}', 'Admin\CommentController@destroy')->name('delete_comment');
        });
        /**
         * Banners routes
         */
        Route::prefix('banners')->group(function () {
            Route::get('/', 'Admin\BannerController@index')->name('banners');
            Route::get('/create', 'Admin\BannerController@create')->name('create_banner');
            Route::post('/store', 'Admin\BannerController@store')->name('store_banner');
            Route::get('/edit/{id}', 'Admin\BannerController@edit')->name('find_banner');
            Route::post('/update/{id}', 'Admin\BannerController@update')->name('edit_banner');
            Route::get('/destroy/{id}', 'Admin\BannerController@destroy')->name('delete_banner');
        });

        /**
         * Messages routes
         */
        Route::prefix('messages')->group(function () {
            Route::group(['middleware' => 'permission:messages-crud'], function () {
                Route::get('/', 'Admin\MessageController@index')->name('messages');
                Route::get('/create', 'Admin\MessageController@create')->name('create_message');
                Route::post('/store', 'Admin\MessageController@store')->name('store_message');
                Route::get('/edit/{id}', 'Admin\MessageController@edit')->name('find_message');
                Route::post('/update/{id}', 'Admin\MessageController@update')->name('edit_message');
                Route::get('/destroy/{id}', 'Admin\MessageController@destroy')->name('delete_message');
                Route::post('/send', 'Admin\MessageController@store')->name('send_message');
            });
        });
        /**
         * Constructor routes
         */
        Route::prefix('constructors')->group(function () {
            Route::get('/', 'Admin\ConstructorController@index')->name('constructors');
            Route::get('/create', 'Admin\ConstructorController@create')->name('create_constructor');
            Route::post('/store', 'Admin\ConstructorController@store')->name('store_constructor');
            Route::get('/edit/{id}', 'Admin\ConstructorController@edit')->name('find_constructor');
            Route::get('/floor/{id}/{type}', 'Admin\ConstructorController@floor')->name('floor');
            Route::post('/update/{id}', 'Admin\ConstructorController@update')->name('edit_constructor');
            Route::get('/destroy/{id}', 'Admin\ConstructorController@destroy')->name('delete_constructor');
            Route::post('/remove-image', 'Admin\ConstructorController@removeImage')->name('remove_image');
            Route::post('/save-plans', 'Admin\ConstructorController@savePlans')->name('save_planes');
            Route::post('/save-floors', 'Admin\ConstructorController@saveFloors')->name('save_floors');
            Route::post('/save-image', 'Admin\ConstructorController@saveImage');
            Route::post('/delete-image', 'Admin\ConstructorController@deleteImage');
        });

        /**
         * Settings routes
         */
        Route::prefix('settings')->group(function () {
            /**
             * Countries routes
             */
            Route::prefix('countries')->group(function () {
                Route::get('/', 'Admin\Settings\CountryController@index')->name('countries');
                Route::get('/create', 'Admin\Settings\CountryController@create')->name('create_country');
                Route::post('/store', 'Admin\Settings\CountryController@store')->name('store_country');
                Route::get('/edit/{id}', 'Admin\Settings\CountryController@edit')->name('find_country');
                Route::post('/update/{id}', 'Admin\Settings\CountryController@update')->name('edit_country');
                Route::get('/destroy/{id}', 'Admin\Settings\CountryController@destroy')->name('delete_country');
            });

            /**
             * States routes
             */
            Route::prefix('states')->group(function () {
                Route::get('/', 'Admin\Settings\StateController@index')->name('states');
                Route::get('/create', 'Admin\Settings\StateController@create')->name('create_state');
                Route::post('/store', 'Admin\Settings\StateController@store')->name('store_state');
                Route::get('/edit/{id}', 'Admin\Settings\StateController@edit')->name('find_state');
                Route::post('/update/{id}', 'Admin\Settings\StateController@update')->name('edit_state');
                Route::get('/destroy/{id}', 'Admin\Settings\StateController@destroy')->name('delete_state');
            });


            /**
             * Cities routes
             */
            Route::prefix('cities')->group(function () {
                Route::get('/', 'Admin\Settings\CityController@index')->name('cities');
                Route::get('/create', 'Admin\Settings\CityController@create')->name('create_city');
                Route::post('/store', 'Admin\Settings\CityController@store')->name('store_city');
                Route::get('/edit/{id}', 'Admin\Settings\CityController@edit')->name('find_city');
                Route::post('/update/{id}', 'Admin\Settings\CityController@update')->name('edit_city');
                Route::get('/destroy/{id}', 'Admin\Settings\CityController@destroy')->name('delete_city');
                Route::post('/city_by_state_id', 'Admin\Settings\CityController@cityByStateId')->name('city_by_state_id');
                Route::post('/city_and_state_by_id', 'Admin\Settings\CityController@cityAndStateById')->name('city_and_state_by_id');
            });
        });
        /**
         * Bank Request routes
         */
        Route::prefix('bank_requests')->group(function () {
            Route::get('/', 'Admin\BankRequestController@index')->name('bank_requests');
            Route::get('/create', 'Admin\BankRequestController@create')->name('create_bank_requests');
            Route::post('/store', 'Admin\BankRequestController@store')->name('store_bank_requests');
            Route::get('/edit/{id}', 'Admin\BankRequestController@edit')->name('find_bank_requests');
            Route::post('/update/{id}', 'Admin\BankRequestController@update')->name('edit_bank_requests');
            Route::get('/destroy/{id}', 'Admin\BankRequestController@destroy')->name('delete_bank_requests');
        });
        /**
         * Profile route
         */
        Route::get('/profile', 'Admin\ProfileController@index')->name('profile');
        Route::get('/edit-profile/{id}', 'Admin\ProfileController@edit')->name('edit_profile');
        Route::post('/update-profile/{id}', 'Admin\ProfileController@update')->name('update_profile');
        Route::post('/profile/remove-image', 'Admin\ProfileController@removeImage')->name('profile_remove_image');

        Route::get('/change-password', 'Admin\ProfileController@change_password')->name('change_password');
        Route::post('/update-password', 'Admin\ProfileController@update_password')->name('update_password');
    });
});


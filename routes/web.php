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

/*
|------------------------------------------
| Website
|------------------------------------------
*/
/*Route::group(['namespace' => 'Website'], function () {
    Route::get('/', 'HomeController@index');
    Route::get('/about', 'AboutController@index');
    Route::get('/contact-us', 'ContactUsController@index');
    Route::post('/contact-us/submit', 'ContactUsController@feedback');

    Route::get('/pages/1-column', 'PagesController@column1');
    Route::get('/pages/2-column', 'PagesController@column2');
    Route::get('/pages/3-column', 'PagesController@column3');
    Route::get('/pages/4-column', 'PagesController@column4');

    Route::get('/changelog', 'PagesController@changelog');
    Route::get('/testimonials', 'PagesController@testimonials');

    Route::get('/pricing', 'PricingController@index');
    Route::get('/faq', 'FAQController@index');
    Route::post('/faq/question/{faq}/{type?}', 'FAQController@incrementClick');
});*/

/*
|------------------------------------------
| Admin Auth
|------------------------------------------
*/
Route::group(['prefix' => 'auth', 'namespace' => 'Auth'], function () {
    // logout
    Route::get('logout', 'LoginController@logout')->name('logout');
    Route::post('logout', 'LoginController@logout');

    // login
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');

    // registration
    Route::get('register/{token}', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    Route::get('register/confirm/{token}', 'RegisterController@confirmRegister');

    // password reset
    Route::get('password/forgot', 'ForgotPasswordController@showLinkRequestForm')
        ->name('forgot-password');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')
        ->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset');
});

/*
|------------------------------------------
| Admin (when authorized and admin)
|------------------------------------------
*/
Route::group(['middleware' => ['auth', 'auth.admin'], 'namespace' => 'Admin'],
    function () {
        Route::get('/', 'DashboardController@index')->name('admin');

        // profile
        Route::get('/profile', 'ProfileController@index');
        Route::put('/profile/{user}', 'ProfileController@update');

        // analytics
        Route::group(['prefix' => 'analytics'], function () {
            Route::get('/', 'AnalyticsController@summary');
            Route::get('/devices', 'AnalyticsController@devices');
            Route::get('/visits-and-referrals', 'AnalyticsController@visitsReferrals');
            Route::get('/interests', 'AnalyticsController@interests');
            Route::get('/demographics', 'AnalyticsController@demographics');
        });

        // history
        Route::group(['prefix' => 'latest-activity', 'namespace' => 'History'], function () {
            Route::get('/', 'HistoryController@website');
            Route::get('/admin', 'HistoryController@admin');
            Route::get('/website', 'HistoryController@website');
        });

        Route::group(['prefix' => 'claim', 'namespace' => 'Claim'], function () {
            Route::get('/', 'ClaimController@index');
            Route::get('/new-claim', 'ClaimController@newclaim');
            Route::get('/deletion', 'ClaimController@delete');
            Route::get('/approval', 'ClaimController@approval');
            Route::post('submit-claim', 'ClaimController@submit');
            Route::post('approve-claim', 'ClaimController@approveClaim');
            Route::post('reject-claim', 'ClaimController@rejectClaim');
            Route::post('delete-claim', 'ClaimController@deleteClaim');
            //Route::get('/website', 'HistoryController@website');
        });

        Route::group(['prefix' => 'unit', 'namespace' => 'Unit'], function () {
            Route::get('/', 'UnitController@site');
            Route::get('/site', 'UnitController@site');
            Route::get('/zone', 'UnitController@zone');
            Route::post('/new-site', 'UnitController@newSite');
            Route::post('/new-zone', 'UnitController@newZone');
            Route::post('/remove-site', 'UnitController@removeSite');
            Route::post('/remove-zone', 'UnitController@removeZone');
        });

        Route::group(['prefix' => 'general'], function () {
            Route::resource('tags', 'TagsController');

            Route::resource('banners', 'BannersController');

            // testimonials
            Route::get('testimonials/order', 'TestimonialsOrderController@index');
            Route::post('testimonials/order', 'TestimonialsOrderController@updateOrder');
            Route::resource('testimonials', 'TestimonialsController');

            // locations
            Route::group(['prefix' => 'locations', 'namespace' => 'Locations'], function () {
                Route::resource('suburbs', 'SuburbsController');
                Route::resource('cities', 'CitiesController');
                Route::resource('provinces', 'ProvincesController');
                Route::resource('countries', 'CountriesController');
            });
        });

        // reports
        Route::group(['prefix' => 'blog', 'namespace' => 'Blog'], function () {
            Route::get('/', function () {
                return redirect('/admin/blog/articles');
            });
            Route::resource('categories', 'CategoriesController');
            Route::resource('articles', 'ArticlesController');
        });

        // faq
        Route::resource('/faqs/categories', 'Faq\CategoriesController');
        Route::get('faqs/order', 'Faq\OrderController@index');
        Route::post('faqs/order', 'Faq\OrderController@updateOrder');
        Route::resource('/faqs', 'Faq\FaqsController');

        // reports
        Route::group(['prefix' => 'reports', 'namespace' => 'Reports'], function () {
            Route::get('summary', 'SummaryController@index');

            // feedback contact us
            Route::get('contact-us', 'ContactUsController@index');
            Route::post('contact-us/chart', 'ContactUsController@getChartData');
            Route::get('contact-us/datatable', 'ContactUsController@getTableData');
        });

        Route::group(['prefix' => 'settings', 'namespace' => 'Settings'], function () {
            Route::resource('roles', 'RolesController');

            // settings / website
            Route::group(['prefix' => 'website', 'namespace' => 'Website'], function () {
                // navigation
                Route::group(['prefix' => 'navigation/order'], function () {
                    Route::get('{type?}', 'NavigationOrderController@index');
                    Route::post('{type?}', 'NavigationOrderController@updateOrder');
                });
                Route::resource('navigation', 'NavigationController');

                // changelogs
                Route::resource('changelogs', 'ChangelogsController');

                Route::resource('subscription-plans/features', 'FeaturesController');
                Route::resource('subscription-plans', 'SubscriptionPlansController');

                Route::get('subscription-plans/{subscription_plan}/features/order',
                    'SubscriptionPlansController@showFeaturesOrder');
                Route::post('subscription-plans/{subscription_plan}/features/order',
                    'SubscriptionPlansController@updateFeaturesOrder');
            });

            // settings / admin
            Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function () {
                // users
                Route::get('users/invites', 'AdministratorsController@showInvites');
                Route::post('users/invites', 'AdministratorsController@postInvite');
                Route::resource('users', 'AdministratorsController');

                // navigation
                Route::get('navigation/order', 'NavigationOrderController@index');
                Route::post('navigation/order', 'NavigationOrderController@updateOrder');
                Route::get('navigation/datatable', 'NavigationController@getTableData');
                Route::resource('navigation', 'NavigationController');
            });
        });
    });

/*
|--------------------------------------------------------------------------
| AJAX ROUTES
|--------------------------------------------------------------------------
*/
Route::group(['prefix' => 'ajax', 'namespace' => 'Ajax', 'middleware' => 'web'], function () {
    // logs
    Route::group(['prefix' => 'log'], function () {
        Route::post('social-media', 'LogsController@socialMedia');
    });
});
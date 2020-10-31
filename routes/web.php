<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file contains all of the routes which will be used anywhere on the Treiner main website.
| Add new routes here that will be accessed via a web browser.
|
|
*/

//Shows the main page
Route::get('/', 'HomeController@welcome')->name('welcome');

//Shows the terms and conditions page
Route::get('/terms', 'HomeController@terms')->name('terms');

//Returns the about page
Route::get('/about', 'HomeController@about')->name('about');

Route::get('/virtual-training', 'HomeController@virtual')->name('virtual-training');

//Returns the contact form
Route::get('/contact', 'HomeController@showContactForm')->name('contact');
//Sends the contact form to us
Route::post('/contact', 'HomeController@contact')->name('contact');

//Returns the support page
Route::get('/support', 'HomeController@showSupportForm')->middleware('auth')->name('support');
Route::post('/support', 'HomeController@support')->middleware('auth')->name('support');

//Returns the privacy page
Route::get('/privacy', 'HomeController@privacy')->name('privacy');

//Returns the FAQ page
Route::get('/faq', 'HomeController@faq')->name('faq');

//Automatically adds all routes for authentication
Auth::routes(['verify' => true]);
Route::get('/register/coach', 'Auth\RegisterController@showCoachRegistrationForm')->name('register.coach');
Route::get('/register/player', 'Auth\RegisterController@showPlayerRegistrationForm')->name('register.player');

Route::resource('/comments', 'CommentController')->except(['index', 'show', 'create']);

//Lets the user search for coaches
Route::get('/coaches/search/welcome', 'CoachController@showSearchForm')->name('coaches.welcome');
Route::get('/coaches/search/q', 'CoachController@search')->name('coaches.search');
Route::get('/coaches/cities/{city}', 'CoachController@showCoachesByCity')->name('coaches.city');
Route::get('/coaches/cities', 'CoachController@showCities')->name('coaches.show-cities');

Route::resource('/coaches', 'CoachController')->except(['index', 'show']);
Route::get('/coaches/{coach}/{slug?}', 'CoachController@show')->name('coaches.show');

//All routes for the BlogPost resource
Route::resource('/blogs', 'BlogPostController')->except(['create', 'show']);

Route::get('/blogs/{blog}/{slug?}', 'BlogPostController@show')->name('blogs.show');

Route::resource('/camps', 'CampController');

//Routes to allow user to subscribe to newsletters
Route::post('/newsletter', 'NewsletterSubscriptionController@store')->name('newsletter.store');
Route::get('/unsubscribe/{unsub_token}', 'NewsletterSubscriptionController@unsub');

//Switches the language to the one shown
Route::get('lang/{locale}', 'HomeController@lang')->name('lang');

Route::resource('/jobs', 'JobPostController');

Route::get('/signup-complete', 'HomeController@signupComplete')->middleware('auth');

Route::middleware(['auth', 'verified'])->group(function() {
    //All routes for the CartItem resource
    Route::resource('/book', 'CartItemController')->only(['store', 'index', 'destroy']);

    Route::get('/book/{session}', 'CartItemController@storeFromUrl')->name('book.store.url');

    Route::get('/sessions/{session}', 'SessionController@show')->name('sessions.show');

    Route::get('/jobs/request-session/{coach}', 'JobPostController@requestSession')->name('jobs.request-session');

    Route::post('/cart/{cartItem}/coupon', 'CouponPlayerController@addToCartItem')->name('cart.coupon.add');

    //As a player, withdraw from a session
    Route::delete('/withdraw/{sessionPlayer}', 'SessionController@withdraw')->name('sessions.withdraw')->middleware('can:withdraw,sessionPlayer');

    Route::post('/book/complete', 'CartItemController@complete')->name('cart.complete')->middleware('can:complete,Treiner\CartItem');

    //Shows the booking form for a coach
    Route::post('/book/{coach}', 'SessionController@showBookingForm')->name('book.show')->middleware('can:book,coach');

    Route::post('/offers/deny/{offer}', 'JobOfferController@deny')->name('offers.deny')->middleware('can:delete,offer');
    Route::get('/offers/{offer}/billing', 'JobOfferController@showBillingForm')->name('offers.billing')->middleware('can:finish,offer');
    Route::post('/offers/{offer}/complete', 'JobPostController@complete')->name('offers.complete');
    Route::get('/offers/create/{job}', 'JobOfferController@create')->name('offers.create');
    Route::resource('/offers', 'JobOfferController')->except(['index', 'create', 'show']);

    Route::get('/jobs/search/welcome', 'JobPostController@showSearchForm')->name('jobs.welcome')->middleware('can:viewAny,Treiner\JobPost');
    Route::get('/jobs/search/q', 'JobPostController@search')->name('jobs.search')->middleware('can:viewAny,Treiner\JobPost');
});

//Adds a prefix for everything within the dashboard
Route::middleware(['auth', 'verified'])->prefix('home')->group(function () {
    Route::get('/blogs', 'BlogPostController@dashboard')->name('blogs.dashboard');

    //Shows the main dashboard page
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/coaches/authorize', 'CoachController@setupPayment')->name('coaches.authorize');

    Route::get('/messages', 'ConversationController@index')->name('conversations.index');
    Route::get('/messages/{conversation}', 'ConversationController@show')->name('conversations.show');

    Route::get('/profile', 'CoachController@showCoachProfilePage')->name('home.profile');
    Route::post('/profile', 'CoachController@updateProfile')->name('home.profile.update');

    Route::get('/camps', 'CampController@dashboard')->name('camps.dashboard');
    Route::get('/camps/{camp}/csv', 'CampController@csv')->name('camps.csv');

    Route::get('/invitations', 'CampController@invitations')->name('invitations.index');
    Route::get('/invitations/{invitation}/accept', 'CampController@acceptInvitation')->name('invitations.accept');
    Route::get('/invitations/{invitation}/deny', 'CampController@denyInvitation')->name('invitations.deny');

    Route::get('/live', 'LiveController@index')->name('live.index');
    Route::get('/live/{zoomNumber}', 'LiveController@startMeeting')->name('live.show');
    Route::post('/live/{session}/add', 'LiveController@addZoomNumber')->name('live.add');
    Route::get('/messages/{conversation}/all', 'Api\MessageController@getAllMessages')->name('messages.all');
    Route::get('/messages/{conversation}/unread', 'Api\MessageController@getUnreadMessages')->name('messages.unread');
    Route::post('/messages/{conversation}/send', 'Api\MessageController@store')->name('messages.send');

    //Lets the user view their sessions
    Route::resource('/sessions', 'SessionController')->except(['update', 'edit']);

    Route::post('/delete', 'HomeController@destroy')->name('user.delete');

    Route::get('/settings', 'HomeController@settings')->name('settings.show');
    Route::post('/settings', 'HomeController@saveSettings')->name('settings.store');

    Route::get('/payments/setup', 'CoachController@setupPayment')->name('payments.setup');
    Route::get('/payments/dashboard', 'CoachController@paymentDashboard')->name('payments.dashboard');

    Route::resource('/reviews', 'ReviewController')->except(['show', 'index']);

    Route::get('/offers', 'JobOfferController@index')->name('offers.index');

    Route::post('/sessions/{session}/payout', 'SessionController@payout')->name('sessions.payout');

    Route::get('/reports/player/create/{sessionPlayer}', 'ReportController@createForPlayer')->name('reports.create-player')->middleware('can:createReportForPlayer,sessionPlayer');
    Route::get('/reports/coach/create/{session}', 'ReportController@createForCoach')->name('reports.create-coach');
    Route::post('/reports/player/store/{sessionPlayer}', 'ReportController@storeForPlayer')->name('reports.store-player')->middleware('can:createReportForPlayer,sessionPlayer');
    Route::post('/reports/coach/store', 'ReportController@storeForCoach')->name('reports.store-coach');

});

//Route::domain('admin.' . parse_url(config('app.url'), PHP_URL_HOST))->middleware(['admin'])->group(function () {
Route::prefix('admin')->middleware(['admin'])->group(function () {
    Route::get('/', 'Admin\AdminController@dashboard')->name('admin.dashboard');

    Route::get('/users/{user}/email/manual', 'Admin\PlayerController@manuallyVerifyEmail')->name('admin.email.manual');

    Route::get('/players/search', 'Admin\PlayerController@showSearchForm')->name('admin.players.search');
    Route::post('/players/search/id', 'Admin\PlayerController@searchById')->name('admin.players.search.id');
    Route::post('/players/search/name', 'Admin\PlayerController@searchByName')->name('admin.players.search.name');
    Route::get('/players/{player}', 'Admin\PlayerController@show')->name('admin.players.show');
    Route::post('/players/csv', 'Admin\PlayerController@csv')->name('admin.players.csv');

    Route::resource('/coupons', 'Admin\CouponController')->except(['show']);

    Route::get('/coaches/search', 'Admin\CoachController@showSearchForm')->name('admin.coaches.search');
    Route::post('/coaches/search/id', 'Admin\CoachController@searchById')->name('admin.coaches.search.id');
    Route::post('/coaches/search/name', 'Admin\CoachController@searchByName')->name('admin.coaches.search.name');
    Route::get('/coaches/csv', 'Admin\CoachController@saveCoachesAsCsv')->name('coaches.csv');
    Route::get('/coaches/{coach}', 'Admin\CoachController@show')->name('admin.coaches.show');
    Route::post('/coaches/{coach}/updatefee', 'Admin\CoachController@updateFee')->name('admin.coaches.updatefee');
    Route::post('/coaches/{coach}/updateverified', 'Admin\CoachController@updateVerified')->name('admin.coaches.updateverified');
    Route::get('/verifications', 'Admin\CoachController@showVerifications')->name('verifications.index');
    Route::post('/verifications/accept-coach', 'Admin\CoachController@acceptCoach')->name('verifications.accept');
    Route::post('/verifications/deny-coach', 'Admin\CoachController@denyCoach')->name('verifications.deny');
    Route::get('/verifications/csv', 'Admin\CoachController@saveVerificationsAsCsv')->name('verifications.csv');

    Route::post('/sessions/store', 'Admin\SessionController@store')->name('admin.sessions.store');
    Route::get('/sessions/create', 'Admin\SessionController@create')->name('admin.sessions.create');
    Route::get('/sessions/search', 'Admin\SessionController@showSearchForm')->name('admin.sessions.search');
    Route::post('/sessions/search', 'Admin\SessionController@search')->name('admin.sessions.search');
    Route::get('/sessions/{session}', 'Admin\SessionController@show')->name('admin.sessions.show');

    Route::get('/blogs/index', 'Admin\BlogPostController@create')->name('admin.blogs.index');

    Route::get('/reports/{report}/toggle', 'ReportController@toggleResolution')->name('reports.toggle');
    Route::get('/reports', 'ReportController@index')->name('reports.index');

    Route::get('/admins', 'Admin\AdminController@admins')->name('admins.index');
    Route::post('/admins/store', 'Admin\AdminController@store')->name('admins.store');
    Route::get('/admins/{user}/edit', 'Admin\AdminController@edit')->name('admins.edit');
    Route::post('/admins/{user}/destroy', 'Admin\AdminController@destroy')->name('admins.destroy');
    Route::post('/admins/{user}/update', 'Admin\AdminController@update')->name('admins.update');

    Route::get('/jobs', 'Admin\JobController@index')->name('admin.jobs.index');
    Route::get('/jobs/{job}', 'Admin\JobController@show')->name('admin.jobs.show');
});

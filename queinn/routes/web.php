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
//Clear Cache facade value:
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route-cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route-clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view-clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config-cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});
*/
//Auth::routes();

//Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
//Route::get('login',   'Auth\LoginController@showLoginForm')->name('login');
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('login',   'Auth\LoginController@login');
//Route::post('register',   'Auth\RegisterController@register');
//Route::get('password/reset/{token}',  'Auth\ResetPasswordController@showResetForm')->name('password.reset');
//Route::post('password/reset/{token}', 'Auth\ResetPasswordController@reset');
//Route::get('password/reset',   'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
//Route::post('password/reset',   'Auth\ForgotPasswordController@reset')->name('password.email');
//
//// Social Login
//Route::get('/login/{provider}', 'Auth\LoginController@redirectToProvider');
//Route::get('/login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

//ADMIN ROUTING STARTS
Route::group(['prefix' => 'admin'], function () {
	Route::get('/', 'AdminController@index');
	Route::get('login', 'AdminAuth\LoginController@showLoginForm');
	Route::post('login', 'AdminAuth\LoginController@login');
	Route::post('logout', 'AdminAuth\LoginController@logout');
	
	Route::get('forgot-password', 'AdminAuth\ForgotPasswordController@showLinkRequestForm');
	Route::post('forgot-password', 'AdminAuth\ForgotPasswordController@forgotPassword');
});


Route::group(['prefix' => 'admin','middleware' => 'adminauth'], function () {
	Route::get('home', 'AdminController@home');
	
	Route::post('quick-mail', 'AdminController@sendQuickEmail');
	
	Route::get('notification', 'Admin\NotificationController@index');
	Route::post('notification', 'Admin\NotificationController@update');

	Route::get('web-settings', 'Admin\WebSettingsController@index');
	Route::post('web-settings', 'Admin\WebSettingsController@update');

    Route::get('users/profile', 'Admin\UsersController@adminProfile');
    Route::post('users/profile', 'Admin\UsersController@updateAdminProfile');
	
	//GENERAL SETTINGS
	Route::get('general-settings', 'Admin\SettingsController@index');
	Route::post('general-settings', 'Admin\SettingsController@updateSettings');
	
	//HOME SLIDER
	Route::get('home-slider', 'Admin\SliderController@index');
	Route::get('home-slider/add-slide', 'Admin\SliderController@addSlide');
	Route::post('home-slider/add-slide', 'Admin\SliderController@saveSlide');
	
	Route::get('home-slider/edit-slide/{id}', 'Admin\SliderController@editSlide');
	Route::post('home-slider/edit-slide/{id}', 'Admin\SliderController@updateSlide');
	Route::get('home-slider/delete-slide/{id}', 'Admin\SliderController@deleteSlide');
	
	// =====business list========================================================================//
	Route::get('pages', 'Admin\BusinessController@index')->name('pages');
	Route::get('pages/add', 'Admin\BusinessController@addPage');
	Route::post('pages/add', 'Admin\BusinessController@savePage');
	Route::get('pages/edit/{id}', 'Admin\BusinessController@editPage');
	Route::post('pages/edit/{id}', 'Admin\BusinessController@updatePage')->name('business-update');
	
	Route::get('pages/delete/{id}', 'Admin\BusinessController@deletePage');
	

	//  =====users list========================================================================//
	Route::get('user', 'Admin\UserlistController@index')->name('user');
	Route::get('user/add', 'Admin\UserlistController@addPage');
	Route::post('user/add', 'Admin\UserlistController@savePage');
	Route::get('user/edit/{id}', 'Admin\UserlistController@editPage');
	Route::post('user/edit/{id}', 'Admin\UserlistController@updatePage')->name('user-update');
	Route::DELETE('user/delete/{id}', 'Admin\UserlistController@deletePage')->name('user-delete');
	
	//==============daily_special=============================================================//
	Route::get('daily_special','Admin\DailySpecialController@index')->name('daily_special');
    Route::get('daily_special/add', 'Admin\DailySpecialController@addPage');
	Route::post('daily_special/add', 'Admin\DailySpecialController@savePage');
	Route::get('daily_special/edit/{id}', 'Admin\DailySpecialController@editPage');
	Route::post('daily_special/edit/{id}', 'Admin\DailySpecialController@updatePage')->name('daily_special-update');
	Route::DELETE('daily_special/delete/{id}', 'Admin\DailySpecialController@deletePage')->name('daily_special-delete');

	//==============appointment=============================================================//
	Route::get('appointment','Admin\AppointmentController@index')->name('appointment');
    Route::get('appointment/add', 'Admin\AppointmentController@addPage');
	Route::post('appointment/add', 'Admin\AppointmentController@savePage');
	Route::get('appointment/edit/{id}', 'Admin\AppointmentController@editPage');
	Route::post('appointment/edit/{id}', 'Admin\AppointmentController@updatePage')->name('appointment-update');
	Route::DELETE('appointment/delete/{id}', 'Admin\AppointmentController@deletePage')->name('appointment-delete');
	
   //==============user_order=============================================================//
    Route::get('order','Admin\OrderController@index')->name('order');
  
	Route::get('order/edit/{id}', 'Admin\OrderController@editPage');
	Route::post('order/edit/{id}', 'Admin\OrderController@updatePage')->name('order-update');
	Route::DELETE('order/delete/{id}', 'Admin\OrderController@deletePage')->name('order-delete');
	

//======================= notification =====================================//

Route::get('notification','Admin\PushNotification@set_message_data');
/*Route::get('notification','Admin\NotificationController@push_notification_instance_creation_without_argument_set_gcm_as_service');
Route::get('notification','Admin\NotificationController@index');
*/	//Blogs
	/*Route::get('blogs', 'Admin\BlogsController@index');
	Route::get('blogs/add', 'Admin\BlogsController@addBlog');
	Route::post('blogs/add', 'Admin\BlogsController@saveBlog');
	
	Route::get('blogs/edit/{id}', 'Admin\BlogsController@editBlog');
	Route::post('blogs/edit/{id}', 'Admin\BlogsController@updateBlog');
	
	Route::get('blogs/delete/{id}', 'Admin\BlogsController@deleteBlog');
	
	Route::get('blogs/categories', 'Admin\BlogsController@blogCategories');
	Route::post('blogs/categories/add', 'Admin\BlogsController@addBlogCategories');
	
	Route::get('blogs/categories/edit/{id}', 'Admin\BlogsController@editBlogCategories');
	Route::post('blogs/categories/edit/{id}', 'Admin\BlogsController@updateBlogCategories');
	Route::get('blogs/categories/delete-category/{id}', 'Admin\BlogsController@deleteBlogCategories');
	
	
	Route::get('blogs/comments-list', 'Admin\BlogsController@commentsList');
	
	Route::get('blogs/comments-list/edit/{id}', 'Admin\BlogsController@editCommentList');
	Route::post('blogs/comments-list/edit/{id}', 'Admin\BlogsController@updateCommentList');
	
	Route::get('blogs/comments-list/delete/{id}', 'Admin\BlogsController@deleteCommentList');*/

//    Route::get('blogs/tags', 'Admin\BlogsController@tagsList');
//    Route::get('blogs/tags/add', 'Admin\BlogsController@addTags');
//    Route::post('blogs/tags/add', 'Admin\BlogsController@saveTags');
//    Route::get('blogs/tags/edit/{id}', 'Admin\BlogsController@editTags');
//    Route::post('blogs/tags/edit/{id}', 'Admin\BlogsController@updateTags');
//    Route::get('blogs/tags/delete-tag/{id}', 'Admin\BlogsController@deleteTags');

    //Contact
    Route::get('contact', 'Admin\ContactDetailsController@index');
    Route::get('contact/add', 'Admin\ContactDetailsController@createContact');
    Route::post('contact/add', 'Admin\ContactDetailsController@saveContact');
    Route::get('contact/edit/{id}', 'Admin\ContactDetailsController@editContact');
    Route::post('contact/edit/{id}', 'Admin\ContactDetailsController@updateContact');
    Route::get('contact/delete/{id}', 'Admin\ContactDetailsController@deleteContact');

	//FAQ
	Route::get('faq', 'Admin\FaqController@index');
	Route::get('faq/add', 'Admin\FaqController@addFaq');
	Route::post('faq/add', 'Admin\FaqController@saveFaq');
	
	Route::get('faq/edit/{id}', 'Admin\FaqController@editFaq');
	Route::post('faq/edit/{id}', 'Admin\FaqController@updateFaq');
	
	Route::get('faq/delete/{id}', 'Admin\FaqController@deleteFaq');

    // Coupons
    Route::get('/coupons','Admin\CouponsController@index');
    Route::get('/coupon/add', 'Admin\CouponsController@add');
    Route::post('/coupon/add', 'Admin\CouponsController@save');
    Route::get('/coupon/edit/{id}', 'Admin\CouponsController@edit');
    Route::post('/coupon/edit/{id}', 'Admin\CouponsController@update');
    Route::get('/coupon/delete/{id}', 'Admin\CouponsController@delete');

    Route::get('coupons/types', 'Admin\CouponsController@Types');
    Route::post('coupons/types', 'Admin\CouponsController@saveType');
    Route::get('coupons/edit-type/{id}', 'Admin\CouponsController@editType');
    Route::post('coupons/edit-type/{id}', 'Admin\CouponsController@updateType');
    Route::get('coupons/delete-type/{id}', 'Admin\CouponsController@deleteType');

   /* // Coupon Guide
    Route::get('guide', 'Admin\CouponsGuideController@index');
    Route::get('guide/add', 'Admin\CouponsGuideController@addGuide');
    Route::post('guide/add', 'Admin\CouponsGuideController@saveGuide');
    Route::get('guide/edit/{id}', 'Admin\CouponsGuideController@editGuide');
    Route::post('guide/edit/{id}', 'Admin\CouponsGuideController@updateGuide');
    Route::get('guide/delete/{id}', 'Admin\CouponsGuideController@deleteGuide');

    Route::get('guide/video/show', 'Admin\CouponsVideoGuideController@videoGuide');
    Route::get('guide/video/add', 'Admin\CouponsVideoGuideController@addVideoGuide');
    Route::post('guide/video/add', 'Admin\CouponsVideoGuideController@saveVideoGuide');
    Route::get('guide/video/edit/{id}', 'Admin\CouponsVideoGuideController@editVideoGuide');
    Route::post('guide/video/edit/{id}', 'Admin\CouponsVideoGuideController@updateVideoGuide');
    Route::get('guide/video/delete/{id}', 'Admin\CouponsVideoGuideController@deleteVideoGuide');
*/
    // Stores
   /* Route::get('/stores','Admin\StoresController@index');
    Route::get('/store/add', 'Admin\StoresController@add');
    Route::post('/store/add', 'Admin\StoresController@save');
    Route::get('/store/edit/{id}', 'Admin\StoresController@edit');
    Route::post('/store/edit/{id}', 'Admin\StoresController@update');
    Route::get('/store/delete/{id}', 'Admin\StoresController@delete');
    Route::get('/stores/delete-image/{id}', 'Admin\StoresController@deleteStoreGallery');

    // Stores Review
    Route::get('/stores/reviews', 'Admin\StoresController@showReview');
    Route::get('/stores/review/edit/{id}', 'Admin\StoresController@editReview');
    Route::post('/stores/review/edit/{id}', 'Admin\StoresController@updateReview');
    Route::get('/stores/review/delete/{id}', 'Admin\StoresController@deleteReview')*/;

	
	Route::get('mailchimp-settings', 'Admin\NewsletterController@mailchimpSettings');
	Route::post('mailchimp-settings', 'Admin\NewsletterController@saveMailchimpSettings');
	Route::get('newsletter-subscription', 'Admin\NewsletterController@index');
	Route::get('newsletter-subscription/delete-subscription/{id}', 'Admin\NewsletterController@deleteSubscription');

	Route::get('admins', 'Admin\UsersController@admins');
	Route::get('admin/add', 'Admin\UsersController@addAdminView');
	Route::post('admin/store', 'Admin\UsersController@addAdmin');
	Route::get('admin/delete/{id}', 'Admin\UsersController@deleteAdmin');
	Route::get('admins/edit/{id}', 'Admin\UsersController@editAdminView');
	Route::post('admins/edit/{id}', 'Admin\UsersController@editAdmin');
});

Route::post('/products/review/save','Admin\ProductReviewsController@saveReview')->name('reviewSubmit');
Route::post('stores/reviews/save', 'Admin\StoresController@saveReview');
Route::post('/blogs/search', 'ArticlesController@articleSearch');

//FRONTEND URLS
Route::get('cron_wp_reset_password_emails', 'CronWPResetPasswordEmailsController@index');

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index');

Route::paginate('blogs', 'ArticlesController@index');
Route::paginate('blog/{slug}', 'ArticlesController@articleBySlug');
Route::get('category/{catslug}', 'ArticlesController@ArticlesByCategory');
//Route::get('tag/{tagslug}', 'ArticlesController@articlesByTag');
Route::post('articles/leave-reply', 'ArticlesController@leaveReply');
Route::get('contact', 'ContactController@index');
Route::post('contact/send', 'ContactController@send');

Route::get('faq', 'PagesController@faq');

Route::get('{slug}', 'PagesController@index');
Route::post('ajax/newsletter-subscription', 'AjaxController@newsletterSubscription');
Route::post('ajax/get-states/{country_code}', 'AjaxController@getStates');

Route::post('/search', 'StoreFrontController@search');
Route::get('{slug}/search', function(){return redirect()->back();});
Route::get('store/{storeSlug}', 'StoreFrontController@storeBySlug');

Route::post('/coupon/count/{id}', 'StoreFrontController@couponCount');

//Delete Unused Files
//Route::get('delete/unused-delete', 'DeleteUnusedFilesController@index');


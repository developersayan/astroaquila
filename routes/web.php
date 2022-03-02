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

// Route::get('/', function () {
//     return view('welcome');
// });
// pundit
// astrologer
Route::get('/lang/{id}', 'HomeController@lang')->name('lang');
Route::get('/currency/{id}', 'HomeController@currency')->name('currency');
Route::get('currency-conversion','HomeController@currencyConversion')->name('currency.conversion.update');

Route::group(['middleware' => 'language','middleware' => 'currency'], function () {


Auth::routes();
Route::get('/', 'Modules\Home\HomeController@index')->name('home');
Route::post('/get-state', 'HomeController@gateState')->name('get.state');
Route::post('/get-city', 'HomeController@gateCity')->name('get.city');
Route::post('/get-area', 'HomeController@getArea')->name('get.area');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::post('login-submit', 'Auth\LoginController@customLogin')->name('custom.login');

Route::get('/forgot-password', 'Auth\LoginController@forgotPassword')->name('password.forgot');
Route::post('/forgot-password', 'Auth\LoginController@forgotPassword')->name('password.forgot.submit');
Route::get('/forgot-password-verify/{id}/{code}', 'Auth\LoginController@forgotPasswordVerifyMail')->name('forgot.email.verify');
Route::Post('/forgot-password/change', 'Auth\LoginController@changePassword')->name('password.forgot.change');


Route::post('/customer/register', 'Auth\RegisterController@CustomerRegister')->name('customer.register.submit');

Route::get('/pundit/register', 'Auth\RegisterController@showRegistrationFormPundit')->name('pundit.register');
Route::post('/pundit/register', 'Auth\RegisterController@PunditRegister')->name('pundit.register.submit');

Route::get('/astrologer/register', 'Auth\RegisterController@showRegistrationFormAstrologer')->name('astrologer.register');
Route::post('/astrologer/register', 'Auth\RegisterController@AstrologerRegister')->name('astrologer.register.submit');

Route::get('/account/verify/{id}/{vcode}', 'Auth\RegisterController@VerifyEmail')->name('account.verify');
Route::get('seller/register', 'Auth\RegisterController@showRegistrationFormSeller')->name('seller.register');
Route::post('seller/register-save', 'Auth\RegisterController@sellerRegister')->name('seller.register.save');
Route::post('check-email', 'Auth\RegisterController@checkEmail')->name('check.email');
Route::post('check-mobile', 'Auth\RegisterController@checkMobile')->name('check.mobile');

Route::get('/account/verify-otp/{id}', 'Auth\RegisterController@otp')->name('account.otp');
Route::post('/account/verify-otp-submit/{id}', 'Auth\RegisterController@verifyOTP')->name('account.otp.submit');
Route::get('/account/resend-otp/{id}', 'Auth\RegisterController@resendOTP')->name('account.resend.otp');
Route::get('/account/resend-otp-auth/{id}', 'HomeController@resendOTP')->name('account.resend.otp.auth');
Route::any('/puja-search', 'Modules\Search\SearchController@searchPundit')->name('search.pandit');
// Route::any('/puja-search/{slug}', 'Modules\Search\SearchController@panditPublicProfile')->name('search.pandit.publicProfile');
Route::any('/search-puja', 'Modules\Search\SearchController@searchPunditPuja')->name('search.pandit.puja');

Route::any('/puja-search/{slug}', 'Modules\Search\SearchController@pujaDetails')->name('search.puja.details');
Route::any('/check-zip', 'Modules\Search\SearchController@checkZip')->name('search.puja.details.check.zip');
// blog
Route::get('/blog','Modules\Blog\BlogController@index')->name('blog.show.frontend');
Route::get('/blog/blog-details/{slug}','Modules\Blog\BlogController@blogDetails')->name('blog.show.details.frontend');


Route::group(['namespace' => 'Modules\Customer'], function() {
    Route::get('/dashboard', 'ProfileController@dashboard')->name('customer.dashboard');
    Route::get('/profile', 'ProfileController@profile')->name('customer.profile');
    Route::post('/profile-edit', 'ProfileController@profileEdit')->name('customer.profile.edit');
    Route::get('/change-password', 'ProfileController@changePassword')->name('customer.change.password');
    Route::post('/change-password', 'ProfileController@changePasswordSave')->name('customer.change.password.save');
    // customer-email-verification
    Route::post('/check-duplicate-email','ProfileController@checkemail')->name('customer.check.email');
    Route::post('/change-email','ProfileController@changemail')->name('customer.change.mail');


    Route::post('/change-mobile', 'ProfileController@mobileChange')->name('customer.change.mobile');
    Route::post('/check-otp', 'ProfileController@wrongOTPCheck')->name('customer.change.mobile.check.otp');
    Route::post('/change-mobile-submit', 'ProfileController@mobileChangeSubmit')->name('customer.change.mobile.submit');

    Route::get('/my-calls', 'BookingController@callBookingList')->name('customer.call');
    Route::post('/my-calls', 'BookingController@callBookingList')->name('customer.call.filter');
    Route::get('/puja-history', 'PujaOrderController@pujaOrderList')->name('customer.puja.history');
    Route::post('/puja-history', 'PujaOrderController@pujaOrderList')->name('customer.puja.history.filter');
    Route::get('/puja-history/{id}', 'PujaOrderController@pujaOrderView')->name('customer.puja.history.view');
    Route::get('/my-calls/{id}', 'BookingController@callBookingView')->name('customer.call.view');
    Route::get('/complete-offline-calls/{id}', 'BookingController@complete')->name('customer.call.complete.offline');

    // cancel-call
    Route::get('/cancel-calls/{id}', 'BookingController@cancel')->name('customer.call.cancel');
    Route::post('/check-cancel-otp','BookingController@checkOtp')->name('customer.check.cancel.otp');
    Route::post('/cancel-order','BookingController@cancelOrder')->name('customer.check.cancel.order');



    // review
    Route::get('/review/call/{id}','ReviewController@index')->name('customer.review.call.view');
    Route::get('/review/puja/{id}','ReviewController@index')->name('customer.review.puja.view');
    Route::post('/post-review','ReviewController@postReview')->name('customer.post.review');

    Route::any('/my-order', 'ProductOrder@index')->name('customer.order');
    Route::any('/my-order/details/{slug}', 'ProductOrder@viewDetails')->name('customer.order.details');
    Route::any('/my-order/review/{slug}', 'ProductOrder@viewReview')->name('customer.order.review');
    Route::post('/my-order/post-review', 'ProductOrder@postReview')->name('customer.order.post.review');

    // Route::get('/my-order/order-cancel/{slug}', 'ProductOrder@orderCancel')->name('customer.order.cancel');
    Route::get('/my-order/cancel-product-order/{slug}','ProductOrder@orderCancel')->name('customer.order.cancel');
    Route::post('/my-order/cancel-product','ProductOrder@cancel')->name('customer.order.cancel.confirm');
});
/* pundit */
Route::group(['namespace' => 'Modules\Pundits'], function() {
    Route::get('pundit/dashboard', 'ProfileController@dashboard')->name('pundit.dashboard');
    Route::get('pundit/profile', 'ProfileController@profile')->name('pundit.profile');
    Route::post('pundit/profile-edit', 'ProfileController@profileEdit')->name('pundit.profile.edit');
    Route::get('pundit/availability', 'ProfileController@availability')->name('pundit.availability');
    Route::post('pundit/availability-save', 'ProfileController@availabilitySave')->name('pundit.availability.save');
    Route::get('pundit/puja', 'ProfileController@pujaList')->name('pundit.puja');
    Route::post('pundit/puja-add', 'ProfileController@pujAdd')->name('pundit.puja.add');
    Route::get('pundit/puja-edit/{id}', 'ProfileController@pujaEdit')->name('pundit.puja.edit');
    Route::post('pundit/puja-edit-save/{id}', 'ProfileController@pujaEditSave')->name('pundit.puja.edit.save');
    Route::get('pundit/puja-delete/{id}', 'ProfileController@pujaDelete')->name('pundit.puja.delete');
    Route::get('pundit/change-password', 'ProfileController@changePassword')->name('pundit.change.password');
    Route::post('pundit/change-password', 'ProfileController@changePasswordSave')->name('pundit.change.password.save');
    Route::post('pundit/change-mobile', 'ProfileController@mobileChange')->name('pundit.change.mobile');
    Route::post('pundit/check-otp', 'ProfileController@wrongOTPCheck')->name('pundit.change.mobile.check.otp');
    Route::post('pundit/change-mobile-submit', 'ProfileController@mobileChangeSubmit')->name('pundit.change.mobile.submit');


    Route::get('pundit/offline-service', 'ProfileController@serviceZipCodeList')->name('pundit.puja.service');
    Route::post('pundit/offline-service-save', 'ProfileController@serviceZipCodeAdd')->name('pundit.puja.service.save');
    Route::get('pundit/offline-service-delete/{id}', 'ProfileController@serviceZipCodeDelete')->name('pundit.puja.service.delete');
    Route::get('pundit/offline-service/get-zipcode','ProfileController@getZip')->name('pundit.puja.service.get-zipcode');
    Route::get('pundit/offline-service/check-zipcode','ProfileController@checkZip')->name('pundit.puja.service.check-zipcode');

    // puja-history//////////////////////////////////
    Route::get('pundit/puja-history','PujaOrderController@pujahistory')->name('pundit.puja.history');
    Route::post('pundit/puja-history','PujaOrderController@pujahistory')->name('pundit.puja.history.search');
    Route::get('pundit/puja-history-delete/{id}','PujaOrderController@delete_puja_history')->name('pundit.puja.history.delete');
    Route::get('pundit/puja-accept/{id}','PujaOrderController@pujaAccept')->name('pundit.puja.accept');
    Route::get('pundit/puja-reject/{id}','PujaOrderController@pujaReject')->name('pundit.puja.reject');
    Route::get('pundit/puja-inprocess/{id}','PujaOrderController@pujaInprocess')->name('pundit.puja.inprocess');
    Route::get('pundit/puja-complete/{id}','PujaOrderController@pujaComplete')->name('pundit.puja.complete');
    // Route::get('pundit/puja-history','PujaOrderController@pujaHistory')->name('pundit.puja.history');
    // Route::post('pundit/puja-history','PujaOrderController@pujaHistory')->name('pundit.puja.history.search');
    // Route::get('pundit/puja-history-delete/{id}','PujaOrderController@delete_puja_history')->name('pundit.puja.history.delete');
    Route::get('pundit/puja-history/{id}','PujaOrderController@pujaHistoryView')->name('pundit.puja.history.view');
    // pundit-change-email
    Route::post('pundit/check-duplicate-email','ProfileController@checkemail')->name('pundit.check.email');
    Route::post('pundit/change-email','ProfileController@changemail')->name('pundit.change.mail');
    Route::get('get-state/pundit','ProfileController@getstate')->name('pundit.get.state');

});
/* astrologer */
Route::group(['namespace' => 'Modules\Astrologer'], function() {
    Route::any('astrologer/dashboard', 'ProfileController@dashboard')->name('astrologer.dashboard');
    Route::get('astrologer/profile', 'ProfileController@profile')->name('astrologer.profile');
    Route::post('astrologer/profile-edit', 'ProfileController@profileEdit')->name('astrologer.profile.edit');
    Route::get('astrologer/availability', 'ProfileController@availability')->name('astrologer.availability');
    Route::post('astrologer/availability-save', 'ProfileController@availabilitySave')->name('astrologer.availability.save');
    Route::get('astrologer/education', 'ProfileController@educationList')->name('astrologer.education');
    Route::post('astrologer/education-save', 'ProfileController@educationAdd')->name('astrologer.education.save');
    Route::get('astrologer/education-edit/{id}', 'ProfileController@educationEdit')->name('astrologer.education.edit');
    Route::post('astrologer/education-update/{id}', 'ProfileController@educationUpdate')->name('astrologer.education.update');
    Route::get('astrologer/education-delete/{id}', 'ProfileController@educationDelete')->name('astrologer.education.delete');
    Route::get('astrologer/experience', 'ProfileController@experienceList')->name('astrologer.experience');
    Route::post('astrologer/experience-save', 'ProfileController@experienceAdd')->name('astrologer.experience.save');
    Route::get('astrologer/experience-edit/{id}', 'ProfileController@experienceEdit')->name('astrologer.experience.edit');
    Route::post('astrologer/experience-update/{id}', 'ProfileController@experienceUpdate')->name('astrologer.experience.update');
    Route::get('astrologer/experience-delete/{id}', 'ProfileController@experienceDelete')->name('astrologer.experience.delete');
    Route::get('astrologer/change-password', 'ProfileController@changePassword')->name('astrologer.change.password');
    Route::post('astrologer/change-password', 'ProfileController@changePasswordSave')->name('astrologer.change.password.save');
    Route::post('astrologer/change-mobile', 'ProfileController@mobileChange')->name('astrologer.change.mobile');
    Route::post('astrologer/check-otp', 'ProfileController@wrongOTPCheck')->name('astrologer.change.mobile.check.otp');
    Route::post('astrologer/change-mobile-submit', 'ProfileController@mobileChangeSubmit')->name('astrologer.change.mobile.submit');
	Route::any('astrologer/date-exclusion-list', 'ProfileController@dateExclusionList')->name('astrologer.date.exclusion.list');
	Route::get('astrologer/date-exclusion-delete/{id}', 'ProfileController@dateExclusionDelete')->name('astrologer.date.exclusion.delete');

    // cancel-call
    Route::any('astrologer/cancel-call-otp','CallBookingController@cancelOtp')->name('astrologer.cancel.call.otp');


    // temp-audio-mobile-number
    Route::post('astrologer/check-audio-mobile','ProfileController@checkAudioMobile')->name('astrologer.check.audio.mboile');
    Route::post('astrologer/change-audio-mobile','ProfileController@changeAudioMobile')->name('astrologer.change.audio.mboile');
    Route::post('astrologer/check-otp-audio-mobile', 'ProfileController@checkOtpAudioMobile')->name('astrologer.change.mobile.check.otp.aduio-mobile');
    Route::post('astrologer/change-audio-mobile-submit', 'ProfileController@changeAudioMobileSubmit')->name('astrologer.change.aduio.mobile.submit');
    // astrologer-call-history///////////////////////////////////////
    Route::get('astrologer/call-history','CallBookingController@callhistory')->name('astrologer.call.history');
    Route::post('astrologer/call-history','CallBookingController@callhistory')->name('astrologer.call.history.search');
    Route::get('astrologer/call-history-delete/{id}','CallBookingController@callhistory_del')->name('astrologer.call.history.del');
    Route::get('astrologer/call-history/{id}','CallBookingController@callBookingView')->name('astrologer.call.view');
    // astrologer-change-email
    Route::post('astrologer/check-duplicate-email','ProfileController@checkemail')->name('astrologer.check.email');
    Route::post('astrologer/change-email','ProfileController@changemail')->name('astrologer.change.mail');
    // get-states-sayan
    Route::get('get-state','ProfileController@getstate')->name('astrologer.get.state');
    // check-duplicate-education
    Route::get('check-duplicate-education','ProfileController@checkedu')->name('astrologer.check.education');
    Route::get('check-duplicate-experience','ProfileController@checkexp')->name('astrologer.check.experience');

    //Astro tips
    Route::get('astrologer/manage-astro-tips','ProfileController@manageAstroTips')->name('manage.astro.tips');
    Route::post('astrologer/add-astro-tips','ProfileController@manageAstroTips')->name('add.astro.tips');
    Route::get('astrologer/edit-astro-tips/{id}','ProfileController@manageAstroTips')->name('edit.astro.tips');
    Route::post('astrologer/update-astro-tips/{id}','ProfileController@manageAstroTips')->name('update.astro.tips');
    Route::get('astrologer/delete-astro-tips/{id}','ProfileController@deleteAstroTips')->name('delete.astro.tips');

    // astro-suggestion
    Route::get('astrologer/suggestion/{id}','ProfileController@suggestion')->name('astro.suggestion');
    Route::post('astrologer/sumit-suggestion','ProfileController@submitSuggestion')->name('astro.suggestion.submit');

});

Route::get('astrologer/change-email-account/verify/{id}/{vcode}', 'HomeController@verifyEmail')->name('astrologer.change.email.verify');
Route::get('pundit/change-email-account/verify/{id}/{vcode}', 'HomeController@verifyEmail')->name('pundit.change.email.verify');
Route::get('/change-email-account/verify/{id}/{vcode}', 'HomeController@verifyEmail')->name('customer.change.email.verify');

// term-condition
Route::get('terms-condition','HomeController@termsCondtion')->name('terms.condition');
Route::get('privacy-policy','HomeController@privacyPolicy')->name('privacy.policy');

Route::get('astrologer-search','Modules\AstrologerSearch\AstrologerSearchController@index')->name('astrologer.search.view');
Route::post('astrologer-search','Modules\AstrologerSearch\AstrologerSearchController@index')->name('astrologer.search');
Route::get('astrologer-search/{slug}', 'Modules\AstrologerSearch\AstrologerSearchController@astrologerPublicProfile')->name('astrologer.search.publicProfile');
Route::post('astrologer-search/{slug}/call-booking', 'Modules\Booking\CallBookingController@callBooking')->name('astrologer.call.booking');
Route::get('astrologer-booking/payment/{order_id}', 'Modules\Booking\CallBookingController@callBookingPaymentView')->name('astrologer.call.booking.payment');
Route::any('astrologer-booking/user-data/{order_id}', 'Modules\Booking\CallBookingController@callBookingUserInfo')->name('astrologer.booking.user.data');
//Temp customer name
Route::get('astrologer-booking/delete-temp-customer-table','Modules\Booking\CallBookingController@deleteTempTable')->name('astrologer.delete.data.temp-table');
Route::post('astrologer-booking/add-temp-customer','Modules\Booking\CallBookingController@addTempAdd')->name('user.astrologer.add.temp-names');
Route::get('astrologer-show-temp-customer','Modules\Booking\CallBookingController@showTempAdd')->name('user.astrologer.show.tempnames');
Route::get('astrologer-delete-temp-customer','Modules\Booking\CallBookingController@deleteTempAdd')->name('user.astrologer.delete.tempnames');
Route::post('astrologer-checkbox-insert-value','Modules\Booking\CallBookingController@checkBoxInsert')->name('user.astrologer.insert.checkbox');
Route::post('astrologer-checkbox-delete-value','Modules\Booking\CallBookingController@delCheckBox')->name('user.astrologer.delete.checkbox');
Route::get('astrologer-data-temp-customer','Modules\Booking\CallBookingController@checkTemp')->name('user.astrologer.check.temp.customer');
//Temp customer name
Route::post('astrologer-booking/pay-now/{order_id}', 'Modules\Booking\CallBookingController@callBookingPayment')->name('astrologer.call.booking.payment.now');
Route::get('astrologer-booking/payable-amount-schedule', 'Modules\AstrologerSearch\AstrologerSearchController@schedulePaymentAmount')->name('astrologer.booking.payable.amount');
// Route::post('puja-search/puja-booking', 'Modules\Booking\PujaBookingController@pujaBooking')->name('pundit.puja.booking');
// Route::get('puja-booking/payment/{order_id}', 'Modules\Booking\PujaBookingController@pujaBookingPaymentView')->name('pundit.puja.booking.payment');
Route::post('puja-booking/payment/{order_id}', 'Modules\Booking\PujaBookingController@pujaBookingPayment')->name('pundit.puja.booking.payment');
// Route::get('astrologer-details/{slug}', 'Modules\Booking\CallBookingController@astrologerPublicProfile')->name('astrologer.details.slug');
Route::post('customer/insert-order', 'Modules\Booking\CallBookingController@callOrder')->name('customer.insert.order');
Route::post('customer/order-status', 'Modules\Booking\CallBookingController@orderStatusCheck')->name('customer.order.status');

Route::post('online-puja-check', 'Modules\Booking\PujaBookingController@checkOnlinePuja')->name('pundit.puja.online.location.check');

Route::get('product-search', 'Modules\Search\searchProductController@index')->name('product.search');
Route::post('product-search', 'Modules\Search\searchProductController@index')->name('product.search.filter');
Route::get('product-search/{slug}', 'Modules\Search\searchProductController@productDetails')->name('product.search.details');

//Gemstones search
Route::get('gems-jwels', 'Modules\Gemstones\GemstoneController@index')->name('gemstone.search');
Route::post('gems-jwels', 'Modules\Gemstones\GemstoneController@index')->name('gemstone.search.filter');
Route::get('gems-jwels/{slug}', 'Modules\Gemstones\GemstoneController@gemstoneDetails')->name('gemstone.details');
Route::post('gemstone-details/fetch-gemstone-price-data', 'Modules\Gemstones\GemstoneController@fetchGemstonePriceData')->name('fetch.gemstone.price.data');

//Horoscope search
Route::any('horoscopes', 'Modules\Horoscope\HoroscopeController@horoscopeSearch')->name('horoscope.search');
Route::get('horoscope-details/{slug}', 'Modules\Horoscope\HoroscopeController@horoscopeDetails')->name('horoscope.details');

Route::get('horoscope-all-category','Modules\Horoscope\HoroscopeController@allCategory')->name('hororscope.all.category');
Route::get('horoscope-sub-category/{id}','Modules\Horoscope\HoroscopeController@subCategory')->name('hororscope.sub.category');

Route::get('hororscope-title/{id}','Modules\Horoscope\HoroscopeController@horoscopeTitle')->name('horoscope.title.get');

Route::any('hororscope-separate-search/{id}/{cat}','Modules\Horoscope\HoroscopeController@separateSearch')->name('horoscope.separate.search');

Route::get('hororscope-category-title/{id}','Modules\Horoscope\HoroscopeController@horoscopeTitleCategory')->name('horoscope.category.title.get');




// gemstone-category / title/ sub title
Route::get('gems-jwels/all-category/search','Modules\Gemstones\GemstoneController@gemCatView')->name('gemstone.search.category');

Route::any('gems-jwels/search-gemstone/{id}','Modules\Gemstones\GemstoneController@categorySearch')->name('gemstone.search.category-search');

Route::get('gems-jwels/title/search/{id}','Modules\Gemstones\GemstoneController@gemTitleView')->name('gemstone.search.title');
Route::get('gems-jwels/sub-title/search/{id}/{cat}','Modules\Gemstones\GemstoneController@gemSubTitleView')->name('gemstone.search.sub-title');

Route::any('gems-jwels/search-gemstone/{id}/{cat}','Modules\Gemstones\GemstoneController@gemSubTitleSearch')->name('gemstone.search.sub-title-search');

// puja-category / sub category/ title
Route::get('puja/all-categories/search','Modules\Search\SearchController@pujaAllCategory')->name('puja.search.category');
Route::get('puja/sub-categories/search/{slug}','Modules\Search\SearchController@pujaAllSubCategory')->name('puja.search.sub.category');
Route::get('puja/puja-names/search/{slug}','Modules\Search\SearchController@pujaAllNames')->name('puja.search.puja-name');
Route::any('puja/search-puja/{slug}/{id?}','Modules\Search\SearchController@pujaAllSearch')->name('puja.search.puja-search');

// Astrologer-country / State
Route::get('astrologer/all-countries/search','Modules\AstrologerSearch\AstrologerSearchController@allCountries')->name('astrologer.search.country');
Route::get('astrologer/all-states/search/{id}','Modules\AstrologerSearch\AstrologerSearchController@allStates')->name('astrologer.search.state');
Route::get('astrologer/all-expertise/search/{id}/{id1?}','Modules\AstrologerSearch\AstrologerSearchController@allExpertise')->name('astrologer.search.expertise');
Route::any('astrologer/search-all/{id}/{id1?}/{id2?}','Modules\AstrologerSearch\AstrologerSearchController@astrologerAllSearch')->name('astrologer.search.all');

Route::post('add-to-cart', 'Modules\Cart\CartController@addToCart')->name('product.add.to.cart');
Route::post('ajax-delete-cart', 'Modules\Cart\CartController@ajaxdeleteCart')->name('product.add.to.cart.delete-ajax');
Route::get('delete-cart/{id}', 'Modules\Cart\CartController@deletecart')->name('product.add.to.cart.delete');
Route::get('shopping-cart', 'Modules\Cart\CartController@viewCart')->name('product.shopping.cart');
Route::any('check-out', 'Modules\Cart\CartController@viewCheckout')->name('product.shopping.check.out');
Route::post('placed-order', 'Modules\Cart\CartController@placedOrder')->name('product.shopping.placed.order');
Route::post('placed-order-success', 'Modules\Cart\CartController@placedOrderSuccess')->name('product.shopping.placed.order.success');
Route::any('horoscope-order-now/{slug}', 'Modules\Horoscope\HoroscopeController@orderNow')->name('horoscope.order.now');

Route::get('/add-to-favorite/{id}', 'Modules\Favorite\FavoriteController@addFavorite')->name('add.to.favorite');
Route::get('/wishlist', 'Modules\Favorite\FavoriteController@favoriteList')->name('wishlist');

//Gemstone add to cart
Route::post('gemstone-add-to-cart', 'Modules\Cart\CartController@gemstoneAddToCart')->name('gemstone.add.to.cart');
Route::get('gemstone-more-info', 'Modules\Cart\CartController@gemstoneMoreInfo')->name('gemstone.more.info');
Route::get('gemstone-order-more-info', 'Modules\Cart\CartController@gemstoneOrderMoreInfo')->name('gemstone.order.more.info');
Route::post('gemstone-update-cart', 'Modules\Cart\CartController@gemstoneCartUpdate')->name('gemstone.update.cart');

// slot-showing
Route::get('check-slot-astrologer','Modules\AstrologerSearch\AstrologerSearchController@slotFetch')->name('astrologer.slot.check.fetch');
Route::get('check-slot-duration','Modules\AstrologerSearch\AstrologerSearchController@slotDuration')->name('astrologer.slot.duration.check');


// new-pooja-booking
Route::post('puja-booking','Modules\Booking\PujaBookingController@pujaBooking')->name('user.puja.booking');
Route::get('puja-booking/payment/{order_id}','Modules\Booking\PujaBookingController@pujaBookingPaymentView')->name('puja.booking.payment.view');

// new-puja-booking-process
Route::get('puja-booking/delete-temp-customer-table','Modules\Booking\PujaBookingController@deleteTempTable')->name('user.delete.data.temp-table');
Route::post('puja-booking/add-temp-customer','Modules\Booking\PujaBookingController@addTempAdd')->name('user.puja.add.temp-names');
Route::get('ajax-show-temp-customer','Modules\Booking\PujaBookingController@showTempAdd')->name('user.puja.show.tempnames');
Route::get('ajax-delete-temp-customer','Modules\Booking\PujaBookingController@deleteTempAdd')->name('user.puja.delete.tempnames');
Route::post('ajax-checkbox-insert-value','Modules\Booking\PujaBookingController@checkBoxInsert')->name('user.puja.insert.checkbox');
Route::post('ajax-checkbox-delete-value','Modules\Booking\PujaBookingController@delCheckBox')->name('user.puja.delete.checkbox');
Route::get('check-data-temp-customer','Modules\Booking\PujaBookingController@checkTemp')->name('user.puja.check.temp.customer');
Route::get('puja-booking/get-mantra-recitals','Modules\Booking\PujaBookingController@getRecitals')->name('user.puja.get-mantra-recitals');
Route::post('puja-booking/add-additional-mantra','Modules\Booking\PujaBookingController@addMantra')->name('user.puja.add.additional-mantra');
Route::get('puja-booking/listing-added-mantra','Modules\Booking\PujaBookingController@mantraList')->name('user.puja.added-mantra-list');
Route::get('puja-booking/delete-mantra-list','Modules\Booking\PujaBookingController@delMantraList')->name('user.puja.delete.mantra.list');

// product-category / sub category
Route::get('product-all-category','Modules\Search\searchProductController@productAllCategory')->name('product.all.categories');
Route::get('product-all-sub-category/{id}','Modules\Search\searchProductController@productSubcategory')->name('product.sub.categories');
Route::any('product/search-product/{id}','Modules\Search\searchProductController@productSeparateSearch')->name('product.separate.search');




// horoscope-order
Route::any('/my-horoscope-order','Modules\Customer\HoroscopeOrder@index')->name('user.manage.horoscope.order');
Route::any('/my-horoscope-order/details/{id}','Modules\Customer\HoroscopeOrder@details')->name('user.manage.horoscope.order.details');



// video-call
Route::get('video-call', 'Modules\VideoCall\VideoCallController@index')->name('my.video');
Route::get('get-twilio-token', 'Modules\VideoCall\VideoCallController@getTwilioToken')->name('get.twilio.token');
Route::post('video-start', 'Modules\VideoCall\VideoCallController@startCall')->name('video.call.start');
Route::post('update-call-time', 'Modules\VideoCall\VideoCallController@updateCallTime')->name('update.call.time');
Route::get('redirect-users/{id?}','Modules\VideoCall\VideoCallController@redirectUser')->name('user.video.call.redirect');
Route::get('video-call-complete/{id?}', 'Modules\VideoCall\VideoCallController@callComplete')->name('my.video.call.complete');
Route::get('video-call-update/update-start-time', 'Modules\VideoCall\VideoCallController@startTimeUpdate')->name('my.video.call.start.time.update.call');

Route::get('video-call/get-details','Modules\VideoCall\VideoCallController@get_details')->name('my.video.get.details');
// aquila-data-bank


// astro-wiki
Route::any('aquila-wiki','HomeController@wiki')->name('aquila.wiki');
Route::get('aquila-wiki-details/{slug}','HomeController@wikidetails')->name('aquila.wiki.details');
// Route::get('video-page','Modules\VideoCall\VideoCallController@videopage')->name('video.cll.page');
// term-condition

});
Route::post('customer/check-astrologer-available', 'Modules\Booking\CallBookingController@checkAstrologerAvailable')->name('customer.check.astrologer.available');
Route::view('/call', 'call');
Route::post('/call-number', 'VoiceController@initiateCall')->name('initiate_call');
Route::post('call-status', 'HomeController@twilioCall');
Route::post('update-call-status', 'HomeController@updateCall')->name('update.call.status.complete');

Route::get('call-redirect-user', 'HomeController@redirect_user')->name('user.rediect.call');

Route::get("/page", function(){
   return view("email.notify_customer");
});
Route::get('test-pusher-chat', 'HomeController@testPusherMessage');
Route::get("/test-show-chat", function(){
   return view("pusher-test");
});
Route::get('chat-with-astrologer/{id}', 'Modules\Chat\ChatController@showChat')->name('chat.with.astrologer');
Route::post('send-chat-message', 'Modules\Chat\ChatController@sendMessage')->name('send.chat.message');
Route::post('close-chat-message', 'Modules\Chat\ChatController@closeChat')->name('close.chat.message');
Route::post('typing-ajax', 'Modules\Chat\ChatController@typingAjax')->name('typing.ajax');
Route::post('chat-sound-off', 'Modules\Chat\ChatController@chatSoundOff')->name('chat.sound.off');
Route::post('deduct-wallet', 'Modules\Chat\ChatController@balanceDeductPerminute')->name('deduct.wallet');
Route::any('aquila-data-bank','Modules\Horoscope\HoroscopeController@databank')->name('aquila.data.bank');
Route::get('aquila-data-bank/details/{id}','Modules\Horoscope\HoroscopeController@databankDetails')->name('aquila.data.bank.details');
Route::any('aquila-data-bank/download/{file}','Modules\Horoscope\HoroscopeController@downlaod')->name('aquila.data.bank.download');

// Route::get('video-call-show','HomeController@video')->name('user.video.call.show');

//For firebase token update
Route::get('refresh-dashboard', 'HomeController@changeDash')->name('refresh.dashboard');
Route::get('test-firebase', 'HomeController@testFireBase')->name('test.firebase');

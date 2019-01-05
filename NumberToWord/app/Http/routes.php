 <?php
Route::get('/next-update', 'StoreController@updateCouponNextStore');
Route::get('/test', 'TestController@index');
//update from lib
Route::get('/auto-update-from-lib/{alias}', 'UpdateFromLibController@index');
Route::any('/next-update-from-lib/', 'UpdateFromLibController@updateCouponNextStore');
//Home page
Route::get('/', 'ConvertNumberIndexController@index');
Route::get('/convertNumber', 'ConvertNumberIndexController@convertNumber');
Route::get('/convertDigits', 'ConvertNumberIndexController@convertDigits');
Route::post('/convertCurrency', 'ConvertNumberIndexController@handleCurrency');
Route::get('/googleSpeech','ConvertNumberIndexController@googleSpeech');
Route::get('/home', 'HomeController@index');
Route::get('/link-exchange', 'LinkExchangeController@index');

//Search
Route::get('/search/', 'WelcomeController@search');
Route::get('/searchFromApi/', 'WelcomeController@searchFromApi');

// Sitemap
Route::get('/sitemap_stores_{page}.xml', 'SitemapController@getStoreSitemap');
Route::get('/{param}.xml', 'SitemapController@index');

// Scholarship
Route::get('/scholarship', 'StaticPageController@scholarship');

// Event
Route::get('/event/{alias}', 'EventController@index');
Route::get('/event/{alias}/showMore', 'EventController@showMore');

//Category Page
Route::get('/categories/all', 'CategoriesController@all');
Route::get('/category/showMoreCoupons', 'CategoriesController@showMoreCoupons');
Route::get('/category/{alias}', 'CategoriesController@detail');


//User action
/*Route::get('/login', 'Auth\AuthController@getLogin');
Route::post('/login', 'Auth\AuthController@postLogin');
Route::get('/register', 'Auth\AuthController@getRegister');
Route::post('/register', 'UserController@register');
Route::get('/user/active-account/', 'UserController@activeAcc');*/
Route::post('/user/subscribeHome', 'UserController@subscribeHome');
Route::post('/user/subscribeStore', 'UserController@subscribeStore');
Route::post('/user/subscribeCategory', 'UserController@subscribeCategory');
Route::get('/user/emailExists', 'UserController@emailExists');
/*Route::get('/user/forgot-password', 'UserController@forgotPass');
Route::post('/user/forgot-password', 'UserController@forgotPass');
Route::get('/user/reset-password/', 'UserController@resetPass');
Route::post('/user/reset-password/', 'UserController@resetPass');*/
Route::get('/user/saveAndFavourite', 'UserController@saveAndFavourite');
Route::get('/user/likeAction', 'UserController@likeAction');
Route::post('/user/sendEmail', 'UserController@sendEmail');
Route::post('/user/saveLocalStorage', 'UserController@sendLocalStorage');
Route::get('/user/saveLocalStorageGet', 'UserController@sendLocalStorage');
Route::get('/faq', 'FAQController@index');
//Login social
/*Route::get('/login/facebook', 'Auth\AuthController@facebook_redirect');
Route::get('/auth/facebook', 'Auth\AuthController@facebook');
Route::get('/login/google', 'Auth\AuthController@google_redirect');
Route::get('/auth/google', 'Auth\AuthController@google');
Route::get('/login/twitter', 'Auth\AuthController@twitter_redirect');
Route::post('/login/twitter-confirm', 'Auth\AuthController@twitterConfirmEmail');
Route::get('/auth/twitter', 'Auth\AuthController@twitter');
Route::get('/login/github', 'Auth\AuthController@github_redirect');
Route::get('/auth/github', 'Auth\AuthController@github');*/

Route::get('/comment/getComment', 'CommentController@getComment');
Route::get('/comment/getCommentDeal', 'CommentController@getCommentDeal');
Route::post('/comment/postComment', 'CommentController@postComment');

Route::get('/go/getCode/{code}', 'GoController@detail');
Route::get('/go/{code}', 'GoController@index');
Route::get('/go/click-get-code', 'GoController@logGetCode');

Route::get('/store/getStores', 'StoreController@getStores');
Route::get('/store/showMoreCoupons', 'StoreController@showMoreCoupons');
Route::post('/store/search', 'StoreController@searchStores');
Route::post('/coupon/submitCoupon', 'CouponController@submitCoupon');
Route::get('/session/filterCoupon', 'StoreController@filterCoupon');
Route::get('/request-coupon', 'StoreController@requestCoupon');

/* Get coupon from dontpayfull */
Route::get('/store/updateCouponDPF', 'StoreController@updateCouponDPF');
Route::post('/store/updateCoupon/getCode', 'StoreController@getCodeFromDPF');
/* Get coupon from dealspotr */
Route::get('/store/updateCouponDealSpot', 'StoreController@updateCouponDealSpot');
Route::post('/store/updateCoupon/addDealspotr', 'StoreController@addDealspotr');
/* Get coupon Couponokay */
Route::get('/store/UpdateCouponokay', 'StoreController@UpdateCouponokay');
/* Get coupon coupert */
Route::get('/store/updateCoupert', 'StoreController@UpdateCouponCoupert');
Route::post('/store/updateCoupon/addCoupert', 'StoreController@addCoupert');
/* Get coupon Couponasion */
Route::get('/store/updateCouponasion', 'StoreController@UpdateCouponCouponasion');
Route::post('/store/updateCoupon/addCouponasion', 'StoreController@addCouponasion');
/* Get coupon CouponShock */
Route::get('/store/updateCouponsherpa', 'StoreController@UpdateCouponsherpa');
/* Get coupon GoodSearch */
Route::get('/store/updateCouponGoodSearch', 'StoreController@updateCouponGoodSearch');
/* Get coupon Promotioncode */
Route::get('/store/updatePromotioncode', 'StoreController@updatePromotioncode');
/* Get coupon Dealoupons */
Route::get('/store/updateDealoupons', 'StoreController@updateDealoupons');
/* Get coupon Bradsdeals */
Route::get('/store/updateBradsdeals', 'StoreController@updateBradsdeals');
/* Get coupon Savevy */
Route::get('/store/updateSavevy', 'StoreController@updateSavevy');
/* Get coupon Dealhack */
Route::get('/store/updateDealhack', 'StoreController@updateDealhack');
/* Get coupon CouponForLess */
Route::get('/store/updateCouponforless', 'StoreController@updateCouponforless');
/* Get coupon 360couponcodes */
Route::get('/store/update360couponcodes', 'StoreController@update360couponcodes');
/* Get coupon Couponology */
Route::get('/store/updateCouponology', 'StoreController@updateCouponology');
/* Get coupon Slickdeals */
Route::get('/store/updateSlickdeals', 'StoreController@updateSlickdeals');
/* Get coupon Anycodes */
Route::get('/store/updateCouponlawn', 'StoreController@updateCouponlawn');
/* Get coupon Getcouponcodes */
Route::get('/store/updateGetcouponcodes', 'StoreController@updateGetcouponcodes');
/* Get coupon Coupontwo.com */
Route::get('/store/updateCoupontwo', 'StoreController@updateCoupontwo');
/* Get coupon savedoubler.com */
Route::get('/store/updateSavedoubler', 'StoreController@updateSavedoubler');
/* Get coupon Couponsgood.com */
Route::get('/store/updateCouponsgood', 'StoreController@updateCouponsgood');
/* Get coupon Copypromocode */
Route::get('/store/updateCopypromocode', 'StoreController@updateCopypromocode');

Route::get('/store/testAllowAjax', 'StoreController@testAllowAjax');
/* auto pull coupon in config */
Route::get('/pull-coupon/{alias}', 'AutoUpdateController@index');
Route::get('/auto-get-pull', 'AutoUpdateController@updateDomain');
Route::post('/auto-insert-db', 'AutoUpdateController@addInsert');
Route::get('/next-update-pull-coupon', 'AutoUpdateController@updateCouponNextStore');

Route::get('/top-20-'.config('config.coupon'), 'CouponController@top20Coupon');
Route::get('/free-'.config('config.shipping'), 'CouponController@top20FreeDelivery');
Route::get('/promotion-code', 'PromotionCodeController@index');

//Deal Page
Route::get('/deals/all', 'DealController@index');
Route::get('/deal/showMore', 'DealController@showMore');
Route::get('/deal/{alias}', 'DealController@detail');

Route::get('/contact-us', 'ContactUsController@index');
Route::post('/sendContact', 'ContactUsController@sendContact');
Route::get('/advertising', 'AdvertisingController@index');

Route::controllers([
    'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController'
]);
/*$router->group(['middleware' => 'auth'], function() {
//Profile
    Route::get('/profile/reference', 'Profile\HomeController@reference');
    Route::get('/profile/edit', 'Profile\HomeController@edit');
    Route::post('/profile/edit', 'Profile\HomeController@edit');
    Route::post('/profile/upload-avatar', 'Profile\HomeController@uploadAvatar');
    Route::post('/profile/preference/changeEmail', 'Profile\PreferenceController@changeEmail');
    Route::post('/profile/preference/changePassword', 'Profile\PreferenceController@changePassword');
    Route::post('/preference/saveAlert', 'Profile\PreferenceController@saveAlert');
    Route::resource('profile/findStoreNotInFavourite', 'Profile\FavouriteController@findStoreNotInFavourite');
    Route::resource('profile/preference', 'Profile\PreferenceController');
    Route::resource('profile/community', 'Profile\CommunityController');
    Route::get('/profile/showMoreFavoriteStores', 'Profile\FavouriteController@showMore');
    Route::get('/profile/showMoreSavedCoupons', 'Profile\SaveVoucherController@showMore');
    Route::resource('profile/cash-back/history', 'Profile\CashBackController@history');
    Route::resource('profile/cash-back', 'Profile\CashBackController@index');
    Route::get('profile/subscribe', 'Profile\SubscribeController@index');
    Route::post('profile/subscribe', 'Profile\SubscribeController@update');
    Route::resource('profile/cash-back/change-paypal-email', 'Profile\CashBackController@changePaypalEmail');
    Route::resource('profile/cash-back/withdraw', 'Profile\CashBackController@withdraw');
});*/
Route::get('/profile/saved' . config('config.Coupon') . 's', 'Profile\SaveVoucherController@index');
Route::get('/profile/favouriteStores', 'Profile\FavouriteController@index');
Route::get('profile/getDataFromBrowser', 'Profile\FavouriteController@getDataFromBrowser');
Route::get('/profile', 'Profile\HomeController@index');

//Static Page
Route::get('/using-a-'.config('config.coupon'), 'StaticPageController@usingCoupon');
Route::get('/submitting-a-'.config('config.coupon'), 'StaticPageController@submittingCoupon');
Route::get('/managing-my-account', 'StaticPageController@managingAccount');
Route::get('/merchant-help', 'StaticPageController@merchantHelp');
Route::get('/AboutUs', 'StaticPageController@aboutUs');
Route::get('/Terms', 'StaticPageController@termsPage');
Route::get('/Privacy-Policy', 'StaticPageController@privacyPolicy');
Route::get('/DMCA-page', 'StaticPageController@dmca');

Route::get('/CustomerSupport', 'StaticPageController@customerSupport');
Route::get('/Advertise', 'StaticPageController@advertise');
Route::get('/Media', 'StaticPageController@media');
Route::get('/Press', 'StaticPageController@press');
Route::get('/Investors', 'StaticPageController@investors');

//Cash Back Stores Page
Route::get('/cash-back-stores', 'CashBackStoresController@index');
Route::get('/cash-back-stores/showMoreStores', 'CashBackStoresController@showMoreStores');
Route::get('/cash-back-stores/filterStores', 'CashBackStoresController@filterStores');

//Rss
Route::get('/feed/stores', 'FeedController@stores');
Route::get('/feed/coupons', 'FeedController@coupons');

//Store Detail
Route::get('/{alias}', 'StoreController@index');
Route::get('/{alias}/coupon-detail/{couponGo}', 'StoreController@index');
Route::get('/{alias}/deal-detail/{dealGo}', 'StoreController@index');
Route::get('/coupon-detail/{couponGo}/{couponTitle}/{alias}', 'StoreController@withSlugTitle');
// Shared
Route::get('shared/store', 'SharedController@store');
Route::get('shared/update', 'SharedController@update');
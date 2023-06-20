<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\AccessTokenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/login', function () {
    echo 'some thing went wrong';
});


Route::group(['middleware' => ['api','auth:api']], function ($router) {
    Route::post('login' ,'App\Http\Controllers\API\AuthController@login')->withoutMiddleware('auth:api');
    Route::post('register' ,'App\Http\Controllers\API\AuthController@register')->withoutMiddleware('auth:api');
    Route::post('logout', 'App\Http\Controllers\API\AuthController@logout');
    Route::get('allusers', 'App\Http\Controllers\API\AuthController@allusers');
    Route::post('refresh', 'App\Http\Controllers\API\AuthController@refresh');
    Route::get('userProfile', 'App\Http\Controllers\API\AuthController@userProfile');
    Route::put('update_user', 'App\Http\Controllers\API\AuthController@update');
    Route::post('delete', 'App\Http\Controllers\API\AuthController@destroy');


    Route::group(['middleware' => ['api'], 'prefix' => 'team'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\TeamController@index');
        Route::post('save', '\App\Http\Controllers\Api\TeamController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\TeamController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\TeamController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\TeamController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'magazine'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\MagazineController@index');
        Route::post('save', '\App\Http\Controllers\Api\MagazineController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\MagazineController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\MagazineController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\MagazineController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'faq'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\FaqController@index');
        Route::post('save', '\App\Http\Controllers\Api\FaqController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\FaqController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\FaqController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\FaqController@destroy');
    });
    Route::group(['middleware' => ['api'], 'prefix' => 'performance'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\PerformanceController@index');
        Route::post('save', '\App\Http\Controllers\Api\PerformanceController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\PerformanceController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\PerformanceController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\PerformanceController@destroy');
    });
    Route::group(['middleware' => ['api'], 'prefix' => 'advertisement'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\AdvertisementController@index');
        Route::post('save', '\App\Http\Controllers\Api\AdvertisementController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\AdvertisementController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\AdvertisementController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\AdvertisementController@destroy');
    });
    Route::group(['middleware' => ['api'], 'prefix' => 'live'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LiveController@index');
        Route::post('save', '\App\Http\Controllers\Api\LiveController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LiveController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LiveController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LiveController@destroy');
    });
    Route::group(['middleware' => ['api'], 'prefix' => 'notification'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\NotificationController@index');
        Route::post('save', '\App\Http\Controllers\Api\NotificationController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\NotificationController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\NotificationController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\NotificationController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'subscription'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\SubscriptionController@index');
        Route::post('save', '\App\Http\Controllers\Api\SubscriptionController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\SubscriptionController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\SubscriptionController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\SubscriptionController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'topnotification'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\TopNotificationController@index');
        Route::post('save', '\App\Http\Controllers\Api\TopNotificationController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\TopNotificationController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\TopNotificationController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\TopNotificationController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'recentachievement'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\RecentAchievementController@index');
        Route::post('save', '\App\Http\Controllers\Api\RecentAchievementController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\RecentAchievementController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\RecentAchievementController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\RecentAchievementController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'feature'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\FeatureController@index');
        Route::post('save', '\App\Http\Controllers\Api\FeatureController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\FeatureController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\FeatureController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\FeatureController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'FollowUpPages'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\FollowUpPagesController@index');
        Route::post('save', '\App\Http\Controllers\Api\FollowUpPagesController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\FollowUpPagesController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\FollowUpPagesController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\FollowUpPagesController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'training_video'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\TrainningVideoController@index');
        Route::post('save', '\App\Http\Controllers\Api\TrainningVideoController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\TrainningVideoController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\TrainningVideoController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\TrainningVideoController@destroy');
    });


    Route::group(['middleware' => ['api'], 'prefix' => 'livefacebook'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LiveFaceBookController@index');
        Route::post('save', '\App\Http\Controllers\Api\LiveFaceBookController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LiveFaceBookController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LiveFaceBookController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LiveFaceBookController@destroy');
    });


    Route::group(['middleware' => ['api'], 'prefix' => 'livetwitter'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LiveTwitterController@index');
        Route::post('save', '\App\Http\Controllers\Api\LiveTwitterController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LiveTwitterController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LiveTwitterController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LiveTwitterController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'liveyoutube'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LiveYoutubeController@index');
        Route::post('save', '\App\Http\Controllers\Api\LiveYoutubeController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LiveYoutubeController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LiveYoutubeController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LiveYoutubeController@destroy');
    });

    Route::group(['middleware' => ['api'], 'prefix' => 'liveinstagram'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LiveInstagramController@index');
        Route::post('save', '\App\Http\Controllers\Api\LiveInstagramController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LiveInstagramController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LiveInstagramController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LiveInstagramController@destroy');
    });


    Route::group(['middleware' => ['api'], 'prefix' => 'livelinkedin'], function ($router) {
        Route::get('show_all', '\App\Http\Controllers\Api\LivelinkedinController@index');
        Route::post('save', '\App\Http\Controllers\Api\LivelinkedinController@store');
        Route::post('show/{id}', '\App\Http\Controllers\Api\LivelinkedinController@show');
        Route::post('update/{id}', '\App\Http\Controllers\Api\LivelinkedinController@update');
        Route::post('delete/{id}', '\App\Http\Controllers\Api\LivelinkedinController@destroy');
    });

    Route::post('password/email', [\App\Http\Controllers\Api\ForgotPasswordController::class,'forgot'])->withoutMiddleware('auth:api');
    Route::post('password/reset', [\App\Http\Controllers\Api\ForgotPasswordController::class,'reset'])->withoutMiddleware('auth:api');

// Route::post('register', 'RegistrationController@register');
// Route::get('email/verify/{id}', 'VerificationController@verify')->name('verification.verify');
// Route::get('email/resend', \App\Http\Controllers\Api\VerificationController,'resend')->name('verification.resend');




});


<?php

use Illuminate\Support\Facades\Route;


Route::group(['namespace' => 'Auth'], function () {

    Route::post('/register/step/{step}', ['as' => 'register', 'uses' => 'RegisterController@stepRegister']);
	Route::get('/login_form', ['uses' => 'LoginController@loginForm']);
    Route::post('/login', ['as' => 'login', 'uses' => 'LoginController@login']);
    Route::post('/social_login', ['as' => 'login', 'uses' => 'LoginController@social_login']);
	


    Route::post('/forget-password', ['as' => 'forgot', 'uses' => 'ForgotPasswordController@sendEmail']);
    Route::post('/reset-password/{token}', ['as' => 'updatePassword', 'uses' => 'ResetPasswordController@updatePassword']);
    Route::post('/verification', ['as' => 'verification', 'uses' => 'VerificationController@confirmCode']);
    Route::get('/google', ['as' => 'google', 'uses' => 'SocialiteController@redirectToGoogle']);
    Route::get('/facebook', ['as' => 'google', 'uses' => 'SocialiteController@redirectToFacebook']);
    Route::post('/google/callback', ['as' => 'google_callback', 'uses' => 'SocialiteController@handleGoogleCallback']);
    Route::post('/facebook/callback', ['as' => 'facebook_callback', 'uses' => 'SocialiteController@handleFacebookCallback']);

   // Route::get('/reff/{code}', 'ReferralController@referral');

});

Route::post('/logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout', 'middleware' => ['api.auth']]);



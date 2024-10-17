<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\MediaController;

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
Route::group(['prefix' => 'my_api' , 'namespace' => 'Api\Panel' , 'middleware' => 'signed' , 'as' => 'my_api.web.'] , function () {
    Route::get('checkout/{user}' , 'CartController@webCheckoutRender')->name('checkout');
    Route::get('/charge/{user}' , 'PaymentsController@webChargeRender')->name('charge');
    Route::get('/subscribe/{user}/{subscribe}' , 'SubscribesController@webPayRender')->name('subscribe');
    Route::get('/registration_packages/{user}/{package}' , 'RegistrationPackagesController@webPayRender')->name('registration_packages');
});

Route::get('/media/{path}', [MediaController::class, 'show'])->where('path', '.*')->middleware('web.auth');

Route::group(['prefix' => 'svn'], function (){
	Route::get('/', 'Web\GitController@runGitCommands');
});

Route::group(['prefix' => 'api_sessions'] , function () {
    Route::get('/big_blue_button' , ['uses' => 'Api\Panel\SessionsController@BigBlueButton'])->name('big_blue_button');
    Route::get('/agora' , ['uses' => 'Api\Panel\SessionsController@agora'])->name('agora');

});

Route::get('/mobile-app' , 'Web\MobileAppController@index')->middleware(['share'])->name('mobileAppRoute');
Route::get('/maintenance' , 'Web\MaintenanceController@index')->middleware(['share'])->name('maintenanceRoute');


	
Route::post('stripe/webhook',[WebhookController::class, 'handleWebhook']);

/* Emergency Database Update */
Route::get('/emergencyDatabaseUpdate' , function () {
    \Illuminate\Support\Facades\Artisan::call('migrate');
    $msg1 = \Illuminate\Support\Facades\Artisan::output();

    \Illuminate\Support\Facades\Artisan::call('db:seed --class=SectionsTableSeeder');
    $msg2 = \Illuminate\Support\Facades\Artisan::output();

    \Illuminate\Support\Facades\Artisan::call('clear:all');

    return response()->json(['migrations' => $msg1 , 'sections' => $msg2 ,]);
});

Route::group(['namespace' => 'Auth' , 'middleware' => ['check_mobile_app' , 'share' , 'check_maintenance']] , function () {
    Route::get('/login' , 'LoginController@showLoginForm');
    Route::post('/login' , 'LoginController@login');
    Route::post('/login_emoji' , 'LoginController@login_emoji');
    Route::post('/login_pin' , 'LoginController@login_pin');
    Route::get('/logout' , 'LoginController@logout');
    Route::get('/register' , 'RegisterController@showRegistrationForm');
    Route::post('/register' , 'RegisterController@register');
    Route::get('/verification' , 'VerificationController@index');
    Route::post('/verification' , 'VerificationController@confirmCode');
    Route::get('/verification/resend' , 'VerificationController@resendCode');
    Route::get('/forget-password' , 'ForgotPasswordController@showLinkRequestForm');
    Route::post('/forget-password' , 'ForgotPasswordController@forgot');
    Route::get('reset-password/{token}' , 'ResetPasswordController@showResetForm');
    Route::post('/reset-password' , 'ResetPasswordController@updatePassword');
    Route::get('/google' , 'SocialiteController@redirectToGoogle');
    Route::get('/google/callback' , 'SocialiteController@handleGoogleCallback');
    Route::get('/facebook/redirect' , 'SocialiteController@redirectToFacebook');
    Route::get('/facebook/callback' , 'SocialiteController@handleFacebookCallback');
    Route::get('/reff/{code}' , 'ReferralController@referral');
    Route::post('/signup-submit' , 'RegisterController@signupSubmit');
});

Route::group(['namespace' => 'Web' , 'middleware' => ['check_mobile_app' , 'impersonate' , 'share' , 'check_maintenance']] , function () {
    Route::get('/stripe' , function () {
        return view('web.default.cart.channels.stripe');
    });

    Route::fallback(function () {
        return view("errors.404" , ['pageTitle' => trans('public.error_404_page_title')]);
    });

    // set Locale
    Route::post('/locale' , 'LocaleController@setLocale')->name('appLocaleRoute');

    // set Locale
    Route::post('/set-currency' , 'SetCurrencyController@setCurrency');

    Route::get('/' , 'HomeController@index')->name('homepage');

    Route::get('/getDefaultAvatar' , 'DefaultAvatarController@make');

    Route::post('/question/validation' , 'QuestionsBankController@validation');
    //Route::post('/question/test_complete', 'QuestionsBankController@test_complete');


    Route::post('/question_attempt/validation' , 'QuestionsAttemptController@validation');
    Route::post('/question_attempt/test_complete' , 'QuestionsAttemptController@test_complete');
    Route::post('/question_attempt/flag_question' , 'QuestionsAttemptController@flag_question');
    Route::post('/question_attempt/jump_question' , 'QuestionsAttemptController@jump_question');
    Route::post('/question_attempt/mark_as_active' , 'QuestionsAttemptController@mark_as_active');
	Route::post('/question_attempt/update_time' , 'QuestionsAttemptController@update_time');
	Route::post('/question_attempt/check_new_activity' , 'QuestionsAttemptController@check_new_activity');
    Route::post('/question_attempt/jump_review' , 'QuestionsAttemptController@jump_review');
    Route::post('/question_attempt/timestables_submit' , 'QuestionsAttemptController@timestables_submit');


    $years = ['year-1', 'year-2', 'year-3', 'year-4', 'year-5', 'year-6', 'year-7'];

	//https://rurera.com/spelling/year-6/words-with-a-first-letters/test
	
	//http://192.168.1.4:9000/year-6/words-with-a-first-letters/spelling/exercise
	
	
	

    if( !empty( $years)){
        foreach( $years as $year_slug){
            Route::group(['prefix' => $year_slug] , function () {

                    /*
                     * Spelling Routes Starts
                     */
                       Route::get('/spelling' , 'SpellsController@index');
                       Route::get('/{quiz_slug}/spelling-list' , 'SpellsController@words_list')->middleware('inject.css:assets/default/css/panel-pages/wordlist.css');
                       Route::get('/{quiz_slug}/spelling/exercise/{quiz_level}' , 'SpellsController@start');
                       Route::get('/{quiz_slug}/spelling/exercise' , 'SpellsController@start');
					   
					   Route::post('/{quiz_slug}/{test_type}/exercise' , 'SpellsController@start');
					   Route::get('/{quiz_slug}/{test_type}/exercise' , 'SpellsController@start');
					   
					   
					   
                       //Route::get('/words_list' , 'SpellsController@words_list');
                       //Route::get('/{quiz_year}/{quiz_slug}' , 'SpellsController@start');
                    /*
                     * Spelling Routes Ends
                     */

                    Route::get('/{slug}' , 'WebinarController@course')->middleware('inject.css:assets/default/css/panel-pages/learn.css');
                    Route::get('/{slug}/learning-journey' , 'LearningJourneyController@index');
                    Route::get('/{slug}/file/{file_id}/download' , 'WebinarController@downloadFile');
                    Route::get('/{slug}/file/{file_id}/showHtml' , 'WebinarController@showHtmlFile');
                    Route::get('/{slug}/lessons/{lesson_id}/read' , 'WebinarController@getLesson');
                    Route::post('/getFilePath' , 'WebinarController@getFilePath');
                    Route::get('/{slug}/file/{file_id}/play' , 'WebinarController@playFile');
                    Route::get('/{slug}/free' , 'WebinarController@free');
                    Route::get('/{slug}/points/apply' , 'WebinarController@buyWithPoint');
                    Route::post('/{id}/report' , 'WebinarController@reportWebinar');
                    Route::post('/{id}/learningStatus' , 'WebinarController@learningStatus');



                    Route::group(['middleware' => 'web.auth'] , function () {
                        Route::get('/{slug}/installments' , 'WebinarController@getInstallmentsByCourse');

                        Route::post('/learning/itemInfo' , 'LearningPageController@getItemInfo');
                        Route::get('/learning/{slug}' , 'LearningPageController@index');
                        Route::get('/learning/{slug}/noticeboards' , 'LearningPageController@noticeboards');
                        Route::get('/assignment/{assignmentId}/download/{id}/attach' , 'LearningPageController@downloadAssignment');
                        Route::post('/assignment/{assignmentId}/history/{historyId}/message' , 'AssignmentHistoryController@storeMessage');
                        Route::post('/assignment/{assignmentId}/history/{historyId}/setGrade' , 'AssignmentHistoryController@setGrade');
                        Route::get('/assignment/{assignmentId}/history/{historyId}/message/{messageId}/downloadAttach' , 'AssignmentHistoryController@downloadAttach');

                        Route::group(['prefix' => '/learning/{slug}/forum'] , function () { // LearningPageForumTrait
                            Route::get('/' , 'LearningPageController@forum');
                            Route::post('/store' , 'LearningPageController@forumStoreNewQuestion');
                            Route::get('/{forumId}/edit' , 'LearningPageController@getForumForEdit');
                            Route::post('/{forumId}/update' , 'LearningPageController@updateForum');
                            Route::post('/{forumId}/pinToggle' , 'LearningPageController@forumPinToggle');
                            Route::get('/{forumId}/downloadAttach' , 'LearningPageController@forumDownloadAttach');

                            Route::group(['prefix' => '/{forumId}/answers'] , function () {
                                Route::get('/' , 'LearningPageController@getForumAnswers');
                                Route::post('/' , 'LearningPageController@storeForumAnswers');
                                Route::get('/{answerId}/edit' , 'LearningPageController@answerEdit');
                                Route::post('/{answerId}/update' , 'LearningPageController@answerUpdate');
                                Route::post('/{answerId}/{togglePinOrResolved}' , 'LearningPageController@answerTogglePinOrResolved');
                            });
                        });
                        Route::post('/direct-payment' , 'WebinarController@directPayment');
                    });
					Route::get('/{slug}/{sub_chapter_slug}/{journey_item_id}/journey' , 'LearningJourneyController@start');
                    Route::get('/{slug}/{sub_chapter_slug}' , 'WebinarController@start');
                });
        }
    }
	
	Route::group(['prefix' => 'learning-journey'], function (){
		Route::get('/{year_slug}/{chapter_slug}/{sub_chapter_slug}/{journey_item_id}' , 'LearningJourneyController@start');
		Route::post('/{year_slug}/{quiz_slug}/{test_type}', 'SpellsController@start');
		Route::get('/{year_slug}/{quiz_slug}/test', 'SpellsController@start');
		Route::post('/{year_slug}/{quiz_slug}/test', 'SpellsController@start');
	});
	
	
	Route::group(['prefix' => 'spelling'], function (){
		Route::get('/{year_slug}/{quiz_slug}/{test_type}', 'SpellsController@start');
		Route::post('/{year_slug}/{quiz_slug}/{test_type}', 'SpellsController@start');
		Route::get('/{year_slug}/{quiz_slug}/test', 'SpellsController@start');
		Route::post('/{year_slug}/{quiz_slug}/test', 'SpellsController@start');
	});


    Route::group(['prefix' => 'course'] , function () {
        Route::get('/{slug}' , 'WebinarController@course');
        Route::get('/{slug}/file/{file_id}/download' , 'WebinarController@downloadFile');
        Route::get('/{slug}/file/{file_id}/showHtml' , 'WebinarController@showHtmlFile');
        Route::get('/{slug}/lessons/{lesson_id}/read' , 'WebinarController@getLesson');
        Route::post('/getFilePath' , 'WebinarController@getFilePath');
        Route::get('/{slug}/file/{file_id}/play' , 'WebinarController@playFile');
        Route::get('/{slug}/free' , 'WebinarController@free');
        Route::get('/{slug}/points/apply' , 'WebinarController@buyWithPoint');
        Route::post('/{id}/report' , 'WebinarController@reportWebinar');
        Route::post('/{id}/learningStatus' , 'WebinarController@learningStatus');

        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/{slug}/installments' , 'WebinarController@getInstallmentsByCourse');

            Route::post('/learning/itemInfo' , 'LearningPageController@getItemInfo');
            Route::get('/learning/{slug}' , 'LearningPageController@index');
            Route::get('/learning/{slug}/noticeboards' , 'LearningPageController@noticeboards');
            Route::get('/assignment/{assignmentId}/download/{id}/attach' , 'LearningPageController@downloadAssignment');
            Route::post('/assignment/{assignmentId}/history/{historyId}/message' , 'AssignmentHistoryController@storeMessage');
            Route::post('/assignment/{assignmentId}/history/{historyId}/setGrade' , 'AssignmentHistoryController@setGrade');
            Route::get('/assignment/{assignmentId}/history/{historyId}/message/{messageId}/downloadAttach' , 'AssignmentHistoryController@downloadAttach');

            Route::group(['prefix' => '/learning/{slug}/forum'] , function () { // LearningPageForumTrait
                Route::get('/' , 'LearningPageController@forum');
                Route::post('/store' , 'LearningPageController@forumStoreNewQuestion');
                Route::get('/{forumId}/edit' , 'LearningPageController@getForumForEdit');
                Route::post('/{forumId}/update' , 'LearningPageController@updateForum');
                Route::post('/{forumId}/pinToggle' , 'LearningPageController@forumPinToggle');
                Route::get('/{forumId}/downloadAttach' , 'LearningPageController@forumDownloadAttach');

                Route::group(['prefix' => '/{forumId}/answers'] , function () {
                    Route::get('/' , 'LearningPageController@getForumAnswers');
                    Route::post('/' , 'LearningPageController@storeForumAnswers');
                    Route::get('/{answerId}/edit' , 'LearningPageController@answerEdit');
                    Route::post('/{answerId}/update' , 'LearningPageController@answerUpdate');
                    Route::post('/{answerId}/{togglePinOrResolved}' , 'LearningPageController@answerTogglePinOrResolved');
                });
            });
            Route::post('/direct-payment' , 'WebinarController@directPayment');
        });
        Route::get('/{quiz_id}/start' , 'WebinarController@start');
    });
	
	
	Route::group(['prefix' => 'links-data'] , function () {
        Route::get('/' , 'LinksDataController@index');
    });

    Route::group(['prefix' => 'certificate_validation'] , function () {
        Route::get('/' , 'CertificateValidationController@index');
        Route::post('/validate' , 'CertificateValidationController@checkValidate');
    });


    Route::group(['prefix' => 'cart'] , function () {
        Route::post('/store' , 'CartManagerController@store');
        Route::get('/{id}/delete' , 'CartManagerController@destroy');
    });

    Route::group(['middleware' => 'web.auth'] , function () {

		/*Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'ensureFolderExists']], function () {
			\UniSharp\LaravelFilemanager\Lfm::routes();
		});*/
		
		Route::group(['prefix' => 'laravel-filemanager'], function () {
			\UniSharp\LaravelFilemanager\Lfm::routes();
		});





        Route::group(['prefix' => 'reviews'] , function () {
            Route::post('/store' , 'WebinarReviewController@store');
            Route::post('/store-reply-comment' , 'WebinarReviewController@storeReplyComment');
            Route::get('/{id}/delete' , 'WebinarReviewController@destroy');
            Route::get('/{id}/delete-comment/{commentId}' , 'WebinarReviewController@destroy');
        });

        Route::group(['prefix' => 'favorites'] , function () {
            Route::get('{slug}/toggle' , 'FavoriteController@toggle');
            Route::post('/{id}/update' , 'FavoriteController@update');
            Route::get('/{id}/delete' , 'FavoriteController@destroy');
        });

        Route::group(['prefix' => 'comments'] , function () {
            Route::post('/store' , 'CommentController@store');
            Route::post('/{id}/reply' , 'CommentController@storeReply');
            Route::post('/{id}/update' , 'CommentController@update');
            Route::post('/{id}/report' , 'CommentController@report');
            Route::get('/{id}/delete' , 'CommentController@destroy');
        });

        Route::group(['prefix' => 'cart'] , function () {
            Route::get('/' , 'CartController@index');

            Route::post('/coupon/validate' , 'CartController@couponValidate');
            Route::post('/checkout' , 'CartController@checkout')->name('checkout');
        });

        Route::group(['prefix' => 'users'] , function () {
            Route::get('/{id}/follow' , 'UserController@followToggle');
        });

        Route::group(['prefix' => 'become-instructor'] , function () {
            Route::get('/' , 'BecomeInstructorController@index')->name('becomeInstructor');
            Route::get('/packages' , 'BecomeInstructorController@packages')->name('becomeInstructorPackages');
            Route::get('/packages/{id}/checkHasInstallment' , 'BecomeInstructorController@checkPackageHasInstallment');
            Route::get('/packages/{id}/installments' , 'BecomeInstructorController@getInstallmentsByRegistrationPackage');
            Route::post('/' , 'BecomeInstructorController@store');
        });

    });

    Route::group(['prefix' => 'meetings'] , function () {
        Route::post('/reserve' , 'MeetingController@reserve');
    });

    Route::group(['prefix' => 'users'] , function () {
        Route::get('/{id}/profile' , 'UserController@profile')->middleware('inject.css:assets/default/css/panel-pages/profile.css');
        Route::post('/{id}/availableTimes' , 'UserController@availableTimes');
        Route::post('/{id}/send-message' , 'UserController@sendMessage');
    });

    Route::group(['prefix' => 'payments'] , function () {
        Route::post('/payment-request' , 'PaymentController@paymentRequest');
        Route::get('/verify/{gateway}' , ['as' => 'payment_verify' , 'uses' => 'PaymentController@paymentVerify']);
        Route::post('/verify/{gateway}' , ['as' => 'payment_verify_post' , 'uses' => 'PaymentController@paymentVerify']);
        Route::get('/status' , 'PaymentController@payStatus');
        Route::get('/payku/callback/{id}' , 'PaymentController@paykuPaymentVerify')->name('payku.result');
    });

    Route::group(['prefix' => 'subscribes'] , function () {
        Route::get('/apply/{webinarSlug}' , 'SubscribeController@apply');
        Route::get('/apply/bundle/{bundleSlug}' , 'SubscribeController@bundleApply');
        Route::get('/apply-subscription' , 'SubscribeController@applySubscription');
        Route::post('/tenure-submit', 'SubscribeController@tenureSubmit');
        Route::get('/autogenerte-username', 'SubscribeController@autoGenerateUsername');
        Route::post('/register-child', 'SubscribeController@registerChild');
        Route::post('/edit-child', 'SubscribeController@editChild');
        Route::post('/payment-form', 'SubscribeController@paymentForm');
        Route::post('/payment-secret', 'SubscribeController@paymentIntent');
        Route::post('/pay', 'SubscribeController@pay');
        Route::get('/packages-list', 'SubscribeController@packagesList')->name('packages-list');
        Route::post('/cancel-subscription', 'SubscribeController@cancelSubscription');
        Route::post('/unlink-user', 'SubscribeController@unlinkUser');
        Route::post('/update-game-time', 'SubscribeController@updateGameTime');
        Route::get('/payment-form-test' , 'SubscribeController@paymentformTest');
		Route::get('/get-coupon-data' , 'SubscribeController@getCouponData');
    });


    Route::group(['prefix' => 'search'] , function () {
        Route::get('/' , 'SearchController@index');
    });

    Route::group(['prefix' => 'categories'] , function () {
        Route::get('/{categoryTitle}/{subCategoryTitle?}' , 'CategoriesController@index');
    });

    Route::group(['prefix' => 'learning-journey'] , function () {
        Route::get('/' , 'LearningJourneyController@index');
        Route::get('/{subject}' , 'LearningJourneyController@subject');
    });

    //Route::get('/classes' , 'ClassesController@index');

    Route::get('/reward-courses' , 'RewardCoursesController@index');

    Route::group(['prefix' => 'blog'] , function () {
        Route::get('/' , 'BlogController@index');
        Route::get('/categories/{category}' , 'BlogController@index');
        Route::get('/{slug}' , 'BlogController@show');
    });

    Route::group(['prefix' => 'contact'] , function () {
        Route::get('/' , 'ContactController@index');
        Route::post('/store' , 'ContactController@store');
    });

    Route::group(['prefix' => 'instructors'] , function () {
        Route::get('/' , 'UserController@instructors');
    });

    Route::group(['prefix' => 'organizations'] , function () {
        Route::get('/' , 'UserController@organizations');
    });

    Route::group(['prefix' => 'load_more'] , function () {
        Route::get('/{role}' , 'UserController@handleInstructorsOrOrganizationsPage');
    });


    // Captcha
    Route::group(['prefix' => 'captcha'] , function () {
        Route::post('create' , function () {
            $response = ['status' => 'success' , 'captcha_src' => captcha_src('flat')];

            return response()->json($response);
        });
        Route::get('{config?}' , '\Mews\Captcha\CaptchaController@getCaptcha');
    });

    Route::post('/newsletters' , 'UserController@makeNewsletter');

    Route::group(['prefix' => 'jobs'] , function () {
        Route::get('/{methodName}' , 'JobsController@index');
        Route::post('/{methodName}' , 'JobsController@index');
    });

    Route::group(['prefix' => 'regions'] , function () {
        Route::get('/provincesByCountry/{countryId}' , 'RegionController@provincesByCountry');
        Route::get('/citiesByProvince/{provinceId}' , 'RegionController@citiesByProvince');
        Route::get('/districtsByCity/{cityId}' , 'RegionController@districtsByCity');
    });

    Route::group(['prefix' => 'instructor-finder'] , function () {
        Route::get('/' , 'InstructorFinderController@index');
        Route::get('/wizard' , 'InstructorFinderController@wizard');
    });

    Route::group(['prefix' => 'products'] , function () {
        Route::get('/' , 'ProductController@searchLists');
        Route::get('/{slug}' , 'ProductController@show');
        Route::post('/{slug}/points/apply' , 'ProductController@buyWithPoint');
        Route::post('/update-shortlist' , 'ProductController@shortListUpdate');


        Route::group(['prefix' => 'reviews'] , function () {
            Route::post('/store' , 'ProductReviewController@store');
            Route::post('/store-reply-comment' , 'ProductReviewController@storeReplyComment');
            Route::get('/{id}/delete' , 'ProductReviewController@destroy');
            Route::get('/{id}/delete-comment/{commentId}' , 'ProductReviewController@destroy');
        });

        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/{slug}/installments' , 'ProductController@getInstallmentsByProduct');
            Route::post('/direct-payment' , 'ProductController@directPayment');
        });
    });

    Route::group(['prefix' => 'games'] , function () {
        Route::get('/', 'GamesController@index')->middleware('inject.css:assets/default/css/panel-pages/gamepage.css');
        Route::get('/word-scramble', 'GamesController@WordScramble');
    });

    /*
     * Common Functionalities
     */
    Route::group(['prefix' => 'common'], function () {
        Route::get('/classes_by_year', 'CommonWebController@classes_by_year');
        Route::get('/sections_by_class', 'CommonWebController@sections_by_class');
        Route::get('/users_by_class', 'CommonWebController@users_by_class');
        Route::get('/users_by_section', 'CommonWebController@users_by_section');
        Route::get('/subjects_by_year', 'CommonWebController@subjects_by_year');
        Route::get('/generate_audio', 'CommonWebController@generate_audio');
        Route::get('/types_quiz_by_year', 'CommonWebController@types_quiz_by_year');
        Route::get('/types_quiz_by_year_group', 'CommonWebController@types_quiz_by_year_group');
        Route::get('/topics_subtopics_by_subject', 'CommonWebController@topics_subtopics_by_subject');
        Route::get('/mock_topics_subtopics_by_subject', 'CommonWebController@mock_topics_subtopics_by_subject');

        Route::get('/get_example_question', 'CommonWebController@get_example_question');
        Route::get('/get_group_questions', 'CommonWebController@get_group_questions');
        Route::get('/get_group_questions_options', 'CommonWebController@get_group_questions_options');
        Route::get('/get_mock_subjects_by_year', 'CommonWebController@get_mock_subjects_by_year');
		Route::get('/user_heatmap', 'CommonWebController@user_heatmap');
		


    });

    Route::group(['prefix' => 'shop'] , function () {
        Route::get('/' , 'ProductController@searchLists')->middleware('inject.css:assets/default/css/panel-pages/shop.css');
        Route::get('/{slug}' , 'ProductController@show')->middleware('inject.css:assets/default/css/panel-pages/shop.css');
        Route::post('/{slug}/points/apply' , 'ProductController@buyWithPoint');

        Route::group(['prefix' => 'reviews'] , function () {
            Route::post('/store' , 'ProductReviewController@store')->middleware('inject.css:assets/default/css/panel-pages/shop.css');
            Route::post('/store-reply-comment' , 'ProductReviewController@storeReplyComment');
            Route::get('/{id}/delete' , 'ProductReviewController@destroy');
            Route::get('/{id}/delete-comment/{commentId}' , 'ProductReviewController@destroy');
        });

        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/{slug}/installments' , 'ProductController@getInstallmentsByProduct');
            Route::post('/direct-payment' , 'ProductController@directPayment');
        });
    });

    Route::get('/reward-products' , 'RewardProductsController@index');

    Route::group(['prefix' => 'bundles'] , function () {
        Route::get('/{slug}' , 'BundleController@index');
        Route::get('/{slug}/free' , 'BundleController@free');

        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/{slug}/favorite' , 'BundleController@favoriteToggle');
            Route::get('/{slug}/points/apply' , 'BundleController@buyWithPoint');

            Route::group(['prefix' => 'reviews'] , function () {
                Route::post('/store' , 'BundleReviewController@store');
                Route::post('/store-reply-comment' , 'BundleReviewController@storeReplyComment');
                Route::get('/{id}/delete' , 'BundleReviewController@destroy');
                Route::get('/{id}/delete-comment/{commentId}' , 'BundleReviewController@destroy');
            });

            Route::post('/direct-payment' , 'BundleController@directPayment');
        });
    });

    Route::group(['prefix' => 'forums'] , function () {
        Route::get('/' , 'ForumController@index');
        Route::get('/create-topic' , 'ForumController@createTopic');
        Route::post('/create-topic' , 'ForumController@storeTopic');
        Route::get('/search' , 'ForumController@search');

        Route::group(['prefix' => '/{slug}/topics'] , function () {
            Route::get('/' , 'ForumController@topics');
            Route::post('/{topic_slug}/likeToggle' , 'ForumController@topicLikeToggle');
            Route::get('/{topic_slug}/edit' , 'ForumController@topicEdit');
            Route::post('/{topic_slug}/edit' , 'ForumController@topicUpdate');
            Route::post('/{topic_slug}/bookmark' , 'ForumController@topicBookmarkToggle');
            Route::get('/{topic_slug}/downloadAttachment/{attachment_id}' , 'ForumController@topicDownloadAttachment');

            Route::group(['prefix' => '/{topic_slug}/posts'] , function () {
                Route::get('/' , 'ForumController@posts');
                Route::post('/' , 'ForumController@storePost');
                Route::post('/report' , 'ForumController@storeTopicReport');
                Route::get('/{post_id}/edit' , 'ForumController@postEdit');
                Route::post('/{post_id}/edit' , 'ForumController@postUpdate');
                Route::post('/{post_id}/likeToggle' , 'ForumController@postLikeToggle');
                Route::post('/{post_id}/un_pin' , 'ForumController@postUnPin');
                Route::post('/{post_id}/pin' , 'ForumController@postPin');
                Route::get('/{post_id}/downloadAttachment' , 'ForumController@postDownloadAttachment');
            });
        });
    });

    Route::group(['prefix' => 'cookie-security'] , function () {
        Route::post('/all' , 'CookieSecurityController@setAll');
        Route::post('/customize' , 'CookieSecurityController@setCustomize');
    });


    Route::group(['prefix' => 'upcoming_courses'] , function () {
        Route::get('/' , 'UpcomingCoursesController@index');
        Route::get('{slug}' , 'UpcomingCoursesController@show');
        Route::get('{slug}/toggleFollow' , 'UpcomingCoursesController@toggleFollow');
        Route::get('{slug}/favorite' , 'UpcomingCoursesController@favorite');
        Route::post('{id}/report' , 'UpcomingCoursesController@report');
    });

    Route::group(['prefix' => 'installments'] , function () {
        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/request_submitted' , 'InstallmentsController@requestSubmitted');
            Route::get('/request_rejected' , 'InstallmentsController@requestRejected');
            Route::get('/{id}' , 'InstallmentsController@index');
            Route::post('/{id}/store' , 'InstallmentsController@store');
        });
    });

    Route::group(['prefix' => 'waitlists'] , function () {
        Route::post('/join' , 'WaitlistController@store');
    });

    Route::group(['prefix' => 'gift'] , function () {
        Route::group(['middleware' => 'web.auth'] , function () {
            Route::get('/{item_type}/{item_slug}' , 'GiftController@index');
            Route::post('/{item_type}/{item_slug}' , 'GiftController@store');
        });
    });

    Route::group(['prefix' => 'books'] , function () {
        Route::get('/' , 'BooksController@index')->middleware('inject.css:assets/default/css/panel-pages/books_pages.css');
        Route::get('/{book_slug}' , 'BooksController@book')->middleware('inject.css:assets/default/css/panel-pages/books_pages.css');
        Route::get('/{book_slug}/activity' , 'BooksController@bookActivity')->middleware('inject.css:assets/default/css/panel-pages/books_pages.css');
        Route::get('/{info_id}/info_detail' , 'BooksController@info_detail')->middleware('inject.css:assets/default/css/panel-pages/books_pages.css');
        Route::post('/update_reading' , 'BooksController@update_reading');
    });

    Route::group(['prefix' => 'books-shelf'] , function () {
        Route::get('/' , 'BooksController@books_shelf');
    });
    Route::group(['prefix' => 'book-shelf'] , function () {
        Route::get('/' , 'BooksController@index');
    });

    Route::group(['prefix' => 'sats'] , function () {
        Route::get('/' , 'SatsController@index');
        //Route::get('/sats_landing' , 'SatsController@sats_landing');
        //Route::get('/{sat_id}/start' , 'SatsController@start');
        Route::get('/{quiz_slug}' , 'SatsController@start');
    });

    Route::group(['prefix' => 'tests'] , function () {
        Route::get('/' , 'TestsController@index')->middleware('inject.css:assets/default/css/panel-pages/test-page.css');
        Route::get('/search_tests' , 'TestsController@search_tests');
        Route::get('/switch_user' , 'TestsController@switch_user');

    });

    Route::group(['prefix' => 'learn'] , function () {
        Route::get('/' , 'LearnController@index')->middleware('inject.css:assets/default/css/panel-pages/learn.css');
    });

    Route::group(['prefix' => 'sats-preparation'] , function () {
        Route::get('/' , 'SatsController@sats_landing');
    });
	
	Route::group(['prefix' => 'tutoring'] , function () {
        Route::get('/' , 'PagesController@tutoring_landing');
    });

    Route::group(['prefix' => 'spelling'] , function () {
        Route::get('/' , 'SpellsController@landing');
    });

    Route::group(['prefix' => 'assignment'] , function () {
        Route::get('/{assignment_id}' , 'AssignmentController@assignment');
        Route::get('/{assignment_id}/start' , 'AssignmentController@start');
        //Route::get('/{quiz_slug}' , 'AssignmentController@start');
    });

    Route::group(['prefix' => 'spells'] , function () {
       Route::get('/' , 'SpellsController@index')->middleware('inject.css:assets/default/css/panel-pages/wordlist.css');
       Route::get('/{quiz_year}/{quiz_slug}/words-list' , 'SpellsController@words_list')->middleware('inject.css:assets/default/css/panel-pages/wordlist.css');
       Route::get('/words_list' , 'SpellsController@words_list')->middleware('inject.css:assets/default/css/panel-pages/wordlist.css');
       Route::get('/{quiz_year}/{quiz_slug}' , 'SpellsController@start');
        Route::get('/search' , 'SpellsController@search');
        Route::get('/words-data' , 'SpellsController@words_data');
	   Route::get('/{spell_category}' , 'SpellsController@index');
       //Route::get('/{quiz_id}/start' , 'ElevenplusController@start');

   });


    Route::group(['prefix' => '11plus'] , function () {
        Route::get('/' , 'ElevenplusController@index');
        Route::get('/{quiz_slug}' , 'ElevenplusController@start');
        //Route::get('/{quiz_id}/start' , 'ElevenplusController@start');

    });
	Route::group(['prefix' => '11-plus'] , function () {
        Route::get('/' , 'ElevenplusController@landing');

    });
	
    Route::group(['prefix' => 'iseb'] , function () {
        Route::get('/' , 'IsebController@index');
        Route::get('/{quiz_slug}' , 'IsebController@start');

    });

    Route::group(['prefix' => 'cat4'] , function () {
        Route::get('/' , 'CatFourController@index');
        Route::get('/{quiz_slug}' , 'CatFourController@start');
    });

    Route::group(['prefix' => 'independent-exams'] , function () {
        Route::get('/' , 'IndependentExamsController@index');
        Route::get('/{quiz_slug}' , 'IndependentExamsController@start');
    });

    Route::group(['prefix' => 'national-curriculum_bk'] , function () {
        Route::get('/' , 'NationalCurriculumController@index');
        Route::get('/curriculum_by_subject' , 'NationalCurriculumController@curriculum_by_subject');
		Route::get('/subjects_by_category', 'NationalCurriculumController@subjects_by_category');
        Route::get('/subjects_by_category_frontend', 'NationalCurriculumController@subjects_by_category_frontend');
    });
	
    Route::group(['prefix' => 'national-curriculum'] , function () {
		Route::get('/subjects_by_category', 'NationalCurriculumController@subjects_by_category');
    });

    Route::group(['prefix' => 'weekly-planner_bk'] , function () {
        Route::get('/' , 'WeeklyPlannerController@index');
        Route::get('/weekly_planner_by_subject' , 'WeeklyPlannerController@weekly_planner_by_subject');
    });

    Route::group(['prefix' => 'timestables'] , function () {
        Route::get('/' , 'TimestablesController@landing');
        //Route::get('/landing' , 'TimestablesController@landing');
        Route::get('/assignment/{assignment_id}' , 'TimestablesController@assignment');
        Route::post('/generate' , 'TimestablesController@genearte');
        Route::post('/generate_powerup' , 'TimestablesController@generate_powerup');
        Route::post('/generate_trophymode' , 'TimestablesController@generate_trophymode');
        Route::post('/generate_treasure_mission' , 'TimestablesController@generate_treasure_mission');
        Route::post('/generate_showdown_mode' , 'TimestablesController@generate_showdown_mode');



        Route::post('/assignment_create' , 'TimestablesController@assignment_create');

        Route::get('/assignment_chase' , 'TimestablesController@assignment_chase');
        Route::get('/past_assignments' , 'TimestablesController@past_assignments');

        Route::get('/global_arena' , 'TimestablesController@global_arena');
        Route::post('/update_tournament_event' , 'TimestablesController@update_tournament_event');

    });

    //Route::group(['prefix' => 'timestables-practice' , 'middleware' => 'check_is_student'] , function () {
    Route::group(['prefix' => 'timestables-practice'] , function () {
        //Route::get('/' , 'TimestablesController@index')->middleware('inject.css:path/to/timestables_assignment.css,path/to/extra.css');
		Route::get('/' , 'TimestablesController@index')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/freedom-mode' , 'TimestablesController@freedom_mode')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/powerup-mode' , 'TimestablesController@powerup_mode')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/trophy-mode' , 'TimestablesController@trophy_mode')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/treasure-mission' , 'TimestablesController@treasure_mission')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/showdown-mode' , 'TimestablesController@showdown_mode')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
        Route::get('/heat-map' , 'TimestablesController@summary')->middleware('inject.css:assets/default/css/panel-pages/timestable.css');
		
		
		Route::post('/freedom-mode/play' , 'TimestablesController@genearte');
        Route::post('/powerup-mode/play' , 'TimestablesController@generate_powerup');
        Route::post('/trophy-mode/play' , 'TimestablesController@generate_trophymode');
        Route::post('/treasure-mission/play' , 'TimestablesController@generate_treasure_mission');
        Route::post('/showdown-mode/play' , 'TimestablesController@generate_showdown_mode');
		
		
    });

    Route::group(['prefix' => 'school-zone'] , function () {
        Route::get('/' , 'TimestablesController@school_zone_mode')->middleware('inject.css:assets/default/css/panel-pages/schoolzone.css');
    });

    Route::group(['prefix' => 'quests'] , function () {
        Route::get('/' , 'DailyQuestsController@index')->middleware('inject.css:assets/default/css/panel-pages/quest_list.css');
		Route::get('/{quest_id}/summary' , 'DailyQuestsController@summary');
    });

    Route::get('/sitemap.xml' , function () {
        return Response::view('sitemap')->header('Content-Type' , 'application/xml');
    });

    Route::group(['prefix' => 'pages'] , function () {
        Route::get('/{link}' , 'PagesController@index');
    });

    Route::post('switch_user', 'UserController@switch_user');

    Route::post('assign_user_topic', 'UserController@assign_user_topic');

    Route::get('custom_html', 'TestsController@custom_html');

    Route::get('faqs', 'FaqsController@index');

    Route::get('pricing', 'PricingController@index');








    /*
     * Cron Functions
     */
    Route::group(['prefix' => 'cron'] , function () {
        Route::get('/create_tournaments_events' , 'CronJobsController@create_tournaments_events');
    });



    Route::group(['prefix' => '{link}'] , function () {
        if (!Request::is('admin') && !Request::is('admin/*')) {
            if (!Request::is('panel') && !Request::is('panel/*') && !Request::is('parent') && !Request::is('parent/*') && !Request::is('tutor') && !Request::is('tutor/*')) {
                Route::get('/' , 'PagesController@index');
            }
        }
    });

});


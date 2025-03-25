<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\Panel\CardReservationController;

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
Route::post('/clear-session', function () {
    Session::forget('teacher_id');
    return response()->json(['success' => 'Session variable cleared']);
})->name('clear-session');
Route::get('/test-session', function() {
    $teacherId = session('teacher_id');
    return $teacherId ? "Teacher ID exists: $teacherId" : "Teacher ID is cleared";
});

Route::post('/insert-icon',  'PdfInsertController@insertIcon');
Route::get('/exp', function () {
    return view('insert');
});
Route::get('/mobile-app', 'Web\MobileAppController@index')->middleware(['share'])->name('mobileAppRoute');

Route::get('/')->middleware(RedirectIfAuthenticated::class);
Route::get('/get-manuel-documents/{id}', [HomeController::class,'getManualDocuments']);

Route::get('/card_reservations', [HomeController::class,'createcard'])->name('webcard_reservations.index');
Route::post('/card_reservations/store', [HomeController::class,'storecard'])->name('webcard_reservations.store');

Route::group(['namespace' => 'Auth', 'middleware' => ['check_mobile_app', 'share']], function () {
    Route::get('/step2', [UserController::class, 'step2']);
    Route::post('/saveUserInfo', [UserController::class, 'saveUserInfo'])->name('saveUserInfo');
    Route::get('/findSchoolName', [UserController::class, 'findSchoolName']);
    Route::get('/findSchoolSection', [UserController::class, 'findSchoolSection']);
    Route::get('/findSchoolOption', [UserController::class, 'findSchoolOption']);
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login')->name('auth.login');
    Route::get('/logout', 'LoginController@logout');
    Route::get('/register', 'RegisterController@showRegistrationForm');
    Route::post('/register', 'RegisterController@register');
    
    Route::get('/Instructor/register', 'RegisterController@showRegistrationInstructorForm');
    Route::post('/Instructor/register', 'RegisterController@registerInstructor');
    
    Route::get('/verification', 'VerificationController@index');
    Route::get('/Instructor/verification', 'VerificationController@indexInstructor');
    
    Route::post('/verification', 'VerificationController@confirmCode');
    Route::post('/Instructor/verification', 'VerificationController@confirmCodeInstructor');
    
    Route::get('/verification/resend', 'VerificationController@resendCode');
    Route::get('/Instructor/verification/resend', 'VerificationController@resendCodeInstructor');
    
    Route::get('/forget-password', 'ForgotPasswordController@showLinkRequestForm');
    Route::post('/send-email', 'ForgotPasswordController@forgot');
    Route::get('reset-password/{token}', 'ResetPasswordController@showResetForm');
    Route::post('/reset-password', 'ResetPasswordController@updatePassword');
    Route::get('/google', 'SocialiteController@redirectToGoogle');
    Route::get('/google/callback', 'SocialiteController@handleGoogleCallback');
    
    Route::get('/facebook/redirect', 'SocialiteController@redirectToFacebook');
    Route::get('/facebook/callback', 'SocialiteController@handleFacebookCallback');
    Route::get('/reff/{code}', 'ReferralController@referral');
});

Route::group(['namespace' => 'Web', 'middleware' => ['check_mobile_app', 'impersonate', 'share']], function () {
    Route::get('/stripe', function () {
        return view('web.default.cart.channels.stripe');
    });

    // set Locale
    Route::post('/locale', 'LocaleController@setLocale');
    
    Route::get('/', 'HomeController@index')->middleware(RedirectIfAuthenticated::class);
   

    Route::get('/getDefaultAvatar', 'DefaultAvatarController@make');

    Route::group(['prefix' => 'course'], function () {
        // Route::get('/{slug}', 'WebinarController@course');
        Route::get('/{slug}/file/{file_id}/download', 'WebinarController@downloadFile');
        Route::get('/{slug}/file/{file_id}/showHtml', 'WebinarController@showHtmlFile');
        Route::get('/{slug}/lessons/{lesson_id}/read', 'WebinarController@getLesson');
        Route::post('/getFilePath', 'WebinarController@getFilePath');
        Route::get('/{slug}/file/{file_id}/play', 'WebinarController@playFile');
        Route::get('/{slug}/free', 'WebinarController@free');
        Route::get('/{slug}/points/apply', 'WebinarController@buyWithPoint');
        Route::post('/{id}/report', 'WebinarController@reportWebinar');
        Route::post('/{id}/learningStatus', 'WebinarController@learningStatus');

        Route::group(['middleware' => 'web.auth'], function () {
            Route::post('/learning/itemInfo', 'LearningPageController@getItemInfo');
            Route::get('/learning/{slug}', 'LearningPageController@index');
            Route::get('/learning/{slug}/noticeboards', 'LearningPageController@noticeboards');
            Route::get('/assignment/{assignmentId}/download/{id}/attach', 'LearningPageController@downloadAssignment');
            Route::post('/assignment/{assignmentId}/history/{historyId}/message', 'AssignmentHistoryController@storeMessage');
            Route::post('/assignment/{assignmentId}/history/{historyId}/setGrade', 'AssignmentHistoryController@setGrade');
            Route::get('/assignment/{assignmentId}/history/{historyId}/message/{messageId}/downloadAttach', 'AssignmentHistoryController@downloadAttach');

            Route::group(['prefix' => '/learning/{slug}/forum'], function () {
                Route::get('/', 'LearningPageController@forum');
                Route::post('/store', 'LearningPageController@forumStoreNewQuestion');
                Route::get('/{forumId}/edit', 'LearningPageController@getForumForEdit');
                Route::post('/{forumId}/update', 'LearningPageController@updateForum');
                Route::post('/{forumId}/pinToggle', 'LearningPageController@forumPinToggle');
                Route::get('/{forumId}/downloadAttach', 'LearningPageController@forumDownloadAttach');

                Route::group(['prefix' => '/{forumId}/answers'], function () {
                    Route::get('/', 'LearningPageController@getForumAnswers');
                    Route::post('/', 'LearningPageController@storeForumAnswers');
                    Route::get('/{answerId}/edit', 'LearningPageController@answerEdit');
                    Route::post('/{answerId}/update', 'LearningPageController@answerUpdate');
                    Route::post('/{answerId}/{togglePinOrResolved}', 'LearningPageController@answerTogglePinOrResolved');
                });
            });

            Route::post('/direct-payment', 'WebinarController@directPayment');
        });
    });

    Route::group(['prefix' => 'certificate_validation'], function () {
        Route::get('/', 'CertificateValidationController@index');
        Route::post('/validate', 'CertificateValidationController@checkValidate');
    });


    Route::group(['prefix' => 'cart'], function () {
        Route::post('/store', 'CartManagerController@store');
        Route::get('/{id}/delete', 'CartManagerController@destroy');
    });

    Route::group(['middleware' => 'web.auth'], function () {
        Route::group(['prefix' => 'laravel-filemanager'], function () {
            \UniSharp\LaravelFilemanager\Lfm::routes();
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/', 'CartController@index');

            Route::post('/coupon/validate', 'CartController@couponValidate');
            Route::post('/checkout', 'CartController@checkout')->name('checkout');
        });

        // Route::group(['prefix' => 'users'], function () {
        //     Route::get('/{id}/follow', 'UserController@followToggle');
        // });
        // Web Routes
        Route::post('/get-matieres-by-levels', 'BecomeInstructorController@getMatieresByLevels');
        Route::post('/get-matieres-by-levels', 'BecomeInstructorController@getMatieresByLevels');
        Route::group(['prefix' => 'become-teacher'], function () {
            Route::get('/', 'BecomeInstructorController@indexteacher')->name('becomeInstructor');
            Route::post('/', 'BecomeInstructorController@storeteacher');
        });
        Route::group(['prefix' => 'become-instructor'], function () {
            Route::get('/', 'BecomeInstructorController@indexteacher')->name('becomeInstructor');
            Route::get('/packages', 'BecomeInstructorController@packages')->name('becomeInstructorPackages');
            Route::post('/', 'BecomeInstructorController@store');
            Route::post('/setting', 'BecomeInstructorController@storeSetting');
        });

    });

    Route::group(['prefix' => 'meetings'], function () {
        Route::post('/reserve', 'MeetingController@reserve');
    });

    Route::group(['prefix' => 'manuels'], function () {
        Route::get('/', 'UserController@manuels')->name('manuels');

    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/{id}/profile', 'UserController@profile');
        Route::get('/pannel/{id}/profile', 'UserController@profilepannel');
        Route::post('/{id}/availableTimes', 'UserController@availableTimes');
        Route::post('/{id}/send-message', 'UserController@sendMessage');
    });

    Route::group(['prefix' => 'subscribes'], function () {
        Route::get('/apply/{webinarSlug}', 'SubscribeController@apply');
        Route::get('/apply/bundle/{bundleSlug}', 'SubscribeController@bundleApply');
    });

    Route::group(['prefix' => 'search'], function () {
        Route::get('/', 'SearchController@index');
    });


    Route::group(['prefix' => 'contact'], function () {
        Route::get('/', 'ContactController@index');
        Route::post('/store', 'ContactController@store');
    });

        Route::group(['prefix' => 'instructors'], function () {
        Route::get('/', 'UserController@instructors');
        Route::get('/get-materials-by-level', [UserController::class, 'getMaterialsByLevel']);
        Route::get('/search', [UserController::class, 'searchInstructors']);

    });

    Route::group(['prefix' => 'load_more'], function () {
        Route::get('/{role}', 'UserController@handleInstructorsOrOrganizationsPage');
    });

    Route::group(['prefix' => 'pages'], function () {
        Route::get('/{link}', 'PagesController@index');
    });

    Route::group(['prefix' => 'captcha'], function () {
        Route::post('create', function () {
            $response = ['status' => 'success', 'captcha_src' => captcha_src('flat')];

            return response()->json($response);
        });
        Route::get('{config?}', '\Mews\Captcha\CaptchaController@getCaptcha');
    });

    Route::post('/newsletters', 'UserController@makeNewsletter');

    Route::group(['prefix' => 'jobs'], function () {
        Route::get('/{methodName}', 'JobsController@index');
        Route::post('/{methodName}', 'JobsController@index');
    });

    Route::group(['prefix' => 'regions'], function () {
        Route::get('/provincesByCountry/{countryId}', 'RegionController@provincesByCountry');
        Route::get('/citiesByProvince/{provinceId}', 'RegionController@citiesByProvince');
        Route::get('/districtsByCity/{cityId}', 'RegionController@districtsByCity');
    });

    Route::group(['prefix' => 'instructor-finder'], function () {
        Route::get('/', 'InstructorFinderController@index');
        Route::get('/wizard', 'InstructorFinderController@wizard');
    });


    Route::group(['prefix' => 'forums'], function () {
        Route::get('/', 'ForumController@index');
        Route::get('/create-topic', 'ForumController@createTopic');
        Route::post('/create-topic', 'ForumController@storeTopic');
        Route::get('/search', 'ForumController@search');

        Route::group(['prefix' => '/{slug}/topics'], function () {
            Route::get('/', 'ForumController@topics');
            Route::post('/{topic_slug}/likeToggle', 'ForumController@topicLikeToggle');
            Route::get('/{topic_slug}/edit', 'ForumController@topicEdit');
            Route::post('/{topic_slug}/edit', 'ForumController@topicUpdate');
            Route::post('/{topic_slug}/bookmark', 'ForumController@topicBookmarkToggle');
            Route::get('/{topic_slug}/downloadAttachment/{attachment_id}', 'ForumController@topicDownloadAttachment');

            Route::group(['prefix' => '/{topic_slug}/posts'], function () {
                Route::get('/', 'ForumController@posts');
                Route::post('/', 'ForumController@storePost');
                Route::post('/report', 'ForumController@storeTopicReport');
                Route::get('/{post_id}/edit', 'ForumController@postEdit');
                Route::post('/{post_id}/edit', 'ForumController@postUpdate');
                Route::post('/{post_id}/likeToggle', 'ForumController@postLikeToggle');
                Route::post('/{post_id}/un_pin', 'ForumController@postUnPin');
                Route::post('/{post_id}/pin', 'ForumController@postPin');
                Route::get('/{post_id}/downloadAttachment', 'ForumController@postDownloadAttachment');
            });
        });
    });

    Route::group(['prefix' => 'cookie-security'], function () {
        Route::post('/all', 'CookieSecurityController@setAll');
        Route::post('/customize', 'CookieSecurityController@setCustomize');
    });
});


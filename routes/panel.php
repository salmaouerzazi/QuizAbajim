<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Panel\ManuelScolaireController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Web\MeetingController;
use App\Http\Controllers\Panel\CardReservationController;
use App\Http\Controllers\Panel\ConcoursController;
use App\Http\Controllers\Panel\QuizController;
/*
|--------------------------------------------------------------------------
| User Panel Routes
|--------------------------------------------------------------------------
*/

// --------------- AJAX ROUTES ----------------
Route::get('/get-matieres', [\App\Http\Controllers\Panel\MeetingController::class, 'getMatieresByLevel'])->name('get-matieres');
Route::get('/get-materials-by-level/{levelId}', [DashboardController::class, 'getMaterialsByLevel']);
Route::get('/get-levels-by-material/{materialId}', [DashboardController::class, 'getLevelsByMaterial']);
//  ------------------------------------------
Route::get('/card', [ManuelScolaireController::class, 'card']);
// -----> Panel routes ---------------------------------------------------------
Route::group(['namespace' => 'Panel', 'prefix' => 'panel', 'middleware' => ['check_mobile_app', 'impersonate', 'panel', 'share']], function () {
    // ----> Child routes ---------------------------------------------------------
    Route::group(['middleware' => ['checkrole:enfant']], function () {
        Route::get('/enfant/concours', [ConcoursController::class, 'getConcoursByLevelEnfant']);
        Route::get('/enfant/concours/{id}', [ConcoursController::class, 'getConcoursBookAndInsertIconPlay']);
        Route::post('/quizzes/submit/{id}', 'QuizController@submitFromChild')->name('panel.quiz.submit');
        Route::post('/panel/quizzes/{id}/attempt', [QuizController::class, 'storeAttempt'])->name('panel.quiz.attempt.store');

        

        //-------------------------------------------------------------------------

        Route::post('/unfollow/{teacherId}', [ManuelScolaireController::class, 'unfollowTeacher']);
        Route::post('/update_user_watch_time', [ManuelScolaireController::class, 'updateWatchTimeUser'])->name('user.updateWatchTimeUser');
        Route::get('/get-user-minutes', [ManuelScolaireController::class, 'getUserMinutes']);
        Route::post('/update_video_watch_time', [ManuelScolaireController::class, 'updateWatchTime'])->name('video.updateWatchTime');
        Route::post('/mark-video-as-seen', [ManuelScolaireController::class, 'markAsSeen']);
        Route::post('/add', [ManuelScolaireController::class, 'add'])->name('add');
        Route::post('/unadd', [ManuelScolaireController::class, 'unadd'])->name('unadd');
        Route::post('/check-subscription', [ManuelScolaireController::class, 'check'])->name('check-subscription');
        Route::get('/followings', 'DashboardController@getFollowings')->name('getFollowings');
        Route::post('/panel/check-subscription', [ManuelScolaireController::class, 'checkSubscription']);
        Route::get('/material/{id}', [DashboardController::class, 'DetailMaterial']);
        Route::post('/video/{id}/like', [ManuelScolaireController::class, 'like'])->name('video.like');
        Route::group(['prefix' => 'webinars'], function () {
            Route::group(['prefix' => 'allcourses'], function () {
                Route::get('/', 'WebinarController@allcourses');
                Route::get('/slug/{slug}', 'WebinarController@course');
            });
        });
        Route::get('/scolaire/{id}', [ManuelScolaireController::class, 'methode'])
            ->name('show')
            ->middleware('check.level');
    });

    // ----> Parent and Child routes ---------------------------------------------------------
    Route::group(['middleware' => ['checkrole:organization,enfant']], function () {
        Route::get('/enfant', 'DashboardController@dashboardEnfant')->name('panel.dashboard.enfant');
        Route::get('/impersonate/user/{user_id}', 'UserController@impersonate')->name('impersonate');
        Route::get('/impersonate/user/{user_id}/setting', 'UserController@impersonateSetting')->name('impersonate.setting');
        Route::post('/enfant/post/settings', 'DashboardController@addEnfantFromSettings');
        Route::get('/impersonate/revert', 'UserController@revertImpersonate')->name('impersonate.revert');
        Route::post('/delete-child', 'UserController@deleteChildAccount');
        Route::post('/validate-card', [ManuelScolaireController::class, 'validateCard']);
        Route::post('/store-payment-proof', [ManuelScolaireController::class, 'storePaymentProof'])->name('payment.proofs.store');
        Route::get('/card_reservations', [CardReservationController::class, 'create'])->name('card_reservations.index');
        Route::post('/card_reservations/store', [CardReservationController::class, 'store'])->name('card_reservations.store');
        Route::post('/card_reservations/update/{id}', [CardReservationController::class, 'update'])->name('card_reservations.update');
        Route::post('/update-guide-progress', 'DashboardController@updateGuideProgress')->name('update.guide.progress');
        Route::get('/fetch-progress', 'DashboardController@fetchGuideProgress')->name('fetch.progress');
        Route::post('/enfant/post', 'DashboardController@addEnfant');

        Route::group(['prefix' => 'meetings'], function () {
            Route::post('/reserveEnfant', [MeetingController::class, 'reserveEnfant'])->name('reserveEnfant.meeting');
        });
        Route::get('/parent/{user_id}/setting', 'UserController@parentSetting')->name('parent.setting');
    });

    // ---> Teacher routes ---------------------------------------------------------
    Route::group(['middleware' => ['checkrole:teacher']], function () {
        Route::get('/', 'DashboardController@dashboard')->name('panel.dashboard');
        Route::post('/addvideo', [ManuelScolaireController::class, 'addvideo'])->name('add.videos');
        Route::post('/upload-file', [ManuelScolaireController::class, 'uploadFile'])->name('upload.file');
        Route::get('/video/{id}/delete', [ManuelScolaireController::class, 'destroy']);
        Route::post('/video-upload', [ManuelScolaireController::class, 'upload'])->name('video.upload');
        Route::delete('/delete/video/{id}', [ManuelScolaireController::class, 'deleteVideo'])->name('delete.video');
        Route::get('/scolaire/teacher/mychaine', [ManuelScolaireController::class, 'mychaine']);
        Route::post('/videos/{id}/edit', [ManuelScolaireController::class, 'updateTitle'])->name('videos.updateTitle');
        Route::get('/scolaire/teacher/{id}', [ManuelScolaireController::class, 'methode2']);
        Route::get('/scolaire/view/teacher/{id}', [ManuelScolaireController::class, 'methode3']);
        Route::get('/scolaire/icon/view/teacher/{id}', [ManuelScolaireController::class, 'methode4']);
        Route::get('/concours/{id}', [ConcoursController::class, 'getConcoursBookAndInsertIconPlus']);
        Route::get('/concours/teacher/{id}', [ConcoursController::class, 'UploadIconPlus']);
        Route::post('/concours/addvideo', [ConcoursController::class, 'Addvideo'])->name('add.videos.concours');

        // ------ Quiz routes ----------------------------
        // routes/panel.php

        Route::get('/quizzes', 'QuizController@indexQuiz')->name('panel.teacher.quiz.index');
        Route::post('/quizzes/generate', 'QuizController@generate')->name('panel.quiz.upload');
        Route::get('/quizzes/edit/{id}', 'QuizController@editQuiz')->name('panel.quiz.edit');
        Route::post('/quizzes/add-question/{id}', 'QuizController@addGeneratedQuestion')->name('panel.quiz.add_question');
        Route::delete('/delete-question/{id}', 'QuizController@deleteQuestion')->name('panel.question.delete');
        Route::put('/quizzes/update/{id}', 'QuizController@updateQuiz')->name('panel.quiz.update');
        Route::get('/quizzes/drafts', 'QuizController@drafts')->name('panel.quiz.drafts');
        Route::post('/quizzes/update-title', 'QuizController@updateTitle')->name('panel.quiz.update.title');
        Route::delete('/quizzes/{id}', 'QuizController@destroy')->name('panel.quiz.destroy');
        Route::post('/quizzes/assign-to-chapter', 'QuizController@assignToChapter')->name('panel.quiz.assignToChapter');
        Route::post('/quizzes/delete', 'QuizController@delete')->name('panel.quiz.delete');

        // -----> Notification routes ---------------------------------------------------------
        Route::group(['prefix' => 'notifications'], function () {
            Route::get('/', 'NotificationsController@index');
            Route::get('/{id}/saveStatus', 'NotificationsController@saveStatus');
            Route::post('/mark-all-read', 'NotificationsController@markAllRead')->name('panel.notifications.markAllRead');
        });
        Route::group(['prefix' => 'webinars'], function () {
            Route::get('/', 'WebinarController@index');
            Route::get('/new', 'WebinarController@create');
            Route::post('/store', 'WebinarController@store');
            Route::get('/{id}/step/{step?}', 'WebinarController@edit');
            Route::get('/{id}/edit', 'WebinarController@edit')->name('panel_edit_webinar');
            Route::post('/{id}/update', 'WebinarController@update');
            Route::get('/{id}/delete', 'WebinarController@destroy');
            Route::get('/{id}/duplicate', 'WebinarController@duplicate');
            Route::post('/{id}/getContentItemByLocale', 'WebinarController@getContentItemByLocale');
            Route::get('/{id}/getNextSessionInfo', 'WebinarController@getNextSessionInfo');
            Route::group(['prefix' => '{webinar_id}/statistics'], function () {
                Route::get('/', 'WebinarStatisticController@index');
            });
        });
        Route::group(['prefix' => 'chapters'], function () {
            Route::get('/{id}', 'ChapterController@getChapter');
            Route::get('/getAllByWebinarId/{webinar_id}', 'ChapterController@getAllByWebinarId');
            Route::post('/store', 'ChapterController@store');
            Route::post('/{id}/update', 'ChapterController@update');
            Route::get('/{id}/delete', 'ChapterController@destroy');
            Route::post('/change', 'ChapterController@change');
        });

        Route::group(['prefix' => 'files'], function () {
            Route::post('/store', 'FileController@store');
            Route::post('/{id}/update', 'FileController@update');
            Route::get('/{id}/delete', 'FileController@destroy');
        });
    });

    Route::get('/getmaterialsforlevel', [DashboardController::class, 'getmaterialsforlevel']);
    Route::get('/get/{id}', 'DashboardController@getManuelBySMatiereId');
    Route::post('/store-teacher-id', [ManuelScolaireController::class, 'storeTeacherId']);

    // -----> Meeting routes ---------------------------------------------------------
    Route::group(['prefix' => 'meetings'], function () {
        Route::get('/reservation', 'ReserveMeetingController@reservation');
        Route::get('/requests', 'ReserveMeetingController@requests');
        Route::get('/getNextAndPreviousWeek', 'MeetingController@getNextAndPreviousWeek')->name('meeting_setting_weekly');
        Route::get('/settings', 'MeetingController@setting')->name('meeting_setting');
        Route::post('/{id}/update', 'MeetingController@update');
        Route::post('saveTime', 'MeetingController@saveTime');
        Route::post('deleteTime', 'MeetingController@deleteTime');
        Route::post('temporaryDisableMeetings', 'MeetingController@temporaryDisableMeetings');
        Route::get('/', 'DashboardController@allMeetingsChild')->name('panel.meeting.all');
        Route::get('/{id}/join', 'ReserveMeetingController@join');
        Route::post('/create-link', 'ReserveMeetingController@createLink');
        Route::get('/{id}/finish', 'ReserveMeetingController@finish');
    });

    // -----> Setting routes ---------------------------------------------------------
    Route::group(['prefix' => 'setting'], function () {
        Route::get('/step/{step?}', 'UserController@setting');
        Route::get('/', 'UserController@setting');
        Route::post('/', 'UserController@update');
        Route::get('/deleteAccount', 'UserController@deleteAccount');
    });

    // Route::group(['prefix' => 'users'], function () {
    //     Route::post('/search', 'UserController@search');
    //     Route::post('/contact-info', 'UserController@contactInfo');
    //     Route::post('/offlineToggle', 'UserController@offlineToggle');
    // });

    // Route::get('/scolaireall/{id}',[ManuelScolaireController::class, 'methode55']);
    // Route::get('/init/scolaire/{id}',[ManuelScolaireController::class, 'methodeinit']);
    // Route::get('/option/scolaire/{id}',[ManuelScolaireController::class, 'methodeoption']);
    // Route::get('/scolaire/teacher/{id}',[ManuelScolaireController::class, 'methode2']);
    // Route::get('/scolaire/view/teacher/{id}',[ManuelScolaireController::class, 'methode3']);
    // Route::get('/scolaire/icon/view/teacher/{id}',[ManuelScolaireController::class, 'methode4']);
});

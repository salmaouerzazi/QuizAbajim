@extends('web.default.layouts.app', ['appFooter' => false, 'appHeader' => false])

@push('styles_top')
    <link rel="stylesheet" href="/assets/default/learning_page/styles.css" />
    <link rel="stylesheet" href="/assets/default/vendors/video/video-js.min.css">
@endpush

@section('content')
    <div class="learning-page">
        @include('web.default.course.learningPage.components.navbar')
        <div class="d-flex align-items-center px-15 px-lg-35 py-10">
            <a href="/users/{{ $course->teacher->id }}/profile" class="d-flex align-items-center">
                <div class="teacher-avatar rounded-circle overflow-hidden">
                    <img src="{{ $course->teacher->getAvatar(100) }}" class="img-fluid"
                        alt="{{ $course->teacher->full_name }}" style="width: 50px; height: 50px;">
                </div>
                <div class="pr-35 py-10" style="padding-right: 15px!important;">
                    <h6 class="mb-0 font-weight-bold">{{ $course->teacher->full_name }}</h6>
                    <small class="text-gray">
                        <span id="followerCount_{{ $course->teacher->id }}">
                            {{ DB::table('teachers')->where('teacher_id', $course->teacher->id)->count() }}
                        </span>
                        {{ trans('panel.followers') }}
                    </small>
                </div>
            </a>
            @include('web.default.user.follow_user.follow_user', [
                'user_id' => $course->teacher->id,
            ])
        </div>
        <div class="d-flex position-relative">
            <div class="learning-page-tabs show">

                <div class="tab-content h-100" id="nav-tabContent">

                    <div class="pb-20 tab-pane fade show active h-100" id="content" role="tabpanel"
                        aria-labelledby="content-tab">
                        @include('web.default.course.learningPage.components.content_tab.index')
                    </div>

                    <div class="pb-20 tab-pane fade  h-100" id="quizzes" role="tabpanel" aria-labelledby="quizzes-tab">
                        @include('web.default.course.learningPage.components.quiz_tab.index')
                    </div>

                    <div class="pb-20 tab-pane fade  h-100" id="certificates" role="tabpanel"
                        aria-labelledby="certificates-tab">
                        @include('web.default.course.learningPage.components.certificate_tab.index')
                    </div>
                </div>
            </div>

            <div class="learning-page-content flex-grow-1 bg-info-light p-15">
                @include('web.default.course.learningPage.components.content')
            </div>
        </div>
    </div>
    <!-- ------------- UNFOLLOW MODAL ------------- -->
    <div class="modal fade" id="confirmUnfollowModal" tabindex="-1" aria-labelledby="confirmUnfollowModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title p-5" id="confirmUnfollowModalLabel">{{ trans('panel.confirm_unfollow') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ trans('panel.confirm_unfollow_desc') }}
                </div>
                <div class="modal-footer">
                    <form method="POST" action="" id="unfollowForm">
                        @csrf
                        <input type="hidden" id="unfollowUserId" name="user_id">
                        <button type="submit" class="btn btn-danger">{{ trans('panel.unfollow') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script src="/assets/default/vendors/video/video.min.js"></script>
    <script src="/assets/default/vendors/video/youtube.min.js"></script>
    <script src="/assets/default/vendors/video/vimeo.js"></script>

    <script>
        var defaultItemType = '{{ request()->get('type') }}'
        var defaultItemId = '{{ request()->get('item') }}'
        var loadFirstContent =
            {{ (!empty($dontAllowLoadFirstContent) and $dontAllowLoadFirstContent) ? 'false' : 'true' }}; // allow to load first content when request item is empty

        var courseUrl = '{{ $course->getUrl() }}';

        // lang
        var pleaseWaitForTheContentLang = '{{ trans('update.please_wait_for_the_content_to_load') }}';
        var downloadTheFileLang = '{{ trans('update.download_the_file') }}';
        var downloadLang = '{{ trans('home.download') }}';
        var showHtmlFileLang = '{{ trans('update.show_html_file') }}';
        var showLang = '{{ trans('update.show') }}';
        var sessionIsLiveLang = '{{ trans('update.session_is_live') }}';
        var youCanJoinTheLiveNowLang = '{{ trans('update.you_can_join_the_live_now') }}';
        var joinTheClassLang = '{{ trans('update.join_the_class') }}';
        var coursePageLang = '{{ trans('update.course_page') }}';
        var quizPageLang = '{{ trans('update.quiz_page') }}';
        var sessionIsNotStartedYetLang = '{{ trans('update.session_is_not_started_yet') }}';
        var thisSessionWillBeStartedOnLang = '{{ trans('update.this_session_will_be_started_on') }}';
        var sessionIsFinishedLang = '{{ trans('update.session_is_finished') }}';
        var sessionIsFinishedHintLang = '{{ trans('update.this_session_is_finished_You_cant_join_it') }}';
        var goToTheQuizPageForMoreInformationLang = '{{ trans('update.go_to_the_quiz_page_for_more_information') }}';
        var downloadCertificateLang = '{{ trans('update.download_certificate') }}';
        var enjoySharingYourCertificateWithOthersLang = '{{ trans('update.enjoy_sharing_your_certificate_with_others') }}';
        var attachmentsLang = '{{ trans('public.attachments') }}';
        var checkAgainLang = '{{ trans('update.check_again') }}';
        var learningToggleLangSuccess = '{{ trans('public.course_learning_change_status_success') }}';
        var learningToggleLangError = '{{ trans('public.course_learning_change_status_error') }}';
        var sequenceContentErrorModalTitle = '{{ trans('update.sequence_content_error_modal_title') }}';
        var sendAssignmentSuccessLang = '{{ trans('update.send_assignment_success') }}';
        var saveAssignmentRateSuccessLang = '{{ trans('update.save_assignment_grade_success') }}';
        var saveSuccessLang = '{{ trans('webinars.success_store') }}';
        var changesSavedSuccessfullyLang = '{{ trans('update.changes_saved_successfully') }}';
        var oopsLang = '{{ trans('update.oops') }}';
        var somethingWentWrongLang = '{{ trans('update.something_went_wrong') }}';
        var notAccessToastTitleLang = '{{ trans('public.not_access_toast_lang') }}';
        var notAccessToastMsgLang = '{{ trans('public.not_access_toast_msg_lang') }}';
        var cantStartQuizToastTitleLang = '{{ trans('public.request_failed') }}';
        var cantStartQuizToastMsgLang = '{{ trans('quiz.cant_start_quiz') }}';
        var learningPageEmptyContentTitleLang = '{{ trans('update.learning_page_empty_content_title') }}';
        var learningPageEmptyContentHintLang = '{{ trans('update.learning_page_empty_content_hint') }}';
    </script>
    <script type="text/javascript" src="https://www.dropbox.com/static/api/2/dropins.js" id="dropboxjs"
        data-app-key="v5gxvm7qj1ku9la"></script>
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>

    <script src="/assets/default/js/parts/video_player_helpers.min.js"></script>
    <script src="/assets/learning_page/scripts.min.js"></script>

    @if (!empty($isForumPage) and $isForumPage or !empty($isForumAnswersPage) and $isForumAnswersPage)
        <script src="/assets/learning_page/forum.min.js"></script>
    @endif
    <script>
        var unFollowLang = '{{ trans('panel.unfollow') }}';
        var followLang = '{{ trans('panel.follow') }}';
        var reservedLang = '{{ trans('meeting.reserved') }}';
        var messageSuccessSentLang = '{{ trans('site.message_success_sent') }}';
        var followersText = '{{ trans('panel.followers') }}';
    </script>
@endpush

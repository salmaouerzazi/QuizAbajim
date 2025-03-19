@extends(getTemplate() . '.panel.layouts.panel_layout')
<style>
    .panel-card {
        margin-top: 20px;
        padding: 20px;
    }

    .section-title {
        font-size: 1.5em !important;
        color: #1e3c65;
        padding: 10px 20px;
    }
</style>
@section('content')
    <section class="panel-card">
        <h2 class="section-title">{{ trans('panel.notifications') }}</h2>
        @if (!empty($notifications) and !$notifications->isEmpty())
            @foreach ($notifications as $notification)
                @php
                    $data = json_decode($notification->data, true);
                @endphp
                <div class="notification-card rounded-sm panel-shadow bg-white py-15 py-lg-20 px-15 px-lg-40 mt-20">
                    <div class="row align-items-center">
                        <div class="col-12 col-lg-3 mt-10 mt-lg-0 d-flex align-items-start">
                            @if (empty($notification->notificationStatus))
                                <span
                                    class="notification-badge badge badge-circle-danger mr-5 mt-5 d-flex align-items-center justify-content-center"></span>
                            @endif

                            <div>
                                <h3 class="notification-title font-16 font-weight-bold text-dark-blue">
                                    {{ trans($notification->title) }}
                                </h3>
                                <span
                                    class="notification-time d-block font-12 text-gray mt-5">{{ dateTimeFormat($notification->created_at, 'j M Y | H:i') }}</span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-5 mt-10 mt-lg-0">
                            <span class="font-weight-500 text-gray font-14">
                                {!! truncate(trans($notification->message, $data), 150, true) !!}
                            </span>
                        </div>

                        <div class="col-12 col-lg-4 mt-10 mt-lg-0 text-right">
                            <button type="button" data-id="{{ $notification->id }}"
                                id="showNotificationMessage{{ $notification->id }}"
                                class="js-show-message btn btn-border-white @if (!empty($notification->notificationStatus)) seen-at @endif">{{ trans('public.view') }}</button>
                            <input type="hidden" class="notification-message" value="{!! trans($notification->message, $data) !!}">
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="my-30">
                {{ $notifications->appends(request()->input())->links('vendor.pagination.panel') }}
            </div>
        @else
            @include(getTemplate() . '.includes.no-result', [
                'file_name' => 'webinar.png',
                'title' => trans('panel.notification_no_result'),
                'hint' => nl2br(trans('panel.notification_no_result_hint')),
            ])
        @endif
    </section>

    <div class="mt-5 d-none" id="messageModal">
        <div class="text-center">
            <h3 class="modal-title font-16 font-weight-bold text-dark-blue"></h3>
            <span class="modal-time d-block font-12 text-gray mt-5"></span>
            <span class="modal-message text-gray mt-20"></span>
        </div>
    </div>
@endsection

@push('scripts_bottom')
    <script>
        (function($) {
            "use strict";

            @if (!empty(request()->get('notification')))
                setTimeout(() => {
                    $('body #showNotificationMessage{{ request()->get('notification') }}').trigger('click');

                    let url = window.location.href;
                    url = url.split('?')[0];
                    window.history.pushState("object or string", "Title", url);
                }, 400);
            @endif
        })(jQuery)
    </script>

    <script src="/assets/default/js/panel/notifications.min.js"></script>
@endpush

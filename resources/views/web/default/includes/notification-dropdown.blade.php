<style>
    .navbar-notification-item {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
    }

    .notification-icon {
        background-color: #e9e9e9;
        border-radius: 50%;
        width: 40px;
        height: 40px;
    }

    .badge-notification {
        right: 22px;
        position: absolute !important;
    }

    .navbar-notification-title {
        color: #1e3c65;
        font-size: 1.2em;
        padding: 10px 20px;
    }

    .btn-transparent.active,
    .btn-transparent:active {
        background-color: #25bec8;
    }

    .btn-transparent.active .notification-bell,
    .btn-transparent:active .notification-bell {
        color: #fff;
    }
</style>


<div class="dropdown" dir="rtl" lang="ar">
    <button type="button" class="btn btn-transparent dropdown-toggle notification-icon" id="navbarNotification"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="far fa-bell notification-bell" style="font-size: 24px"></i>
        @if (!empty($unReadNotifications) && $unReadNotificationsCount)
            <span
                class="badge badge-circle-danger d-flex align-items-center justify-content-center badge-notification notification-count">
                {{ $unReadNotificationsCount }}
            </span>
        @endif
    </button>

    <div class="dropdown-menu pt-20" aria-labelledby="navbarNotification">
        <div class="d-flex flex-column h-100">
            <div class="mb-auto navbar-notification-card" data-simplebar>
                <h2 class="navbar-notification-title"> {{ trans('notification.notifications') }} </h2>
                <div class="border-bottom text-right"></div>
                
                @if (!empty($unReadNotifications))
                    @foreach ($unReadNotifications as $index => $unReadNotification)
                        <div class="navbar-notification-item">
                            <div class="d-flex" style="direction: {{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }};">
                                <div style="align-items: flex-start;">
                                    <div class="d-flex align-items-center mr-25">
                                        @if (empty($unReadNotification->notificationStatus))
                                            <span
                                                class="notification-badge badge badge-circle-danger d-flex align-items-center justify-content-center "
                                                style="margin-left: 15px"></span>
                                        @endif
                                        <div class="d-flex flex-column">
                                            @if (!empty($unReadNotification->title))
                                                <h5 class="font-14 font-weight-bold text-secondary">
                                                    {{ trans($unReadNotification->title, json_decode($unReadNotification->data, true)) }}
                                                </h5>
                                            @endif
                                            @if (!empty($unReadNotification->message))
                                                <div class="font-12 text-muted mb-2">
                                                    <p style="font-size: 14px">
                                                        {{ trans($unReadNotification->message, json_decode($unReadNotification->data, true)) }}
                                                    </p>
                                                </div>
                                            @endif

                                            <div class="d-flex justify-content-start">
                                                <span class="notification-time text-muted"
                                                    style="white-space: nowrap; font-size: 0.6em;">
                                                    {{ customTimeShort(\Carbon\Carbon::parse($unReadNotification->created_at)) }}
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if (!$loop->last)
                                <div class="dropdown-divider"></div>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="d-flex align-items-center text-center py-50">
                        <span>{{ trans('notification.empty_notifications') }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-10 navbar-notification-action">
                <a href="/panel/notifications" class="btn btn-sm btn-danger btn-block">
                    {{ trans('notification.all_notifications') }}
                </a>
            </div>
        </div>
    </div>

</div>

@push('scripts_bottom')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var bellButton = document.getElementById('navbarNotification');

            bellButton.addEventListener('click', function() {
                this.classList.toggle('active');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var bellButton = document.getElementById('navbarNotification');
            var notificationCountElem = document.querySelector('.notification-count');
            bellButton.addEventListener('click', function() {
                if (notificationCountElem && parseInt(notificationCountElem.innerText) > 0) {
                    $.ajax({
                        url: '{{ route('panel.notifications.markAllRead') }}',
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status === 'success') {
                                notificationCountElem.remove();
                                $('.notification-badge').remove();
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error marking all notifications as read:', error);
                        }
                    });
                }
            });
            feather.replace();
        });
    </script>
@endpush

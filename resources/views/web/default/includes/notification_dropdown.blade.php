<style>
    /* Styles pour les notifications */
    .notification-item {
        padding: 10px;
        border-radius: 8px;
        transition: all 0.2s ease;
        position: relative;
        margin-bottom: 4px;
    }
    .notification-item:hover {
        background-color: rgba(13, 110, 253, 0.05);
    }
    .notification-title {
        font-size: 14px;
        margin-bottom: 3px;
        color: #444;
    }
    .notification-message {
        font-size: 12px;
        color: #666;
        margin-bottom: 5px;
        line-height: 1.4;
    }
    .notification-action button {
        display: inline-flex;
        align-items: center;
        font-size: 12px;
        font-weight: 500;
        transition: all 0.15s ease;
        padding: 3px 8px !important;
        border-radius: 4px;
    }
    .notification-action button:hover {
        background-color: rgba(13, 110, 253, 0.1);
        transform: translateX(3px);
    }
    .notification-read {
        display: inline-flex;
        align-items: center;
        font-size: 12px;
        padding: 3px 8px;
        border-radius: 4px;
        background-color: rgba(25, 135, 84, 0.1);
    }
    .unread-indicator {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 4px;
        background-color: #0d6efd;
        border-radius: 50%;
    }
    .view-all-link {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 8px;
        border-radius: 6px;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 13px;
        background-color: rgba(13, 110, 253, 0.05);
    }
    .view-all-link:hover {
        background-color: rgba(13, 110, 253, 0.1);
        text-decoration: none;
    }
    .dropdown-divider {
        margin: 5px 0;
        opacity: 0.5;
    }
</style>

<div class="notifications-container">
    @foreach($notifications as $notif)
        <div class="dropdown-item notification-item d-flex flex-column position-relative">
            @if(!$notif->is_read)
                <div class="unread-indicator"></div>
            @endif
            <strong class="notification-title">{{ $notif->notification->title }}</strong>
            <small class="notification-message">{{ Str::limit($notif->notification->message, 60) }}</small>
            @if(!$notif->is_read)
                <div class="notification-action">
                    <form method="POST" action="{{ route('child.notifications.read', $notif->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-link text-primary p-0 mt-1">📖 Marquer comme lue</button>
                    </form>
                </div>
            @else
                <span class="notification-read text-success small">✅ Déjà lu</span>
            @endif
        </div>
        @if(!$loop->last)
            <div class="dropdown-divider"></div>
        @endif
    @endforeach

    @if(count($notifications) > 0)
        <div class="dropdown-divider"></div>
    @endif

    <div class="dropdown-item p-0 mt-2">
        <a href="{{ route('child.notifications.index') }}" class="text-primary view-all-link">📋 Voir toutes les notifications</a>
    </div>
</div>

@foreach($notifications as $notif)
    <div class="dropdown-item d-flex flex-column">
        <strong>{{ $notif->notification->title }}</strong>
        <small>{{ Str::limit($notif->notification->message, 60) }}</small>
        @if(!$notif->is_read)
            <form method="POST" action="{{ route('child.notifications.read', $notif->id) }}">
                @csrf
                <button class="btn btn-sm btn-link text-primary p-0 mt-1">📖 Marquer comme lue</button>
            </form>
        @else
            <span class="text-success small">✅ Déjà lu</span>
        @endif
    </div>
    <div class="dropdown-divider my-1"></div>
@endforeach
<div class="dropdown-item text-center mt-2">
    <a href="{{ route('child.notifications.index') }}" class="text-primary">📋 Voir toutes les notifications</a>
</div>

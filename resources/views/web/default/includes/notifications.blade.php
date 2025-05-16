<div class="notifications-box">
    <h4 class="mb-3">📩 الإشعارات</h4>

    <ul class="list-group" id="notificationsList">
        @foreach($notifications as $notif)
            <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $notif->notification->title }}</strong><br>
                    <small>{{ $notif->notification->message }}</small>
                </div>
                @if(!$notif->is_read)
                    <form method="POST" action="{{ route('child.notifications.read', $notif->id) }}">
                        @csrf
                        <button class="btn btn-sm btn-primary">📖 تم</button>
                    </form>
                @else
                    <span class="badge bg-success">✅ تمت قراءته</span>
                @endif
            </li>
        @endforeach
    </ul>
</div>

<script>
    Echo.private("child.{{ auth()->id() }}")
        .listen(".quiz.notification", (e) => {
            const list = document.getElementById("notificationsList");
            const li = document.createElement('li');
            li.className = "list-group-item d-flex justify-content-between align-items-center";
            li.innerHTML = `
                <div>
                    <strong>${e.notification.title}</strong><br>
                    <small>${e.notification.message}</small>
                </div>
                <span class="badge bg-warning">🆕 جديد</span>
            `;
            list.prepend(li);
        });
</script>

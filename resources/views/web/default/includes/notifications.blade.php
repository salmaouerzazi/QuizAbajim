@extends(getTemplate() . '.panel.layouts.panel_layout')

@section('content')
<div class="notifications-container">
    <div class="notifications-header">
        <h4 class="notifications-title"><i class="fas fa-bell swing"></i> الإشعارات</h4>
    </div>

    <div class="notifications-wrapper" id="notificationsWrapper">
        @if(count($notifications) > 0)
            <div class="notification-cards" id="notificationsList">
                @foreach($notifications as $notif)
                    <div class="notification-card @if(!$notif->is_read) unread @endif" 
                         style="animation: slideInDown 0.5s ease"
                         onclick="markAsReadAndRedirect('{{ route('child.notifications.read', $notif->id) }}', '{{ url('/course/learning/' . $notif->notification->quiz->model->webinar->slug) }}')">
                        <div class="notification-icon">
                            @if(!$notif->is_read)
                                <i class="fas fa-envelope"></i>
                            @else
                                <i class="fas fa-envelope-open"></i>
                            @endif
                        </div>
                        <div class="notification-content">
                            <h5 class="notification-title">{{ $notif->notification->title }}</h5>
                            <p class="notification-message">{{ Str::limit($notif->notification->message, 160) }}</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="notification-time">{{ $notif->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="notification-action">
                            @if(!$notif->is_read)
                                <button class="btn-read-notification" title="قراءة الإشعار">
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            @else
                                <div class="read-status">
                                    <i class="fas fa-check-double"></i> تمت القراءة
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-notifications">
                <div class="empty-icon">
                    <i class="far fa-bell-slash"></i>
                </div>
                <h5>لا توجد إشعارات حتى الآن</h5>
                <p>ستظهر الإشعارات الجديدة هنا</p>
            </div>
        @endif
    </div>
</div>

<style>
    .notifications-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 25px;
        transition: all 0.3s ease;
    }
    
    .notifications-container:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    
    .notifications-header {
        background: linear-gradient(135deg, #0d4483 0%, #2575fc 100%);
        padding: 15px 20px;
        text-align: center;
        border-radius: 15px 15px 0 0;
    }
    
    .notifications-title {
        color: white;
        margin: 0;
        font-size: 1.5rem;
        font-weight: 600;
    }
    
    .notifications-wrapper {
        padding: 15px;
        max-height: 500px;
        overflow-y: auto;
    }
    
    .notification-cards {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    
    .notification-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: flex-start;
        transition: all 0.3s ease;
        position: relative;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    }
    
    .notification-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }
    
    .notification-card.unread {
        border-right: 4px solid #2575fc;
        background: rgba(37, 117, 252, 0.05);
    }
    
    .notification-icon {
        min-width: 45px;
        height: 45px;
        border-radius: 50%;
        background: #f0f5ff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 15px;
        color: #2575fc;
        font-size: 1.2rem;
    }
    
    .notification-card.unread .notification-icon {
        background: #e0edff;
        animation: pulse 2s infinite;
    }
    
    .notification-content {
        flex: 1;
    }
    
    .notification-title {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
    }
    
    .notification-message {
        margin: 0 0 8px 0;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.4;
    }
    
    .notification-time {
        display: block;
        font-size: 0.8rem;
        color: #999;
    }
    
    .notification-action {
        margin-right: auto;
        align-self: center;
    }
    
    .btn-read-notification {
        background: none;
        border: none;
        color: #2575fc;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 5px;
    }
    
    .btn-read-notification:hover {
        transform: scale(1.2);
        color: #126383;
    }
    
    .read-status {
        font-size: 0.8rem;
        color: #28a745;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .empty-notifications {
        text-align: center;
        padding: 30px 15px;
        color: #666;
    }
    
    .empty-icon {
        font-size: 3rem;
        color: #ccc;
        margin-bottom: 15px;
    }
    
    .empty-notifications h5 {
        font-size: 1.2rem;
        margin-bottom: 10px;
        color: #555;
    }
    
    .empty-notifications p {
        color: #888;
        font-size: 0.9rem;
    }
    
    /* Animations */
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(37, 117, 252, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(37, 117, 252, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(37, 117, 252, 0);
        }
    }
    
    @keyframes slideInDown {
        from {
            transform: translateY(-30px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
    
    .swing {
        display: inline-block;
        animation: swing 2s infinite;
        transform-origin: top center;
    }
    
    @keyframes swing {
        20% {
            transform: rotate(8deg);
        }
        40% {
            transform: rotate(-8deg);
        }
        60% {
            transform: rotate(4deg);
        }
        80% {
            transform: rotate(-4deg);
        }
        100% {
            transform: rotate(0deg);
        }
    }
</style>

<script>
    // Fonction pour marquer une notification comme lue et rediriger vers le cours
    function markAsReadAndRedirect(postUrl, redirectUrl) {
        // Ajout d'un effet visuel avant la redirection
        const elem = event.currentTarget;
        elem.style.transform = 'scale(0.95)';
        elem.style.opacity = '0.8';
        
        // Effet sonore de clic
        try {
            const audio = new Audio('/assets/default/sounds/click.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => {}); // Ignore les erreurs si le son ne peut pas être joué
        } catch (e) {}
        
        // Empêcher la propagation pour éviter des clics multiples
        event.preventDefault();
        event.stopPropagation();
        
        // Envoyer la requête pour marquer comme lu
        fetch(postUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            credentials: 'same-origin'
        })
        .then(response => {
            if (response.ok) {
                // Rediriger vers la page du cours après un court délai pour montrer l'animation
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 300);
            } else {
                console.error('Erreur lors du marquage de la notification comme lue');
                // Rétablir l'apparence normale en cas d'erreur
                elem.style.transform = '';
                elem.style.opacity = '';
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            // Rétablir l'apparence normale en cas d'erreur
            elem.style.transform = '';
            elem.style.opacity = '';
        });
    }

    Echo.private("child.{{ auth()->id() }}")
        .listen(".quiz.notification", (e) => {
            const list = document.getElementById("notificationsList");
            
            // Create new notification card
            const card = document.createElement('div');
            card.className = "notification-card unread";
            card.style.animation = "slideInDown 0.5s ease";
            
            card.innerHTML = `
                <div class="notification-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="notification-content">
                    <h5 class="notification-title">${e.notification.title}</h5>
                    <p class="notification-message">${e.notification.message}</p>
                    <span class="notification-time">الآن</span>
                </div>
                <div class="notification-action">
                    <div class="read-status new-badge">
                        <i class="fas fa-star"></i> جديد
                    </div>
                </div>
            `;
            
            // Check if empty state exists and remove it
            const emptyState = document.querySelector('.empty-notifications');
            if (emptyState) {
                emptyState.remove();
                // Create notification list if it doesn't exist
                if (!list) {
                    const newList = document.createElement('div');
                    newList.id = "notificationsList";
                    newList.className = "notification-cards";
                    document.getElementById("notificationsWrapper").appendChild(newList);
                    newList.appendChild(card);
                }
            } else {
                // Add to existing list
                list.prepend(card);
            }
            
            // Play notification sound
            const audio = new Audio('/assets/default/sounds/notification.mp3');
            audio.play().catch(err => console.log('Notification sound could not be played', err));
        });
</script>

@endsection

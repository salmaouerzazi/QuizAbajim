<style>
    /* Styles pour le dropdown des notifications - Même style que notifications.blade.php */
    .notifications-dropdown {
        padding: 0;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        border: none;
        min-width: 320px;
        max-height: 450px;
        overflow-y: auto;
        background: linear-gradient(135deg, #f5f7fa 0%, #e4e8f0 100%);
        transition: all 0.3s ease;
    }
    
    .notifications-dropdown:hover {
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        transform: translateY(-5px);
    }
    
    .notifications-dropdown-header {
        background: linear-gradient(135deg, #0a4d6b 0%, #36b1cd 100%);
        padding: 15px 20px;
        border-radius: 15px 15px 0 0;
        text-align: center;
        position: sticky;
        top: 0;
        z-index: 10;
    }
    
    .notifications-dropdown-title {
        color: white;
        font-size: 1.2rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    
    .bell-icon {
        display: inline-block;
        animation: swing 2s infinite;
        transform-origin: top center;
    }
    
    .notifications-dropdown-body {
        padding: 15px;
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
        margin-bottom: 8px;
    }
    
    .notification-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        cursor: pointer;
    }
    
    .notification-card.unread {
        border-right: 4px solid #2575fc;
        background: rgba(37, 117, 252, 0.05);
    }
    
    .notification-icon {
        min-width: 35px;
        height: 35px;
        border-radius: 50%;
        background: #f0f5ff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-left: 12px;
        color: #2575fc;
        font-size: 1rem;
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
        font-size: 0.9rem;
        font-weight: 600;
        color: #333;
    }
    
    .notification-message {
        margin: 0 0 8px 0;
        font-size: 0.8rem;
        color: #666;
        line-height: 1.4;
    }
    
    .notification-time {
        display: block;
        font-size: 0.7rem;
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
        font-size: 1.2rem;
        cursor: pointer;
        transition: all 0.2s ease;
        padding: 5px;
    }
    
    .btn-read-notification:hover {
        transform: scale(1.2);
        color: #1a69aa;
    }
    
    .read-status {
        font-size: 0.75rem;
        color: #28a745;
        display: flex;
        align-items: center;
        gap: 5px;
    }
    
    .dropdown-divider {
        margin: 10px 0;
        opacity: 0.1;
        border-color: #1184cb;
    }
    
    .view-all-notifications {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 12px 15px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(17, 61, 95, 0.1) 0%, rgba(37, 117, 252, 0.1) 100%);
        color: #2575fc;
        font-weight: 500;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        text-decoration: none;
        margin-top: 10px;
    }
    
    .view-all-notifications:hover {
        background: linear-gradient(135deg, rgba(17, 126, 203, 0.15) 0%, rgba(37, 117, 252, 0.15) 100%);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(37, 117, 252, 0.1);
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
        font-size: 1.1rem;
        margin-bottom: 10px;
        color: #555;
    }
    
    .empty-notifications p {
        color: #888;
        font-size: 0.85rem;
    }
    
    .notification-badge {
        position: absolute;
        top: -6px;
        right: -6px;
        background: linear-gradient(135deg, #ff3e3e 0%, #ff7676 100%);
        color: white;
        border-radius: 50%;
        width: 20px;
        height: 20px;
        font-size: 0.7rem;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 3px 8px rgba(255, 62, 62, 0.4);
        animation: pulse 2s infinite;
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

@php
    $maxNotifications = 5; // Limite pour le dropdown
    $unreadCount = $notifications->where('is_read', false)->count();
@endphp

<div class="notifications-dropdown">
    <!-- En-tête du dropdown -->
    <div class="notifications-dropdown-header">
        <h5 class="notifications-dropdown-title">
            <span class="bell-icon"><i class="fas fa-bell"></i></span>
            الإشعارات
            
        </h5>
    </div>
    
    <!-- Corps du dropdown -->
    <div class="notifications-dropdown-body">
        @if($notifications->count() > 0)
            <div class="notification-cards">
                @foreach($notifications->take($maxNotifications) as $notif)
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
                            <p class="notification-message">{{ Str::limit($notif->notification->message, 60) }}</p>
                            
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

                    @if(!$loop->last)
                        <div class="dropdown-divider"></div>
                    @endif
                @endforeach
            </div>

            @if($notifications->count() > $maxNotifications)
                <div class="dropdown-divider"></div>
            @endif

            <a href="{{ route('child.notifications.index') }}" class="view-all-notifications">
                <i class="fas fa-clipboard-list"></i> عرض جميع الإشعارات ({{ $notifications->count() }})
            </a>
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

<script>
    function markAsReadAndRedirect(postUrl, redirectUrl) {
        // Ajout d'un effet visuel avant la redirection
        const elem = event.currentTarget;
        elem.style.transform = 'scale(0.95)';
        elem.style.opacity = '0.8';
        
        // Effet sonore de clic (optionnel)
        try {
            const audio = new Audio('/assets/default/sounds/click.mp3');
            audio.volume = 0.5;
            audio.play().catch(() => {}); // Ignore les erreurs si le son ne peut pas être joué
        } catch (e) {}
        
        // Envoyer la requête pour marquer comme lu
        fetch(postUrl, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({})
        })
        .then(() => {
            // Animation de transition avant la redirection
            setTimeout(() => {
                elem.style.transform = 'scale(0.8) translateY(-20px)';
                elem.style.opacity = '0';
                
                setTimeout(() => {
                    window.location.href = redirectUrl;
                }, 300);
            }, 100);
        })
        .catch((error) => {
            console.error('Erreur lors du marquage comme lu:', error);
            window.location.href = redirectUrl;
        });
        
        // Empêcher la propagation de l'événement
        event.preventDefault();
        event.stopPropagation();
    }
    
    // Observer pour les nouvelles notifications
    Echo.private("child.{{ auth()->id() }}")
        .listen(".quiz.notification", (e) => {
            // Vérifier s'il existe une liste de notifications
            let cardsContainer = document.querySelector('.notification-cards');
            const dropdownBody = document.querySelector('.notifications-dropdown-body');
            const emptyState = document.querySelector('.empty-notifications');
            
            // Créer le conteneur de cartes s'il n'existe pas
            if (!cardsContainer && dropdownBody) {
                // Supprimer l'état vide s'il existe
                if (emptyState) {
                    emptyState.remove();
                }
                
                cardsContainer = document.createElement('div');
                cardsContainer.className = 'notification-cards';
                dropdownBody.prepend(cardsContainer);
            }
            
            // Créer la nouvelle carte de notification
            const card = document.createElement('div');
            card.className = 'notification-card unread';
            card.style.animation = 'slideInDown 0.5s ease';
            
            // Générer l'URL pour marquer comme lu et rediriger
            const readUrl = `/panel/notifications/${e.notification.id}/read`;
            const redirectUrl = `/course/learning/${e.notification.quiz.model.webinar.slug}`;
            
            card.setAttribute('onclick', `markAsReadAndRedirect('${readUrl}', '${redirectUrl}')`);
            
            card.innerHTML = `
                <div class="notification-icon">
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="notification-content">
                    <h5 class="notification-title">${e.notification.title}</h5>
                    <p class="notification-message">${e.notification.message}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="notification-time">الآن</span>
                    </div>
                </div>
                <div class="notification-action">
                    <button class="btn-read-notification" title="قراءة الإشعار">
                        <i class="fas fa-check-circle"></i>
                    </button>
                </div>
            `;
            
            // Ajouter la nouvelle notification en haut de la liste
            if (cardsContainer) {
                // Si c'est la première notification, pas besoin de séparateur
                if (cardsContainer.children.length > 0) {
                    const divider = document.createElement('div');
                    divider.className = 'dropdown-divider';
                    cardsContainer.prepend(divider);
                }
                
                cardsContainer.prepend(card);
                
                // Mettre à jour le badge de notification dans la barre de navigation
                const navBadge = document.querySelector('.notification-bell .notification-badge');
                const navBellIcon = document.querySelector('.notification-bell .notification-icon');
                
                if (navBadge) {
                    // Mettre à jour le compteur existant
                    const count = parseInt(navBadge.textContent || '0') + 1;
                    navBadge.textContent = count;
                    navBadge.classList.add('pulse');
                    // S'assurer que le badge est visible
                    navBadge.style.display = 'flex';
                } else if (navBellIcon && navBellIcon.parentNode) {
                    // Créer un nouveau badge s'il n'existe pas
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notification-badge pulse';
                    newBadge.textContent = '1';
                    navBellIcon.parentNode.appendChild(newBadge);
                }
                
                // Ajouter le bouton "voir tout" s'il n'existe pas
                if (!document.querySelector('.view-all-notifications')) {
                    const viewAllLink = document.createElement('a');
                    viewAllLink.href = "{{ route('child.notifications.index') }}";
                    viewAllLink.className = 'view-all-notifications';
                    viewAllLink.innerHTML = '<i class="fas fa-clipboard-list"></i> عرض جميع الإشعارات';
                    dropdownBody.appendChild(viewAllLink);
                }
            }
            
            // Le son de notification est géré par navbarPannelEnfant.blade.php
        });
</script>

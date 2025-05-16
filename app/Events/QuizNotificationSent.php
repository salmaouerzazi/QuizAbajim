<?php

namespace App\Events;

use App\QuizNotificationUsers;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class QuizNotificationSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notificationUser;

    /**
     * Crée un nouvel événement de broadcast
     */
    public function __construct(QuizNotificationUsers $notificationUser)
    {
        $this->notificationUser = $notificationUser;
    }

    /**
     * Canal sur lequel l’événement est broadcasté
     */
    public function broadcastOn()
    {
        return new PrivateChannel('child.' . $this->notificationUser->receiver_id);
    }

    /**
     * Données envoyées au client frontend
     */
    public function broadcastWith()
    {
        return [
            'notification' => $this->notificationUser->load('notification')
        ];
    }

    /**
     * Nom personnalisé de l’événement côté frontend
     */
    public function broadcastAs()
    {
        return 'quiz.notification';
    }
}

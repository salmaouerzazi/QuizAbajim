<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\BroadcastMessage;


class NewQuizNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $quiz;

    public function __construct($quiz)
    {
        $this->quiz = $quiz;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'quiz_id' => $this->quiz->id,
            'title' => '📝 Quiz ajouté',
            'message' => "Un nouveau quiz « {$this->quiz->title} » dans la matière « {$this->quiz->material->name} » par {$this->quiz->teacher->full_name}.",
            'sender_id' => $this->quiz->teacher->id,
            'receiver_id' => $notifiable->id,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'data' => $this->toArray($notifiable),
        ]);
    }
}

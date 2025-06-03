<?php

namespace App;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Quiz;
use App\QuizNotificationUsers;

use Illuminate\Database\Eloquent\Model;

class QuizNotification extends Model
{
    protected $table = 'quiz_notifications';

    protected $fillable = [
        'title',
        'message',
        'quiz_id',
        'sender_type',
        'sender_id',
        'target_type',
        'receiver_id',
    ];

    // 🔁 Notification envoyée à plusieurs enfants (relation avec la table pivot)
    //  Notification envoyée à plusieurs enfants (relation avec la table pivot)
    public function receivers(): HasMany
    {
        return $this->hasMany(QuizNotificationUsers::class, 'notification_id');
    }

    // 🔁 Notification envoyée à un seul enfant (cas single)
    //  Notification envoyée à un seul enfant (cas single)
    public function singleReceiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }


    // 🔁 Émetteur (admin ou système)

    //  Émetteur (admin ou système)
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // 🔁 Quiz associé
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
}
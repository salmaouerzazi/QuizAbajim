<?php

namespace App;
use App\QuizNotification;
use App\User;

use Illuminate\Database\Eloquent\Model;

class QuizNotificationUsers extends Model
{
    protected $table = 'quiz_notifications_users';

    protected $fillable = [
        'notification_id',
        'receiver_id',
        'is_read',
    ];

    public function notification()
    {
        return $this->belongsTo(QuizNotification::class, 'notification_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}


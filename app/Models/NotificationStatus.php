<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationStatus extends Model
{
    protected $table = 'notifications_status';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];

    public function notification()
    {
        return $this->belongsTo('App\Models\Notification', 'notification_id', 'id');
    }
}

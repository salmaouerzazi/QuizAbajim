<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingTime extends Model
{

    public static $open = "open";
    public static $finished = "finished";
    protected $dateFormat = 'U';

    protected $guarded = ['id'];

    public function meeting()
    {
        return $this->belongsTo('App\Models\Meeting', 'meeting_id', 'id');
    }
    public function level()
    {
        return $this->belongsTo('App\Models\School_level', 'level_id', 'id');
    }
    public function material()
    {
        return $this->belongsTo('App\Models\Material', 'matiere_id', 'id');
    }
    public function reservations()
    {
        return $this->hasMany('App\Models\ReserveMeeting', 'meeting_time_id', 'id');
    }
}

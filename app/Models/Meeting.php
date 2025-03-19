<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public $timestamps = false;

    protected $guarded = ['id'];

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id', 'id');
    }

    public function meetingTimes()
    {
        return $this->hasMany('App\Models\MeetingTime', 'meeting_id', 'id');
    }
    public function getTimezone()
    {
        $timezone = getGeneralSettings('default_time_zone');

        $user = $this->teacher;

        if (!empty($user) and !empty($user->timezone)) {
            $timezone = $user->timezone;
        }

        return $timezone;
    }

}

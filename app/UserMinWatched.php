<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserMinWatched extends Model
{
    protected $dateFormat  = 'U';
    protected $table = 'user_min_watched';

    protected $fillable = [
        'user_id',
        'minutes_watched',
        'latest_watched_day',
        'minutes_watched_day'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

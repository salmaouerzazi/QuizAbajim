<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribeAccessDay extends Model
{
    protected $table = 'subscribe_access_day';

    // Define the fillable attributes
    protected $fillable = [
        'subscribe_id',
        'access_date',
    ];

    // Define relationships (if needed)
    public function subscribe()
    {
        return $this->belongsTo(Subscribe::class, 'subscribe_id');
    }
}

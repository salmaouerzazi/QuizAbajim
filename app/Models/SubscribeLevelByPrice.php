<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscribeLevelByPrice extends Model
{
    protected $table = 'subscribe_level_by_price';

    // Define the fillable attributes
    protected $fillable = [
        'subscribe_id',
        'level_id',
        'price',
    ];

    // Define relationships (if needed)
    public function subscribe()
    {
        return $this->belongsTo(Subscribe::class, 'subscribe_id');
    }

    public function schoolLevel()
    {
        return $this->belongsTo(SchoolLevel::class, 'level_id');
    }
}

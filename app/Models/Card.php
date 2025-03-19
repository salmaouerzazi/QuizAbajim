<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\School_level;
use App\Models\Subscribe;

class Card extends Model
{
    protected $dateFormat = 'U';

    protected $fillable = [
        'card_key',
        'reference',
        'status',
        'level_id',
        'subscribe_id',
        'expires_in',
        'is_used',
        'is_printed',
        'created_at',
        'updated_at',
    ];

    public function level()
    {
        return $this->belongsTo(School_level::class, 'level_id');
    }

    public function subscribe()
    {
        return $this->belongsTo(Subscribe::class, 'subscribe_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoConcour extends Model
{
    protected $table = 'video_concours';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
}

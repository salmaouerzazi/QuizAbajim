<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    public static $requested = "requested";
    public static $accepted = "accepted";
    public static $rejected = "rejected";
    
    public $timestamps = true;

    protected $guarded = ['id'];
    
    public function followerUser()
    {
        return $this->belongsTo('App\User', 'follower');
    }
}

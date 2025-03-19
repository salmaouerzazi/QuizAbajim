<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Subscribe;

class School_level extends Model
{
    protected $fillable = [
        'id',
         'name'

     ];
     public function subscribes()
     {
         return $this->belongsToMany(Subscribe::class, 'subscribe_level_by_price', 'level_id', 'subscribe_id')
                     ->withPivot('price');
     }
    public function sectionsmat(){
        return $this->hasMany(SectionMat::class, 'level_id');
    }

    public function webinars(){
        return $this->hasMany(Webinar::class, 'level_id');
    }

}

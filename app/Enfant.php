<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\School_level;
use App\User;

class Enfant extends Model
{
    
    protected $table = 'enfant';
    protected $foreignKeys = [
        'level_id' => 'level_id', 
    ];
    protected $fillable = [
       'id',
       'nom',
       'prenom',
       'sexe',
       'level_id',
       'parent_id',
       'user_id',
       'path'
    ];
    public function level()
    {
        return $this->belongsTo(School_level::class, $this->foreignKeys['level_id'], 'id');
    }
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'organ_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

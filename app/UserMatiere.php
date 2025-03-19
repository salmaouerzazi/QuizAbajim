<?php

namespace App;

use App\Models\Material;
use App\Models\School_level;
use Illuminate\Database\Eloquent\Model;

class UserMatiere extends Model
{
    protected $table = 'user_matiere';

    protected $fillable = [
       'matiere_id',
       'teacher_id',
        'level_id',
    ];

    public function matiere()
    {
        return $this->belongsTo(Material::class, 'matiere_id');
    }

    public function level()
    {
        return $this->belongsTo(School_level::class, 'level_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School_level;

class SectionMat extends Model
{
    protected $table = 'sectionsmat';
    protected $foreignKeys = [
        'level_id' => 'level_id',
    ];

    protected $fillable = [
        'id',
        'name',
        'level_id',
    ];
    public function level()
    {
        return $this->belongsTo(School_level::class, $this->foreignKeys['level_id'], 'id');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'section_id', 'id');
    }
}

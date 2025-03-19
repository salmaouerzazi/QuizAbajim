<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SectionMat;
use App\Models\Concours;

class Material extends Model
{
    public $table = 'materials';
    protected $foreignKeys = [
        'section_id' => 'section_id',
    ];

    protected $fillable = [
        'id',
        'name',
        'section_id',
        'path'

     ];
     public function concours()
     {
         return $this->hasMany(Concours::class);
     }
     public function section()
     {
         return $this->belongsTo(SectionMat::class, $this->foreignKeys['section_id'], 'id');
     }

     public function manuels()
     {
         return $this->hasMany(Manuels::class, 'material_id');
     }
     public function webinars()
     {
         return $this->hasMany(Webinar::class, 'matiere_id');
     }
     public function submaterials()
     {
         return $this->hasMany(Submaterial::class);
     }
     

}

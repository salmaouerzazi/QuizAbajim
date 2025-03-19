<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\School_level;
class Option extends Model
{
    protected $foreignKeys = [
        'niveau' => 'niveau', 
    ];
    protected $fillable = [
        'id',
         'name',
         'niveau',
         'logo',
         'pdf',
         'video'
         
 
     ];
     public function level()
     {
         return $this->belongsTo(School_level::class, $this->foreignKeys['niveau'], 'id');
     }
}

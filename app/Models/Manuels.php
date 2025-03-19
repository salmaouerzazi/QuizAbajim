<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
use App\Models\Document;
use App\Models\Video;
class Manuels extends Model
{
    public $table = 'manuels';
    protected $foreignKeys = [
        'material_id' => 'material_id', 
        'manuel_id' => 'manuel_id', 

    ];
    
 
    protected $fillable = [
        'id',
       'name',
       'logo',
       'material_id',
       'matiereps_id',
    ];
    public function matiere()
    {
        return $this->belongsTo(Material::class, $this->foreignKeys['material_id'], 'id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class, $this->foreignKeys['manuel_id'], 'id');
    }
    public function videos()
    {
        return $this->hasMany(Video::class, 'manuel_id'); // Assuming 'manuel_id' is the foreign key in the videos table
    }
}

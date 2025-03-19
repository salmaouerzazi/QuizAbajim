<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'id',
        'name',
        'nombre_page',
        'pdf',
        'manuel_id',   
        '3d_path_teacher',
        '3d_path_enfant'
    ];
}

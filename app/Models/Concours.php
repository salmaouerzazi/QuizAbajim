<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Material;
class Concours extends Model
{
    protected $table = 'concours';
    public $timestamps = false;
    protected $dateFormat = 'U';
    protected $guarded = ['id'];
    public function material()
    {
        return $this->belongsTo(Material::class);
    }

}

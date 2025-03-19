<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submaterial extends Model
{

    protected $fillable = ['material_id', 'name'];

    /**
     * Relationship with Material.
     */

    public function material()
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Relationship with Webinar.
     */

    public function webinars()
    {
        return $this->hasMany(Webinar::class, 'submaterial_id');
    }
}

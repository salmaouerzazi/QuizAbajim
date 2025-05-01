<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use SoftDeletes;
use App\Models\School_level;
use App\Models\Material;
use App\User;

class Quiz extends Model
{
    protected $dateFormat = 'U';
    

    public $timestamps = false;
    protected $table = 'quiz';
    protected $guarded = ['id'];

    protected $fillable = ['title','status','model_type', 'model_id', 'level_id', 'material_id', 'question_count', 'pdf_path', 'teacher_id', 'created_by', 'updated_by',  'text_content',];

    /**
     * Relationship with Level
     */
    public function level(){
        return $this->belongsTo(School_level::class);
    }

    /**
     * Relationship with Material
     */
    public function material(){
        return $this->belongsTo(Material::class);
    }
    /**
     * Relationship with Teacher
     */
    public function teacher(){
        return $this->belongsTo(User::class);
    }
    
    /**
     * Relationship with Question
     */
    public function questions(){
        return $this->hasMany(Question::class);
    }

    
    

    /**
     * Relationship with model
     */
    public function model(){
        return $this->morphTo();
    }    

}

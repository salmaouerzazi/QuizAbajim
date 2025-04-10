<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;

class Question extends Model
{
    protected $table = 'questions';
    protected $guarded = ['id'];

    protected $fillable = [
        'quiz_id',
        'type',
        'is_valid',
        'question_text',
        'score'
    ];

    /**
     *  relationship A question can have many possible quiz
     */
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
    /**
     *  relationship A question can have many possible answers
    */
    public function answers()
    {
    return $this->hasMany(Answer::class);
    }

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Answer extends Model
{
    protected $table = 'answers';

    protected $fillable = [
        'question_id',
        'answer_text',
        'is_valid',
    ];

    /**
     * Relation one to one with Question
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}

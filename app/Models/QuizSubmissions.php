<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Quiz;
use App\Models\Question;
use App\Models\Answer;
use App\Models\QuizAttemptScore;

use App\User;

class QuizSubmissions extends Model
{
    protected $table = 'quiz_submissions';

    protected $fillable = [
        'quiz_id',
        'child_id',
        'attempt_id',
        'question_id',
        'answer_id',
        'is_valid',
        'is_boolean_question',
        'arrow_mapping',
    ];

    protected $casts = [
        'is_valid' => 'boolean',
        'is_boolean_question' => 'boolean',
        'arrow_mapping' => 'array', // pour décoder automatiquement le JSON en tableau
    ];

    // Relations
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class);
    }

    public function attempt()
    {
        return $this->belongsTo(QuizAttemptScore::class, 'attempt_id');
    }

    public function child()
    {
        return $this->belongsTo(User::class, 'child_id');
    }
}
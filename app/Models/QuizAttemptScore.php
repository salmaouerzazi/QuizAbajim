<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use SoftDeletes;
use App\Models\quiz;
use App\User;
use App\Models\QuizSubmissions;

class QuizAttemptScore extends Model
{   
    protected $table = 'quiz_attempt_scores';
    protected $fillable = [
        'quiz_id', 'child_id','attempt_number',  'score', 'score_total', 'submitted_at'
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function child()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmissions::class, 'attempt_id');
    }
}

<?php

namespace App\Models;

use SoftDeletes;
use App\Models\quiz;
use App\User;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    protected $table = 'quiz_submissions'; 

    protected $fillable = ['quiz_id', 'child_id', 'score', 'submitted_at'];

    // Relations 
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function child()
    {
        return $this->belongsTo(User::class);
    }
}

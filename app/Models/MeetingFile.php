<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingFile extends Model
{

    public $timestamps = false;
    protected $dateFormat = 'U';

    protected $fillable = [
        'meeting_id',
        'file_path',
        'created_at',
        'updated_at',
    ];

    public function meeting()
    {
        return $this->belongsTo(Meeting::class, 'meeting_id');
    }
}

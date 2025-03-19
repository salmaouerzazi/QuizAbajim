<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use App\Models\School_level;

class PaymentProof extends Model
{
    use SoftDeletes;

    protected $table = 'payment_proofs';

    protected $fillable = [
        'image', 'user_id', 'status', 'note', 'approved_by', 'level_id'
    ];

    protected $dates = ['deleted_at'];

    protected $dateFormat = 'U';

    /**
     * PaymentProof belongs to a User
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Approved by a User
     */
    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * PaymentProof belongs to a Level
     */
    public function level()
    {
        return $this->belongsTo(School_level::class, 'level_id');
    }
    
}

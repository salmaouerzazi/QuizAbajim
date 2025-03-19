<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\School_level;
use App\User;
class CardReservation extends Model
{
    
    protected $fillable = [
        'name', 
        'address',
        'city', 
        'user_id', 
        'level_id', 
        'enfant_id', 
        'phone_number', 
        'status',
        'rejection_note',
    ];

    const STATUS_WAITING = 'waiting';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';
    const STATUS_IN_DELIVERY = 'in_delivery';
    const STATUS_DELIVERED = 'delivered';

    public static function getStatuses()
    {
        return [
            self::STATUS_WAITING,
            self::STATUS_APPROVED,
            self::STATUS_IN_DELIVERY,
            self::STATUS_DELIVERED,
            self::STATUS_REJECTED,
        ];
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function level()
    {
        return $this->belongsTo(School_level::class, 'level_id');
    }

}

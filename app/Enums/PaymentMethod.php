<?php 
namespace App\Enums;
abstract class PaymentMethod
{
    const CARD = 'card';
    const ONLINE = 'online';
    const BALANCE = 'balance';

    public static function toArray(): array
    {
        return [
            self::CARD,
            self::ONLINE,
            self::BALANCE,
        ];
    }
}

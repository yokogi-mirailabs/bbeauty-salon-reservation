<?php

namespace App\Enums;

enum ReservationTimeType: int
{
    case FIRST = 1;
    case SECOND = 2;
    case THIRD = 3;
    case FOURTH = 4;
    case FIFTH = 5;
    case SIXTH = 6;
    case SEVENTH = 7;
    case EIGHTH = 8;
    case NINTH = 9;
    case TENTH = 10;

    /**
     * 名称を取得する
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::FIRST => '10:00~11:00',
            self::SECOND => '11:00~12:00',
            self::THIRD => '12:00~13:00',
            self::FOURTH => '13:00~14:00',
            self::FIFTH => '14:00~15:00',
            self::SIXTH => '15:00~16:00',
            self::SEVENTH => '16:00~17:00',
            self::EIGHTH => '17:00~18:00',
            self::NINTH => '18:00~19:00',
            self::TENTH => '19:00~20:00',
        };
    }
}

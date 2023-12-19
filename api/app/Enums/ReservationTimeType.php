<?php

namespace App\Enums;

enum ReservationTimeType: int
{
    case STSRT_TEN = 1;
    case START_ELEVEN = 2;
    case START_TWELVE = 3;
    case START_THIRTEEN = 4;
    case START_FOURTEEN = 5;
    case START_FIFTEEN = 6;
    case START_SIXTEEN = 7;
    case START_SEVENTEEN = 8;
    case START_EIGHTEEN = 9;
    case START_NINETEEN = 10;
    case START_TWENTY = 11;
    case START_TWENTY_ONE = 12;
    case START_TWENTY_TWO = 13;

    /**
     * 名称を取得する
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::STSRT_TEN => '10:00:00',
            self::START_ELEVEN => '11:00:00',
            self::START_TWELVE => '12:00:00',
            self::START_THIRTEEN => '13:00:00',
            self::START_FOURTEEN => '14:00:00',
            self::START_FIFTEEN => '15:00:00',
            self::START_SIXTEEN => '16:00:00',
            self::START_SEVENTEEN => '17:00:00',
            self::START_EIGHTEEN => '18:00:00',
            self::START_NINETEEN => '19:00:00',
            self::START_TWENTY => '20:00:00',
            self::START_TWENTY_ONE => '21:00:00',
            self::START_TWENTY_TWO => '22:00:00',
        };
    }
}

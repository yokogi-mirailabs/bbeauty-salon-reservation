<?php

namespace App\Enums;

enum JobPostType: int
{
    case NO_POSITION = 0;
    case SUB_MANAGER = 1;
    case MANAGER = 2;

    /**
     * 名称を取得する
     */
    public function getLabel(): string
    {
        return match ($this) {
            self::NO_POSITION => '一般店員',
            self::SUB_MANAGER => '副店長',
            self::MANAGER => '店長',
        };
    }
}

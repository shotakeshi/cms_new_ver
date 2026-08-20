<?php

namespace App\Enums;

enum DefaultStatus: int
{
    case INACTIVE = 0;
    case ACTIVE = 1;

    public function getName(): string
    {
        return match ($this) {
            self::INACTIVE => __('site.status.inactive'),
            self::ACTIVE => __('site.status.active')
        };
    }

    public function getClass(): string{
        return match ($this) {
            self::INACTIVE => 'badge badge-soft-danger p-2',
            self::ACTIVE => 'badge badge-soft-primary p-2',
        };
    }
}

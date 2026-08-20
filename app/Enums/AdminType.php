<?php

namespace App\Enums;

enum AdminType: string
{
    case NORMAL = 'normal';
    case ROOT = 'root';

    public function getName(): string
    {
        return match ($this) {
            self::NORMAL => __('site.admin.type.normal'),
            self::ROOT => __('site.admin.type.root')
        };
    }

    public function getClass(): string{
        return match ($this) {
            self::NORMAL => 'badge badge-soft-info p-2',
            self::ROOT => 'badge badge-soft-primary p-2'
        };
    }
}

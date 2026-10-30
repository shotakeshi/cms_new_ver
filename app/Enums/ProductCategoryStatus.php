<?php

namespace App\Enums;

enum ProductCategoryStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case PENDING = 'pending';
    case ARCHIVED = 'archived';


    public function getName(): string
    {
        return __('site.product_category_status.'. $this->value);
    }

    public function getClass(): string{
        return match ($this) {
            self::ACTIVE => 'badge badge-soft-primary p-2',
            self::INACTIVE => 'badge badge-soft-danger p-2',
            self::PENDING => 'badge badge-soft-warning p-2',
            self::ARCHIVED=> 'badge badge-soft-pink p-2',
        };
    }

    public static function options(): array
    {
        return collect([
            self::ACTIVE,
            self::INACTIVE,
            self::PENDING,
            self::ARCHIVED,
        ])
            ->map(fn (self $status) => [
                'value' => $status->value,
                'label' => $status->getName(),
            ])
            ->values()
            ->toArray();
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

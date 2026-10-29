<?php

namespace App\Enums;

enum ProductStatus: string
{
    case DRAFT = 'draft'; // Not ready to publish.
    case PENDING = 'pending'; // Waiting for review before publishing.
    case SCHEDULE = 'schedule'; // Publish automatically on a chosen date.
    case PUBLISH = 'published';

    public function getName(): string
    {
        return match ($this) {
            self::DRAFT => __('site.status.draft'),
            self::PENDING => __('site.status.pending'),
            self::SCHEDULE => __('site.status.schedule'),
            self::PUBLISH => __('site.status.publish')
        };
    }

    public function getClass(): string{
        return match ($this) {
            self::DRAFT => 'badge badge-soft-danger p-2',
            self::PENDING => 'badge badge-soft-warning p-2',
            self::SCHEDULE => 'badge badge-soft-pink p-2',
            self::PUBLISH => 'badge badge-soft-primary p-2'
        };
    }

    public static function options(): array
    {
        return collect([
            self::DRAFT,
            self::SCHEDULE,
            self::PUBLISH,
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

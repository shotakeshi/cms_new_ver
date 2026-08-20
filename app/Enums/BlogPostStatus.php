<?php

namespace App\Enums;

enum BlogPostStatus: string
{
    case DRAFT = 'draft'; // Not ready to publish.
    case PENDING = 'pending'; // Waiting for review before publishing.
    case PRIVATED = 'private'; // Only visible to site admins and editors.
    case SHEDULED = 'schedule'; // Publish automatically on a chosen date.
    case PUBLISHED = 'published';

    public function getName(): string
    {
        return match ($this) {
            self::DRAFT => __('site.status.draft'),
            self::PENDING => __('site.status.pending'),
            self::PRIVATED => __('site.status.private'),
            self::SHEDULED => __('site.status.schedule'),
            self::PUBLISHED => __('site.status.publish')
        };
    }

    public function getClass(): string{
        return match ($this) {
            self::DRAFT => 'badge badge-soft-danger p-2',
            self::PENDING => 'badge badge-soft-warning p-2',
            self::PRIVATED => 'badge badge-soft-success p-2',
            self::SHEDULED => 'badge badge-soft-danger p-2',
            self::PUBLISHED => 'badge badge-soft-primary p-2'
        };
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

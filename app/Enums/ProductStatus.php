<?php

namespace App\Enums;

enum ProductStatus: string
{
    case DRAFT = 'draft'; // Sản phẩm đang soạn thảo.
    case PENDING = 'pending'; // Chờ phê duyệt.
    case APPROVED = 'approved'; // Đã được phê duyệt.
    case ACTIVE = 'active'; // Đang kinh doanh.
    case INACTIVE = 'inactive'; // Tạm ngừng kinh doanh.
    case OUT_OF_STOCK = 'out_of_stock'; // Hết hàng
    case DISCONTINUED = 'discontinued'; // Ngừng kinh doanh vĩnh viễn
    case ARCHIVED = 'archived'; //Đã lưu trữ.

    public function getName(): string
    {
        return __('site.product_status.'. $this->value);
    }

    public function getClass(): string{
        return match ($this) {
            self::DRAFT => 'badge badge-soft-danger p-2',
            self::PENDING => 'badge badge-soft-warning p-2',
            self::APPROVED => 'badge badge-soft-success p-2',
            self::ACTIVE => 'badge badge-soft-success p-2',
            self::INACTIVE => 'badge badge-soft-success p-2',
            self::OUT_OF_STOCK => 'badge badge-soft-success p-2',
            self::DISCONTINUED => 'badge badge-soft-success p-2',
            self::ARCHIVED => 'badge badge-soft-success p-2',
        };
    }

    public static function options(): array
    {
        return collect([
            self::DRAFT,
            self::PENDING,
            self::APPROVED,
            self::ACTIVE,
            self::INACTIVE,
            self::OUT_OF_STOCK,
            self::DISCONTINUED,
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

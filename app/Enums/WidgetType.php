<?php

namespace App\Enums;

enum WidgetType: string
{
    case BANNER = 'banner';
    case TEXT = 'text';
    case BUTTON = 'button';
    case GALLERY = 'gallery';
    case CONTACT = 'contact';
    case HTML = 'html';
    case SLIDER = 'slider';
    case BLOCK = 'block';
    case BLOCKS = 'blocks';

    public function label(): string
    {
        return __('site.widget.types.'.$this->value);
    }

    public function icon(): string
    {
        return match ($this) {
            self::BANNER => 'far fa-image',
            self::TEXT => 'far fa-file-alt',
            self::BLOCK => 'far fa-file',
            self::BLOCKS => 'far fa-file-alt',
            self::BUTTON => 'far fa-hand-pointer',
            self::GALLERY => 'far fa-images',
            self::CONTACT => 'far fa-address-card',
            self::HTML => 'far fa-file-code',
            self::SLIDER => 'far fa-image',
        };
    }

    public function description(): string
    {
        return __('site.widget.type_descriptions.'.$this->value);
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn (self $type) => [
                $type->value => $type->label(),
            ])
            ->toArray();
    }
}

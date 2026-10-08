<?php

namespace App\Enums;

enum WidgetType: string
{
    case BANNER = 'banner';
    case TEXT = 'text';
    case IMAGE = 'image';
    case BUTTON = 'button';
    case BLOG_POSTS = 'blog_posts';
    case GALLERY = 'gallery';
    case CONTACT = 'contact';
    case HTML = 'html';
    case SLIDER = 'slider';
    case BLOCK = 'block';
    case BLOCKS = 'blocks';

    public function label(): string
    {
        return match ($this) {
            self::BANNER => 'Banner',
            self::TEXT => 'Text',
            self::BLOCK => 'Block',
            self::BLOCKS => 'Blocks',
            self::IMAGE => 'Image',
            self::BUTTON => 'Button',
            self::BLOG_POSTS => 'Blog Posts',
            self::GALLERY => 'Gallery',
            self::CONTACT => 'Contact',
            self::HTML => 'HTML',
            self::SLIDER => 'Slider',
        };
    }

    public function icon(): string
    {
        return match ($this) {
            self::BANNER => 'far fa-image',
            self::TEXT => 'far fa-file-alt',
            self::BLOCK => 'far fa-file',
            self::BLOCKS => 'far fa-file-alt',
            self::IMAGE => 'far fa-image',
            self::BUTTON => 'far fa-hand-pointer',
            self::BLOG_POSTS => 'far fa-newspaper',
            self::GALLERY => 'far fa-images',
            self::CONTACT => 'far fa-address-card',
            self::HTML => 'far fa-file-code',
            self::SLIDER => 'far fa-image',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::BANNER => 'Banner or promotional section.',
            self::TEXT => 'Simple text content block.',
            self::BLOCK => 'Simple text content block.',
            self::BLOCKS => 'Simple text contents blocks.',
            self::IMAGE => 'Display an image.',
            self::BUTTON => 'Call-to-action button.',
            self::BLOG_POSTS => 'Display a list of blog posts.',
            self::GALLERY => 'Display an image gallery.',
            self::CONTACT => 'Contact information or contact form.',
            self::HTML => 'Custom HTML content.',
            self::SLIDER => 'Custom Slider',
        };
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
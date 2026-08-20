<?php

namespace App\Enums;

enum SettingType : string
{
    case GENERAL = 'general';
    case WEBSITE_TRACKING = 'website-tracking';
    case SEO_CONFIG = 'seo-config';
    case SEO_API = 'api';

    /**
     * @return string
     */
    public function getName(): string
    {
        return match ($this) {
            self::GENERAL => 'General Information',
            self::WEBSITE_TRACKING => 'Website Tracking',
            self::SEO_CONFIG => 'SEO Configuration',
            self::SEO_API => 'API',
        };
    }

    /**
     * @return string
     */
    public function getSetting(): string
    {
        return match ($this) {
            self::GENERAL => 'general',
            self::WEBSITE_TRACKING => 'website-tracking',
            self::SEO_CONFIG => 'seo-config',
            self::SEO_API => 'api',
        };
    }
}

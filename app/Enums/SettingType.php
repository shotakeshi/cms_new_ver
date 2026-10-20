<?php

namespace App\Enums;

enum SettingType: string
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
            self::GENERAL => __('site.setting.general_information'),
            self::WEBSITE_TRACKING => __('site.setting.website_tracking'),
            self::SEO_CONFIG => __('site.setting.seo_config'),
            self::SEO_API => __('site.setting.api'),
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

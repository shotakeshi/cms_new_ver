<?php
namespace App\Helpers;

use App\Models\Language;

class LanguageHelper
{
    /**
     * Get the language name by its slug.
     *
     * @param string $langSlug
     * @return string
     */
    public static function getLanguageNameBySlug($langSlug): ?string
    {
        $language = Language::slug($langSlug);
        if($language->first())
        {
            return $language->name;
        }
        return null;
    }
}

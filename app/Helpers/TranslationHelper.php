<?php
namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TranslationHelper
{
    /**
     * Load translation file
     *
     * @param string $locale
     * @param string $group
     * @return array
     */
    public static function load(string $locale, string $group): array
    {
        return array_filter(
            Arr::dot(self::read($locale, $group)),
            fn ($value) => is_string($value)
        );
    }

    /**
     * Scan and get all translation groups for a given locale.
     *
     * @param string $locale
     * @return array
     */
    public static function scanGroups(string $locale): array
    {
        $path = lang_path($locale);
        if (!File::exists($path)) {
            return [];
        }

        return array_map(
            fn ($file) => $file->getFilenameWithoutExtension(),
            File::files($path)
        );
    }

    /**
     * Check if a translation group exists
     *
     * @param string $group
     * @return bool
     */
    public static function groupExists(string $group): bool
    {
        foreach (File::directories(lang_path()) as $localeDir) {
            if (File::exists($localeDir . "/{$group}.php")) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all translation for a give locale
     *
     * @param string $locale
     * @return array
     */
    public static function getTranslation(string $locale, string $keySearch = ''): array
    {
        $translations = [];
        $exceptionGroups = config('exceptions.group_translations');
        foreach (self::scanGroups($locale) as $group) {
            if (in_array($group, $exceptionGroups)) continue;

            foreach (self::load($locale, $group) as $key => $value) {
                $translations["$group.$key"] = $value;
            }
        }

        if (!empty($keySearch)) {
            $translations = collect($translations)
                ->filter(fn ($value, $key) =>
                    Str::contains($key, $keySearch, true)
                    || Str::contains((string) $value, $keySearch, true)
                )->all();
        }

        return $translations;
    }

    /**
     * Update a translation entry in language files.
     *
     * @param string $locale
     * @param string $group
     * @param string $transKey
     * @param string $transValue
     * @return void
     */
    public static function update(string $locale, string $group, string $transKey, string $transValue ): void
    {
        $dots = self::load($locale, $group);
        $dots[$transKey] = $transValue;

        self::write($locale, $group, $dots);
    }

    /**
     * Create a translation entry in language files.
     *
     * @param string $group
     * @param string $dotKey
     * @param array $valuesByLocale
     * @return void
     */
    public static function create(string $group, string $dotKey, array $valuesByLocale): void
    {
        foreach ($valuesByLocale as $locale => $value) {
            $existingDots = self::load($locale, $group);

            if (array_key_exists($dotKey, $existingDots)) continue;

            $existingDots[$dotKey] = $value;
            self::write($locale, $group, $existingDots);
        }
    }

    /**
     * Read translation data
     *
     * @param string $locale
     * @param string $group
     * @return array
     */
    private static function read(string $locale, string $group): array
    {
        $path = self::path($locale, $group);
        return File::exists($path) ? require $path : [];
    }

    /**
     * Write translation data
     *
     * @param string $locale
     * @param string $group
     * @param array $dots
     * @return void
     */
    private static function write(string $locale, string $group, array $dots): void
    {
        $langs = Arr::undot($dots);
        $path = self::path($locale, $group);

        try {
            File::ensureDirectoryExists(dirname($path));
        } catch (\Throwable) {
            throw new \RuntimeException("Cannot write language files. Folder is not writable: " . lang_path());
        }

        $langs = self::exportShortArray($langs);
        $content = "<?php\n\n";
        $content .= "return {$langs};\n";
        File::put($path, $content);
    }

    /**
     * Convert an array into a formatted PHP short array string.
     *
     * @param array $data
     * @param int $level
     * @return string
     */
    private static function exportShortArray(array $data, int $level = 0): string
    {
        $indent = str_repeat('    ', $level);
        $output = "[\n";

        foreach ($data as $key => $value) {
            $output .= $indent .'    '. var_export($key, true) . ' => ';

            if (is_array($value)) {
                $output .= self::exportShortArray($value, $level + 1);
            } else {
                $output .= var_export($value, true);
            }

            $output .= ",\n";
        }

        $output .= $indent . "]";

        return $output;
    }

    /**
     * Build the path to a translation group file.
     *
     * @param string $locale
     * @param string $group
     * @return string
     */
    private static function path(string $locale, string $group): string
    {
        return lang_path("$locale/$group.php");
    }

}

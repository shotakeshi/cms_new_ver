<?php
namespace App\Services;

use App\Models\Tag;
use App\Models\TagTranslation;
use Illuminate\Support\Str;

class TagService
{
    public function sync($model, array $tagNames = [])
    {
        $locale = $model->language_code;
        $tagIds = collect($tagNames)
            ->filter()
            ->map(fn($tagName) => trim($tagName))
            ->unique()
            ->map(function ($name) use ($locale) {
                $slug = Str::slug(Str::lower($name));

                // tag có tồn tại hay chưa
                $translation = TagTranslation::where([
                    'locale' => $locale,
                    'slug'   => $slug,
                ])->first();

                if ($translation) {
                    return $translation->tag_id;
                }

                // chưa có thì tạo mới
                $tag = Tag::create();
                $translation = TagTranslation::create([
                    'locale' => $locale,
                    'slug'   => $slug,
                    'name' => $name,
                    'tag_id' => $tag->id,
                ]);

                return $translation->tag_id;
            });

        $model->tags()->sync($tagIds);
    }

    protected function generateUniqueSlug($name, $locale)
    {
        $baseSlug = Str::slug(Str::lower($name));
        $slug = $baseSlug;
        $i = 1;

        while (
        TagTranslation::where('locale', $locale)
            ->where('slug', $slug)
            ->exists()
        ) {
            $slug = $baseSlug . '-' . $i++;
        }

        return $slug;
    }
}
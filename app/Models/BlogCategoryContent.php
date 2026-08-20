<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;

class BlogCategoryContent extends Model
{
    use HasFilterableTrait;

    protected $fillable = [
        'language_code',
        'name',
        'description',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'image',
        'slug'
    ];

    public function blogCategory(): BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    protected static function boot()
    {
        parent::boot();

        $locale = Setting::where('key','locale')->pluck('value')->first();
        static::creating(
            function ($model) {
                $model->slug = Str::slug($model->slug);
                $model->language_code = $locale ?? config('app.locale');
            }
        );

        static::updating(
            function ($model) {
                $model->slug = Str::slug($model->slug);
            }
        );
    }
}

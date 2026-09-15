<?php

namespace App\Models;

use App\Enums\ActivityModule;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use Illuminate\Support\Str;

class BlogPostContent extends Model
{
    use HasFilterableTrait;
    use LogsActivity;

    public const ACTIVITY_MODULE = ActivityModule::BLOG_POSTS_CONTENT->value;

    protected $fillable = [
        'blog_post_id',
        'name',
        'slug',
        'language_code',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'image',
    ];

    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (BlogPostContent $blogPostContent) {
            $blogPostContent->language_code ??= config('app.locale');
            $blogPostContent->slug = Str::slug($blogPostContent->slug ?: $blogPostContent->title);
        });

        self::updating(function (BlogPostContent $blogPostContent) {
            if ($blogPostContent->isDirty('slug')) {
                $blogPostContent->slug = Str::slug($blogPostContent->slug);
            }
        });
    }
}
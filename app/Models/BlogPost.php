<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\BlogPostStatus;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogPost extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'status',
        'comment_status',
        'published_at',
        'post_password',
        'comment_count',
        'admin_id',
        'more',
    ];

    protected $casts = [
        'comment_status' => 'integer',
        'comment_count' => 'integer',
        'status' => BlogPostStatus::class,
        'published_at' => 'datetime:d/m/Y - H:i',
        'post_password' => 'hashed',
    ];

    // Optionally, specify the name of the 'deleted_at' column
    protected $dates = ['deleted_at'];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'blog_post_category',
            'blog_post_id',
            'blog_category_id'
        );
    }

    public function contents(): HasMany
    {
        return $this->hasMany(BlogPostContent::class);
    }

    public function content(string $languageCode = '') : ?BlogPostContent
    {
        $languageCode = $languageCode ?: config('app.locale');
        return $this->contents()->where('language_code', $languageCode)->first();
    }

    // Mutator for setting the 'published_at' attribute
    public function setPublishedAtAttribute($publishedAt)
    {
        if (!empty($publishedAt)) {
            $this->attributes['published_at'] = Carbon::createFromFormat(
                'd/m/Y - H:i',
                $publishedAt
            )->format('Y-m-d H:i:s');
            return;
        }

        $this->attributes['published_at'] = null;
    }

    public function getPublishedAtAttribute($publishedAt)
    {
        return Carbon::parse($publishedAt)->format('d/m/Y - H:i');
    }

    public function getCreatedAtAttribute($createdAt)
    {
        return Carbon::parse($createdAt)->format('d/m/Y - H:i');
    }

    public function getUpdatedAtAttribute($updatedAt)
    {
        return Carbon::parse($updatedAt)->format('d/m/Y - H:i');
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (BlogPost $blogPost) {
            $blogPost->admin_id = Auth::id();

            $blogPost->resolveStatusFromPublishAt();
        });

        self::updating(function (BlogPost $blogPost) {
            if ($blogPost->isDirty('slug')) {
                $blogPost->slug = Str::slug($blogPost->slug);
            }
        });
    }

    protected function resolveStatusFromPublishAt(): void
    {
        if ( !$this->published_at ) {
            $this->status = BlogPostStatus::DRAFT;
            return;
        }

        $publishedAt = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $this->attributes['published_at']
        );

        $this->status = $publishedAt->isFuture()
            ? BlogPostStatus::SCHEDULE
            : BlogPostStatus::PUBLISH;
    }
}

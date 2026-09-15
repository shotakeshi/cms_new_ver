<?php

namespace App\Models;

use App\Enums\ActivityModule;
use App\Enums\DefaultStatus;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogCategory extends Model
{
    use LogsActivity;

    public const ACTIVITY_MODULE = ActivityModule::BLOG_CATEGORY->value;

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $fillable = [
        'admin_id', 'deleted_at', 'parent_id'
    ];

    // Optionally, specify the name of the 'deleted_at' column
    protected $dates = ['deleted_at'];

    public function contents(): HasMany
    {
        return $this->hasMany(BlogCategoryContent::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with([
            'contents',
            'childrenRecursive'
        ]);
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogPost::class,
            'blog_post_category',
            'blog_category_id',
            'blog_post_id'
        );
    }

    public function content(string $languageCode = '') : ?BlogCategoryContent
    {
        $languageCode = $languageCode ?: config('app.locale');
        return $this->contents()->where('language_code', $languageCode)->first();
    }

    public function getDescendantIds(): array
    {
        $ids = [];

        foreach ($this->children as $child) {
            $ids[] = $child->id;

            $ids = array_merge(
                $ids,
                $child->getDescendantIds()
            );
        }

        return $ids;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->admin_id = Auth::id();
                $model->status = DefaultStatus::ACTIVE;
            }
        );

        static::deleting(function (BlogCategory $blogCategory) {
            // Move children to the nearest parent
            $blogCategory->children()->update([
                'parent_id' => $blogCategory->parent_id,
            ]);

            // Remove post-category relationships
            $blogCategory->posts()->detach();
        });
    }
}

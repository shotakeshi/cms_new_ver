<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use App\Traits\LogsActivity;
use App\Enums\ActivityModule;

class PageContent extends Model
{
    use HasFilterableTrait;
    use LogsActivity;
    public const ACTIVITY_MODULE = ActivityModule::PAGE_CONTENT->value;

    protected $fillable = [
        'language_code','name','description', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'meta_image', 'image'
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->language_code ??= config('app.locale');
            }
        );
    }
}

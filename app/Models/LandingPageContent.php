<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use App\Traits\LogsActivity;
use App\Enums\ActivityModule;
use Illuminate\Support\Str;

class LandingPageContent extends Model
{
    use HasFilterableTrait;
    use LogsActivity;
    public const ACTIVITY_MODULE = ActivityModule::LANDING_PAGE_CONTENT->value;

    protected $fillable = [
        'language_code','name','description', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'meta_image', 'image', 'slug', 'more'
    ];

    protected $casts = [
        'more' => 'array',
    ];

    public function landingPage(): BelongsTo
    {
        return $this->belongsTo(LandingPage::class);
    }


    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (LandingPageContent $landingPageContent) {
            $landingPageContent->language_code ??= config('app.locale');
            $landingPageContent->slug = Str::slug($landingPageContent->slug ?: $landingPageContent->name);
        });

        self::updating(function (LandingPageContent $landingPageContent) {
            if ($landingPageContent->isDirty('slug')) {
                $landingPageContent->slug = Str::slug($landingPageContent->slug);
            }
        });
    }
}

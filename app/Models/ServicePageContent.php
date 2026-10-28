<?php

namespace App\Models;

use App\Enums\ActivityModule;
use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;

class ServicePageContent extends Model
{
    use HasFilterableTrait;
    use LogsActivity;

    public const ACTIVITY_MODULE = ActivityModule::SERVICE_PAGE_CONTENT->value;

    protected $fillable = [
        'language_code', 'name', 'description', 'content', 'meta_title', 'meta_description', 'meta_keywords', 'meta_image', 'image', 'slug', 'more',
    ];

    protected $casts = [
        'more' => 'array',
    ];

    public function servicePage(): BelongsTo
    {
        return $this->belongsTo(ServicePage::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (ServicePageContent $servicePageContent) {
            $servicePageContent->language_code ??= config('app.locale');
            $servicePageContent->slug = Str::slug($servicePageContent->slug ?: $servicePageContent->name);
        });

        self::updating(function (ServicePageContent $servicePageContent) {
            if ($servicePageContent->isDirty('slug')) {
                $servicePageContent->slug = Str::slug($servicePageContent->slug);
            }
        });
    }
}

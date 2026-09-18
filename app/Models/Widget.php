<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Enums\WidgetType;

class Widget extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'type',
        'settings',
        'status',
    ];

    protected $casts = [
        'settings' => 'array',
        'status' => 'boolean',
        'type' => WidgetType::class,
    ];

    /**
     * Widget translations.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(WidgetContent::class);
    }

    /**
     * Get content for a specific language.
     */
    public function content(?string $languageCode = null): ?WidgetContent
    {
        $languageCode ??= app()->getLocale();

        return $this->contents
            ->firstWhere('language_code', $languageCode);
    }

    /**
     * Scope active widgets.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
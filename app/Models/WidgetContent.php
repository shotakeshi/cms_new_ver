<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WidgetContent extends Model
{
    protected $fillable = [
        'widget_id',
        'language_code',
        'title',
        'excerpt',
        'content',
        'image',
        'data',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    /**
     * Parent widget.
     */
    public function widget(): BelongsTo
    {
        return $this->belongsTo(Widget::class);
    }

    /**
     * Scope by language.
     */
    public function scopeLanguage($query, ?string $languageCode = null)
    {
        return $query->where(
            'language_code',
            $languageCode ?? app()->getLocale()
        );
    }
}
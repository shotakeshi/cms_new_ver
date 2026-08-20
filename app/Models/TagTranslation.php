<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagTranslation extends Model
{
    protected $fillable = [
        'tag_id',
        'locale',
        'name',
        'slug'
    ];

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function scopeLocale($query, $locale = null)
    {
        return $query->where(
            'locale',
            $locale ?? app()->getLocale()
        );
    }
}

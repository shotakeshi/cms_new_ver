<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function translations()
    {
        return $this->hasMany(TagTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(TagTranslation::class);
    }

    public function pages()
    {
        return $this->morphedByMany(PageContent::class, 'taggable');
    }
}

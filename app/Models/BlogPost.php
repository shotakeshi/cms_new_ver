<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{
    use SoftDeletes;
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogCategory::class,
            'blog_post_category',
            'blog_post_id',
            'blog_category_id'
        );
    }
}

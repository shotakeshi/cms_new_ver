<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BlogPostContent extends Model
{
    protected $fillable = [
        'blog_post_id',
        'name',
        'slug',
        'language_code',
        'excerpt',
        'content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'meta_image',
        'image',
    ];

    public function blogPost(): BelongsTo
    {
        return $this->belongsTo(BlogPost::class);
    }
}
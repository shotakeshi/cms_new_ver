<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\BlogPostStatus;

class BlogPost extends Model
{
    use SoftDeletes;
    use LogsActivity;

    protected $fillable = [
        'status',
        'comment_status',
        'published_at',
        'post_password',
        'comment_count',
        'admin_id',
        'more',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'comment_status' => 'integer',
        'comment_count' => 'integer',
        'status' => BlogPostStatus::class
    ];
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

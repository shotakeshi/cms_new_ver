<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BlogCategory extends Model
{
    use HasFilterableTrait;

    protected $casts = [
        'status' => 'boolean'
    ];

    protected $fillable = [
        'admin_id', 'deleted_at', 'parent_id'
    ];

    // Optionally, specify the name of the 'deleted_at' column
    protected $dates = ['deleted_at'];

    public function contents(): HasMany
    {
        return $this->hasMany(BlogCategoryContent::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function parent()
    {
        return $this->belongsTo(BlogCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(BlogCategory::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with([
            'contents',
            'childrenRecursive'
        ]);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->admin_id = Auth::id();
            }
        );
    }
}

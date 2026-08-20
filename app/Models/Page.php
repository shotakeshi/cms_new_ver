<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Enums\DefaultStatus;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use App\Filters\Filterable\PagesFilterable;
use App\Traits\LogsActivity;
use App\Enums\ActivityModule;

class Page extends Model
{
    use SoftDeletes;
    use HasFilterableTrait;
    use LogsActivity;

    public const ACTIVITY_MODULE = ActivityModule::PAGE->value;

    protected $fillable = [
        'status', 'status_comment', 'admin_id', 'published_at', 'slug', 'deleted_at'
    ];

    protected $casts = [
        'status' => 'boolean',
        'status_comment' => 'boolean',
        'published_at' => 'datetime:d/m/Y - H:i'
    ];

    // Optionally, specify the name of the 'deleted_at' column
    protected $dates = ['deleted_at'];

    /**
     * Enable the filterable class to the model
     *
     * @return string
     */
    public function filterableClass(): string
    {
        return PagesFilterable::class;
    }

    public function contents() : HasMany
    {
        return $this->hasMany(PageContent::class);
    }

    public function content(string $languageCode = '') : ?PageContent
    {
        $languageCode = $languageCode ?: config('app.locale');
        return $this->contents()->where('language_code', $languageCode)->first();
    }

    // Mutator for setting the 'published_at' attribute
    public function setPublishedAtAttribute($publishedAt)
    {
        if(!empty($publishedAt)) {
            $this->attributes['published_at'] = Carbon::createFromFormat('d/m/Y - H:i', $publishedAt)->format('Y-m-d H:i:s');
        }
    }

    // Accessor for getting the 'published_at' attribute
    public function getPublishedAtAttribute($publishedAt)
    {
        return Carbon::parse($publishedAt)->format('d/m/Y - H:i');
    }

    public function getCreatedAtAttribute($createdAt)
    {
        return Carbon::parse($createdAt)->format('d/m/Y - H:i');
    }

    public function getUpdatedAtAttribute($updatedAt)
    {
        return Carbon::parse($updatedAt)->format('d/m/Y - H:i');
    }

    public function getStatusNameAttribute(): string
    {
        return DefaultStatus::from($this->status)->getName();
    }

    public function getStatusClassAttribute(): string
    {
        return DefaultStatus::from($this->status)->getClass();
    }

    public function getStatusCommentClassAttribute(): string
    {
        return DefaultStatus::from($this->status_comment)->getClass();
    }

    public function getStatusCommentNameAttribute(): string
    {
        return DefaultStatus::from($this->status_comment)->getName();
    }

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(
            function ($model) {
                $model->slug = Str::slug($model->slug);
                $model->admin_id = Auth::id();
            }
        );

        static::updating(
            function ($model) {
                $model->slug = Str::slug($model->slug);
            }
        );
    }
}

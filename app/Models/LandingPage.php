<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Enums\DefaultStatus;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;
use App\Filters\Filterable\LandingPagesFilterable;
use App\Traits\LogsActivity;
use App\Enums\ActivityModule;

class LandingPage extends Model
{
    use SoftDeletes;
    use HasFilterableTrait;
    use LogsActivity;

    public const ACTIVITY_MODULE = ActivityModule::LANDING_PAGE->value;

    protected $fillable = [
        'status', 'admin_id', 'slug', 'deleted_at'
    ];

    protected $casts = [
        'status' => 'boolean'
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
        return LandingPagesFilterable::class;
    }

    public function contents() : HasMany
    {
        return $this->hasMany(LandingPageContent::class);
    }

    public function content(string $languageCode = '') : ?LandingPageContent
    {
        $languageCode = $languageCode ?: config('app.locale');
        return $this->contents()->where('language_code', $languageCode)->first();
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

    public function scopeWithWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (LandingPage $landingPage) {
            $landingPage->admin_id = Auth::id();
        });
    }
}

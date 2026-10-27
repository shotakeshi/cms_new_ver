<?php

namespace App\Models;

use App\Enums\ActivityModule;
use App\Enums\DefaultStatus;
use App\Filters\Filterable\ServicePagesFilterable;
use App\Traits\LogsActivity;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use TheJano\LaravelFilterable\Traits\HasFilterableTrait;

class ServicePage extends Model
{
    use HasFilterableTrait;
    use LogsActivity;
    use SoftDeletes;

    public const ACTIVITY_MODULE = ActivityModule::SERVICE_PAGE->value;

    protected $fillable = [
        'status', 'admin_id', 'deleted_at',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Optionally, specify the name of the 'deleted_at' column
    protected $dates = ['deleted_at'];

    /**
     * Enable the filterable class to the model
     */
    public function filterableClass(): string
    {
        return ServicePagesFilterable::class;
    }

    public function contents(): HasMany
    {
        return $this->hasMany(ServicePageContent::class);
    }

    public function content(string $languageCode = ''): ?ServicePageContent
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

        static::creating(function (ServicePage $servicePage) {
            $servicePage->admin_id = Auth::id();
        });
    }
}

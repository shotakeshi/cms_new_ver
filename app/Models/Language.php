<?php

namespace App\Models;

use App\Enums\DefaultStatus as EnumDefaultStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Language extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'code', 'status'
    ];

    protected function casts(): array
    {
        return [
            'status' => EnumDefaultStatus::class,
        ];
    }

    public function getStatusNameAttribute(): string
    {
        return EnumDefaultStatus::from($this->status->value)->getName();
    }

    public function getStatusClassAttribute(): string
    {
        return EnumDefaultStatus::from($this->status->value)->getClass();
    }

    public function scopeActive($query) {
        return $query->where('status', EnumDefaultStatus::ACTIVE->value);
    }

    public function scopeSlug($query, $slug) {
        return $query->where('slug', $slug)->first();
    }

    public function admins(): HasMany
    {
        return $this->hasMany(Admin::class);
    }

    protected static function boot()
    {
        parent::boot();
    }
}

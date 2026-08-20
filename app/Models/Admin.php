<?php

namespace App\Models;

use App\Enums\ActivityModule;
use App\Traits\LogsActivity;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Enums\AdminStatus as EnumAdminStatus;
use App\Enums\AdminType as EnumAdminType;
use Illuminate\Database\Eloquent\Relations\{ BelongsTo, HasMany };

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, LogsActivity;
    protected $guard = 'admin'; // Define the guard for this model
    protected $appends = ['root_admin'];

    public const ACTIVITY_MODULE = ActivityModule::ADMIN->value;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name', 'email', 'status', 'phone', 'locale', 'password', 'language_id', 'type', 'position_id','department_id', 'avatar'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'password' => 'hashed',
            'status' => EnumAdminStatus::class,
            'type' => EnumAdminType::class,
        ];
    }

    public function getStatusNameAttribute(): string {
        return EnumAdminStatus::from($this->status->value)->getName();
    }

    public function getStatusClassAttribute(): string {
        return EnumAdminStatus::from($this->status->value)->getClass();
    }

    public function getAdminTypeClassAttribute(): string {
        return EnumAdminType::from($this->type->value)->getClass();
    }

    public function getAdminTypeNameAttribute(): string {
        return EnumAdminType::from($this->type->value)->getName();
    }

    public function language(): BelongsTo {
        return $this->belongsTo(Language::class);
    }

    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function position(): BelongsTo {
        return $this->belongsTo(Position::class);
    }

    public function activities(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    /**
     * Check is root admin
     * @return bool
     */
    public function getRootAdminAttribute(): bool
    {
        return $this->type->value === 'root';
    }
}

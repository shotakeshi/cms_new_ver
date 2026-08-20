<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermissionGroup extends Model
{
    protected $fillable = [
        'name', 'permission_id'
    ];

    protected function casts(): array
    {
        return [
            'permission_id' => 'array'
        ];
    }
}

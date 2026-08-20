<?php

namespace App\Models;

use App\Enums\ActivityModule;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['name','setting', 'key', 'value'];

    protected $casts = ['value' => 'array'];
}

<?php

namespace App\Traits;

use App\Helpers\ActivityLogHelper;
use App\Enums\ActivityAction;

trait LogsActivity
{
    /**
     * Snapshot data before update (runtime only)
     */
    protected array $activityBefore = [];

    protected static function bootLogsActivity()
    {
        static::updating(function ($model) {
            $model->activityBefore = $model->getOriginal();
        });

        static::updated(function ($model) {
            $changes = $model->getChanges();

            $ignored = array_merge(
                ['updated_at'],
                property_exists($model, 'activityIgnore')
                    ? $model->activityIgnore
                    : []
            );

            $before = [];
            $after  = [];

            foreach ($changes as $field => $newValue) {
                if (in_array($field, $ignored, true)) {
                    continue;
                }

                $before[$field] = $model->activityBefore[$field] ?? null;
                $after[$field]  = $newValue;
            }

            if (!empty($after)) {
                ActivityLogHelper::log(
                    ActivityAction::UPDATE->value,
                    self::activityModule(),
                    $model,
                    [
                        'before' => $before,
                        'after'  => $after,
                    ]
                );
            }

            $model->activityBefore = [];
        });

        static::created(function ($model) {
            ActivityLogHelper::log(
                ActivityAction::CREATE->value,
                self::activityModule(),
                $model
            );
        });

        static::deleted(function ($model) {
            ActivityLogHelper::log(
                ActivityAction::DELETE->value,
                self::activityModule(),
                $model
            );
        });
    }

    protected static function activityModule(): string
    {
        $class = static::class;

        return defined("$class::ACTIVITY_MODULE")
            ? constant("$class::ACTIVITY_MODULE")
            : strtolower(class_basename($class));
    }
}

<?php

namespace App\Helpers;

use App\Models\ActivityLog;

class ActivityLogHelper
{
    public static function log(
        string $action,
        string $module,
               $subject = null,
        array $properties = []
    ): void {
        try {
            ActivityLog::create([
                'admin_id' => auth('admin')->id(),
                'action' => $action,
                'module' => $module,
                'subject_type' => $subject ? get_class($subject) : null,
                'subject_id' => $subject->id ?? null,
                'properties' => $properties,
                'ip' => request()?->ip(),
                'user_agent' => request()?->userAgent(),
            ]);
        } catch (\Throwable $e) {
            logger()->warning('ActivityLog failed', [
                'error' => $e->getMessage(),
            ]);
        }
    }
}

<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Enums\ActivityAction;
use Illuminate\Support\Facades\Auth;

class LogAdminLogout
{
    public function handle(Logout $event): void
    {
        // LẤY USER TRƯỚC KHI SESSION CLEAR
        $admin = $event->user ?? Auth::guard('admin')->user();

        if (!$admin) {
            return;
        }

        ActivityLog::create([
            'action'      => ActivityAction::LOGOUT,
            'module'      => 'auth',
            'causer_type' => Admin::class,
            'admin_id'    => $admin->id,
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}

<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\ActivityLog;
use App\Models\Admin;
use App\Enums\ActivityAction;
use Illuminate\Support\Facades\Auth;

class LogAdminLogin
{
    public function handle(Login $event): void
    {
        $admin = Auth::guard('admin')->user();

        if (!$admin) {
            return;
        }

        ActivityLog::create([
            'action'      => ActivityAction::LOGIN,
            'module'      => 'auth',
            'causer_type' => Admin::class,
            'admin_id'    => $admin->id,
            'ip'          => request()->ip(),
            'user_agent'  => request()->userAgent(),
        ]);
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Listeners\LogAdminLogin;
use App\Listeners\LogAdminLogout;

class EventServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Event::listen(Login::class, LogAdminLogin::class);
        Event::listen(Logout::class, LogAdminLogout::class);
    }
}

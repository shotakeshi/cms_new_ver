<?php

namespace App\Providers;

use App\Models\Image;
use App\Models\Setting;
use App\Observers\ImageObserver;
use App\Services\Image\Disk\DiskHandler;
use App\Services\Image\Disk\LocalDiskHandler;
use App\Services\Image\Disk\S3DiskHandler;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Log;
use App\Models\Language;
use App\Models\Page;
use App\Observers\PageObserver;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(DiskHandler::class, function () {
            return config('filesystems.default') === 's3'
                    ? new S3DiskHandler
                    : new LocalDiskHandler();
        });

        Image::observe(ImageObserver::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->runningInConsole()) {
            return;
        }

        $startTime = microtime(true);

        app()->terminating(function () use ($startTime) {
            $endTime = microtime(true);
            $duration = round(($endTime - $startTime) * 1000, 2); // ms
            Log::info('Page loaded in ' . $duration . ' ms');
        });

        Blade::anonymousComponentPath(
            resource_path('views/admin/components'),
            'admin'
        );

        // Check if a database connection is available
        try {
            DB::connection()->getPdo(); // Attempt to connect to the database
            if (Schema::hasTable('languages')) { // Prevent errors if the table doesn't exist
                View::share('globalLanguages', Language::active()->get()); // Shared data globally
                View::share('currentLanguage', Language::active()->slug(app()->getLocale()));
            }
//            $locale = Setting::where('key','locale')->pluck('value')->first();
            View::composer('*', function ($view) {
                $view->with('appLocale', app()->getLocale());
            });
        } catch (\Exception $e) {
            // Database not available, skip setting globalLanguages
        }
    }
}

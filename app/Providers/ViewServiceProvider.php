<?php

namespace App\Providers;

use App\Http\View\Composers\ViewComposer;
use App\Models\Language;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Sharing data with a specific view
//        View::composer(['admin.layouts.partials.topbar','admin.layouts.partials.tr-language'], function ($view) {
//            $view->with('globalLanguages', Language::active()->get());
//        });
    }
}

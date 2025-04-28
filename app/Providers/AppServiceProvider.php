<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cagnotte;
use App\Models\Service;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Partage de quelques campagnes et services avec toutes les vues
        View::composer('*', function ($view) {
            $view->with('campaigns', Cagnotte::latest()->take(5)->get());
            $view->with('services', Service::latest()->take(5)->get());
        });
    }
}

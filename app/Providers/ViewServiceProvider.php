<?php
// app/Providers/ViewServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cagnotte; 
use App\Models\Service;

class ViewServiceProvider extends ServiceProvider
{
        public function boot()
    {
        // Partager les campagnes et services avec toutes les vues
        View::composer('*', function ($view) {
            $view->with('campaigns', Cagnotte::where('status', 'open')->latest()->take(5)->get()); // Filtrer les campagnes avec statut 'open'
            $view->with('services', Service::where('status', 'approved')->latest()->take(5)->get()); // Filtrer les services avec statut 'approved'
        });
        
    }

    public function register()
    {
        //
    }
}

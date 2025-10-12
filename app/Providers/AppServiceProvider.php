<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\DemandeTransport;
use App\Observers\DemandeTransportObserver;

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
        // Enregistrer l'observer pour les demandes de transport
        DemandeTransport::observe(DemandeTransportObserver::class);
    }
}

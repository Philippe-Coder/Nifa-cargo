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
        
        // Gestion de la locale - approche plus directe
        if ($this->app->runningInConsole()) {
            return;
        }
        
        // Utiliser un événement plus précoce
        $this->app->booted(function () {
            $supportedLocales = ['fr', 'en', 'zh_CN'];
            
            // Vérifier s'il y a une session active
            if (session()->isStarted()) {
                $sessionLocale = session('locale');
                
                if ($sessionLocale && in_array($sessionLocale, $supportedLocales)) {
                    app()->setLocale($sessionLocale);
                }
            }
        });
    }
}

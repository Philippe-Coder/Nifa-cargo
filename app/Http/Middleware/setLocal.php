<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class setLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = ['fr', 'en', 'zh_CN'];
        
        // Vérifier si une locale est dans la session
        if (session()->has('locale')) {
            $sessionLocale = session('locale');
            
            // Valider que la locale est supportée
            if (in_array($sessionLocale, $availableLocales)) {
                App::setLocale($sessionLocale);
                
                // Log pour debug (à enlever en production)
                Log::info("Locale définie depuis session: " . $sessionLocale);
            }
        } else {
            // Utiliser la locale par défaut si pas de session
            App::setLocale(config('app.locale', 'fr'));
            Log::info("Utilisation locale par défaut: " . config('app.locale', 'fr'));
        }

        return $next($request);
    }
}
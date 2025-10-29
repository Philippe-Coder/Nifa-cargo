<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class setLocal
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Locales supportées
        $supportedLocales = ['fr', 'en', 'zh_CN'];
        
        // Récupérer la locale depuis la session
        $sessionLocale = Session::get('locale');
        
        // Log pour debug
        Log::info("=== MIDDLEWARE DEBUG ===");
        Log::info("Session locale: " . ($sessionLocale ?? 'null'));
        Log::info("App locale avant: " . App::getLocale());
        
        // Définir la locale si elle existe et est supportée
        if ($sessionLocale && in_array($sessionLocale, $supportedLocales)) {
            App::setLocale($sessionLocale);
            Log::info("Locale définie à: " . $sessionLocale);
        } else {
            // Forcer la locale par défaut
            App::setLocale(config('app.locale', 'fr'));
            Log::info("Locale par défaut: " . config('app.locale', 'fr'));
        }
        
        Log::info("App locale après: " . App::getLocale());
        Log::info("=== FIN MIDDLEWARE ===");
        
        return $next($request);
    }
}
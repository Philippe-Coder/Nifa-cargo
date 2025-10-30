<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class SetLocaleFromUrl
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Locales supportées
        $supportedLocales = ['fr', 'en', 'zh_CN'];
        
        // Récupérer la locale depuis l'URL
        $urlLocale = $request->get('locale');
        
        // TOUJOURS logger l'exécution du middleware
        Log::info('🚀 MIDDLEWARE SETLOCALE EXECUTE', [
            'timestamp' => now()->toDateTimeString(),
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'route_name' => $request->route() ? $request->route()->getName() : 'unknown',
            'url_locale' => $urlLocale,
            'current_locale_before' => app()->getLocale(),
            'session_locale' => session('locale')
        ]);
        
        // Si une locale est fournie dans l'URL et qu'elle est supportée
        if ($urlLocale && in_array($urlLocale, $supportedLocales)) {
            App::setLocale($urlLocale);
            session(['locale' => $urlLocale]);
            Log::info('Locale set from URL', ['locale' => $urlLocale]);
        } else {
            // Fallback vers la session si pas de paramètre URL
            $sessionLocale = session('locale', 'fr');
            if (in_array($sessionLocale, $supportedLocales)) {
                App::setLocale($sessionLocale);
                Log::info('Locale set from session', ['locale' => $sessionLocale]);
            } else {
                // Utiliser la locale par défaut
                App::setLocale('fr');
                Log::info('Locale set to default', ['locale' => 'fr']);
            }
        }
        
        Log::info('Final locale set', ['locale' => app()->getLocale()]);
        
        return $next($request);
    }
}
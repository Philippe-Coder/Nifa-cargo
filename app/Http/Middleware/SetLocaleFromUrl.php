<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        
        // Si une locale est fournie dans l'URL et qu'elle est supportée
        if ($urlLocale && in_array($urlLocale, $supportedLocales)) {
            App::setLocale($urlLocale);
            // Sauvegarder aussi dans la session pour persistance
            session(['locale' => $urlLocale]);
        } else {
            // Fallback vers la session si pas de paramètre URL
            $sessionLocale = session('locale', 'fr');
            if (in_array($sessionLocale, $supportedLocales)) {
                App::setLocale($sessionLocale);
            } else {
                // Utiliser la locale par défaut
                App::setLocale(config('app.locale', 'fr'));
            }
        }
        
        return $next($request);
    }
}
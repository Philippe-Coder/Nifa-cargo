<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * The URIs that should be reachable while maintenance mode is enabled.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
    
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Illuminate\Http\Exceptions\PostTooLargeException
     */
    public function handle($request, Closure $next)
    {
        if ($this->app->isDownForMaintenance()) {
            $data = json_decode(file_get_contents($this->app->storagePath() . '/framework/down'), true);
            
            // Vérifier si la requête est autorisée
            if (isset($data['secret']) && $request->path() === $data['secret']) {
                return $next($request);
            }

            // Vérifier les IPs autorisées
            if (isset($data['allowed']) && in_array($request->ip(), $data['allowed'])) {
                return $next($request);
            }

            // Vérifier les tokens d'accès
            if (isset($data['tokens']) && 
                $request->has('token') && 
                in_array($request->input('token'), $data['tokens'])) {
                return $next($request);
            }

            // Vérifier si c'est une requête API
            if ($this->inExceptArray($request) || $request->is('api/*')) {
                return $next($request);
            }

            // Afficher la vue de maintenance personnalisée
            return response()->view('vendor.maintenance.index', [], 503);
        }

        return $next($request);
    }
}

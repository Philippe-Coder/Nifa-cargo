<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Report or log an exception.
     */
    public function report(Throwable $exception): void
    {
        // Log personnalisé selon le type d'exception
        $this->logException($exception);
        
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     */
    public function render($request, Throwable $exception)
    {
        // En production, masquer les erreurs techniques
        if (app()->environment('production')) {
            return $this->renderProductionError($request, $exception);
        }

        return parent::render($request, $exception);
    }

    /**
     * Logging personnalisé selon le type d'exception
     */
    protected function logException(Throwable $exception): void
    {
        $context = [
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => Auth::check() ? Auth::user()->id : null,
            'timestamp' => now()->toISOString(),
        ];

        switch (get_class($exception)) {
            case QueryException::class:
                /** @var QueryException $exception */
                Log::channel('database')->error('[ERREUR SQL] ' . $exception->getMessage(), [
                    'sql' => method_exists($exception, 'getSql') ? $exception->getSql() : 'SQL non disponible',
                    'bindings' => method_exists($exception, 'getBindings') ? $exception->getBindings() : [],
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                    ...$context
                ]);
                break;

            case ValidationException::class:
                /** @var ValidationException $exception */
                Log::channel('validation')->warning('[ERREUR VALIDATION] ' . $exception->getMessage(), [
                    'errors' => method_exists($exception, 'errors') ? $exception->errors() : [],
                    'input' => request()->except(['password', 'password_confirmation']),
                    ...$context
                ]);
                break;

            case NotFoundHttpException::class:
                Log::channel('access')->info('[404 NOT FOUND] ' . request()->fullUrl(), $context);
                break;

            case AccessDeniedHttpException::class:
                Log::channel('security')->warning('[ACCÈS REFUSÉ] ' . $exception->getMessage(), [
                    'requested_resource' => request()->fullUrl(),
                    ...$context
                ]);
                break;

            case AuthenticationException::class:
                Log::channel('auth')->info('[AUTHENTIFICATION ÉCHOUÉE] ' . $exception->getMessage(), $context);
                break;

            default:
                Log::channel('application')->error('[ERREUR SYSTÈME] ' . $exception->getMessage(), [
                    'exception_type' => get_class($exception),
                    'file' => $exception->getFile(),
                    'line' => $exception->getLine(),
                    'trace' => $exception->getTraceAsString(),
                    ...$context
                ]);
        }
    }

    /**
     * Rendu des erreurs pour la production (messages utilisateur friendly)
     */
    protected function renderProductionError($request, Throwable $exception)
    {
        $errorId = uniqid('ERR_');
        
        // Log l'ID d'erreur pour traçabilité
        Log::error("[ID: {$errorId}] Erreur production masquée", [
            'exception' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
        ]);

        // Messages d'erreur conviviaux selon le type
        if ($exception instanceof QueryException) {
            return $this->handleDatabaseError($request, $errorId);
        }

        if ($exception instanceof NotFoundHttpException) {
            return response()->view('errors.404', ['errorId' => $errorId], 404);
        }

        if ($exception instanceof AccessDeniedHttpException) {
            return response()->view('errors.403', ['errorId' => $errorId], 403);
        }

        if ($exception instanceof ValidationException) {
            return back()->withErrors($exception->errors())->withInput();
        }

        // Erreur générique
        return $this->handleGenericError($request, $errorId);
    }

    /**
     * Gestion des erreurs de base de données
     */
    protected function handleDatabaseError($request, string $errorId)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur technique est survenue. Veuillez réessayer.',
                'error_id' => $errorId
            ], 500);
        }

        return back()->with('error', 'Une erreur technique est survenue. Si le problème persiste, contactez le support en mentionnant le code: ' . $errorId);
    }

    /**
     * Gestion des erreurs génériques
     */
    protected function handleGenericError($request, string $errorId)
    {
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur inattendue s\'est produite.',
                'error_id' => $errorId
            ], 500);
        }

        return response()->view('errors.500', [
            'errorId' => $errorId,
            'message' => 'Une erreur inattendue s\'est produite.'
        ], 500);
    }

    /**
     * Convert an authentication exception into a response.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Non authentifié.'], 401);
        }

        // Redirection selon le type d'utilisateur
        $guard = $exception->guards()[0] ?? null;
        
        if ($guard === 'admin') {
            return redirect()->guest(route('admin.login'));
        }
        
        return redirect()->guest(route('login'));
    }
}
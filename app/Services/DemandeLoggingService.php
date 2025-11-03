<?php

namespace App\Services;

use App\Models\DemandeTransport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Exception;
use Throwable;
use Illuminate\Support\Arr;

class DemandeLoggingService
{
    /**
     * Logger la création d'une demande
     */
    public static function logCreation(array $data, ?int $userId = null, bool $isAdmin = false): void
    {
        try {
            $context = [
                'action' => 'CREATION_DEMANDE',
                'user_id' => $userId ?: Auth::id(),
                'is_admin' => $isAdmin,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'data' => Arr::except($data, ['password', 'password_confirmation']),
                'timestamp' => now()->toISOString(),
            ];

            Log::channel('demandes')->info('Nouvelle demande créée', $context);
        } catch (Throwable $e) {
            // En cas d'erreur de logging, ne pas faire planter l'application
            Log::error('Erreur lors du logging de création de demande', [
                'error' => $e->getMessage(),
                'user_id' => $userId
            ]);
        }
    }

    /**
     * Logger la mise à jour d'une demande
     */
    public static function logUpdate(DemandeTransport $demande, array $oldData, array $newData, ?int $userId = null): void
    {
        try {
            $changes = [];
            foreach ($newData as $key => $value) {
                if (isset($oldData[$key]) && $oldData[$key] != $value) {
                    $changes[$key] = [
                        'old' => $oldData[$key],
                        'new' => $value
                    ];
                }
            }

            $context = [
                'action' => 'MODIFICATION_DEMANDE',
                'demande_id' => $demande->id,
                'numero_suivi' => $demande->numero_suivi ?? $demande->numero_tracking,
                'user_id' => $userId ?: Auth::id(),
                'changes' => $changes,
                'ip' => request()->ip(),
                'timestamp' => now()->toISOString(),
            ];

            if (!empty($changes)) {
                Log::channel('demandes')->info('Demande modifiée', $context);
            }
        } catch (Throwable $e) {
            Log::error('Erreur lors du logging de modification de demande', [
                'error' => $e->getMessage(),
                'demande_id' => $demande->id ?? 'unknown'
            ]);
        }
    }

    /**
     * Logger les erreurs de validation
     */
    public static function logValidationError(array $errors, array $input, ?string $action = null): void
    {
        try {
            $context = [
                'action' => $action ?: 'VALIDATION_ERROR',
                'errors' => $errors,
                'input' => Arr::except($input, ['password', 'password_confirmation']),
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'url' => request()->fullUrl(),
                'timestamp' => now()->toISOString(),
            ];

            Log::channel('validation')->warning('Erreur de validation sur demande', $context);
        } catch (Throwable $e) {
            Log::error('Erreur lors du logging de validation', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Logger les erreurs de base de données
     */
    public static function logDatabaseError(Throwable $exception, array $data = [], ?string $operation = null): string
    {
        $errorId = uniqid('DB_ERR_');
        
        try {
            $context = [
                'error_id' => $errorId,
                'operation' => $operation ?: 'UNKNOWN',
                'exception_type' => get_class($exception),
                'message' => $exception->getMessage(),
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'sql' => $exception instanceof \Illuminate\Database\QueryException ? $exception->getSql() : null,
                'bindings' => $exception instanceof \Illuminate\Database\QueryException ? $exception->getBindings() : null,
                'data' => Arr::except($data, ['password', 'password_confirmation']),
                'user_id' => Auth::id(),
                'ip' => request()->ip(),
                'url' => request()->fullUrl(),
                'timestamp' => now()->toISOString(),
            ];

            Log::channel('database')->error('Erreur de base de données sur demande', $context);
            
            // Log également dans le canal application pour alertes critiques
            Log::channel('application')->critical("Erreur critique DB [{$errorId}]: " . $exception->getMessage(), [
                'error_id' => $errorId,
                'operation' => $operation
            ]);
            
        } catch (Throwable $e) {
            // Fallback si le logging échoue
            Log::error('CRITICAL: Logging system failure', [
                'original_error' => $exception->getMessage(),
                'logging_error' => $e->getMessage(),
                'error_id' => $errorId
            ]);
        }

        return $errorId;
    }

    /**
     * Logger les accès non autorisés
     */
    public static function logUnauthorizedAccess(?int $demandeId = null, ?string $action = null): void
    {
        try {
            $context = [
                'action' => 'UNAUTHORIZED_ACCESS',
                'attempted_action' => $action,
                'demande_id' => $demandeId,
                'user_id' => Auth::id(),
                'user_role' => Auth::check() ? Auth::user()->role : 'guest',
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'url' => request()->fullUrl(),
                'referer' => request()->header('referer'),
                'timestamp' => now()->toISOString(),
            ];

            Log::channel('security')->warning('Tentative d\'accès non autorisé', $context);
        } catch (Throwable $e) {
            Log::error('Erreur lors du logging de sécurité', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Logger les changements de statut
     */
    public static function logStatusChange(DemandeTransport $demande, string $oldStatus, string $newStatus, ?int $userId = null): void
    {
        try {
            $context = [
                'action' => 'CHANGEMENT_STATUT',
                'demande_id' => $demande->id,
                'numero_suivi' => $demande->numero_suivi ?? $demande->numero_tracking,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'user_id' => $userId ?: Auth::id(),
                'ip' => request()->ip(),
                'timestamp' => now()->toISOString(),
            ];

            Log::channel('demandes')->info('Changement de statut de demande', $context);
        } catch (Throwable $e) {
            Log::error('Erreur lors du logging de changement de statut', [
                'error' => $e->getMessage(),
                'demande_id' => $demande->id ?? 'unknown'
            ]);
        }
    }

    /**
     * Créer un message d'erreur convivial pour l'utilisateur
     */
    public static function getUserFriendlyMessage(Throwable $exception): string
    {
        $messages = [
            'QueryException' => 'Une erreur technique est survenue lors de l\'enregistrement. Veuillez réessayer.',
            'ValidationException' => 'Certaines informations saisies sont incorrectes. Veuillez corriger et réessayer.',
            'ModelNotFoundException' => 'La demande recherchée n\'a pas été trouvée.',
            'AccessDeniedHttpException' => 'Vous n\'avez pas l\'autorisation d\'effectuer cette action.',
            'NotFoundHttpException' => 'La page ou la ressource demandée n\'existe pas.',
        ];

        $exceptionName = class_basename(get_class($exception));
        
        return $messages[$exceptionName] ?? 'Une erreur inattendue s\'est produite. Nos équipes ont été notifiées.';
    }
}
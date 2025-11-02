<?php

namespace App\Http\Controllers;

use App\Models\DemandeTransport;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TestNotificationController extends Controller
{
    /**
     * Test complet des notifications (Email + WhatsApp)
     */
    public function testNotifications(DemandeTransport $demande)
    {
        try {
            Log::info('🧪 Test complet notifications pour demande ID: ' . $demande->id);
            
            $service = new NotificationService();
            $result = $service->envoyerNotificationEtape($demande, 'Test Complet', 'en_cours');
            
            return response()->json([
                'status' => 'success',
                'message' => 'Test des notifications terminé',
                'demande_id' => $demande->id,
                'numero_suivi' => $demande->numero_tracking ?? null,
                'user' => [
                    'name' => $demande->user->name,
                    'email' => $demande->user->email,
                    'telephone' => $demande->user->telephone ?? 'Non renseigné'
                ],
                'results' => $result
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Erreur test notification complet: ' . $e->getMessage());
            
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur lors du test: ' . $e->getMessage(),
                'demande_id' => $demande->id
            ], 500);
        }
    }

    /**
     * Test Email seulement
     */
    public function testEmail(DemandeTransport $demande)
    {
        try {
            Log::info('📧 Test Email seul pour demande ID: ' . $demande->id);
            
            $message = "🧪 Test de configuration email - Votre système de notifications fonctionne parfaitement !";
            
            $result = NotificationService::envoyerNotification(
                $demande->user, 
                $demande, 
                'Test Email - NIF CARGO', 
                $message
            );
            
            return response()->json([
                'status' => 'success',
                'message' => 'Test email terminé',
                'email_sent' => $result['email'],
                'user_email' => $demande->user->email,
                'numero_suivi' => $demande->numero_tracking ?? null,
                'errors' => $result['errors']
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Erreur test email: ' . $e->getMessage());
            return response()->json([
                'status' => 'error', 
                'message' => 'Erreur email: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test WhatsApp seulement
     */
    public function testWhatsApp(DemandeTransport $demande)
    {
        try {
            Log::info('📱 Test WhatsApp seul pour demande ID: ' . $demande->id);
            
            if (empty($demande->user->telephone)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Aucun numéro de téléphone renseigné pour cet utilisateur',
                    'user_name' => $demande->user->name
                ], 400);
            }
            
            $message = "🧪 Test WhatsApp NIF CARGO: Configuration réussie ! Numéro de suivi: " . ($demande->numero_tracking ?? '—');
            
            $result = NotificationService::envoyerNotification(
                $demande->user, 
                $demande, 
                'Test WhatsApp - NIF CARGO', 
                $message
            );
            
            return response()->json([
                'status' => 'success',
                'message' => 'Test WhatsApp terminé',
                'whatsapp_sent' => $result['whatsapp'],
                'user_phone' => $demande->user->telephone,
                'numero_suivi' => $demande->numero_tracking ?? null,
                'errors' => $result['errors']
            ]);
            
        } catch (\Exception $e) {
            Log::error('❌ Erreur test WhatsApp: ' . $e->getMessage());
            return response()->json([
                'status' => 'error', 
                'message' => 'Erreur WhatsApp: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Afficher la configuration actuelle
     */
    public function showConfig()
    {
        $config = [
            'email' => [
                'mailer' => config('mail.default'),
                'host' => config('mail.mailers.smtp.host'),
                'port' => config('mail.mailers.smtp.port'),
                'username' => config('mail.mailers.smtp.username') ? 
                    str_replace(substr(config('mail.mailers.smtp.username'), 2, -10), '***', config('mail.mailers.smtp.username')) : 
                    'Non configuré',
                'password' => config('mail.mailers.smtp.password') ? 'Configuré (16 caractères)' : 'Non configuré',
                'from_name' => config('mail.from.name'),
                'from_address' => config('mail.from.address'),
                'status' => config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password') ? '✅ Configuré' : '❌ Manquant'
            ],
            'whatsapp' => [
                '360dialog' => [
                    'configured' => !empty(env('WHATSAPP_360_API_KEY')),
                    'api_key' => env('WHATSAPP_360_API_KEY') ? substr(env('WHATSAPP_360_API_KEY'), 0, 8) . '***' : 'Non configuré',
                    'base_url' => env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io'),
                    'status' => !empty(env('WHATSAPP_360_API_KEY')) ? '✅ Configuré' : '❌ Manquant'
                ],
                'twilio' => [
                    'configured' => !empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN')) && !empty(env('TWILIO_WHATSAPP_NUMBER')),
                    'sid' => env('TWILIO_SID') ? 'AC***' . substr(env('TWILIO_SID'), -4) : 'Non configuré',
                    'number' => env('TWILIO_WHATSAPP_NUMBER') ?: 'Non configuré',
                    'status' => (!empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN'))) ? '✅ Configuré' : '❌ Manquant'
                ],
                'meta' => [
                    'configured' => !empty(env('WHATSAPP_ACCESS_TOKEN')) && !empty(env('WHATSAPP_PHONE_NUMBER_ID')),
                    'phone_number_id' => env('WHATSAPP_PHONE_NUMBER_ID') ? 'ID***' . substr(env('WHATSAPP_PHONE_NUMBER_ID'), -4) : 'Non configuré',
                    'template' => env('WHATSAPP_TEMPLATE_NAME') ?: 'Non défini',
                    'status' => (!empty(env('WHATSAPP_ACCESS_TOKEN')) && !empty(env('WHATSAPP_PHONE_NUMBER_ID'))) ? '✅ Configuré' : '❌ Manquant'
                ],
                'callmebot' => [
                    'configured' => !empty(env('CALLMEBOT_API_KEY')),
                    'api_key' => env('CALLMEBOT_API_KEY') ? substr(env('CALLMEBOT_API_KEY'), 0, 6) . '***' : 'Non configuré',
                    'status' => !empty(env('CALLMEBOT_API_KEY')) ? '✅ Configuré' : '❌ Manquant'
                ],
                'active_method' => $this->getActiveWhatsAppMethod()
            ]
        ];
        
        return response()->json($config, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Test basique de connectivité email
     */
    public function testEmailConnection()
    {
        try {
            // Test simple sans template
            Mail::raw('Test de connexion SMTP - NIF CARGO', function ($message) {
                $message->to(config('mail.from.address'))
                        ->subject('Test Connexion SMTP')
                        ->from(config('mail.from.address'), 'NIF CARGO Test');
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Connexion email testée avec succès',
                'smtp_host' => config('mail.mailers.smtp.host'),
                'smtp_port' => config('mail.mailers.smtp.port')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Erreur de connexion email: ' . $e->getMessage(),
                'suggestion' => 'Vérifiez vos credentials Gmail dans le fichier .env'
            ], 500);
        }
    }

    /**
     * Déterminer la méthode WhatsApp active
     */
    private function getActiveWhatsAppMethod(): string
    {
        if (!empty(env('WHATSAPP_360_API_KEY'))) {
            return '360dialog';
        }
        if (!empty(env('WHATSAPP_ACCESS_TOKEN')) && !empty(env('WHATSAPP_PHONE_NUMBER_ID'))) {
            return 'meta';
        }
        if (!empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN')) && !empty(env('TWILIO_WHATSAPP_NUMBER'))) {
            return 'twilio';
        }
        if (!empty(env('CALLMEBOT_API_KEY'))) {
            return 'callmebot';
        }
        
        return 'none';
    }
}
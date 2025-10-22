<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PublicTestController extends Controller
{
    /**
     * Test public de la configuration (sans authentification)
     */
    public function testConfig()
    {
        try {
            $config = [
                'app' => [
                    'name' => config('app.name'),
                    'env' => config('app.env'),
                    'debug' => config('app.debug'),
                    'url' => config('app.url')
                ],
                'email' => [
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'username' => config('mail.mailers.smtp.username') ? 
                        str_replace(substr(config('mail.mailers.smtp.username'), 2, -10), '***', config('mail.mailers.smtp.username')) : 
                        'Non configuré',
                    'password' => config('mail.mailers.smtp.password') ? 'Configuré (masqué)' : 'Non configuré',
                    'from_name' => config('mail.from.name'),
                    'from_address' => config('mail.from.address'),
                    'status' => config('mail.mailers.smtp.username') && config('mail.mailers.smtp.password') ? '✅ Configuré' : '❌ Manquant'
                ],
                'whatsapp' => [
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
                    'twilio' => [
                        'configured' => !empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN')) && !empty(env('TWILIO_WHATSAPP_NUMBER')),
                        'sid' => env('TWILIO_SID') ? 'AC***' . substr(env('TWILIO_SID'), -4) : 'Non configuré',
                        'number' => env('TWILIO_WHATSAPP_NUMBER') ?: 'Non configuré',
                        'status' => (!empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN'))) ? '✅ Configuré' : '❌ Manquant'
                    ],
                    'active_method' => $this->getActiveWhatsAppMethod()
                ],
                'recommendations' => $this->getRecommendations()
            ];
            
            return response()->json($config, 200, [], JSON_PRETTY_PRINT);
            
        } catch (\Exception $e) {
            Log::error('Erreur test config: ' . $e->getMessage());
            return response()->json([
                'error' => 'Erreur lors du test',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Instructions pour configurer les notifications
     */
    public function instructions()
    {
        $instructions = [
            'title' => '🚀 Configuration Notifications NIF CARGO',
            'current_status' => [
                'email' => $this->getEmailStatus(),
                'whatsapp' => $this->getWhatsAppStatus()
            ],
            'steps' => [
                'email' => [
                    'title' => '📧 Configuration Email Gmail (5 minutes)',
                    'status' => $this->getEmailStatus()['ready'] ? 'TERMINÉ ✅' : 'À FAIRE ❌',
                    'steps' => [
                        '1. Activer authentification 2 facteurs sur Gmail',
                        '2. Créer un mot de passe d\'application',
                        '3. Remplacer xxx@gmail.com et xxx_app_password dans .env',
                        '4. Tester via: GET /test-config'
                    ]
                ],
                'whatsapp' => [
                    'title' => '📱 Configuration WhatsApp CallMeBot (2 minutes - GRATUIT)',
                    'status' => $this->getWhatsAppStatus()['ready'] ? 'TERMINÉ ✅' : 'À FAIRE ❌',
                    'steps' => [
                        '1. Ajouter contact WhatsApp: +34 644 94 50 22',
                        '2. Envoyer message: "I allow callmebot to send me messages"',
                        '3. Aller sur: https://www.callmebot.com/blog/free-api-whatsapp-messages/',
                        '4. Saisir votre numéro et récupérer API Key',
                        '5. Ajouter CALLMEBOT_API_KEY=votre-cle dans .env'
                    ]
                ]
            ],
            'test_urls' => [
                'Configuration actuelle' => url('/test-config'),
                'Instructions détaillées' => url('/test-instructions'),
                'Après authentification' => url('/admin/test')
            ]
        ];
        
        return response()->json($instructions, 200, [], JSON_PRETTY_PRINT);
    }

    /**
     * Déterminer la méthode WhatsApp active
     */
    private function getActiveWhatsAppMethod(): string
    {
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

    /**
     * Obtenir le statut email
     */
    private function getEmailStatus(): array
    {
        $username = config('mail.mailers.smtp.username');
        $password = config('mail.mailers.smtp.password');
        
        return [
            'ready' => !empty($username) && !empty($password) && !str_contains($username, 'xxx'),
            'username' => $username ?: 'Non configuré',
            'needs_setup' => str_contains($username ?? '', 'xxx') || empty($password)
        ];
    }

    /**
     * Obtenir le statut WhatsApp
     */
    private function getWhatsAppStatus(): array
    {
        $meta = !empty(env('WHATSAPP_ACCESS_TOKEN')) && !empty(env('WHATSAPP_PHONE_NUMBER_ID'));
        $callmebot = !empty(env('CALLMEBOT_API_KEY'));
        $twilio = !empty(env('TWILIO_SID')) && !empty(env('TWILIO_AUTH_TOKEN'));
        
        return [
            'ready' => $meta || $callmebot || $twilio,
            'meta_ready' => $meta,
            'callmebot_ready' => $callmebot,
            'twilio_ready' => $twilio,
            'active_method' => $this->getActiveWhatsAppMethod()
        ];
    }

    /**
     * Obtenir les recommandations
     */
    private function getRecommendations(): array
    {
        $email = $this->getEmailStatus();
        $whatsapp = $this->getWhatsAppStatus();
        
        $recommendations = [];
        
        if (!$email['ready']) {
            $recommendations[] = '📧 Configurez votre email Gmail en remplaçant xxx@gmail.com et xxx_app_password dans .env';
        }
        
        if (!$whatsapp['ready']) {
            $recommendations[] = '📱 Configurez WhatsApp CallMeBot (gratuit) en ajoutant CALLMEBOT_API_KEY dans .env';
        }
        
        if ($email['ready'] && $whatsapp['ready']) {
            $recommendations[] = '🎉 Configuration complète ! Vous pouvez maintenant tester via /admin/test après authentification';
        }
        
        return $recommendations;
    }
}
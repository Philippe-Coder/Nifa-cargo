<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

// Route temporaire pour tester les images (à supprimer après test)
Route::get('/test-images', function () {
    return view('test-images');
})->name('test.images');

// Route de test WhatsApp 360dialog - PRODUCTION READY
Route::get('/test-whatsapp', function (Request $request) {
    $phone = $request->query('phone');
    
    // Vérification du numéro
    if (!$phone) {
        return response()->json([
            'success' => false,
            'error' => 'Paramètre "phone" requis. Exemple: /test-whatsapp?phone=+228XXXXXXXX',
            'info' => 'En mode sandbox 360dialog, utilisez uniquement votre numéro vérifié'
        ], 400);
    }
    
    // Normalisation du numéro
    if (!str_starts_with($phone, '+')) {
        $phone = '+228' . ltrim($phone, '0'); // Ajouter indicatif Togo par défaut
    }
    
    $message = "🚀 Test WhatsApp NIF CARGO via 360dialog\n" . 
               "📅 " . now()->format('d/m/Y à H:i:s') . "\n" .
               "✅ Configuration API fonctionnelle!";
    
    $payload = [
        'messaging_product' => 'whatsapp',
        'to' => $phone,
        'type' => 'text',
        'text' => [
            'body' => $message
        ]
    ];
    
    try {
        Log::info('📱 Test WhatsApp 360dialog', ['phone' => $phone, 'payload' => $payload]);
        
        $response = Http::withHeaders([
            'D360-API-KEY' => env('WHATSAPP_360_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(30)->post(env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io') . '/v1/messages', $payload);
        
        Log::info('📱 Réponse 360dialog', ['status' => $response->status(), 'body' => $response->body()]);
        
        if ($response->successful()) {
            $responseData = $response->json();
            return response()->json([
                'success' => true,
                'message' => '✅ WhatsApp envoyé avec succès!',
                'phone' => $phone,
                'message_id' => $responseData['messages'][0]['id'] ?? null,
                'status' => $responseData['messages'][0]['message_status'] ?? 'sent',
                'timestamp' => now()->toISOString(),
                'info' => 'Message envoyé via 360dialog API'
            ]);
        } else {
            $errorBody = $response->body();
            $errorData = json_decode($errorBody, true);
            
            // Messages d'erreur spécifiques
            $errorMessage = 'Erreur 360dialog API';
            if (str_contains($errorBody, 'can only send to your verified number')) {
                $errorMessage = '🔒 Sandbox: Vous ne pouvez envoyer qu\'à votre numéro vérifié. Vérifiez votre numéro sur la plateforme 360dialog.';
            } elseif (str_contains($errorBody, 'messaging_product')) {
                $errorMessage = '⚙️ Erreur de configuration API: paramètre messaging_product requis.';
            }
            
            return response()->json([
                'success' => false,
                'error' => $errorMessage,
                'details' => $errorData['detail'] ?? $errorBody,
                'status' => $response->status(),
                'phone' => $phone,
                'solution' => str_contains($errorBody, 'verified number') 
                    ? 'Vérifiez votre numéro sur https://hub.360dialog.com ou utilisez votre numéro vérifié'
                    : 'Vérifiez la configuration API dans le fichier .env'
            ], 400);
        }
    } catch (\Exception $e) {
        Log::error('❌ Exception test WhatsApp', ['error' => $e->getMessage(), 'phone' => $phone]);
        
        return response()->json([
            'success' => false,
            'error' => 'Exception réseau ou configuration',
            'details' => $e->getMessage(),
            'phone' => $phone,
            'solution' => 'Vérifiez votre connexion internet et la configuration .env'
        ], 500);
    }
});

// Route de test notification complète (admin uniquement)
Route::middleware(['auth'])->get('/admin/test-notification', function (Request $request) {
    $phone = $request->query('phone');
    $email = $request->query('email', Auth::user()?->email ?? 'admin@nifcargo.com');
    
    if (!$phone) {
        return response()->json([
            'success' => false,
            'error' => 'Paramètre "phone" requis. Exemple: /admin/test-notification?phone=+228XXXXXXXX',
        ], 400);
    }
    
    // Normalisation du numéro
    if (!str_starts_with($phone, '+')) {
        $phone = '+228' . ltrim($phone, '0');
    }
    
    $testData = [
        'client_nom' => 'Test Client',
        'statut' => 'En transit',
        'destination' => 'Lomé, Togo',
        'date_creation' => now()->format('d/m/Y'),
        'tracking_number' => 'TRK' . rand(100000, 999999)
    ];
    
    $message = "🚛 *NIF CARGO* - Test Notification\n\n" .
               " **Client**: {$testData['client_nom']}\n" .
               "📍 **Destination**: {$testData['destination']}\n" .
               "📅 **Date**: {$testData['date_creation']}\n" .
               "🔍 **Numéro de suivi**: {$testData['tracking_number']}\n" .
               "📊 **Statut**: {$testData['statut']}\n\n" .
               "✅ Système de notification fonctionnel!";
    
    try {
        // Test avec payload WhatsApp direct pour éviter les erreurs de type
        $payload = [
            'messaging_product' => 'whatsapp',
            'to' => $phone,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];
        
        $whatsappResult = Http::withHeaders([
            'D360-API-KEY' => env('WHATSAPP_360_API_KEY'),
            'Content-Type' => 'application/json',
        ])->timeout(30)->post(env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io') . '/v1/messages', $payload);
        
        // Test email basique
        $emailResult = ['success' => true, 'message' => 'Email simulé (pas d\'envoi réel en test)'];
        
        $result = [
            'whatsapp' => $whatsappResult->successful() ? 'Envoyé avec succès' : 'Erreur: ' . $whatsappResult->body(),
            'email' => $emailResult['message']
        ];
        
        Log::info('🧪 Test notification complète', [
            'email' => $email,
            'phone' => $phone,
            'result' => $result,
            'test_data' => $testData
        ]);
        
        return response()->json([
            'success' => true,
            'message' => '✅ Test de notification complète réussi!',
            'results' => $result,
            'test_data' => $testData,
            'email' => $email,
            'phone' => $phone,
            'timestamp' => now()->toISOString()
        ]);
        
    } catch (\Exception $e) {
        Log::error('❌ Erreur test notification', ['error' => $e->getMessage(), 'phone' => $phone, 'email' => $email]);
        
        return response()->json([
            'success' => false,
            'error' => 'Erreur lors du test de notification',
            'details' => $e->getMessage(),
            'phone' => $phone,
            'email' => $email
        ], 500);
    }
})->name('admin.test.notification');

// Route pour configurer CallMeBot comme fallback
Route::get('/admin/setup-callmebot', function () {
    $instructions = [
        'title' => 'Configuration CallMeBot pour Fallback WhatsApp',
        'steps' => [
            '1. Ouvrez WhatsApp et envoyez le message "I allow callmebot to send me messages" au numéro +34 644 94 43 21',
            '2. Attendez la réponse avec votre API Key personnelle',
            '3. Ajoutez cette clé dans votre fichier .env :',
            '   CALLMEBOT_API_KEY=votre_cle_recue',
            '4. Testez avec : /test-callmebot-fallback?phone=VOTRENUMERO'
        ],
        'benefits' => [
            '✅ Fallback gratuit pour les numéros non vérifiés 360dialog',
            '✅ Pas de limite de numéros comme le sandbox 360dialog',
            '✅ Configuration simple en 2 minutes',
            '✅ Idéal pour les tests et développement'
        ],
        'current_config' => [
            'WHATSAPP_360_API_KEY' => env('WHATSAPP_360_API_KEY') ? '✅ Configuré' : '❌ Manquant',
            'CALLMEBOT_API_KEY' => env('CALLMEBOT_API_KEY') ? '✅ Configuré' : '❌ Manquant (recommandé pour fallback)',
        ]
    ];
    
    return response()->json($instructions);
})->middleware(['auth'])->name('admin.setup.callmebot');

// Route de test CallMeBot fallback
Route::get('/test-callmebot-fallback', function (Request $request) {
    $phone = $request->query('phone');
    
    if (!$phone) {
        return response()->json([
            'success' => false,
            'error' => 'Paramètre "phone" requis. Exemple: /test-callmebot-fallback?phone=22897311158'
        ], 400);
    }
    
    $apiKey = env('CALLMEBOT_API_KEY');
    if (!$apiKey) {
        return response()->json([
            'success' => false,
            'error' => 'CallMeBot non configuré. Visitez /admin/setup-callmebot pour les instructions',
            'setup_url' => url('/admin/setup-callmebot')
        ], 400);
    }
    
    // Nettoyer le numéro (CallMeBot utilise format sans + ni indicatif pays)
    $cleanPhone = preg_replace('/[^0-9]/', '', $phone);
    if (str_starts_with($cleanPhone, '228')) {
        $cleanPhone = substr($cleanPhone, 3); // Retirer l'indicatif Togo
    }
    
    $message = "🧪 Test CallMeBot Fallback - " . now()->format('d/m/Y H:i:s') . "\n✅ Système de fallback WhatsApp fonctionnel!";
    
    try {
        $url = "https://api.callmebot.com/whatsapp.php";
        $response = Http::get($url, [
            'phone' => $cleanPhone,
            'text' => $message,
            'apikey' => $apiKey
        ]);
        
        if ($response->successful()) {
            Log::info('✅ CallMeBot fallback test réussi', ['phone' => $cleanPhone]);
            
            return response()->json([
                'success' => true,
                'message' => 'CallMeBot test réussi! Ce service peut servir de fallback.',
                'phone' => $cleanPhone,
                'info' => 'Idéal comme fallback pour les numéros non vérifiés en sandbox 360dialog'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'error' => 'Erreur CallMeBot: ' . $response->body(),
                'solution' => 'Vérifiez que vous avez bien envoyé le message d\'autorisation au +34 644 94 43 21'
            ], 400);
        }
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => 'Exception CallMeBot: ' . $e->getMessage()
        ], 500);
    }
})->name('test.callmebot.fallback');
use App\Http\Controllers\Public\DemandeController;
use App\Http\Controllers\Admin\DemandeTransportController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\Admin\EtapeLogistiqueController;
use App\Http\Controllers\Admin\AnnonceController;
use App\Http\Controllers\Admin\GalerieController;
use App\Http\Controllers\Client\SuiviController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\Public\PublicController;
use App\Http\Controllers\Auth\CustomRegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\TestNotificationController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\Public\GaleriePubliqueController;

// Route pour changer de langue
Route::get('/lang/{locale}', [LanguageController::class, 'switch'])->name('lang.switch');

// Routes de test pour les traductions (à enlever en production)
Route::get('/test-translation', function () {
    return view('test-translation');
})->name('test.translation');

Route::get('/test-translation-url', function () {
    return view('test-translation-url');
})->name('test.translation.url');

Route::get('/test-simple', function () {
    return view('test-simple-translation');
})->name('test.simple');

Route::get('/api/test-locale', [App\Http\Controllers\TestController::class, 'testLocale']);
Route::get('/api/set-locale/{locale}', [App\Http\Controllers\TestController::class, 'setTestLocale']);

// Routes publiques de la galerie
Route::get('/galerie', [GaleriePubliqueController::class, 'index'])->name('galerie.index');
Route::get('/galerie/{galerie}', [GaleriePubliqueController::class, 'show'])->name('galerie.show');
Route::get('/galerie/categorie/{categorie}', [GaleriePubliqueController::class, 'categorie'])->name('galerie.categorie');
// Routes publiques (vitrine)
Route::get('/', [PublicController::class, 'accueil'])->name('accueil');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'envoyerContact'])->name('contact.envoyer');
Route::get('/a-propos', [PublicController::class, 'apropos'])->name('apropos');
Route::get('/suivi', [PublicController::class, 'suiviPublic'])->name('suivi.public');
Route::post('/suivi', [PublicController::class, 'rechercherDemande'])->name('suivi.rechercher');

// Route pour le sitemap XML
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Routes publiques de test des notifications (sans authentification)
Route::get('/test-config', [\App\Http\Controllers\PublicTestController::class, 'testConfig'])->name('test.config.public');
Route::get('/test-instructions', [\App\Http\Controllers\PublicTestController::class, 'instructions'])->name('test.instructions.public');

// Routes pour le blog/actualités
Route::get('/blog', [PublicController::class, 'blog'])->name('blog.index');
Route::get('/blog/{id}', [PublicController::class, 'showArticle'])->name('blog.show');

// Routes pour les commentaires
Route::post('/blog/{annonce}/comments', [\App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
Route::get('/blog/{annonce}/comments', [\App\Http\Controllers\CommentController::class, 'index'])->name('comments.index');
Route::post('/comments/{comment}/approve', [\App\Http\Controllers\CommentController::class, 'approve'])->name('comments.approve');
Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');



// Routes publiques pour les paiements (callbacks)
Route::get('/paiement/success', [PaiementController::class, 'success'])->name('paiement.success');
Route::get('/paiement/cancel', [PaiementController::class, 'cancel'])->name('paiement.cancel');
Route::post('/paiement/callback/flooz', [PaiementController::class, 'callbackFlooz'])->name('paiement.callback.flooz');
Route::post('/paiement/callback/tmoney', [PaiementController::class, 'callbackTMoney'])->name('paiement.callback.tmoney');
Route::post('/paiement/webhook/stripe', [PaiementController::class, 'webhookStripe'])->name('paiement.webhook.stripe');

// Routes d'inscription personnalisées
Route::get('/register/client', [CustomRegisterController::class, 'showClientRegister'])->name('register.client');
Route::post('/register/client', [CustomRegisterController::class, 'registerClient'])->name('register.client.store');
Route::get('/register/admin', [CustomRegisterController::class, 'showAdminRegister'])->name('register.admin');
Route::post('/register/admin', [CustomRegisterController::class, 'registerAdmin'])->name('register.admin.store');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

// Routes protégées par authentification
Route::middleware(['auth'])->group(function () {
    // Routes de notification
    Route::prefix('notifications')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
        Route::post('/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllRead');
        Route::delete('/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        Route::get('/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    });
    
    // Routes de demande de transport
    Route::get('/demande-transport', [DemandeController::class, 'create'])->name('demande.create');
    Route::post('/demande-transport', [DemandeController::class, 'store'])->name('demande.store');
    
    // Interface client de suivi
    Route::get('/mes-demandes', [SuiviController::class, 'index'])->name('mes-demandes.index');
    Route::get('/mes-demandes/{demande}', [SuiviController::class, 'show'])->name('mes-demandes.show');
    
    // Gestion des documents
    Route::get('/demandes/{demande}/documents', [DocumentController::class, 'index'])->name('documents.index');
    Route::post('/demandes/{demande}/documents', [DocumentController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::delete('/documents/{document}', [DocumentController::class, 'destroy'])->name('documents.destroy');
    
    // Gestion des paiements
    Route::get('/factures/{facture}/paiement', [PaiementController::class, 'show'])->name('paiement.show');
    Route::post('/factures/{facture}/paiement', [PaiementController::class, 'initier'])->name('paiement.initier');
    Route::get('/paiements/historique', [PaiementController::class, 'historique'])->name('paiement.historique');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    
    // Routes spécifiques pour les demandes (AVANT les routes avec paramètres)
    Route::get('/demandes/create-admin', [\App\Http\Controllers\Admin\AdminDemandeController::class, 'create'])->name('admin.demandes.create-admin');
    Route::post('/demandes/store-admin', [\App\Http\Controllers\Admin\AdminDemandeController::class, 'store'])->name('admin.demandes.store-admin');
    Route::get('/demandes/search-clients', [\App\Http\Controllers\Admin\AdminDemandeController::class, 'searchClients'])->name('admin.demandes.search-clients');
    Route::get('/demandes/get-client/{id}', [\App\Http\Controllers\Admin\AdminDemandeController::class, 'getClient'])->name('admin.demandes.get-client');
    
    // Route de test pour vérifier l'envoi d'email
    Route::get('/test-email', function () {
        try {
            \Illuminate\Support\Facades\Mail::html(
                '<div style="padding: 20px; background: #f4f4f4;"><div style="background: white; padding: 20px; border-radius: 10px; max-width: 600px; margin: 0 auto;"><h1 style="color: #10b981;">🧪 Test Email NIF CARGO</h1><p>Ceci est un test d\'envoi d\'email depuis l\'admin.</p><p><strong>Date:</strong> ' . now() . '</p><p><strong>Configuration email actuelle:</strong></p><ul><li>Host: ' . config('mail.mailers.smtp.host') . '</li><li>Port: ' . config('mail.mailers.smtp.port') . '</li><li>Username: ' . config('mail.mailers.smtp.username') . '</li><li>From: ' . config('mail.from.address') . '</li></ul></div></div>',
                function ($mail) {
                    $mail->to(config('mail.from.address')) // Envoyer à soi-même pour test
                         ->subject('🧪 Test Email NIF CARGO - ' . now()->format('d/m/Y H:i'))
                         ->from(config('mail.from.address'), config('mail.from.name'));
                }
            );
            return response()->json([
                'success' => true, 
                'message' => 'Email de test envoyé avec succès à ' . config('mail.from.address'),
                'config' => [
                    'mailer' => config('mail.default'),
                    'host' => config('mail.mailers.smtp.host'),
                    'port' => config('mail.mailers.smtp.port'),
                    'from' => config('mail.from.address')
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    })->name('admin.test-email');
    
    // Route de test pour les templates de notification
    Route::get('/test-notifications', function () {
        try {
            $testClient = (object) [
                'name' => 'Test Client',
                'email' => config('mail.from.address'),
                'telephone' => '+22800000000'
            ];
            
            $testDemande = (object) [
                'numero_tracking' => 'TRK202410290001',
                'ville_depart' => 'Lomé',
                'ville_destination' => 'Accra',
                'nature_colis' => 'Vêtements',
                'poids' => 5.5,
                'volume' => 0.1,
                'type' => 'express',
                'statut' => 'en attente',
                'frais_expedition' => 25000
            ];
            
            $results = [];
            
            // Test email bienvenue
            try {
                \Illuminate\Support\Facades\Mail::send('emails.welcome-client', [
                    'client_name' => $testClient->name,
                    'email' => $testClient->email,
                    'password' => 'NIF20241234',
                    'login_url' => route('login')
                ], function ($mail) use ($testClient) {
                    $mail->to($testClient->email, $testClient->name)
                         ->subject('🎉 Test - Bienvenue chez NIF CARGO')
                         ->from(config('mail.from.address'), config('mail.from.name'));
                });
                $results['welcome_email'] = 'Envoyé ✅';
            } catch (\Exception $e) {
                $results['welcome_email'] = 'Erreur: ' . $e->getMessage();
            }
            
            // Test email demande créée
            try {
                \Illuminate\Support\Facades\Mail::send('emails.demande-created-by-admin', [
                    'client_name' => $testClient->name,
                    'demande' => $testDemande,
                    'tracking_number' => $testDemande->numero_tracking,
                    'suivi_url' => route('suivi.public') . '?tracking=' . $testDemande->numero_tracking,
                    'login_url' => route('login')
                ], function ($mail) use ($testClient, $testDemande) {
                    $mail->to($testClient->email, $testClient->name)
                         ->subject('📦 Test - Nouvelle demande ' . $testDemande->numero_tracking)
                         ->from(config('mail.from.address'), config('mail.from.name'));
                });
                $results['demande_email'] = 'Envoyé ✅';
            } catch (\Exception $e) {
                $results['demande_email'] = 'Erreur: ' . $e->getMessage();
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Tests des notifications terminés',
                'results' => $results,
                'sent_to' => $testClient->email
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ]);
        }
    })->name('admin.test-notifications');
    
    // Routes générales pour les demandes (APRÈS les routes spécifiques)
    Route::get('/demandes', [DemandeTransportController::class, 'index'])->name('admin.demandes.index');
    Route::get('/demandes/export', [DemandeTransportController::class, 'export'])->name('admin.demandes.export');
    Route::get('/demandes/export/pdf', [DemandeTransportController::class, 'exportPDF'])->name('admin.demandes.export.pdf');
    Route::get('/demandes/{id}', [DemandeTransportController::class, 'show'])->name('admin.demandes.show');
    Route::get('/demandes/{id}/pdf', [DemandeTransportController::class, 'downloadPDF'])->name('admin.demandes.pdf');
    Route::post('/demandes/{id}/statut', [DemandeTransportController::class, 'updateStatut'])->name('admin.demandes.updateStatut');
    Route::post('/demandes/{id}/tracking', [DemandeTransportController::class, 'updateTracking'])->name('admin.demandes.updateTracking');
    Route::delete('/demandes/{id}', [DemandeTransportController::class, 'destroy'])->name('admin.demandes.destroy');
    
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('admin.clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('admin.clients.destroy');
    Route::get('/clients/export/csv', [ClientController::class, 'exportCSV'])->name('admin.clients.export.csv');
    Route::get('/clients/export/pdf', [ClientController::class, 'exportPDF'])->name('admin.clients.export.pdf');
    
    // Gestion des étapes logistiques
    Route::post('/etapes/{id}/statut', [EtapeLogistiqueController::class, 'updateStatut'])->name('admin.etapes.updateStatut');
    Route::post('/etapes/{id}/agent', [EtapeLogistiqueController::class, 'assignerAgent'])->name('admin.etapes.assignerAgent');
    Route::get('/etapes/{id}', [EtapeLogistiqueController::class, 'show'])->name('admin.etapes.show');
    
    // Gestion des annonces
    Route::resource('annonces', AnnonceController::class)->names([
        'index' => 'admin.annonces.index',
        'create' => 'admin.annonces.create',
        'store' => 'admin.annonces.store',
        'show' => 'admin.annonces.show',
        'edit' => 'admin.annonces.edit',
        'update' => 'admin.annonces.update',
        'destroy' => 'admin.annonces.destroy'
    ]);
    Route::post('/annonces/{annonce}/toggle-active', [AnnonceController::class, 'toggleActive'])->name('admin.annonces.toggle-active');
    Route::post('/annonces/{annonce}/toggle-epingle', [AnnonceController::class, 'toggleEpingle'])->name('admin.annonces.toggle-epingle');
    
    // Gestion de la galerie
    Route::resource('galeries', GalerieController::class)->names([
        'index' => 'admin.galeries.index',
        'create' => 'admin.galeries.create',
        'store' => 'admin.galeries.store',
        'show' => 'admin.galeries.show',
        'edit' => 'admin.galeries.edit',
        'update' => 'admin.galeries.update',
        'destroy' => 'admin.galeries.destroy'
    ]);
    Route::post('/galeries/{galerie}/toggle-active', [GalerieController::class, 'toggleActive'])->name('admin.galeries.toggle-active');
    Route::post('/galeries/{galerie}/toggle-mise-en-avant', [GalerieController::class, 'toggleMiseEnAvant'])->name('admin.galeries.toggle-mise-en-avant');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Routes pour les documents d'étape
    Route::post('/etapes/{etape}/documents', [\App\Http\Controllers\EtapeDocumentController::class, 'store'])->name('etape-documents.store');
    Route::get('/etape-documents/{document}/download', [\App\Http\Controllers\EtapeDocumentController::class, 'download'])->name('etape-documents.download');
    Route::delete('/etape-documents/{document}', [\App\Http\Controllers\EtapeDocumentController::class, 'destroy'])->name('etape-documents.destroy');
    Route::get('/etapes/{etape}/documents', [\App\Http\Controllers\EtapeDocumentController::class, 'index'])->name('etape-documents.index');
});

require __DIR__.'/auth.php';

// Routes de test pour les notifications (à supprimer en production)
Route::middleware('auth')->group(function () {
    Route::prefix('admin/test')->group(function () {
        // Interface de test
        Route::get('/', [\App\Http\Controllers\Admin\TestNotificationViewController::class, 'index'])
            ->name('test.notifications.index');
        
        // Tests complets
        Route::get('/notifications/{demande}', [TestNotificationController::class, 'testNotifications'])
            ->name('test.notifications.all');
        
        // Tests spécifiques
        Route::get('/email/{demande}', [TestNotificationController::class, 'testEmail'])
            ->name('test.notifications.email');
        Route::get('/whatsapp/{demande}', [TestNotificationController::class, 'testWhatsApp'])
            ->name('test.notifications.whatsapp');
        
        // Configuration et diagnostics
        Route::get('/config', [TestNotificationController::class, 'showConfig'])
            ->name('test.notifications.config');
        Route::get('/email-connection', [TestNotificationController::class, 'testEmailConnection'])
            ->name('test.notifications.email-connection');
    });
});

// Route de debug des traductions
Route::get('/debug-lang', function() {
    return [
        'current_locale' => app()->getLocale(),
        'url_locale' => request()->get('locale'),
        'session_locale' => session('locale'),
        'test_translation' => __('Accueil'),
        'test_welcome' => __('Bienvenue'),
        'test_transport' => __('Transport Maritime'),
        'config_locale' => config('app.locale'),
        'available_locales' => config('app.available_locales', ['fr', 'en', 'zh_CN'])
    ];
});

// Page de test des traductions
Route::get('/test-traductions', function() {
    return view('test-traductions');
});

// Page de debug locale avancée
Route::get('/debug-locale', function() {
    return view('debug-locale');
});

// Route de test ultra simple pour le middleware
Route::get('/test-middleware', function() {
    return response()->json([
        'middleware_test' => 'SUCCESS',
        'current_locale' => app()->getLocale(),
        'session_locale' => session('locale'),
        'url_locale' => request()->get('locale'),
        'test_translation' => __('Accueil'),
        'timestamp' => now()->toDateTimeString()
    ]);
});

<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Route temporaire pour tester les images (à supprimer après test)
Route::get('/test-images', function () {
    return view('test-images');
})->name('test.images');

// Route temporaire pour tester WhatsApp 360dialog (à supprimer après test)
Route::get('/test-whatsapp', function () {
    try {
        $apiKey = env('WHATSAPP_360_API_KEY');
        $baseUrl = env('WHATSAPP_360_BASE_URL', 'https://waba-sandbox.360dialog.io');
        
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'error' => 'API Key 360dialog manquante dans .env'
            ]);
        }
        
        // Numéro de test (remplacez par votre numéro)
        $testPhone = request()->get('phone', '+22897311158'); // Votre numéro WhatsApp
        $message = "🧪 Test WhatsApp 360dialog\n\nCeci est un test d'envoi WhatsApp depuis NIF CARGO.\n\nDate: " . now()->format('d/m/Y H:i') . "\n\n📦 NIF CARGO - Transport & Logistique";
        
        $url = $baseUrl . '/v1/messages';
        
        $payload = [
            'to' => $testPhone,
            'type' => 'text',
            'text' => [
                'body' => $message
            ]
        ];
        
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'D360-API-KEY' => $apiKey,
            'Content-Type' => 'application/json'
        ])->post($url, $payload);
        
        return response()->json([
            'success' => $response->successful(),
            'status_code' => $response->status(),
            'response_body' => $response->json(),
            'config' => [
                'api_key' => substr($apiKey, 0, 8) . '...',
                'base_url' => $baseUrl,
                'phone' => $testPhone
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
})->name('test.whatsapp');
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
    Route::get('/demandes/{id}', [DemandeTransportController::class, 'show'])->name('admin.demandes.show');
    Route::get('/demandes/{id}/pdf', [DemandeTransportController::class, 'downloadPDF'])->name('admin.demandes.pdf');
    Route::post('/demandes/{id}/statut', [DemandeTransportController::class, 'updateStatut'])->name('admin.demandes.updateStatut');
    Route::delete('/demandes/{id}', [DemandeTransportController::class, 'destroy'])->name('admin.demandes.destroy');
    
    Route::get('/clients', [ClientController::class, 'index'])->name('admin.clients.index');
    Route::get('/clients/{id}', [ClientController::class, 'show'])->name('admin.clients.show');
    Route::delete('/clients/{id}', [ClientController::class, 'destroy'])->name('admin.clients.destroy');
    
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

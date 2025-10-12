<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
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


// Routes de la galerie
Route::get('/galerie', [GalerieController::class, 'index'])->name('galerie.index');
Route::get('/galerie/{galerie}', [GalerieController::class, 'show'])->name('galerie.show');
// Routes publiques (vitrine)
Route::get('/', [PublicController::class, 'accueil'])->name('accueil');
Route::get('/services', [PublicController::class, 'services'])->name('services');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'envoyerContact'])->name('contact.envoyer');
Route::get('/a-propos', [PublicController::class, 'apropos'])->name('apropos');
Route::get('/suivi', [PublicController::class, 'suiviPublic'])->name('suivi.public');
Route::post('/suivi', [PublicController::class, 'rechercherDemande'])->name('suivi.rechercher');



// Routes publiques pour les paiements (callbacks)
Route::get('/paiement/success', [PaiementController::class, 'success'])->name('paiement.success');
Route::get('/paiement/cancel', [PaiementController::class, 'cancel'])->name('paiement.cancel');
Route::post('/paiement/callback/flooz', [PaiementController::class, 'callbackFlooz'])->name('paiement.callback.flooz');
Route::post('/paiement/callback/tmoney', [PaiementController::class, 'callbackTMoney'])->name('paiement.callback.tmoney');
Route::post('/paiement/webhook/stripe', [PaiementController::class, 'webhookStripe'])->name('paiement.webhook.stripe');

// Routes d'inscription personnalisées
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
    Route::get('/demandes', [DemandeTransportController::class, 'index'])->name('admin.demandes.index');
    Route::get('/demandes/{id}', [DemandeTransportController::class, 'show'])->name('admin.demandes.show');
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
});

require __DIR__.'/auth.php';

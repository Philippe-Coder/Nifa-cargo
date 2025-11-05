<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'client')->withCount('demandes');

        // Filtrage par statut de vérification
        if ($request->filled('statut') && $request->statut !== 'tous') {
            switch ($request->statut) {
                case 'actifs':
                    $query->whereNull('suspended_at');
                    break;
                case 'suspendus':
                    $query->whereNotNull('suspended_at');
                    break;
                case 'verifies':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'non_verifies':
                    $query->whereNull('email_verified_at');
                    break;
                case 'recents':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'avec_demandes':
                    $query->has('demandes');
                    break;
            }
        }

        // Recherche par nom, email, ou téléphone
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('telephone', 'like', "%{$searchTerm}%");
            });
        }

        // Filtrage par période d'inscription
        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $clients = $query->latest()->paginate(10)->withQueryString();

        // Statistiques pour les cartes
        $totalClients = User::where('role', 'client')->count();
        $clientsVerifies = User::where('role', 'client')->whereNotNull('email_verified_at')->count();
        $clientsRecents = User::where('role', 'client')->where('created_at', '>=', now()->subDays(30))->count();
        $clientsAvecDemandes = User::where('role', 'client')->has('demandes')->count();
        $clientsSuspendus = User::where('role', 'client')->whereNotNull('suspended_at')->count();

        return view('admin.clients.index', compact(
            'clients', 
            'totalClients', 
            'clientsVerifies', 
            'clientsRecents', 
            'clientsAvecDemandes',
            'clientsSuspendus'
        ));
    }

    public function show($id)
    {
        $client = User::with('demandes')->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function destroy(Request $request, $id)
    {
        // Valider la confirmation de suppression
        $request->validate([
            'confirmation' => 'required|string|in:SUPPRIMER'
        ], [
            'confirmation.required' => 'Vous devez taper SUPPRIMER pour confirmer la suppression.',
            'confirmation.in' => 'Vous devez taper exactement SUPPRIMER en majuscules.'
        ]);

        $client = User::where('role', 'client')->findOrFail($id);
        
        // Vérifier s'il a des demandes en cours
        $demandesEnCours = $client->demandes()->whereNotIn('statut', ['livree', 'annulee', 'terminee'])->count();
        
        if ($demandesEnCours > 0) {
            return redirect()->back()
                ->with('error', "Impossible de supprimer ce client car il a {$demandesEnCours} demande(s) en cours. Veuillez d'abord traiter ses demandes.");
        }

        $clientName = $client->name;
        $clientEmail = $client->email;

        try {
            // Notifier le client avant suppression
            \App\Services\NotificationService::notifyClientAccountDeleted($client);
        } catch (\Exception $e) {
            Log::warning("Erreur lors de l'envoi de la notification de suppression: " . $e->getMessage());
        }
        
        // Supprimer le client et toutes ses données associées
        $client->delete();

        return redirect()->route('admin.clients.index')
            ->with('success', "Le compte de {$clientName} ({$clientEmail}) a été supprimé définitivement.");
    }

    public function exportCSV(Request $request)
    {
        $query = User::where('role', 'client')->withCount('demandes');

        // Appliquer les mêmes filtres
        if ($request->filled('statut') && $request->statut !== 'tous') {
            switch ($request->statut) {
                case 'verifies':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'non_verifies':
                    $query->whereNull('email_verified_at');
                    break;
                case 'recents':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'avec_demandes':
                    $query->has('demandes');
                    break;
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('telephone', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $clients = $query->latest()->get();

        $filename = 'clients_' . now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () use ($clients) {
            $file = fopen('php://output', 'w');
            
            // En-têtes CSV
            fputcsv($file, [
                'Nom',
                'Email',
                'Téléphone',
                'Statut de vérification',
                'Nombre de demandes',
                'Date d\'inscription',
                'Dernière connexion'
            ]);

            foreach ($clients as $client) {
                fputcsv($file, [
                    $client->name,
                    $client->email,
                    $client->telephone,
                    $client->email_verified_at ? 'Vérifié' : 'Non vérifié',
                    $client->demandes_count,
                    $client->created_at->format('d/m/Y'),
                    $client->updated_at->format('d/m/Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPDF(Request $request)
    {
        $query = User::where('role', 'client')->withCount('demandes');

        // Appliquer les mêmes filtres
        if ($request->filled('statut') && $request->statut !== 'tous') {
            switch ($request->statut) {
                case 'verifies':
                    $query->whereNotNull('email_verified_at');
                    break;
                case 'non_verifies':
                    $query->whereNull('email_verified_at');
                    break;
                case 'recents':
                    $query->where('created_at', '>=', now()->subDays(30));
                    break;
                case 'avec_demandes':
                    $query->has('demandes');
                    break;
            }
        }

        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('email', 'like', "%{$searchTerm}%")
                  ->orWhere('telephone', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('date_debut')) {
            $query->whereDate('created_at', '>=', $request->date_debut);
        }
        if ($request->filled('date_fin')) {
            $query->whereDate('created_at', '<=', $request->date_fin);
        }

        $clients = $query->latest()->get();

        $pdf = PDF::loadView('admin.clients.pdf', compact('clients'));
        
        return $pdf->download('clients_' . now()->format('Y-m-d_H-i-s') . '.pdf');
    }

    /**
     * Afficher le formulaire d'édition d'un client
     */
    public function edit($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        
        return view('admin.clients.edit', compact('client'));
    }

    /**
     * Mettre à jour les informations d'un client
     */
    public function update(Request $request, $id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $client->id,
            'telephone' => 'nullable|string|max:20',
            'role' => 'required|in:client,admin'
        ]);

        $oldData = $client->only(['name', 'email', 'telephone', 'role']);
        $client->update($validated);

        // Notifier le client s'il y a des changements significatifs
        if ($oldData['email'] !== $validated['email'] || $oldData['name'] !== $validated['name']) {
            \App\Services\NotificationService::notifyClientAccountModified($client, $oldData, $validated);
        }

        return redirect()->route('admin.clients.show', $client->id)
            ->with('success', 'Informations du client mises à jour avec succès.');
    }

    /**
     * Suspendre un compte client
     */
    public function suspend(Request $request, $id)
    {
        $request->validate([
            'suspension_reason' => 'required|string',
            'suspension_comment' => 'nullable|string|max:1000'
        ], [
            'suspension_reason.required' => 'Vous devez sélectionner une raison de suspension.'
        ]);

        $client = User::where('role', 'client')->findOrFail($id);
        
        // Enregistrer les informations de suspension
        $client->update([
            'suspended_at' => now(),
            'suspension_reason' => $request->suspension_reason,
            'suspension_comment' => $request->suspension_comment
        ]);

        $clientName = $client->name;

        try {
            // Notifier le client
            \App\Services\NotificationService::notifyClientAccountSuspended($client);
        } catch (\Exception $e) {
            Log::warning("Erreur lors de l'envoi de la notification de suspension: " . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', "Le compte de {$clientName} a été suspendu avec succès.");
    }

    /**
     * Activer un compte client suspendu
     */
    public function activate($id)
    {
        $client = User::where('role', 'client')->findOrFail($id);
        
        $client->update(['suspended_at' => null]);

        // Notifier le client
        \App\Services\NotificationService::notifyClientAccountActivated($client);

        return redirect()->back()
            ->with('success', 'Compte client activé avec succès.');
    }

    /**
     * Envoyer une notification personnalisée à un client
     */
    public function sendNotification(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'type' => 'required|in:info,reminder,warning,promotion',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'send_whatsapp' => 'boolean'
        ]);

        $client = User::findOrFail($request->client_id);
        
        // Vérifier que c'est bien un client
        if ($client->role !== 'client') {
            return response()->json([
                'success' => false,
                'message' => 'L\'utilisateur spécifié n\'est pas un client.'
            ], 400);
        }

        try {
            // Créer la notification en base
            $notification = $client->notifications()->create([
                'type' => 'admin_message',
                'data' => [
                    'type' => $request->type,
                    'title' => $request->title,
                    'message' => $request->message,
                    'sent_by' => Auth::user()->name,
                    'sent_at' => now()->toDateTimeString()
                ]
            ]);

            // Envoyer par email si activé
            if ($client->notify_email ?? true) {
                \App\Services\NotificationService::sendNotificationEmail(
                    $client->email,
                    $request->title,
                    $request->message,
                    $request->type
                );
            }

            // Envoyer par WhatsApp si demandé et activé
            if ($request->send_whatsapp && ($client->notify_whatsapp ?? true) && $client->telephone) {
                \App\Services\NotificationService::sendWhatsAppMessage(
                    $client->telephone,
                    "📢 *{$request->title}*\n\n{$request->message}\n\n_Message de l'équipe NIF Cargo_"
                );
            }

            return response()->json([
                'success' => true,
                'message' => 'Notification envoyée avec succès!'
            ]);

        } catch (\Exception $e) {
            Log::error('Erreur envoi notification client', [
                'client_id' => $request->client_id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de l\'envoi de la notification: ' . $e->getMessage()
            ], 500);
        }
    }

}

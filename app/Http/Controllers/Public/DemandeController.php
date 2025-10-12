<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\DemandeTransport;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class DemandeController extends Controller
{
    public function create()
    {
        return view('public.demande');
    }

    public function store(Request $request)
    {
        // Valider les données
        $validated = $request->validate([
            'type_transport' => 'required|string',
            'marchandise' => 'required|string|max:255',
            'poids' => 'nullable|numeric',
            'origine' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'ville_depart' => 'nullable|string|max:255',
            'ville_destination' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date_souhaitee' => 'nullable|date',
            'dimensions' => 'nullable|string|max:255',
            'valeur' => 'nullable|numeric|min:0',
            'fragile' => 'nullable|boolean',
        ]);

        // Générer une référence unique
        $reference = 'NIFA-' . date('Y') . '-' . str_pad(DemandeTransport::count() + 1, 3, '0', STR_PAD_LEFT);

        // Créer la demande avec toutes les données nécessaires
        $demande = DemandeTransport::create([
            'user_id' => Auth::id(),
            'reference' => $reference,
            'type_transport' => $validated['type_transport'],
            'marchandise' => $validated['marchandise'],
            'poids' => $validated['poids'] ?? null,
            'origine' => $validated['origine'],
            'destination' => $validated['destination'],
            'ville_depart' => $validated['ville_depart'] ?? null,
            'ville_destination' => $validated['ville_destination'] ?? null,
            'description' => $validated['description'] ?? null,
            'date_souhaitee' => $validated['date_souhaitee'] ?? null,
            'valeur' => $validated['valeur'] ?? 0,
            'fragile' => $request->has('fragile'),
            'statut' => 'en_attente'
        ]);

        // Envoyer une notification à l'administrateur
        NotificationService::notifyDemandeCreated($demande);

        // Envoyer une notification de confirmation au client
        NotificationService::create(
            Auth::user(),
            'demande_creer',
            $demande,
            'Votre demande de transport #' . $demande->reference . ' a été créée avec succès.'
        );

        // Envoi d'email de confirmation (optionnel)
        try {
            Mail::raw(
                "Nouvelle demande de transport : {$demande->marchandise} ({$demande->type_transport})",
                function ($message) use ($demande) {
                    $message->to(Auth::user()->email)
                            ->subject('Confirmation de votre demande N°' . $demande->reference);
                }
            );
        } catch (\Exception $e) {
            // Journaliser l'erreur mais ne pas interrompre le flux
            \Log::error('Erreur lors de l\'envoi de l\'email de confirmation : ' . $e->getMessage());
        }

        return redirect()->route('mes-demandes.show', $demande)
            ->with('success', 'Votre demande a été soumise avec succès !');

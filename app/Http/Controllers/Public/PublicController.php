<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DemandeTransport;
use App\Models\User;
use App\Models\Annonce;
use App\Models\Galerie;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    /**
     * Page d'accueil
     */
    public function accueil()
    {
        // Statistiques pour la page d'accueil
        $stats = [
            'demandes_traitees' => DemandeTransport::count(),
            'clients_satisfaits' => User::where('role', 'client')->count(),
            'pays_desservis' => 15, // Nombre fixe pour l'exemple
            'annees_experience' => 10 // Nombre fixe pour l'exemple
        ];
        
        // Récupérer les annonces actives et valides
        $annonces = Annonce::active()
            ->valide()
            ->ordered()
            ->take(5)
            ->get();
            
        // Récupérer les photos mises en avant pour la galerie
        $photosGalerie = Galerie::active()
            ->miseEnAvant()
            ->ordered()
            ->take(8)
            ->get();
        
        return view('public.accueil', compact('stats', 'annonces', 'photosGalerie'));
    }

    /**
     * Page des services
     */
    public function services()
    {
        $services = [
            [
                'titre' => 'Transport Maritime',
                'description' => 'Transport de marchandises par voie maritime vers l\'Afrique et l\'Europe',
                'icon' => '🚢',
                'features' => [
                    'Conteneurs 20 et 40 pieds',
                    'Groupage et dédouanement',
                    'Assurance marchandises',
                    'Suivi en temps réel'
                ]
            ],
            [
                'titre' => 'Transport Aérien',
                'description' => 'Transport rapide par voie aérienne pour vos marchandises urgentes',
                'icon' => '✈️',
                'features' => [
                    'Livraison express',
                    'Marchandises fragiles',
                    'Documents et colis',
                    'Réseau mondial'
                ]
            ],
            [
                'titre' => 'Transport Terrestre',
                'description' => 'Transport routier en Afrique de l\'Ouest avec notre flotte moderne',
                'icon' => '🚛',
                'features' => [
                    'Camions réfrigérés',
                    'Transport de véhicules',
                    'Livraison domicile',
                    'Couverture régionale'
                ]
            ],
            [
                'titre' => 'Dédouanement',
                'description' => 'Service complet de dédouanement et formalités administratives',
                'icon' => '📋',
                'features' => [
                    'Déclaration en douane',
                    'Certificats d\'origine',
                    'Inspection marchandises',
                    'Conseil réglementaire'
                ]
            ],
            [
                'titre' => 'Entreposage',
                'description' => 'Solutions d\'entreposage sécurisé dans nos entrepôts modernes',
                'icon' => '🏭',
                'features' => [
                    'Entrepôts sécurisés',
                    'Gestion des stocks',
                    'Conditionnement',
                    'Distribution'
                ]
            ],
            [
                'titre' => 'Assurance',
                'description' => 'Protection complète de vos marchandises pendant le transport',
                'icon' => '🛡️',
                'features' => [
                    'Couverture tous risques',
                    'Indemnisation rapide',
                    'Expertise sinistres',
                    'Conseil en assurance'
                ]
            ]
        ];
        
        return view('public.services', compact('services'));
    }

    /**
     * Page de contact
     */
    public function contact()
    {
        $contacts = [
            'togo' => [
                'pays' => 'Togo',
                'ville' => 'Lomé',
                'adresse' => 'Totsi à 100m non loin de l\'eglise catholique, Lomé',
                'telephone' => '+228 22 61 00 00',
                'mobile' => '+228 99 25 25 31',
                'email' => 'contact@nif-tg.com',
                'horaires' => 'Lun-Ven: 8h-18h, Sam: 8h-12h'
            ],
            'benin' => [
                'pays' => 'Bénin',
                'ville' => 'Cotonou',
                'adresse' => '456 Avenue Clozel, Cotonou',
                'telephone' => '+229 21 30 00 00',
                'mobile' => '+229 97 12 34 56',
                'email' => 'contact@nif-tg.com',
                'horaires' => 'Lun-Ven: 8h-18h, Sam: 8h-12h'
            ]
        ];
        
        return view('public.contact', compact('contacts'));
    }

    /**
     * Traiter le formulaire de contact
     */
    public function envoyerContact(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'nullable|string|max:20',
            'sujet' => 'required|string|max:255',
            'message' => 'required|string|max:2000'
        ]);

        // Ici, vous pouvez envoyer l'email ou sauvegarder en base
        // Pour l'exemple, on simule l'envoi
        
        try {
            // Mail::to('contact@nifa.com')->send(new ContactMail($request->all()));
            
            return back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
        } catch (\Exception $e) {
            return back()->with('error', 'Une erreur est survenue lors de l\'envoi de votre message. Veuillez réessayer.');
        }
    }

    /**
     * Page À propos
     */
    public function apropos()
    {
        return view('public.apropos');
    }

    /**
     * Page de suivi public (avec numéro de référence)
     */
    public function suiviPublic()
    {
        return view('public.suivi');
    }

    /**
     * Rechercher une demande par référence
     */
    public function rechercherDemande(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        $demande = DemandeTransport::with(['etapes', 'user'])
            ->where('reference', $request->reference)
            ->first();

        if (!$demande) {
            return back()->with('error', 'Aucune demande trouvée avec cette référence.');
        }

        return view('public.suivi-resultat', compact('demande'));
    }
}

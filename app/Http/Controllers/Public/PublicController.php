<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Annonce;
use App\Models\DemandeTransport;
use App\Models\Galerie;

class PublicController extends Controller
{
    // Page d'accueil
    public function accueil()
    {
        // Préparer les statistiques attendues par la vue
        try {
            $demandesTraitees = DemandeTransport::where('statut', 'livrée')->count();
        } catch (\Throwable $e) {
            // Si la table n'existe pas encore (migrations non exécutées), fallback à 0
            $demandesTraitees = 0;
        }

        $stats = [
            'demandes_traitees'   => $demandesTraitees,
            'clients_satisfaits'  => 98,  // Valeur marketing par défaut
            'pays_desservis'      => 12,  // Ajuster si vous avez un calcul réel
            'annees_experience'   => 5,
        ];

        // Annonces actives et valides (limite 6)
        try {
            $annonces = Annonce::active()->valide()->ordered()->take(6)->get();
        } catch (\Throwable $e) {
            $annonces = collect();
        }

        // Galerie: photos actives mises en avant/ordonnées (limite 8)
        try {
            $photosGalerie = Galerie::active()->ordered()->take(8)->get()->map(function ($g) {
                return (object) [
                    'image_url' => $g->image_url,
                    'alt' => $g->alt,
                    'categorie_formate' => $g->categorie_formate,
                    'titre' => $g->titre,
                    'description' => $g->description,
                ];
            });
        } catch (\Throwable $e) {
            $photosGalerie = collect();
        }

        return view('public.accueil', compact('stats', 'annonces', 'photosGalerie'));
    }

    // Page Services (construit la liste attendue par la vue)
    public function services()
    {
        $services = [
            [
                'titre' => 'Transport Maritime',
                'icon' => '<i class="fas fa-ship"></i>',
                'description' => 'Expéditions par conteneur complet (FCL) ou groupage (LCL) avec formalités douanières.',
                'features' => [
                    'Conteneurs 20/40 pieds',
                    'Groupage hebdomadaire',
                    'Suivi en temps réel',
                    'Assurance marchandise'
                ],
            ],
            [
                'titre' => 'Transport Aérien',
                'icon' => '<i class="fas fa-plane"></i>',
                'description' => 'Solutions express et prioritaires pour vos envois urgents à l’international.',
                'features' => [
                    'Express et standard',
                    'Door to Door',
                    'Délais garantis',
                    'Déclaration douanière'
                ],
            ],
            [
                'titre' => 'Transport Terrestre',
                'icon' => '<i class="fas fa-truck"></i>',
                'description' => 'Transport routier inter-États avec réseau fiable et sécurisé.',
                'features' => [
                    'Camions bâchés et fourgons',
                    'Messagerie et lots partiels',
                    'Suivi GPS',
                    'Réseau régional'
                ],
            ],
            [
                'titre' => 'Dédouanement',
                'icon' => '<i class="fas fa-clipboard-check"></i>',
                'description' => 'Prise en charge complète des formalités douanières import/export.',
                'features' => [
                    'Formalités import/export',
                    'Accompagnement administratif',
                    'Conseil réglementaire',
                    'Optimisation des coûts'
                ],
            ],
            [
                'titre' => 'Entreposage',
                'icon' => '<i class="fas fa-warehouse"></i>',
                'description' => 'Stockage sécurisé et préparation de commandes près des hubs logistiques.',
                'features' => [
                    'Stockage sécurisé',
                    'Préparation de commandes',
                    'Contrôle qualité',
                    'Inventaires'
                ],
            ],
            [
                'titre' => 'Assurance',
                'icon' => '<i class="fas fa-shield-alt"></i>',
                'description' => 'Couverture adaptée pour garantir la sécurité financière de vos expéditions.',
                'features' => [
                    'Couverture tous risques',
                    'Assurance à la demande',
                    'Gestion des sinistres',
                    'Partenaires certifiés'
                ],
            ],
        ];

        return view('public.services', compact('services'));
    }

    // À propos
    public function apropos()
    {
        // Si la vue dédiée n'existe pas encore, fallback vers l'accueil
        return view()->exists('public.apropos') ? view('public.apropos') : view('public.accueil');
    }

    // Contact (GET)
    public function contact()
    {
        return view()->exists('public.contact') ? view('public.contact') : view('public.accueil');
    }

    // Contact (POST)
    public function envoyerContact(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|max:5000',
        ]);

        // TODO: Envoi d'email de contact (facultatif)
        return back()->with('success', 'Votre message a bien été envoyé.');
    }

    // Suivi public (GET)
    public function suiviPublic(Request $request)
    {
        $tracking = $request->query('tracking');
        if ($tracking) {
            $demande = DemandeTransport::with(['etapes' => function($query) {
                $query->orderBy('ordre');
            }])->where('numero_tracking', $tracking)->first();
            
            if ($demande) {
                // Retourner la vue de résultats avec la demande trouvée
                return view('public.suivi-resultat', compact('demande', 'tracking'));
            }
            
            // Si aucune demande trouvée, retourner la vue de recherche avec erreur
            return view('public.suivi')->with('error', 'Aucune demande trouvée pour le numéro de suivi: ' . $tracking);
        }
        
        // Si pas de paramètre tracking, afficher le formulaire de recherche
        return view('public.suivi');
    }

    // Suivi public (POST)
    public function rechercherDemande(Request $request)
    {
        $request->validate(['tracking' => 'required|string|max:20']);
        return redirect()->route('suivi.public', ['tracking' => $request->tracking]);
    }

    // Blog
    public function blog(Request $request)
    {
        $type = $request->query('type');
        $query = Annonce::query()->latest();
        if ($type && $type !== 'all') {
            $query->where('type', $type);
        }
        $annonces = $query->paginate(10);
        return view('public.blog.index', compact('annonces'));
    }

    public function showArticle($id)
    {
        $article = Annonce::findOrFail($id);
        return view('public.blog.show', compact('article'));
    }
}
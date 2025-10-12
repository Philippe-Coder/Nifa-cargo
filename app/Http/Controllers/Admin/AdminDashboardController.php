<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\DemandeTransport;
use App\Models\Annonce;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $clientsCount = User::where('role', 'client')->count();
        $demandesCount = DemandeTransport::count();
        $demandesEnAttente = DemandeTransport::where('statut', 'en attente')->count();
        $demandesLivrees = DemandeTransport::where('statut', 'livrée')->count();
        $dernieresDemandes = DemandeTransport::with('user')->latest()->take(5)->get();
        
        // Statistiques des annonces
        $annoncesCount = Annonce::count();
        $annoncesActives = Annonce::where('active', true)->count();
        $annoncesEpinglees = Annonce::where('epingle', true)->count();
        $dernieresAnnonces = Annonce::with('user')->latest()->take(3)->get();

        return view('admin.dashboard', compact(
            'clientsCount', 'demandesCount', 'demandesEnAttente', 'demandesLivrees', 'dernieresDemandes',
            'annoncesCount', 'annoncesActives', 'annoncesEpinglees', 'dernieresAnnonces'
        ));
    }
}

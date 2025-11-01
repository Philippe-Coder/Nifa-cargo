<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'client')->withCount('demandes');

        // Filtrage par statut de vérification
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

        return view('admin.clients.index', compact(
            'clients', 
            'totalClients', 
            'clientsVerifies', 
            'clientsRecents', 
            'clientsAvecDemandes'
        ));
    }

    public function show($id)
    {
        $client = User::with('demandes')->findOrFail($id);
        return view('admin.clients.show', compact('client'));
    }

    public function destroy($id)
    {
        $client = User::findOrFail($id);
        $client->delete();
        
        return redirect()->route('admin.clients.index')
            ->with('success', 'Client supprimé avec succès');
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
}

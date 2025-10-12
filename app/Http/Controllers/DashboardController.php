<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DemandeTransport;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques pour le client
        $stats = [
            'total_demandes' => DemandeTransport::where('user_id', $user->id)->count(),
            'en_cours' => DemandeTransport::where('user_id', $user->id)
                ->whereIn('statut', ['en attente', 'en cours', 'en transit'])->count(),
            'livrees' => DemandeTransport::where('user_id', $user->id)
                ->where('statut', 'livrée')->count(),
            'montant_total' => DemandeTransport::where('user_id', $user->id)
                ->sum('montant') ?? 0
        ];
        
        // Dernières demandes
        $recent_demandes = DemandeTransport::where('user_id', $user->id)
            ->with('etapes')
            ->latest()
            ->limit(5)
            ->get();

        // Dernières notifications non lues
        $notifications = $user->unreadNotifications()
            ->latest()
            ->limit(5)
            ->get();

        return view('dashboard.index', [
            'stats' => $stats,
            'recent_demandes' => $recent_demandes,
            'notifications' => $notifications,
            'unreadCount' => $user->unreadNotifications()->count(),
            'pageTitle' => 'Tableau de bord'
        ]);
    }

    /**
     * Marquer une notification comme lue
     */
    public function markNotificationAsRead($id)
    {
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllNotificationsAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }

    /**
     * Récupérer les notifications non lues (pour AJAX)
     */
    public function getUnreadNotifications()
    {
        $notifications = auth()->user()
            ->unreadNotifications()
            ->latest()
            ->limit(10)
            ->get();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => auth()->user()->unreadNotifications()->count()
        ]);
    }
}

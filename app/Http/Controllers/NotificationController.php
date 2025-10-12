<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Afficher toutes les notifications de l'utilisateur
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marquer une notification comme lue
     */
    public function markAsRead(Notification $notification)
    {
        $this->authorize('update', $notification);
        
        $notification->markAsRead();
        
        return response()->json(['success' => true]);
    }

    /**
     * Marquer toutes les notifications comme lues
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        
        $notification->delete();
        
        return back()->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * Obtenir les notifications non lues (pour AJAX)
     */
    public function unread()
    {
        $unreadCount = Auth::user()->unreadNotifications->count();
        $notifications = Auth::user()->unreadNotifications()->latest()->take(5)->get();
        
        return response()->json([
            'count' => $unreadCount,
            'notifications' => $notifications->map(function($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->message,
                    'time' => $notification->created_at->diffForHumans(),
                    'icon' => $notification->icon,
                    'url' => $notification->notifiable->notificationUrl() ?? '#'
                ];
            })
        ]);
    }
}

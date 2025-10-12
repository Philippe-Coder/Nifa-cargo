<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NotificationController extends Controller
{
    /**
     * Afficher la liste des notifications
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()
            ->latest()
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    });

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications
        ]);
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
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Toutes les notifications ont été marquées comme lues.');
    }

    /**
     * Récupérer le nombre de notifications non lues
     */
    public function unreadCount()
    {
        $count = Auth::user()->unreadNotifications()->count();
        
        return response()->json([
            'count' => $count
        ]);
    }

    /**
     * Supprimer une notification
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);
        
        $notification->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Notification supprimée avec succès.');
    }

    /**
     * Vider toutes les notifications
     */
    public function clearAll()
    {
        Auth::user()->notifications()->delete();
        
        if (request()->wantsJson()) {
            return response()->json(['success' => true]);
        }
        
        return back()->with('success', 'Toutes les notifications ont été supprimées.');
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

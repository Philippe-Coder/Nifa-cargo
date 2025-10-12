<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class NotificationBell extends Component
{
    public $unreadCount;
    public $notifications = [];
    public $showDropdown = false;

    protected $listeners = ['notificationRead' => 'updateNotifications'];

    public function mount()
    {
        $this->updateNotifications();
    }

    public function updateNotifications()
    {
        $this->unreadCount = Auth::user()->unreadNotifications()->count();
        $this->notifications = Auth::user()->unreadNotifications()
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'message' => $notification->data['message'] ?? 'Nouvelle notification',
                    'time' => $notification->created_at->diffForHumans(),
                    'url' => $notification->data['url'] ?? '#',
                    'read_at' => $notification->read_at
                ];
            });
    }

    public function markAsRead($notificationId = null)
    {
        if ($notificationId) {
            $notification = Auth::user()->notifications()->find($notificationId);
            if ($notification) {
                $notification->markAsRead();
                $this->emit('notificationRead');
                return redirect($notification->data['url'] ?? route('notifications.index'));
            }
        }
        return '#';
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        $this->updateNotifications();
        return redirect()->route('notifications.index');
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function render()
    {
        return view('livewire.notification-bell');
    }
}

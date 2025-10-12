@extends('layouts.dashboard')

@section('title', 'Mes Notifications')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">Mes Notifications</h2>
                @if($notifications->count() > 0)
                    <form action="{{ route('notifications.markAllRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                            <i class="far fa-check-circle mr-1"></i> Tout marquer comme lu
                        </button>
                    </form>
                @endif
            </div>
        </div>
        
        @if($notifications->count() > 0)
            <div class="divide-y divide-gray-200">
                @foreach($notifications as $notification)
                    <div class="p-4 hover:bg-gray-50 transition-colors duration-150 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-1">
                                @php
                                    $icon = [
                                        'nouvelle_demande' => 'fa-file-alt text-blue-500',
                                        'statut_modifie' => 'fa-sync-alt text-yellow-500',
                                        'paiement_effectue' => 'fa-credit-card text-green-500',
                                        'livraison_effectuee' => 'fa-check-circle text-green-600',
                                        'demande_acceptee' => 'fa-thumbs-up text-green-500',
                                        'demande_refusee' => 'fa-times-circle text-red-500',
                                    ][$notification->type] ?? 'fa-bell text-gray-400';
                                @endphp
                                <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                    <i class="fas {{ $icon }}"></i>
                                </div>
                            </div>
                            <div class="ml-4 flex-1">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ $notification->message }}
                                    </p>
                                    <span class="text-xs text-gray-500 ml-2 whitespace-nowrap">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="mt-1 text-sm text-gray-600">
                                    @if($notification->notifiable)
                                        <a href="{{ $notification->notifiable->notificationUrl() }}" class="text-blue-600 hover:text-blue-800">
                                            Voir les détails <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="ml-4">
                                @if(!$notification->read_at)
                                    <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-gray-400 hover:text-gray-600" title="Marquer comme lu">
                                            <i class="far fa-circle"></i>
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-400 hover:text-red-600" title="Supprimer">
                                        <i class="far fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                    <i class="far fa-bell-slash text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune notification</h3>
                <p class="text-gray-500">Vous n'avez pas encore de notifications.</p>
            </div>
        @endif
    </div>
</div>
@endsection

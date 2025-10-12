<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button 
        @click="open = !open; $wire.toggleDropdown()"
        class="relative p-2 text-gray-400 hover:text-gray-500 focus:outline-none"
        aria-label="Notifications"
    >
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        
        @if($unreadCount > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-500 rounded-full">
                {{ $unreadCount > 9 ? '9+' : $unreadCount }}
            </span>
        @endif
    </button>

    <!-- Dropdown panel -->
    <div 
        x-show="open" 
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-50"
    >
        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
            <div class="px-4 py-2 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                @if($unreadCount > 0)
                    <button 
                        wire:click="markAllAsRead"
                        class="text-xs text-blue-600 hover:text-blue-800"
                    >
                        Tout marquer comme lu
                    </button>
                @endif
            </div>

            <div class="max-h-96 overflow-y-auto">
                @forelse($notifications as $notification)
                    <a 
                        href="{{ $notification['url'] }}"
                        wire:click.prevent="markAsRead('{{ $notification['id'] }}')"
                        class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 {{ is_null($notification['read_at']) ? 'bg-blue-50' : '' }}"
                        role="menuitem"
                    >
                        <div class="flex items-start">
                            <div class="flex-shrink-0 pt-0.5">
                                <span class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <svg class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-3 flex-1">
                                <p class="text-sm text-gray-700">
                                    {{ $notification['message'] }}
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    {{ $notification['time'] }}
                                </p>
                            </div>
                            @if(is_null($notification['read_at']))
                                <div class="ml-2 flex-shrink-0">
                                    <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                                </div>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="px-4 py-6 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucune notification</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Vous n'avez pas de nouvelles notifications.
                        </p>
                    </div>
                @endforelse
            </div>

            @if(count($notifications) > 0)
                <div class="border-t border-gray-100 px-4 py-2 text-center">
                    <a 
                        href="{{ route('notifications.index') }}" 
                        class="text-sm font-medium text-blue-600 hover:text-blue-800"
                    >
                        Voir toutes les notifications
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Écouter les événements de notification en temps réel (si vous utilisez Echo/Broadcast)
        @if(config('broadcasting.default') === 'pusher')
            window.Echo.private(`App.Models.User.{{ auth()->id() }}`)
                .listen('.notification.sent', (data) => {
                    window.livewire.emit('notificationReceived');
                });
        @endif
    });
</script>
@endpush

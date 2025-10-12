@extends('layouts.dashboard')

@section('title', 'Tableau de bord')

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- En-tête -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tableau de bord</h1>
        <div class="flex space-x-4">
            <a href="{{ route('demande.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg flex items-center">
                <i class="fas fa-plus mr-2"></i> Nouvelle demande
            </a>
        </div>
    </div>

    <!-- Cartes de statistiques -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 mr-4">
                    <i class="fas fa-truck text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total des demandes</p>
                    <h3 class="text-2xl font-bold">{{ $stats['total_demandes'] }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                    <i class="fas fa-spinner text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">En cours</p>
                    <h3 class="text-2xl font-bold">{{ $stats['en_cours'] }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Livrées</p>
                    <h3 class="text-2xl font-bold">{{ $stats['livrees'] }}</h3>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <i class="fas fa-money-bill-wave text-xl"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Dépenses totales</p>
                    <h3 class="text-2xl font-bold">{{ number_format($stats['montant_total'], 2, ',', ' ') }} FCFA</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Dernières demandes -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-medium text-gray-900">Dernières demandes</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Référence</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Origine</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destination</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($recent_demandes as $demande)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-indigo-600">{{ $demande->reference }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'en attente' => 'bg-yellow-100 text-yellow-800',
                                    'en cours' => 'bg-blue-100 text-blue-800',
                                    'en transit' => 'bg-purple-100 text-purple-800',
                                    'livrée' => 'bg-green-100 text-green-800',
                                    'annulée' => 'bg-red-100 text-red-800',
                                ][$demande->statut] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClasses }}">
                                {{ ucfirst($demande->statut) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $demande->ville_depart }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $demande->ville_destination }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $demande->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ route('mes-demandes.show', $demande) }}" class="text-indigo-600 hover:text-indigo-900">Voir</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-500">
                            Aucune demande pour le moment.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200 text-right">
            <a href="{{ route('mes-demandes.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Voir toutes les demandes <span aria-hidden="true">&rarr;</span>
            </a>
        </div>
    </div>

    <!-- Notifications récentes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-lg font-medium text-gray-900">Notifications récentes</h2>
            @if($unreadCount > 0)
            <form action="{{ route('notifications.markAllRead') }}" method="POST">
                @csrf
                <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900">
                    Tout marquer comme lu
                </button>
            </form>
            @endif
        </div>
        <div class="divide-y divide-gray-200">
            @forelse($notifications as $notification)
            <div class="px-6 py-4 hover:bg-gray-50 {{ $notification->unread() ? 'bg-blue-50' : '' }}">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-bell"></i>
                    </div>
                    <div class="ml-4">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $notification->data['title'] ?? 'Notification' }}
                        </div>
                        <p class="text-sm text-gray-500">
                            {{ $notification->data['message'] ?? '' }}
                        </p>
                        <div class="mt-1 text-xs text-gray-500">
                            {{ $notification->created_at->diffForHumans() }}
                        </div>
                    </div>
                    @if($notification->unread())
                    <div class="ml-auto">
                        <form action="{{ route('notifications.markAsRead', $notification) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm">
                                <i class="far fa-check-circle"></i>
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="px-6 py-4 text-center text-sm text-gray-500">
                Aucune notification pour le moment.
            </div>
            @endforelse
        </div>
        @if($unreadCount > 5)
        <div class="px-6 py-4 border-t border-gray-200 text-center">
            <a href="{{ route('notifications.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">
                Voir toutes les notifications ({{ $unreadCount }} non lues)
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

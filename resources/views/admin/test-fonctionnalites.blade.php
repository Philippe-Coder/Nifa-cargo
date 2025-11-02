@extends('layouts.dashboard')

@section('title', 'Test Fonctionnalités Admin - NIF Cargo')
@section('page-title', 'Test des Fonctionnalités Admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Test des routes -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">
            <i class="fas fa-cog mr-2 text-blue-600"></i>
            Test des Routes Admin
        </h3>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Routes Clients -->
            <div class="space-y-3">
                <h4 class="font-medium text-gray-900 border-b pb-2">Gestion des Clients</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Liste des clients:</span>
                        <a href="{{ route('admin.clients.index') }}" class="text-blue-600 hover:underline">Tester</a>
                    </div>
                    @if($clients->count() > 0)
                        <div class="flex justify-between">
                            <span>Modifier client:</span>
                            <a href="{{ route('admin.clients.edit', $clients->first()->id) }}" class="text-blue-600 hover:underline">Tester</a>
                        </div>
                        <div class="flex justify-between">
                            <span>Voir client:</span>
                            <a href="{{ route('admin.clients.show', $clients->first()->id) }}" class="text-blue-600 hover:underline">Tester</a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Routes Demandes -->
            <div class="space-y-3">
                <h4 class="font-medium text-gray-900 border-b pb-2">Gestion des Demandes</h4>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span>Liste des demandes:</span>
                        <a href="{{ route('admin.demandes.index') }}" class="text-blue-600 hover:underline">Tester</a>
                    </div>
                    @if($demandes->count() > 0)
                        <div class="flex justify-between">
                            <span>Modifier demande:</span>
                            <a href="{{ route('admin.demandes.edit', $demandes->first()->id) }}" class="text-blue-600 hover:underline">Tester</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistiques -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-8">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">
            <i class="fas fa-chart-bar mr-2 text-green-600"></i>
            Statistiques du Système
        </h3>
        
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-2xl font-bold text-blue-600">{{ $totalClients }}</div>
                <div class="text-sm text-blue-700">Clients Total</div>
            </div>
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-2xl font-bold text-green-600">{{ $clientsActifs }}</div>
                <div class="text-sm text-green-700">Clients Actifs</div>
            </div>
            <div class="text-center p-4 bg-red-50 rounded-lg">
                <div class="text-2xl font-bold text-red-600">{{ $clientsSuspendus }}</div>
                <div class="text-sm text-red-700">Clients Suspendus</div>
            </div>
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-2xl font-bold text-purple-600">{{ $totalDemandes }}</div>
                <div class="text-sm text-purple-700">Demandes Total</div>
            </div>
        </div>
    </div>
    
    <!-- Actions de test -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h3 class="text-xl font-semibold text-gray-900 mb-6">
            <i class="fas fa-flask mr-2 text-purple-600"></i>
            Actions de Test Disponibles
        </h3>
        
        @if($clients->count() > 0)
            @php $testClient = $clients->first(); @endphp
            
            <div class="space-y-4">
                <div class="border rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">Client de Test: {{ $testClient->name }}</h4>
                    <div class="flex flex-wrap gap-3">
                        <!-- Actions disponibles -->
                        <a href="{{ route('admin.clients.edit', $testClient->id) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-edit mr-1"></i> Modifier
                        </a>
                        
                        @if($testClient->suspended_at)
                            <form action="{{ route('admin.clients.activate', $testClient->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm">
                                    <i class="fas fa-user-check mr-1"></i> Réactiver
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.clients.suspend', $testClient->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" onclick="return confirm('Tester la suspension ?')" 
                                        class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg text-sm">
                                    <i class="fas fa-ban mr-1"></i> Suspendre
                                </button>
                            </form>
                        @endif
                        
                        <button onclick="testNotification({{ $testClient->id }}, '{{ addslashes($testClient->name) }}')"
                                class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm">
                            <i class="fas fa-bell mr-1"></i> Test Notification
                        </button>
                    </div>
                    
                    <div class="mt-3 text-sm text-gray-600">
                        <p><strong>Statut:</strong> 
                            @if($testClient->suspended_at)
                                <span class="text-red-600">Suspendu le {{ $testClient->suspended_at->format('d/m/Y à H:i') }}</span>
                            @else
                                <span class="text-green-600">Actif</span>
                            @endif
                        </p>
                        <p><strong>Email:</strong> {{ $testClient->email }}</p>
                        <p><strong>Téléphone:</strong> {{ $testClient->telephone ?? 'Non renseigné' }}</p>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-users text-4xl mb-3"></i>
                <p>Aucun client disponible pour les tests</p>
            </div>
        @endif
    </div>
</div>

<script>
function testNotification(clientId, clientName) {
    if (confirm('Envoyer une notification de test à ' + clientName + ' ?')) {
        fetch('{{ route("admin.clients.send-notification") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                client_id: clientId,
                type: 'info',
                title: 'Test de Notification',
                message: 'Ceci est un test de notification depuis l\'interface admin. Si vous recevez ce message, le système fonctionne correctement !',
                send_whatsapp: false
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('✅ Notification envoyée avec succès !');
            } else {
                alert('❌ Erreur: ' + data.message);
            }
        })
        .catch(error => {
            alert('❌ Erreur réseau: ' + error.message);
        });
    }
}
</script>
@endsection
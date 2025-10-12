{{-- resources/views/admin/clients/show.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Détails du client')

@section('content')
<div class="max-w-6xl mx-auto p-6">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Détails du client</h1>

    {{-- Informations du client --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Informations personnelles</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><span class="font-semibold">Nom :</span> {{ $client->name }}</p>
                <p><span class="font-semibold">Email :</span> {{ $client->email }}</p>
                <p><span class="font-semibold">Rôle :</span> {{ ucfirst($client->role) }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Date d’inscription :</span> {{ $client->created_at->format('d/m/Y') }}</p>
            </div>
        </div>

    </div>

    {{-- Liste des demandes --}}
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Historique des expéditions</h2>

        @if($client->demandes->count() > 0)
            <table class="min-w-full border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="text-left px-4 py-2">Marchandise</th>
                        <th class="text-left px-4 py-2">Type</th>
                        <th class="text-left px-4 py-2">Origine → Destination</th>
                        <th class="text-left px-4 py-2">Statut</th>
                        <th class="text-left px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($client->demandes as $demande)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $demande->marchandise ?? 'N/A' }}</td>
                            <td class="px-4 py-2">{{ ucfirst($demande->type) }}</td>
                            <td class="px-4 py-2">{{ $demande->origine }} → {{ $demande->destination }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $colors = [
                                        'en attente' => 'bg-yellow-100 text-yellow-800',
                                        'validée' => 'bg-blue-100 text-blue-800',
                                        'en transit' => 'bg-orange-100 text-orange-800',
                                        'livrée' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-sm font-medium {{ $colors[strtolower($demande->statut)] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($demande->statut) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $demande->created_at->format('d/m/Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p class="text-gray-600">Aucune expédition enregistrée pour ce client.</p>
        @endif
    </div>
</div>
@endsection

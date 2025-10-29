@extends('layouts.dashboard')

@section('title', 'Test - Créer une Demande Client')
@section('page-title', 'Test - Créer une Demande pour un Client')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Créer une Demande pour un Client</h1>
        <p class="text-gray-600">Cette page fonctionne ! Le contrôleur AdminDemandeController est correctement chargé.</p>
        
        <div class="mt-6">
            <a href="{{ route('admin.demandes.index') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Retour aux demandes
            </a>
        </div>
    </div>
</div>
@endsection
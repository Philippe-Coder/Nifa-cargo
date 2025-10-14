@extends('layouts.public')

@section('title', 'Actualités & Blog - ' . config('app.name'))

@section('content')
<!-- Hero Section -->
<section class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Actualités & Blog</h1>
        <p class="text-xl text-blue-100 max-w-3xl mx-auto">
            Découvrez les dernières actualités, conseils et informations sur le transport et la logistique en Afrique
        </p>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar avec onglets -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-md p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Catégories</h3>
                    <nav class="space-y-2">
                        <a href="{{ route('blog.index', ['type' => 'all']) }}"
                           class="block px-4 py-3 rounded-lg {{ !request('type') ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                            <i class="fas fa-th-large mr-3"></i>Tous les articles
                        </a>
                        <a href="{{ route('blog.index', ['type' => 'actualite']) }}"
                           class="block px-4 py-3 rounded-lg {{ request('type') === 'actualite' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                            <i class="fas fa-newspaper mr-3"></i>Actualités
                        </a>
                        <a href="{{ route('blog.index', ['type' => 'promotion']) }}"
                           class="block px-4 py-3 rounded-lg {{ request('type') === 'promotion' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                            <i class="fas fa-tags mr-3"></i>Promotions
                        </a>
                        <a href="{{ route('blog.index', ['type' => 'info']) }}"
                           class="block px-4 py-3 rounded-lg {{ request('type') === 'info' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                            <i class="fas fa-info-circle mr-3"></i>Informations
                        </a>
                        <a href="{{ route('blog.index', ['type' => 'urgent']) }}"
                           class="block px-4 py-3 rounded-lg {{ request('type') === 'urgent' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100' }} transition-colors">
                            <i class="fas fa-exclamation-triangle mr-3"></i>Urgents
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="lg:w-3/4">
                <!-- En-tête de catégorie -->
                <div class="mb-8">
                    @php
                        $typeLabels = [
                            'actualite' => 'Actualités',
                            'promotion' => 'Promotions',
                            'info' => 'Informations',
                            'urgent' => 'Annonces Urgentes',
                            'all' => 'Tous les Articles'
                        ];
                        $currentType = request('type', 'all');
                        $typeLabel = $typeLabels[$currentType] ?? 'Tous les Articles';
                    @endphp
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">{{ $typeLabel }}</h2>
                    <p class="text-gray-600">
                        @if($currentType === 'actualite')
                            Découvrez les dernières nouvelles et mises à jour importantes
                        @elseif($currentType === 'promotion')
                            Consultez nos offres spéciales et promotions exclusives
                        @elseif($currentType === 'info')
                            Restez informé avec nos informations utiles et conseils pratiques
                        @elseif($currentType === 'urgent')
                            Consultez les annonces importantes et urgentes
                        @else
                            Explorez tous nos contenus informatifs et éducatifs
                        @endif
                    </p>
                </div>

                <!-- Liste des articles -->
                @if($annonces->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @foreach($annonces as $annonce)
                            <article class="bg-white rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow duration-300">
                                <a href="{{ route('blog.show', $annonce->id) }}" class="block">
                                    <div class="h-48 overflow-hidden">
                                        <img src="{{ $annonce->image ?? 'https://via.placeholder.com/800x500?text=' . urlencode($annonce->titre) }}"
                                             alt="{{ $annonce->titre }}"
                                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="p-6">
                                        <div class="flex items-center text-sm text-gray-500 mb-3">
                                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                                {{ ucfirst($annonce->type) }}
                                            </span>
                                            <span class="mx-2">•</span>
                                            <time datetime="{{ $annonce->created_at->format('Y-m-d') }}">
                                                {{ $annonce->created_at->format('d/m/Y') }}
                                            </time>
                                        </div>
                                        <h2 class="text-xl font-bold text-gray-900 mb-3 hover:text-blue-600 transition-colors">
                                            {{ $annonce->titre }}
                                        </h2>
                                        <p class="text-gray-600 mb-4 line-clamp-3">
                                            {!! Str::limit(strip_tags($annonce->contenu), 150) !!}
                                        </p>
                                        <div class="flex items-center text-blue-600 font-medium">
                                            Lire la suite
                                            <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-12">
                        {{ $annonces->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-100 text-blue-600 mb-4">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">
                            @if($currentType === 'actualite')
                                Aucune actualité trouvée
                            @elseif($currentType === 'promotion')
                                Aucune promotion trouvée
                            @elseif($currentType === 'info')
                                Aucune information trouvée
                            @elseif($currentType === 'urgent')
                                Aucune annonce urgente trouvée
                            @else
                                Aucun article trouvé
                            @endif
                        </h3>
                        <p class="text-gray-600">
                            @if($currentType === 'actualite')
                                Aucun article d'actualité n'est disponible pour le moment.
                            @elseif($currentType === 'promotion')
                                Aucune promotion n'est disponible pour le moment.
                            @elseif($currentType === 'info')
                                Aucune information n'est disponible pour le moment.
                            @elseif($currentType === 'urgent')
                                Aucune annonce urgente n'est disponible pour le moment.
                            @else
                                Aucun article n'est disponible pour le moment.
                            @endif
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Besoin d'un devis pour vos envois ?</h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Notre équipe est à votre disposition pour répondre à toutes vos demandes de transport et logistique.
        </p>
        <a href="{{ route('contact') }}" class="inline-block bg-white text-blue-700 font-semibold px-8 py-3 rounded-lg hover:bg-blue-50 transition-colors">
            Nous contacter
        </a>
    </div>
</section>
@endsection

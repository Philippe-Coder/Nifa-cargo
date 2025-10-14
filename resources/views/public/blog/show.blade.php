@extends('layouts.public')

@section('title', $article->titre . ' - ' . config('app.name'))

@section('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($article->contenu), 160) }}">
    <meta property="og:title" content="{{ $article->titre }} - {{ config('app.name') }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($article->contenu), 160) }}">
    @if($article->image_url)
    <meta property="og:image" content="{{ asset($article->image_url) }}">
    @endif
    <meta property="og:type" content="article">
    <meta name="twitter:card" content="summary_large_image">
@endsection

@section('content')
<!-- Article Header -->
<article class="bg-white">
    <div class="max-w-4xl mx-auto px-4 py-12">
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Retour aux actualités
            </a>
            
            <div class="flex items-center text-sm text-gray-500 mb-4">
                <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded">
                    {{ ucfirst($article->categorie) }}
                </span>
                <span class="mx-2">•</span>
                <time datetime="{{ $article->date_publication->format('Y-m-d') }}">
                    {{ $article->date_publication->format('d/m/Y') }}
                </time>
                @if($article->auteur)
                <span class="mx-2">•</span>
                <span>Par {{ $article->auteur->name }}</span>
                @endif
            </div>
            
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">{{ $article->titre }}</h1>
            
            @if($article->sous_titre)
            <p class="text-xl text-gray-600 mb-6">{{ $article->sous_titre }}</p>
            @endif
            
            @if($article->image_url)
            <div class="rounded-xl overflow-hidden mb-8">
                <img src="{{ $article->image_url }}" 
                     alt="{{ $article->titre }}" 
                     class="w-full h-auto rounded-lg">
                @if($article->legende_image)
                <p class="mt-2 text-sm text-gray-500 text-center">{{ $article->legende_image }}</p>
                @endif
            </div>
            @endif
        </div>

        <!-- Contenu de l'article -->
        <div class="prose max-w-none mb-12">
            {!! $article->contenu !!}
        </div>

        <!-- Partage sur les réseaux sociaux -->
        <div class="border-t border-b border-gray-200 py-6 my-8">
            <div class="flex flex-col sm:flex-row items-center justify-between">
                <p class="text-gray-700 font-medium mb-4 sm:mb-0">Partager cet article :</p>
                <div class="flex space-x-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="text-gray-500 hover:text-blue-600 transition-colors"
                       aria-label="Partager sur Facebook">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($article->titre) }}" 
                       target="_blank" 
                       class="text-gray-500 hover:text-blue-400 transition-colors"
                       aria-label="Partager sur Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}" 
                       target="_blank" 
                       class="text-gray-500 hover:text-blue-700 transition-colors"
                       aria-label="Partager sur LinkedIn">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z" />
                        </svg>
                    </a>
                    <button onclick="navigator.clipboard.writeText(window.location.href); alert('Lien copié dans le presse-papier !')" 
                            class="text-gray-500 hover:text-gray-700 transition-colors"
                            aria-label="Copier le lien">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Auteur (optionnel) -->
        @if($article->auteur)
        <div class="flex items-center bg-gray-50 rounded-lg p-6 mb-12">
            <div class="w-16 h-16 rounded-full bg-gray-200 overflow-hidden mr-4">
                @if($article->auteur->profile_photo_path)
                <img src="{{ $article->auteur->profile_photo_url }}" alt="{{ $article->auteur->name }}" class="w-full h-full object-cover">
                @else
                <div class="w-full h-full flex items-center justify-center bg-blue-600 text-white text-2xl font-bold">
                    {{ substr($article->auteur->name, 0, 1) }}
                </div>
                @endif
            </div>
            <div>
                <h3 class="font-bold text-lg text-gray-900">{{ $article->auteur->name }}</h3>
                @if($article->auteur->profile_photo_path)
                <p class="text-gray-600">{{ $article->auteur->profile_photo_path }}</p>
                @endif
            </div>
        </div>
        @endif
    </div>
</article>

<!-- Articles similaires -->
@if($articlesSimilaires->count() > 0)
<section class="bg-gray-50 py-16">
    <div class="max-w-4xl mx-auto px-4">
        <h2 class="text-2xl font-bold text-gray-900 mb-8">Articles similaires</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($articlesSimilaires as $article)
            <article class="bg-white rounded-lg overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                <a href="{{ route('blog.show', $article->slug) }}" class="block">
                    <div class="h-40 overflow-hidden">
                        <img src="{{ $article->image_url ?? 'https://via.placeholder.com/800x500?text=' . urlencode($article->titre) }}" 
                             alt="{{ $article->titre }}"
                             class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                    </div>
                    <div class="p-4">
                        <span class="inline-block bg-blue-100 text-blue-800 text-xs font-medium px-2 py-1 rounded mb-2">
                            {{ ucfirst($article->categorie) }}
                        </span>
                        <h3 class="font-bold text-gray-900 mb-2 hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $article->titre }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $article->date_publication->format('d/m/Y') }}
                        </p>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Section des commentaires -->
<section id="comment-section" class="py-12 bg-white">
    <div class="max-w-4xl mx-auto px-4">
        <div class="mb-8">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Commentaires <span id="comment-count" class="text-gray-600">Chargement...</span></h2>
            <p class="text-gray-600">Partagez vos pensées avec la communauté</p>
        </div>

        @auth
        <!-- Formulaire de commentaire -->
        <div class="bg-gray-50 rounded-lg p-6 mb-8">
            <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="annonce_id" id="annonce-id" value="{{ $article->id }}">
                <div class="mb-4">
                    <label for="comment-content" class="block text-sm font-medium text-gray-700 mb-2">Votre commentaire</label>
                    <textarea name="content" id="comment-content" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Écrivez votre commentaire ici..." required></textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Publier le commentaire
                    </button>
                </div>
            </form>
        </div>
        @else
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 mb-8">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700">
                        <a href="{{ route('login') }}" class="font-medium text-blue-700 hover:text-blue-600 underline">Connectez-vous</a> ou <a href="{{ route('register.client') }}" class="font-medium text-blue-700 hover:text-blue-600 underline">inscrivez-vous</a> pour laisser un commentaire.
                    </p>
                </div>
            </div>
        </div>
        @endauth

        <!-- Liste des commentaires -->
        <div id="comment-list" class="space-y-6">
            <!-- Les commentaires seront chargés ici via JavaScript -->
            <div class="text-center py-8">
                <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                <p class="mt-2 text-gray-600">Chargement des commentaires...</p>
            </div>
        </div>
    </div>
</section>

@push('styles')
    <link href="{{ asset('css/comments.css') }}" rel="stylesheet">
@endpush

@push('scripts')
    <script src="{{ asset('js/comments.js') }}"></script>
    <script>
        // Données utilisateur pour le système de commentaires
        @auth
        const currentUser = document.createElement('div');
        currentUser.id = 'current-user';
        currentUser.dataset.user = JSON.stringify({
            id: {{ auth()->id() }},
            name: '{{ addslashes(auth()->user()->name) }}',
            avatar_url: '{{ auth()->user()->avatar_url ?? '' }}'
        });
        document.body.appendChild(currentUser);
        @endauth

        // Charger les commentaires
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.commentSystem !== 'undefined') {
                window.commentSystem.loadComments({{ $article->id }});
            }
        });
    </script>
@endpush

<!-- CTA Section -->
<section class="bg-blue-600 text-white py-16">
    <div class="max-w-4xl mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Restez informé</h2>
        <p class="text-xl text-blue-100 mb-8">
            Abonnez-vous à notre newsletter pour recevoir les dernières actualités et offres spéciales.
        </p>
        <form action="#" method="POST" class="max-w-md mx-auto">
            <div class="flex">
                <input type="email" 
                       name="email" 
                       placeholder="Votre adresse email" 
                       class="flex-grow px-4 py-3 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-300 text-gray-900"
                       required>
                <button type="submit" class="bg-blue-800 hover:bg-blue-900 text-white font-medium px-6 py-3 rounded-r-lg transition-colors">
                    S'abonner
                </button>
            </div>
        </form>
    </div>
</section>

@endsection

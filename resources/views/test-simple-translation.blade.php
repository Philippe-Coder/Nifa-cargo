<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('Test Traduction Simple') }} - {{ app()->getLocale() }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .language-indicator {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        
        <!-- Header avec indicateur de langue -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center mb-4 px-6 py-3 rounded-full
                {{ app()->getLocale() == 'fr' ? 'bg-blue-100 text-blue-800 border-2 border-blue-300' : '' }}
                {{ app()->getLocale() == 'en' ? 'bg-green-100 text-green-800 border-2 border-green-300' : '' }}
                {{ app()->getLocale() == 'zh_CN' ? 'bg-red-100 text-red-800 border-2 border-red-300' : '' }}
                language-indicator">
                @switch(app()->getLocale())
                    @case('fr')
                        <span class="text-3xl mr-3">🇫🇷</span>
                        <span class="font-bold text-lg">FRANÇAIS ACTIF</span>
                        @break
                    @case('en')
                        <span class="text-3xl mr-3">🇺🇸</span>
                        <span class="font-bold text-lg">ENGLISH ACTIVE</span>
                        @break
                    @case('zh_CN')
                        <span class="text-3xl mr-3">🇨🇳</span>
                        <span class="font-bold text-lg">中文激活</span>
                        @break
                @endswitch
            </div>
            
            <h1 class="text-4xl font-bold mb-2">
                {{ __('Test du Système de Traduction') }}
            </h1>
            <p class="text-xl text-gray-600">
                {{ __('Locale courante') }} : <span class="font-mono bg-gray-200 px-2 py-1 rounded">{{ app()->getLocale() }}</span>
            </p>
        </div>

        <!-- Sélecteur de langue central -->
        <div class="flex justify-center mb-8">
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h2 class="text-xl font-semibold mb-4 text-center">{{ __('Sélecteur de Langue') }}</h2>
                <x-language-selector-url />
            </div>
        </div>

        <!-- Tests de traduction visibles -->
        <div class="grid md:grid-cols-2 gap-6 max-w-4xl mx-auto">
            
            <!-- Navigation -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold mb-4 text-blue-600">
                    <i class="fas fa-compass mr-2"></i>{{ __('Navigation') }}
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Accueil') }}</span>
                        <span class="text-2xl">🏠</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Services') }}</span>
                        <span class="text-2xl">🚚</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Contact') }}</span>
                        <span class="text-2xl">📞</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('À Propos') }}</span>
                        <span class="text-2xl">ℹ️</span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white p-6 rounded-xl shadow-lg">
                <h3 class="text-lg font-semibold mb-4 text-green-600">
                    <i class="fas fa-bolt mr-2"></i>{{ __('Actions') }}
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Suivre un colis') }}</span>
                        <span class="text-2xl">📦</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Mon espace') }}</span>
                        <span class="text-2xl">👤</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Faire une demande') }}</span>
                        <span class="text-2xl">➕</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-gray-50 rounded-lg">
                        <span class="font-medium">{{ __('Se connecter') }}</span>
                        <span class="text-2xl">🔑</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="max-w-2xl mx-auto mt-8 bg-white p-6 rounded-xl shadow-lg">
            <h3 class="text-lg font-semibold mb-4 text-purple-600">
                <i class="fas fa-info-circle mr-2"></i>{{ __('Instructions') }}
            </h3>
            <div class="space-y-3 text-sm">
                <div class="flex items-start">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">1</span>
                    <p>{{ __('Cliquez sur le sélecteur de langue ci-dessus') }}</p>
                </div>
                <div class="flex items-start">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">2</span>
                    <p>{{ __('Choisissez une langue') }} (🇺🇸 English {{ __('ou') }} 🇨🇳 中文)</p>
                </div>
                <div class="flex items-start">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">3</span>
                    <p>{{ __('Observez le changement de l\'URL et des traductions') }}</p>
                </div>
                <div class="flex items-start">
                    <span class="bg-purple-100 text-purple-800 rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold mr-3 mt-0.5">4</span>
                    <p>{{ __('Les traductions doivent changer immédiatement') }} ✨</p>
                </div>
            </div>
        </div>

        <!-- Lien vers la page d'accueil -->
        <div class="text-center mt-8">
            <a href="{{ route('accueil') }}{{ app()->getLocale() != 'fr' ? '?locale=' . app()->getLocale() : '' }}" 
               class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-home mr-2"></i>
                {{ __('Voir la page d\'accueil avec cette langue') }}
            </a>
        </div>
    </div>
</body>
</html>
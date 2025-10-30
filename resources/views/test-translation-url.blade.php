<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Test Traduction URL - {{ app()->getLocale() }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">{{ __('Test du Système de Traduction') }} (URL)</h1>
        
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Informations de Debug') }} :</h2>
            <p><strong>{{ __('Locale courante') }} (App::getLocale()) :</strong> {{ app()->getLocale() }}</p>
            <p><strong>{{ __('Paramètre URL locale') }} :</strong> {{ request()->get('locale', __('non défini')) }}</p>
            <p><strong>{{ __('Config locale par défaut') }} :</strong> {{ config('app.locale') }}</p>
            <p><strong>Timestamp :</strong> {{ now() }}</p>
        </div>

        <div class="bg-blue-50 p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Tests de Traduction') }} :</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p><strong>{{ __('Navigation') }} :</strong></p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>{{ __('Accueil') }}:</strong> "{{ __('Accueil') }}"</li>
                        <li><strong>{{ __('Services') }}:</strong> "{{ __('Services') }}"</li>
                        <li><strong>{{ __('Contact') }}:</strong> "{{ __('Contact') }}"</li>
                        <li><strong>{{ __('À Propos') }}:</strong> "{{ __('À Propos') }}"</li>
                        <li><strong>{{ __('Galerie') }}:</strong> "{{ __('Galerie') }}"</li>
                    </ul>
                </div>
                <div>
                    <p><strong>{{ __('Actions') }} :</strong></p>
                    <ul class="list-disc list-inside ml-4 space-y-1">
                        <li><strong>{{ __('Mon espace') }}:</strong> "{{ __('Mon espace') }}"</li>
                        <li><strong>{{ __('Suivre un colis') }}:</strong> "{{ __('Suivre un colis') }}"</li>
                        <li><strong>{{ __('Se connecter') }}:</strong> "{{ __('Se connecter') }}"</li>
                        <li><strong>{{ __('Faire une demande') }}:</strong> "{{ __('Faire une demande') }}"</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">{{ __('Sélecteur de Langue') }} (URL) :</h2>
            <x-language-selector-url />
        </div>

        <div class="bg-green-50 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">{{ __('Instructions') }} :</h2>
            <ol class="list-decimal list-inside space-y-2">
                <li>{{ __('Cliquez sur le sélecteur de langue ci-dessus') }}</li>
                <li>{{ __('Choisissez une langue') }} (English {{ __('ou') }} 中文)</li>
                <li>{{ __('Observez le changement de l\'URL et des traductions') }}</li>
                <li>{{ __('L\'URL doit contenir') }} <code>?locale=en</code> {{ __('ou') }} <code>?locale=zh_CN</code></li>
                <li>{{ __('Les traductions doivent changer immédiatement') }}</li>
            </ol>
            
            <!-- Indicateur visuel de langue active -->
            <div class="mt-6 p-4 bg-white rounded-lg border-l-4 
                {{ app()->getLocale() == 'fr' ? 'border-blue-500 bg-blue-50' : '' }}
                {{ app()->getLocale() == 'en' ? 'border-green-500 bg-green-50' : '' }}
                {{ app()->getLocale() == 'zh_CN' ? 'border-red-500 bg-red-50' : '' }}">
                <div class="flex items-center">
                    @switch(app()->getLocale())
                        @case('fr')
                            <span class="text-2xl mr-3">🇫🇷</span>
                            <div>
                                <p class="font-semibold text-blue-700">{{ __('Langue Active') }} : Français</p>
                                <p class="text-sm text-blue-600">{{ __('Interface en français') }}</p>
                            </div>
                            @break
                        @case('en')
                            <span class="text-2xl mr-3">🇺🇸</span>
                            <div>
                                <p class="font-semibold text-green-700">{{ __('Langue Active') }} : English</p>
                                <p class="text-sm text-green-600">{{ __('Interface en anglais') }}</p>
                            </div>
                            @break
                        @case('zh_CN')
                            <span class="text-2xl mr-3">🇨🇳</span>
                            <div>
                                <p class="font-semibold text-red-700">{{ __('Langue Active') }} : 中文</p>
                                <p class="text-sm text-red-600">{{ __('Interface en chinois') }}</p>
                            </div>
                            @break
                        @default
                            <span class="text-2xl mr-3">🌍</span>
                            <div>
                                <p class="font-semibold text-gray-700">{{ __('Langue Active') }} : {{ app()->getLocale() }}</p>
                                <p class="text-sm text-gray-600">{{ __('Langue détectée') }}</p>
                            </div>
                    @endswitch
                </div>
            </div>
        </div>
    </div>
</body>
</html>
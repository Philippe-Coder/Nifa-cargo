<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Debug Locale</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; background: #f5f5f5; }
        .container { background: white; padding: 30px; border-radius: 10px; max-width: 800px; margin: 0 auto; }
        .debug-info { background: #f8f9fa; padding: 20px; border-radius: 5px; margin: 10px 0; }
        .test-section { background: #e3f2fd; padding: 15px; border-radius: 5px; margin: 10px 0; }
        .language-switcher { margin: 20px 0; }
        .language-switcher a { 
            display: inline-block; 
            margin: 5px; 
            padding: 10px 15px; 
            background: #007bff; 
            color: white; 
            text-decoration: none; 
            border-radius: 5px; 
        }
        .language-switcher a:hover { background: #0056b3; }
        .success { color: #28a745; }
        .warning { color: #ffc107; }
        .error { color: #dc3545; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Debug Locale - NIF CARGO</h1>
        
        <div class="language-switcher">
            <h3>Test des langues :</h3>
            <a href="?locale=fr">🇫🇷 Français</a>
            <a href="?locale=en">🇺🇸 English</a>
            <a href="?locale=zh_CN">🇨🇳 中文</a>
        </div>

        <div class="debug-info">
            <h3>📊 Informations de locale :</h3>
            <ul>
                <li><strong>URL Locale:</strong> {{ request()->get('locale', 'non défini') }}</li>
                <li><strong>App Locale:</strong> <span class="@if(app()->getLocale() === 'fr') success @elseif(app()->getLocale() === 'en') warning @else error @endif">{{ app()->getLocale() }}</span></li>
                <li><strong>Session Locale:</strong> {{ session('locale', 'non défini') }}</li>
                <li><strong>Config Locale:</strong> {{ config('app.locale') }}</li>
                <li><strong>Available Locales:</strong> {{ implode(', ', config('app.available_locales', ['fr', 'en', 'zh_CN'])) }}</li>
                <li><strong>Timestamp:</strong> {{ now()->format('Y-m-d H:i:s') }}</li>
            </ul>
        </div>

        <div class="test-section">
            <h3>🧪 Test des traductions :</h3>
            <ul>
                <li><strong>Accueil:</strong> "{{ __('Accueil') }}"</li>
                <li><strong>Bienvenue:</strong> "{{ __('Bienvenue chez NIF CARGO') }}"</li>
                <li><strong>Transport Maritime:</strong> "{{ __('Transport Maritime') }}"</li>
                <li><strong>Services:</strong> "{{ __('Nos Services') }}"</li>
                <li><strong>Contact:</strong> "{{ __('Contactez-nous') }}"</li>
                <li><strong>Devis Gratuit:</strong> "{{ __('Obtenez un devis gratuit en quelques minutes') }}"</li>
                <li><strong>Qualité:</strong> "{{ __('Qualité et Fiabilité') }}"</li>
                <li><strong>Suivi:</strong> "{{ __('Suivi en Temps Réel') }}"</li>
            </ul>
        </div>

        <div class="debug-info">
            <h3>🔧 Détails techniques :</h3>
            <ul>
                <li><strong>Route actuelle:</strong> {{ request()->url() }}</li>
                <li><strong>Middleware groupe:</strong> web (contient SetLocaleFromUrl)</li>
                <li><strong>Translation path:</strong> {{ resource_path('lang') }}</li>
                <li><strong>Lang files:</strong> 
                    @if(file_exists(resource_path('lang/fr.json'))) ✅ fr.json @else ❌ fr.json @endif,
                    @if(file_exists(resource_path('lang/en.json'))) ✅ en.json @else ❌ en.json @endif,
                    @if(file_exists(resource_path('lang/zh_CN.json'))) ✅ zh_CN.json @else ❌ zh_CN.json @endif
                </li>
                <li><strong>Alternative lang path:</strong> {{ base_path('lang') }}
                    @if(file_exists(base_path('lang/fr.json'))) ✅ fr.json @else ❌ fr.json @endif,
                    @if(file_exists(base_path('lang/en.json'))) ✅ en.json @else ❌ en.json @endif,
                    @if(file_exists(base_path('lang/zh_CN.json'))) ✅ zh_CN.json @else ❌ zh_CN.json @endif
                </li>
            </ul>
        </div>

        <div class="test-section">
            <h3>🔄 Actions de test :</h3>
            <a href="{{ url('/') }}?locale=en" style="background: #28a745; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;">
                Tester page d'accueil en anglais
            </a>
            <a href="{{ url('/') }}?locale=zh_CN" style="background: #ffc107; color: black; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;">
                Tester page d'accueil en chinois
            </a>
            <a href="{{ url('/') }}?locale=fr" style="background: #dc3545; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px; margin: 5px;">
                Retour au français
            </a>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Test Traduction - {{ app()->getLocale() }}</title>
</head>
<body>
    <h1>Test du Système de Traduction</h1>
    
    <div style="padding: 20px; border: 2px solid #ccc; margin: 10px;">
        <h2>Informations de Debug :</h2>
        <p><strong>Locale courante (App::getLocale()) :</strong> {{ app()->getLocale() }}</p>
        <p><strong>Session locale :</strong> {{ session('locale', 'non définie') }}</p>
        <p><strong>Config locale par défaut :</strong> {{ config('app.locale') }}</p>
        <p><strong>Fallback locale :</strong> {{ config('app.fallback_locale') }}</p>
        <p><strong>Session ID :</strong> {{ session()->getId() }}</p>
        <p><strong>Timestamp :</strong> {{ now() }}</p>
    </div>

    <div style="padding: 20px; border: 2px solid #007bff; margin: 10px;">
        <h2>Tests de Traduction :</h2>
        <p><strong>Accueil (key='Accueil') :</strong> "{{ __('Accueil') }}"</p>
        <p><strong>Services (key='Services') :</strong> "{{ __('Services') }}"</p>
        <p><strong>Contact (key='Contact') :</strong> "{{ __('Contact') }}"</p>
        <p><strong>Mon espace (key='Mon espace') :</strong> "{{ __('Mon espace') }}"</p>
        <p><strong>À Propos (key='À Propos') :</strong> "{{ __('À Propos') }}"</p>
        <p><strong>Test direct trans() :</strong> "{{ trans('Accueil') }}"</p>
    </div>

    <div style="padding: 20px; margin: 10px;">
        <h2>Sélecteur de Langue :</h2>
        <a href="{{ route('lang.switch', 'fr') }}" style="margin-right: 10px; padding: 5px 10px; background: #007bff; color: white; text-decoration: none;">🇫🇷 Français</a>
        <a href="{{ route('lang.switch', 'en') }}" style="margin-right: 10px; padding: 5px 10px; background: #28a745; color: white; text-decoration: none;">🇺🇸 English</a>
        <a href="{{ route('lang.switch', 'zh_CN') }}" style="margin-right: 10px; padding: 5px 10px; background: #dc3545; color: white; text-decoration: none;">🇨🇳 中文</a>
    </div>

    <div style="padding: 20px; border: 2px solid #28a745; margin: 10px;">
        <h2>Instructions de Test :</h2>
        <ol>
            <li>Notez la locale courante ci-dessus</li>
            <li>Cliquez sur un des liens de langue</li>
            <li>Vérifiez que la locale change</li>
            <li>Vérifiez que les traductions changent</li>
            <li>Rafraîchissez la page (F5) pour voir si ça persiste</li>
        </ol>
    </div>
</body>
</html>
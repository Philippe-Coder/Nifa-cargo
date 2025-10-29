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
        <h1 class="text-3xl font-bold mb-6">Test du Système de Traduction (URL)</h1>
        
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Informations de Debug :</h2>
            <p><strong>Locale courante (App::getLocale()) :</strong> {{ app()->getLocale() }}</p>
            <p><strong>Paramètre URL locale :</strong> {{ request()->get('locale', 'non défini') }}</p>
            <p><strong>Config locale par défaut :</strong> {{ config('app.locale') }}</p>
            <p><strong>Timestamp :</strong> {{ now() }}</p>
        </div>

        <div class="bg-blue-50 p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Tests de Traduction :</h2>
            <p><strong>Accueil :</strong> "{{ __('Accueil') }}"</p>
            <p><strong>Services :</strong> "{{ __('Services') }}"</p>
            <p><strong>Contact :</strong> "{{ __('Contact') }}"</p>
            <p><strong>À Propos :</strong> "{{ __('À Propos') }}"</p>
            <p><strong>Mon espace :</strong> "{{ __('Mon espace') }}"</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Sélecteur de Langue (URL) :</h2>
            <x-language-selector-url />
        </div>

        <div class="bg-green-50 p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4">Instructions :</h2>
            <ol class="list-decimal list-inside space-y-2">
                <li>Cliquez sur le sélecteur de langue ci-dessus</li>
                <li>Choisissez une langue (English ou 中文)</li>
                <li>Observez le changement de l'URL et des traductions</li>
                <li>L'URL doit contenir <code>?locale=en</code> ou <code>?locale=zh_CN</code></li>
                <li>Les traductions doivent changer immédiatement</li>
            </ol>
        </div>
    </div>
</body>
</html>
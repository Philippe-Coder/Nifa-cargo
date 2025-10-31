<!DOCTYPE html>
<html>
<head>
    <title>Test Images - NIF CARGO</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .image-test { margin: 20px 0; padding: 15px; border: 1px solid #ddd; }
        .image-test img { max-width: 200px; height: auto; }
        .error { color: red; }
        .success { color: green; }
        .info { background: #f0f0f0; padding: 10px; margin: 10px 0; }
    </style>
</head>
<body>
    <h1>🔍 Test des Images - NIF CARGO</h1>
    
    <div class="info">
        <strong>URL de base:</strong> {{ url('/') }}<br>
        <strong>Environnement:</strong> {{ app()->environment() }}<br>
        <strong>Date/Heure:</strong> {{ now() }}
    </div>

    @php
        $images = [
            'Transport Maritime' => 'transport-maritime.jpg',
            'Transport Aérien' => 'transport-aerien.jpg', 
            'Transport Terrestre' => 'transport-terrestre.jpg',
            'Dédouanement' => 'dedouanement.jpg',
            'Entreposage' => 'entreposage.jpg',
            'Assurance' => 'assurance.jpg'
        ];
    @endphp

    @foreach($images as $title => $filename)
        <div class="image-test">
            <h3>{{ $title }}</h3>
            <p><strong>Fichier:</strong> {{ $filename }}</p>
            <p><strong>URL:</strong> {{ asset('images/' . $filename) }}</p>
            <p><strong>Chemin physique:</strong> {{ public_path('images/' . $filename) }}</p>
            <p><strong>Existe:</strong> 
                @if(file_exists(public_path('images/' . $filename)))
                    <span class="success">✅ OUI</span>
                @else
                    <span class="error">❌ NON</span>
                @endif
            </p>
            
            @if(file_exists(public_path('images/' . $filename)))
                <div>
                    <img src="{{ asset('images/' . $filename) }}" alt="{{ $title }}" 
                         onerror="this.parentElement.innerHTML='<span class=error>❌ Erreur de chargement</span>'">
                </div>
            @endif
        </div>
    @endforeach

    <div class="info">
        <h3>📋 Checklist Production</h3>
        <ul>
            <li>✅ Fichiers renommés sans espaces</li>
            <li>🔄 Vérifier permissions des dossiers (755)</li>
            <li>🔄 Vérifier permissions des fichiers (644)</li>
            <li>🔄 Vérifier que les images sont uploadées sur le serveur</li>
            <li>🔄 Vérifier la configuration du serveur web</li>
        </ul>
    </div>
</body>
</html>
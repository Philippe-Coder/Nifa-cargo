<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance en cours - NIFA</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f7fafc;
            color: #2d3748;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            text-align: center;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #2b6cb0;
            font-size: 2rem;
            margin-bottom: 1rem;
        }
        p {
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 1.5rem;
        }
        .status {
            display: inline-block;
            background-color: #e2e8f0;
            color: #4a5568;
            padding: 0.5rem 1rem;
            border-radius: 9999px;
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }
        .spinner {
            display: inline-block;
            width: 2rem;
            height: 2rem;
            border: 0.25rem solid rgba(66, 153, 225, 0.3);
            border-radius: 50%;
            border-top-color: #4299e1;
            animation: spin 1s ease-in-out infinite;
            margin-bottom: 1.5rem;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="{{ asset('img/logo.png') }}" alt="NIFA Logo" class="logo">
        <div class="spinner"></div>
        <h1>Maintenance en cours</h1>
        <div class="status">Mise à jour du système</div>
        <p>Notre site est actuellement en cours de maintenance pour une mise à jour. Nous faisons de notre mieux pour revenir au plus vite.</p>
        <p>Merci de votre compréhension et de votre patience.</p>
        <p><small>L'équipe NIFA CARGO</small></p>
    </div>
</body>
</html>

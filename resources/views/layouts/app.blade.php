<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'NIF Cargo, leader du transport et de la logistique en Afrique. Services de transport maritime, aérien et terrestre avec suivi en temps réel.')">

    <title>{{ config('app.name', 'NIF Cargo') }} - @yield('title', 'Transport et Logistique')</title>

    <!-- Favicon et icônes -->
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées Open Graph pour les réseaux sociaux -->
    <meta property="og:title" content="{{ config('app.name', 'NIF Cargo') }} - @yield('title', 'Transport et Logistique')">
    <meta property="og:description" content="@yield('description', 'NIF Cargo, leader du transport et de la logistique en Afrique. Services de transport maritime, aérien et terrestre avec suivi en temps réel.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="NIF Cargo">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:locale" content="fr_FR">
    
    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name', 'NIF Cargo') }} - @yield('title', 'Transport et Logistique')">
    <meta name="twitter:description" content="@yield('description', 'NIF Cargo, leader du transport et de la logistique en Afrique. Services de transport maritime, aérien et terrestre avec suivi en temps réel.')">
    <meta name="twitter:image" content="{{ asset('images/logo.png') }}">
    
    <!-- Métadonnées supplémentaires pour SEO -->
    <meta name="robots" content="index, follow">
    <meta name="author" content="NIF Cargo">
    <meta name="theme-color" content="#1e3a8a">
    <link rel="canonical" href="{{ url()->current() }}">
    
    <!-- Web App Manifest -->
    <link rel="manifest" href="/manifest.json">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Styles -->
    @stack('styles')
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.header')
    <!-- Contenu principal -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('components.footer')

    <!-- Scripts -->
    @stack('scripts')
</body>
</html>

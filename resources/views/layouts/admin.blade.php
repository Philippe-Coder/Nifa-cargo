<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de bord - Administration</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-blue-800 text-white flex flex-col">
            <div class="p-4 text-2xl font-bold border-b border-blue-700">
                🚚 Logistique Admin
            </div>

            <nav class="flex-1 p-4 space-y-3">
                <a href="{{ route('admin.dashboard') }}" class="block py-2 px-3 rounded hover:bg-blue-700 transition">
                🏠 Tableau de bord
                </a>
                <a href="{{ route('admin.demandes.index') }}" class="block py-2 px-3 rounded hover:bg-blue-700 transition">
                    📦 Demandes de transport
                </a>
               <a href="{{ route('admin.clients.index') }}" class="block py-2 px-3 rounded hover:bg-blue-700 transition">
                👥 Clients
                </a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700 transition">
                    📄 Documents
                </a>
                <a href="#" class="block py-2 px-3 rounded hover:bg-blue-700 transition">
                    ⚙️ Paramètres
                </a>
            </nav>

            <div class="p-4 border-t border-blue-700">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 py-2 rounded text-white">
                        🔒 Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        <!-- Contenu principal -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white shadow p-4 flex justify-between items-center">
                <h1 class="text-xl font-semibold text-gray-800">Tableau de bord</h1>
                <div class="flex items-center space-x-3">
                    <span class="text-gray-600 font-medium">{{ Auth::user()->name ?? 'Administrateur' }}</span>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}&background=0D8ABC&color=fff"
                         class="w-9 h-9 rounded-full border">
                </div>
            </header>

            <!-- Contenu de chaque page -->
            <main class="flex-1 overflow-y-auto">
                @yield('content')
            </main>
        </div>
    </div>

</body>
</html>

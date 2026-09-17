<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 text-unhcr-dark font-sans antialiased flex flex-col min-h-screen">
    <!-- En-tête -->
    <header class="bg-unhcr-blue text-white shadow-md border-b-4 border-unhcr-lightblue">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white text-unhcr-blue rounded-full flex items-center justify-center font-bold text-xl shadow-sm">PP</div>
                    <div>
                        <h1 class="text-lg font-bold leading-tight tracking-wide">Portail Partenaires</h1>
                        <p class="text-xs text-unhcr-lightblue font-medium">Rapportage des activités</p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Contenu Principal -->
    <main class="flex-1 flex items-center justify-center p-6">
        <div class="text-center max-w-lg bg-white p-10 rounded-xl shadow-lg border border-gray-100">
            <div class="text-6xl font-extrabold text-unhcr-blue mb-4">
                @yield('code')
            </div>
            <h2 class="text-2xl font-bold text-gray-800 mb-6">
                @yield('message')
            </h2>
            
            <p class="text-gray-500 mb-8">
                Il semble que la page que vous recherchez n'existe pas, que vous n'y avez pas accès, ou qu'une erreur est survenue.
            </p>

            <a href="{{ route('dashboard') }}" class="inline-flex items-center px-6 py-3 bg-unhcr-blue text-white font-medium rounded-md hover:bg-unhcr-dark transition-colors gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                </svg>
                Retour au Tableau de Bord
            </a>
        </div>
    </main>

    <!-- Pied de page -->
    <footer class="bg-white border-t border-unhcr-gray py-6 mt-auto">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Portail Partenaires - Accès réservé aux partenaires.
        </div>
    </footer>
</body>
</html>

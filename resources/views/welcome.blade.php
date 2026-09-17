<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Portail Partenaires') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .hero-pattern {
            background-color: var(--color-unhcr-blue);
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="antialiased bg-gray-50 flex flex-col min-h-screen">
    
    <!-- Navbar -->
    <nav class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Logo placeholder -->
                    <div class="flex-shrink-0 flex items-center gap-3">
                        <div class="w-10 h-10 bg-unhcr-blue rounded-full flex items-center justify-center text-white font-bold text-xl shadow-sm">PP</div>
                        <span class="font-bold text-xl text-gray-900 tracking-tight">Portail Partenaires</span>
                    </div>
                </div>
                <div class="flex items-center">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-600 hover:text-unhcr-blue px-3 py-2 rounded-md text-sm font-medium transition">Accéder au portail</a>
                    @else
                        <a href="{{ route('auth.google.redirect') }}" class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-medium rounded-md text-white bg-unhcr-blue hover:bg-unhcr-dark shadow-sm transition transform hover:-translate-y-0.5">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" />
                            </svg>
                            Connexion Partenaire
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="flex-grow">
        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            </div>
        @endif
        
        <div class="hero-pattern relative overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
                <div class="text-center md:max-w-3xl md:mx-auto">
                    <h1 class="text-4xl tracking-tight font-extrabold text-white sm:text-5xl md:text-6xl mb-6">
                        <span class="block">Rapportage des activités</span>
                        <span class="block text-unhcr-lightblue">des Activités Humanitaires</span>
                    </h1>
                    <p class="mt-3 max-w-md mx-auto text-base text-white sm:text-lg md:mt-5 md:text-xl md:max-w-2xl">
                        Plateforme centralisée pour la gestion des secteurs, le rapportage des activités par les partenaires et le suivi des indicateurs clés.
                    </p>
                    <div class="mt-10 max-w-sm mx-auto sm:max-w-none sm:flex sm:justify-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-unhcr-dark bg-white hover:bg-gray-50 md:py-4 md:text-lg px-10 transition shadow-lg">
                                Aller au tableau de bord
                            </a>
                        @else
                            <a href="{{ route('auth.google.redirect') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-unhcr-dark bg-white hover:bg-gray-50 md:py-4 md:text-lg px-10 transition shadow-lg">
                                <svg class="w-5 h-5 mr-3 text-unhcr-blue" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                    <path d="M12.48 10.92v3.28h7.84c-.24 1.84-.853 3.187-1.787 4.133-1.147 1.147-2.933 2.4-6.053 2.4-4.827 0-8.6-3.893-8.6-8.72s3.773-8.72 8.6-8.72c2.6 0 4.507 1.027 5.907 2.347l2.307-2.307C18.747 1.44 16.133 0 12.48 0 5.867 0 .307 5.387.307 12s5.56 12 12.173 12c3.573 0 6.267-1.173 8.373-3.36 2.16-2.16 2.84-5.213 2.84-7.667 0-.76-.053-1.467-.173-2.053H12.48z" />
                                </svg>
                                S'authentifier avec Google
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
            
            <!-- Curve SVG -->
            <div class="absolute bottom-0 inset-x-0">
                <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="#f9fafb"></path>
                </svg>
            </div>
        </div>

        <!-- Features Section -->
        <div class="py-16 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-base text-unhcr-blue font-semibold tracking-wide uppercase">Une gestion unifiée</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                        Tout pour le pilotage humanitaire
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Feature 1 -->
                    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-unhcr-gray bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-unhcr-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Rapportage d'Activités</h3>
                        <p class="text-gray-600">Saisissez et suivez en temps réel l'ensemble de vos interventions sur le terrain par secteur et province.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-unhcr-gray bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-unhcr-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Gestion Documentaire</h3>
                        <p class="text-gray-600">Centralisez vos rapports, listes, cartes et évaluations au sein d'une bibliothèque sécurisée.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 hover:shadow-md transition">
                        <div class="w-12 h-12 bg-unhcr-gray bg-opacity-20 rounded-lg flex items-center justify-center mb-6">
                            <svg class="w-6 h-6 text-unhcr-blue" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">Coordination Inter-Agences</h3>
                        <p class="text-gray-600">Pilotez les accès, affectez les partenaires et bénéficiez de statistiques consolidées.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Portail Partenaires. Accès restreint aux partenaires autorisés.
            </p>
        </div>
    </footer>
</body>
</html>

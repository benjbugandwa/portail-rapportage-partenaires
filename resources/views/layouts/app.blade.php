<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0072BC">
    <title>{{ $title ?? 'Portail Partenaires' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @notifyCss
</head>
<body class="flex min-h-screen flex-col font-sans antialiased">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:left-4 focus:top-4 focus:z-[60] focus:bg-white focus:px-4 focus:py-2 focus:text-unhcr-dark">Aller au contenu principal</a>
    <header class="bg-white">
        <div class="mx-auto flex max-w-screen-2xl items-center justify-between gap-5 px-4 py-5 sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-unhcr-blue" aria-label="Portail Partenaires, accueil">
                <svg class="h-11 w-11 shrink-0" viewBox="0 0 48 48" fill="none" aria-hidden="true"><circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="2"/><path d="M15 33V20l9-7 9 7v13M20 33V24h8v9M11 17c3-5 8-8 13-8s10 3 13 8" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/></svg>
                <span class="border-l border-slate-300 pl-3 leading-none"><span class="block text-2xl font-bold tracking-tight">UNHCR</span><span class="mt-1 block text-[11px] font-semibold uppercase tracking-[0.08em]">Portail Partenaires</span></span>
            </a>
            <div class="hidden text-right text-xs text-slate-600 sm:block"><p class="font-semibold text-unhcr-dark">Rapportage et coordination</p><p>Activités humanitaires</p></div>
        </div>
        <nav class="border-y border-[#0067aa] bg-unhcr-blue text-white" aria-label="Navigation principale">
            <div class="mx-auto max-w-screen-2xl px-4 sm:px-6 lg:px-8">
                <div class="hidden min-h-14 items-stretch md:flex">
                    <a href="{{ route('dashboard') }}" @class(['portal-nav-link', 'portal-nav-link-active' => request()->routeIs('dashboard')])>Tableau de bord</a>
                    <a href="{{ route('activites') }}" @class(['portal-nav-link', 'portal-nav-link-active' => request()->routeIs('activites')])>Activités</a>
                    <a href="{{ route('documents') }}" @class(['portal-nav-link', 'portal-nav-link-active' => request()->routeIs('documents')])>Documents</a>
                    @role('Admin')
                    <a href="{{ route('utilisateurs') }}" @class(['portal-nav-link', 'portal-nav-link-active' => request()->routeIs('utilisateurs')])>Utilisateurs</a>
                    <a href="{{ route('secteurs') }}" @class(['portal-nav-link', 'portal-nav-link-active' => request()->routeIs('secteurs')])>Secteurs</a>
                    @endrole
                    <div class="ml-auto flex items-center gap-3 py-2 pl-4"><div class="hidden text-right lg:block"><p class="text-sm font-bold">{{ auth()->user()->nom ?? 'Utilisateur' }}</p><p class="text-xs text-blue-100">{{ optional(auth()->user()->organisation)->denomination ?? 'Non assigné' }}</p></div><form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="rounded-sm border border-blue-300 px-3 py-1.5 text-xs font-bold hover:bg-[#005b96]" title="Se déconnecter">Déconnexion</button></form></div>
                </div>
                <details class="group md:hidden"><summary class="flex cursor-pointer list-none items-center justify-between py-3 text-sm font-bold [&::-webkit-details-marker]:hidden">Menu<svg class="h-5 w-5 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 0 1 1.06.02L10 11.17l3.71-3.94a.75.75 0 1 1 1.08 1.04l-4.25 4.5a.75.75 0 0 1-1.08 0l-4.25-4.5a.75.75 0 0 1 .02-1.06Z" clip-rule="evenodd"/></svg></summary><div class="border-t border-blue-500 py-2"><a href="{{ route('dashboard') }}" class="portal-nav-link-mobile">Tableau de bord</a><a href="{{ route('activites') }}" class="portal-nav-link-mobile">Activités</a><a href="{{ route('documents') }}" class="portal-nav-link-mobile">Documents</a>@role('Admin')<a href="{{ route('utilisateurs') }}" class="portal-nav-link-mobile">Utilisateurs</a><a href="{{ route('secteurs') }}" class="portal-nav-link-mobile">Secteurs</a>@endrole<form method="POST" action="{{ route('logout') }}" class="px-3 py-2">@csrf<button type="submit" class="text-sm font-bold underline">Déconnexion</button></form></div></details>
            </div>
        </nav>
    </header>
    <main id="main-content" class="mx-auto w-full max-w-screen-2xl flex-1 px-4 py-8 sm:px-6 lg:px-8">{{ $slot }}</main>
    <footer class="mt-auto bg-[#303030] text-slate-200"><div class="mx-auto flex max-w-screen-2xl flex-col gap-4 px-4 py-8 text-sm sm:px-6 md:flex-row md:items-center md:justify-between lg:px-8"><div><p class="text-lg font-bold text-white">UNHCR</p><p>Portail de rapportage des partenaires</p></div><p class="text-slate-300">© {{ date('Y') }} Portail Partenaires · Accès réservé aux partenaires autorisés.</p></div></footer>
    @notifyJs
    <x-notify::notify />
</body>
</html>

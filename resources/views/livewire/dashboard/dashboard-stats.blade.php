<div class="portal-page">
    <div class="portal-heading flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div><p class="portal-kicker">Rapportage humanitaire</p><h2>Tableau de bord</h2></div>
        <span class="rounded-full bg-unhcr-pale px-4 py-2 text-sm font-bold text-unhcr-dark">
            {{ $isAdmin ? 'Vue Globale (Administrateur)' : 'Vue Partenaire (Staff)' }}
        </span>
    </div>

    <!-- KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="portal-card border-l-4 border-unhcr-blue p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Activités</h3>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $totalActivites }}</p>
        </div>
        <div class="portal-card border-l-4 border-amber-500 p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">En cours</h3>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $activitesEnCours }}</p>
        </div>
        <div class="portal-card border-l-4 border-emerald-600 p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Clôturées</h3>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $activitesCloturees }}</p>
        </div>
        <div class="portal-card border-l-4 border-unhcr-dark p-6">
            <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Personnes Atteintes</h3>
            <p class="mt-2 text-3xl font-bold text-gray-900">{{ number_format($totalPersonnes, 0, ',', ' ') }}</p>
        </div>
    </div>

    <!-- Secondary KPIs -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @if($isAdmin)
        <div class="portal-card flex items-center justify-between p-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Utilisateurs</h3>
                <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
            <div class="p-3 bg-gray-100 rounded-full">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
        </div>
        <div class="portal-card flex items-center justify-between p-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Organisations Partenaires</h3>
                <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalOrgs }}</p>
            </div>
            <div class="p-3 bg-gray-100 rounded-full">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            </div>
        </div>
        @else
        <div class="portal-card flex items-center justify-between p-6">
            <div>
                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Membres de votre organisation</h3>
                <p class="mt-2 text-2xl font-bold text-gray-900">{{ $totalUsers }}</p>
            </div>
        </div>
        @endif
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="portal-card p-6">
            <h3 class="text-lg font-bold text-gray-800 mb-4">Activités par Secteur</h3>
            <div class="relative h-64 w-full">
                <canvas id="secteurChart"></canvas>
            </div>
        </div>
        
        <div class="portal-card flex items-center justify-center border-dashed bg-unhcr-pale p-6">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                <p class="mt-2 text-gray-500 mb-2">L'évolution mensuelle sera disponible prochainement.</p>
                <span class="px-3 py-1 bg-gray-200 text-gray-600 rounded text-xs font-semibold">Bientôt</span>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('livewire:navigated', () => {
            initChart();
        });
        document.addEventListener('DOMContentLoaded', () => {
            initChart();
        });

        function initChart() {
            const ctx = document.getElementById('secteurChart');
            if(!ctx) return;
            
            const labels = {!! $activitesParSecteurLabels !!};
            const data = {!! $activitesParSecteurData !!};

            new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: labels.length > 0 ? labels : ['Aucun secteur'],
                    datasets: [{
                        data: data.length > 0 ? data : [1],
                        backgroundColor: data.length > 0 ? [
                            '#0072BC',
                            '#18375F',
                            '#99C7E4',
                            '#0067AA',
                            '#4D9DCF',
                            '#74B5DA',
                        ] : ['#e5e7eb'], // gray-200 if empty
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        }
    </script>
</div>

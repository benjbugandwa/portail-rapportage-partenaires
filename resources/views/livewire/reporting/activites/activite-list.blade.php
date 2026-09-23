<div class="portal-card p-5 sm:p-6">
    <div class="portal-heading mb-6 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div><p class="portal-kicker">Suivi opérationnel</p><h2>Rapportage des activités</h2></div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <button class="portal-button-secondary" wire:click="$dispatch('open-export-modal')">
                Exporter
            </button>
            <button class="portal-button-primary" wire:click="$dispatch('open-activite-modal')">
                Nouvelle Activité
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="portal-filter mb-6 grid grid-cols-1 gap-4 md:grid-cols-5">
        <input type="text" wire:model.live="search" placeholder="Rechercher..." class="p-2 border rounded w-full">
        
        <select wire:model.live="secteur_id" class="p-2 border rounded w-full">
            <option value="">Tous les secteurs</option>
            @foreach($secteurs as $secteur)
                <option value="{{ $secteur->id }}">{{ $secteur->denomination }}</option>
            @endforeach
        </select>

        <select wire:model.live="province_id" class="p-2 border rounded w-full">
            <option value="">Toutes les provinces</option>
            @foreach($provinces as $prov)
                <option value="{{ $prov->id }}">{{ $prov->nom_province }}</option>
            @endforeach
        </select>

        <select wire:model.live="statut" class="p-2 border rounded w-full">
            <option value="">Tous les statuts</option>
            <option value="en cours">En cours</option>
            <option value="clôturée">Clôturée</option>
        </select>

        <div class="flex gap-2">
            <input type="date" wire:model.live="date_debut" class="p-2 border rounded w-full text-sm" title="Date de début">
            <input type="date" wire:model.live="date_fin" class="p-2 border rounded w-full text-sm" title="Date de fin">
        </div>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto rounded-sm border border-slate-200">
        <table class="portal-table min-w-full divide-y divide-slate-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Activité</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Secteur</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($activites as $activite)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="text-sm font-bold text-gray-900">{{ $activite->intitule }}</div>
                            <div class="text-xs text-gray-500 line-clamp-1">{{ $activite->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ optional(optional($activite->createur)->organisation)->denomination ?? 'N/A' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex rounded-full bg-unhcr-pale px-2 text-xs font-semibold leading-5 text-unhcr-dark">
                                {{ optional($activite->secteur)->denomination }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($activite->statut === 'clôturée')
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Clôturée</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">En cours</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $activite->date_activite->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            @can('update', $activite)
                                <button wire:click="$dispatch('edit-activite', { id: '{{ $activite->id }}' })" class="font-bold text-unhcr-blue hover:text-unhcr-dark">Éditer</button>
                            @endcan
                            @can('delete', $activite)
                                <button wire:confirm="Êtes-vous sûr de vouloir supprimer cette activité ?" wire:click="deleteActivite('{{ $activite->id }}')" class="font-bold text-red-600 hover:text-red-800">Supprimer</button>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucune activité trouvée.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $activites->links() }}
    </div>

    <livewire:reporting.activites.activite-form-modal />
    <livewire:reporting.activites.activite-export-modal />
</div>

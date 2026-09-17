<div class="portal-card p-5 sm:p-6">
    <div class="portal-heading mb-6 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div><p class="portal-kicker">Administration</p><h2>Gestion des secteurs</h2></div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <button class="portal-button-primary" wire:click="$dispatch('openSecteurModal')">
                Ajouter un secteur
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="portal-filter mb-6">
        <input type="text" wire:model.live="search" placeholder="Rechercher par dénomination..." class="p-2 border rounded w-full md:w-1/3">
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto rounded-sm border border-slate-200">
        <table class="portal-table min-w-full divide-y divide-slate-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dénomination</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($secteurs as $secteur)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-gray-900">{{ $secteur->denomination }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-500 line-clamp-2">{{ $secteur->description }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="$dispatch('editSecteur', { id: '{{ $secteur->id }}' })" class="font-bold text-unhcr-blue hover:text-unhcr-dark">Éditer</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucun secteur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $secteurs->links() }}
    </div>

    <!-- Modals -->
    <livewire:admin.secteurs.secteur-form-modal />
</div>

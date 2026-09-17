<div class="portal-card p-5 sm:p-6">
    <div class="portal-heading mb-6 flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div><p class="portal-kicker">Administration</p><h2>Gestion des utilisateurs</h2></div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <button class="portal-button-primary" wire:click="$dispatch('open-user-modal')">
                Ajouter un utilisateur
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="portal-filter mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
        <input type="text" wire:model.live="search" placeholder="Rechercher (nom, email)..." class="p-2 border rounded w-full">
        
        <select wire:model.live="organisation_id" class="p-2 border rounded w-full">
            <option value="">Toutes les organisations</option>
            @foreach($organisations as $org)
                <option value="{{ $org->id }}">{{ $org->denomination }}</option>
            @endforeach
        </select>

        <select wire:model.live="province_id" class="p-2 border rounded w-full">
            <option value="">Toutes les provinces</option>
            @foreach($provinces as $prov)
                <option value="{{ $prov->id }}">{{ $prov->nom_province }}</option>
            @endforeach
        </select>

        <select wire:model.live="is_active" class="p-2 border rounded w-full">
            <option value="">Tous les statuts</option>
            <option value="1">Actif</option>
            <option value="0">Inactif</option>
        </select>
    </div>

    <!-- Tableau -->
    <div class="overflow-x-auto rounded-sm border border-slate-200">
        <table class="portal-table min-w-full divide-y divide-slate-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom / Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Organisation</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Province</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rôle</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Statut</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dernière Connexion</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 bg-white">
                @forelse($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->nom }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $user->organisation ? $user->organisation->denomination : 'Non assigné' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                {{ $user->province ? $user->province->nom_province : 'Non assigné' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->roles->first()->name ?? $user->role }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->is_active)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Actif</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactif</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Jamais' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="$dispatch('edit-user', { id: '{{ $user->id }}' })" class="mr-3 font-bold text-unhcr-blue hover:text-unhcr-dark">Éditer</button>
                            <button wire:click="$dispatch('audit-user', { id: '{{ $user->id }}' })" class="font-bold text-slate-600 hover:text-unhcr-blue">Audit</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 whitespace-nowrap text-center text-gray-500">Aucun utilisateur trouvé.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>

    <!-- Modals -->
    <livewire:admin.users.user-form-modal />
    <livewire:admin.users.user-audit-modal />
</div>

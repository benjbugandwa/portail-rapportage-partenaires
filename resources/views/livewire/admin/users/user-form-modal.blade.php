<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel relative inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="portal-modal-title" id="modal-title">
                                    {{ $user_id ? 'Éditer l\'utilisateur' : 'Ajouter un utilisateur' }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom complet</label>
                                        <input type="text" wire:model="nom" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                        @error('nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" wire:model="email" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Organisation</label>
                                        <select wire:model="organisation_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                            <option value="">-- Aucune --</option>
                                            @foreach($organisations as $org)
                                                <option value="{{ $org->id }}">{{ $org->denomination }}</option>
                                            @endforeach
                                        </select>
                                        @error('organisation_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Province</label>
                                        <select wire:model="province_id" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                            <option value="">-- Aucune --</option>
                                            @foreach($provinces as $prov)
                                                <option value="{{ $prov->id }}">{{ $prov->nom_province }}</option>
                                            @endforeach
                                        </select>
                                        @error('province_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Rôle</label>
                                        <select wire:model="role" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                                            @foreach($roles as $r)
                                                <option value="{{ $r->name }}">{{ ucfirst($r->name) }}</option>
                                            @endforeach
                                        </select>
                                        @error('role') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-indigo-600 border-gray-300 rounded">
                                        <label class="ml-2 block text-sm text-gray-900">Compte Actif</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="portal-button-primary w-full sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="save">Enregistrer</span>
                            <span wire:loading wire:target="save">Chargement...</span>
                        </button>
                        <button type="button" wire:click="close" class="portal-button-secondary mt-3 w-full sm:mt-0 sm:ml-3 sm:w-auto">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>

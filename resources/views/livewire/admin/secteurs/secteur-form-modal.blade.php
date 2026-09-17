<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="portal-modal-title" id="modal-title">
                                    {{ $secteur_id ? 'Éditer le secteur' : 'Ajouter un secteur' }}
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Dénomination (ex: WASH, SANTE)</label>
                                        <input type="text" wire:model="denomination" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                                        @error('denomination') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea wire:model="description" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"></textarea>
                                        @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
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

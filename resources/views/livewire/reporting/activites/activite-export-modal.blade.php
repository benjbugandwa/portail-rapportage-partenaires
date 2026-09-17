<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel relative inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:align-middle">
                <form wire:submit.prevent="export">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="portal-modal-title" id="modal-title">
                            Exporter les activités
                        </h3>
                        <div class="mt-4 space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de début</label>
                                <input type="date" wire:model="date_debut" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                @error('date_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                                <input type="date" wire:model="date_fin" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                @error('date_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="portal-button-primary w-full sm:ml-3 sm:w-auto">
                            Exporter en CSV
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

<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel relative inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-2xl sm:align-middle">
                
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="portal-modal-title mb-4" id="modal-title">
                                    {{ $document_id ? 'Éditer le document' : 'Ajouter un document' }}
                                </h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nom du document *</label>
                                        <input type="text" wire:model="doc_name" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                                        @error('doc_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Catégorie *</label>
                                            <select wire:model="doc_category" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                                                @foreach($categories as $cat)
                                                    <option value="{{ $cat }}">{{ $cat }}</option>
                                                @endforeach
                                            </select>
                                            @error('doc_category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Date de publication *</label>
                                            <input type="date" wire:model="date_publication" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500" required>
                                            @error('date_publication') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Résumé court</label>
                                        <textarea wire:model="doc_summary" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                        @error('doc_summary') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Fichier (PDF, Excel, Word, Image) {{ !$document_id ? '*' : '' }}</label>
                                        <input type="file" wire:model="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        @if($existing_file_path)
                                            <div class="mt-2 text-sm text-gray-500">
                                                Fichier actuel : <strong>{{ $original_name }}</strong>
                                            </div>
                                        @endif
                                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg">
                        <button type="submit" class="portal-button-primary w-full sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="save, file">Enregistrer</span>
                            <span wire:loading wire:target="save">Sauvegarde...</span>
                            <span wire:loading wire:target="file">Upload...</span>
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

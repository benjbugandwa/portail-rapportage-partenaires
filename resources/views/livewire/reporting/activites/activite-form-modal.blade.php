<div>
    @if($show)
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="close"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="portal-modal-panel relative inline-block max-h-[calc(100vh-2rem)] overflow-y-auto bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-3xl sm:align-middle">
                
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 max-h-[80vh] overflow-y-auto">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="portal-modal-title mb-4" id="modal-title">
                                    {{ $activite_id ? 'Éditer l\'activité' : 'Nouvelle activité' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Intitulé -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Intitulé de l'activité *</label>
                                        <input type="text" wire:model="intitule" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                        @error('intitule') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Date & Secteur -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date *</label>
                                        <input type="date" wire:model="date_activite" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                        @error('date_activite') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Secteur *</label>
                                        <select wire:model="secteur_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                            <option value="">Sélectionnez un secteur</option>
                                            @foreach($secteurs as $secteur)
                                                <option value="{{ $secteur->id }}">{{ $secteur->denomination }}</option>
                                            @endforeach
                                        </select>
                                        @error('secteur_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Description -->
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea wire:model="description" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700">Défis et contraintes</label>
                                        <textarea wire:model="defis_contraintes" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
                                    </div>

                                    <!-- Localisation (Provinces + Texte libre) -->
                                    <div class="md:col-span-2 bg-gray-50 p-4 rounded-md border">
                                        <h4 class="font-medium text-gray-800 mb-2">Localisation</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-700">Provinces concernées (Multiples)</label>
                                                <select wire:model="province_id" multiple class="mt-1 block w-full border border-gray-300 rounded-md p-2 h-24">
                                                    @foreach($provinces as $prov)
                                                        <option value="{{ $prov->id }}">{{ $prov->nom_province }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="text-xs text-gray-500">Maintenez CTRL pour sélectionner plusieurs</span>
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-700">Précisions (Territoire, Village, etc.)</label>
                                                <textarea wire:model="localites" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md p-2"></textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Indicateurs -->
                                    <div class="md:col-span-2 bg-gray-50 p-4 rounded-md border">
                                        <h4 class="font-medium text-gray-800 mb-2">Indicateurs et Cibles</h4>
                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label class="block text-sm text-gray-700">Nombre de personnes</label>
                                                <input type="number" min="0" wire:model="nbre_personnes" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-700">Nombre de ménages</label>
                                                <input type="number" min="0" wire:model="nbre_menage" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                            </div>
                                            <div>
                                                <label class="block text-sm text-gray-700">Population Cible</label>
                                                <select wire:model="population_cible" multiple class="mt-1 block w-full border border-gray-300 rounded-md p-2 h-20">
                                                    <option value="PDI">PDI</option>
                                                    <option value="Réfugié">Réfugié</option>
                                                    <option value="Autochtones">Autochtones</option>
                                                    <option value="Autres">Autres</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Statut et Fichier -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Statut</label>
                                        <select wire:model="statut" class="mt-1 block w-full border border-gray-300 rounded-md p-2">
                                            <option value="en cours">En cours</option>
                                            <option value="clôturée">Clôturée</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Justificatif (PDF, Image, etc.)</label>
                                        <input type="file" wire:model="file" class="mt-1 block w-full">
                                        @if($existing_file_path)
                                            <div class="mt-1 text-sm">
                                                <a href="{{ Storage::url($existing_file_path) }}" target="_blank" class="text-blue-600 underline">Voir le fichier actuel</a>
                                            </div>
                                        @endif
                                        @error('file') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-100 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse rounded-b-lg border-t">
                        <button type="submit" class="portal-button-primary w-full sm:ml-3 sm:w-auto">
                            <span wire:loading.remove wire:target="save, file">Enregistrer</span>
                            <span wire:loading wire:target="save">Sauvegarde...</span>
                            <span wire:loading wire:target="file">Upload en cours...</span>
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

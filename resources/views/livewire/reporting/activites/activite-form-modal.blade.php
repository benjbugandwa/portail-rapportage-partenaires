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
                                    <!-- 1. Secteur & Date -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Secteur *</label>
                                        <select wire:model.live="secteur_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                            <option value="">Sélectionnez d'abord un secteur</option>
                                            @foreach($secteurs as $secteur)
                                                <option value="{{ $secteur->id }}">{{ $secteur->denomination }}</option>
                                            @endforeach
                                        </select>
                                        @error('secteur_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Date *</label>
                                        <input type="date" wire:model="date_activite" class="mt-1 block w-full border border-gray-300 rounded-md p-2" required>
                                        @error('date_activite') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- 2. Intitulé de l'activité (filtré par le secteur sélectionné) -->
                                    <div class="md:col-span-2 relative" x-data="{ openSuggestions: false }">
                                        <label class="block text-sm font-medium text-gray-700">Intitulé de l'activité *</label>
                                        <div class="relative mt-1">
                                            <input 
                                                type="text" 
                                                wire:model.live.debounce.150ms="intitule" 
                                                @focus="openSuggestions = true"
                                                @click.outside="openSuggestions = false"
                                                placeholder="{{ $selectedSecteurName ? 'Choisissez une activité pour '.$selectedSecteurName.' ou saisissez un intitulé...' : 'Sélectionnez un secteur ci-dessus pour des suggestions ciblées...' }}"
                                                class="block w-full border border-gray-300 rounded-md p-2 pr-10 focus:border-unhcr-blue focus:ring-unhcr-blue" 
                                                required
                                                autocomplete="off"
                                            >
                                            <button 
                                                type="button" 
                                                @click="openSuggestions = !openSuggestions"
                                                class="absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-unhcr-blue"
                                                title="Afficher les suggestions"
                                            >
                                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': openSuggestions }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Dropdown de suggestions -->
                                        <div 
                                            x-show="openSuggestions" 
                                            x-transition:enter="transition ease-out duration-100"
                                            x-transition:enter-start="transform opacity-0 scale-95"
                                            x-transition:enter-end="transform opacity-100 scale-100"
                                            x-transition:leave="transition ease-in duration-75"
                                            x-transition:leave-start="transform opacity-100 scale-100"
                                            x-transition:leave-end="transform opacity-0 scale-95"
                                            class="absolute z-30 mt-1 w-full bg-white rounded-md shadow-lg border border-slate-200 max-h-60 overflow-y-auto"
                                            style="display: none;"
                                        >
                                            @if(count($suggestions) > 0)
                                                <div class="px-3 py-1.5 text-[11px] font-bold uppercase tracking-wider text-unhcr-blue bg-unhcr-pale border-b border-slate-100 flex justify-between items-center sticky top-0 bg-unhcr-pale z-10">
                                                    <span>
                                                        @if($selectedSecteurName)
                                                            Suggestions pour {{ $selectedSecteurName }} ({{ count($suggestions) }})
                                                        @else
                                                            Suggestions d'activités ({{ count($suggestions) }})
                                                        @endif
                                                    </span>
                                                    <span class="text-[10px] text-gray-500 font-normal">Cliquer pour sélectionner</span>
                                                </div>
                                                <ul class="divide-y divide-gray-100">
                                                    @foreach($suggestions as $suggestion)
                                                        <li>
                                                            <button 
                                                                type="button" 
                                                                wire:click="selectSuggestion('{{ $suggestion->id }}')"
                                                                @click="openSuggestions = false"
                                                                class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-unhcr-pale hover:text-unhcr-blue transition flex items-center justify-between group"
                                                            >
                                                                <span class="font-medium text-gray-800 group-hover:text-unhcr-blue">{{ $suggestion->activite }}</span>
                                                                <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-slate-100 text-slate-600 group-hover:bg-blue-100 group-hover:text-unhcr-dark shrink-0">
                                                                    {{ $suggestion->secteur }}
                                                                </span>
                                                            </button>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <div class="p-3 text-center text-xs text-gray-500">
                                                    Aucune suggestion trouvée. Vous pouvez saisir un intitulé personnalisé.
                                                </div>
                                            @endif
                                        </div>

                                        @error('intitule') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                        <p class="mt-1 text-xs text-gray-500">
                                            @if($selectedSecteurName)
                                                Les suggestions ci-dessus sont filtrées pour le secteur <strong>{{ $selectedSecteurName }}</strong>. Vous pouvez aussi écrire votre propre intitulé.
                                            @else
                                                Astuce : sélectionnez un secteur ci-dessus pour obtenir les activités recommandées pour ce secteur.
                                            @endif
                                        </p>
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

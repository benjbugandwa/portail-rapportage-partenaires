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
                            Exporter les activités d'intervention
                        </h3>
                        <div class="mt-4 space-y-4">

                            <!-- Format d'exportation -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Format du rapport</label>
                                <div class="mt-2 grid grid-cols-2 gap-3">
                                    <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-slate-50 @if($format === 'excel') border-unhcr-blue bg-blue-50/50 @endif">
                                        <input type="radio" wire:model.live="format" value="excel" class="text-unhcr-blue focus:ring-unhcr-blue">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-900">Excel (.xlsx)</span>
                                            <span class="block text-xs text-gray-500">Tableau structuré</span>
                                        </div>
                                    </label>

                                    <label class="flex items-center p-3 border rounded-md cursor-pointer hover:bg-slate-50 @if($format === 'pdf') border-unhcr-blue bg-blue-50/50 @endif">
                                        <input type="radio" wire:model.live="format" value="pdf" class="text-unhcr-blue focus:ring-unhcr-blue">
                                        <div class="ml-3">
                                            <span class="block text-sm font-bold text-gray-900">PDF A4</span>
                                            <span class="block text-xs text-gray-500">Rapport imprimable</span>
                                        </div>
                                    </label>
                                </div>
                                @error('format') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <!-- Organisation -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Organisation</label>
                                @if(auth()->user()->hasRole('Admin'))
                                    <select wire:model="organisation_id" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm focus:border-unhcr-blue focus:ring-unhcr-blue">
                                        <option value="">Toutes les organisations</option>
                                        @foreach($organisations as $org)
                                            <option value="{{ $org->id }}">{{ $org->denomination }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-xs text-gray-500">En tant qu'administrateur, vous pouvez choisir l'organisation.</span>
                                @else
                                    <input type="text" value="{{ optional(auth()->user()->organisation)->denomination ?? 'Mon Organisation' }}" class="mt-1 block w-full border border-gray-200 bg-gray-100 rounded-md p-2 text-sm text-gray-600" disabled>
                                    <span class="text-xs text-amber-600 font-medium">Exportation limitée aux données de votre organisation.</span>
                                @endif
                            </div>

                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date de début</label>
                                    <input type="date" wire:model="date_debut" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                                    @error('date_debut') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date de fin</label>
                                    <input type="date" wire:model="date_fin" class="mt-1 block w-full border border-gray-300 rounded-md p-2 text-sm" required>
                                    @error('date_fin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit" class="portal-button-primary w-full sm:ml-3 sm:w-auto">
                            Générer l'export {{ strtoupper($format) }}
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

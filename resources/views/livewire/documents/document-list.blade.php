<div class="portal-page">
    <div class="portal-heading flex flex-col items-start justify-between gap-4 md:flex-row md:items-center">
        <div><p class="portal-kicker">Bibliothèque partagée</p><h2>Gestion des documents</h2></div>
        <div class="mt-4 md:mt-0 flex gap-2">
            <button class="portal-button-primary" wire:click="$dispatch('openDocumentModal')">
                Ajouter un Document
            </button>
        </div>
    </div>

    <!-- Filtres -->
    <div class="portal-filter grid grid-cols-1 gap-4 md:grid-cols-3">
        <div class="md:col-span-2">
            <input type="text" wire:model.live="search" placeholder="Rechercher par nom ou résumé..." class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <select wire:model.live="category" class="p-2 border border-gray-300 rounded w-full focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat }}">{{ $cat }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Grille de documents (Cards) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($documents as $doc)
            <div class="portal-card p-5 transition-shadow hover:shadow-md">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center">
                        <div class="mr-3 rounded-sm bg-unhcr-pale p-2 text-unhcr-blue">
                            <!-- Icon file -->
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        </div>
                        <div>
                            <span class="text-xs font-semibold px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ $doc->doc_category ?? 'Autre' }}</span>
                            <div class="text-xs text-gray-400 mt-1">{{ $doc->date_publication ? $doc->date_publication->format('d/m/Y') : $doc->created_at->format('d/m/Y') }}</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        @can('update', $doc)
                        <button wire:click="$dispatch('editDocument', { id: '{{ $doc->id }}' })" class="text-gray-400 hover:text-blue-600" title="Éditer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </button>
                        @endcan
                        @can('delete', $doc)
                        <button wire:confirm="Êtes-vous sûr de vouloir supprimer ce document ?" wire:click="deleteDocument('{{ $doc->id }}')" class="text-gray-400 hover:text-red-600" title="Supprimer">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                        @endcan
                    </div>
                </div>

                <h3 class="text-lg font-bold text-gray-800 line-clamp-1 mb-2" title="{{ $doc->doc_name }}">{{ $doc->doc_name }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2 mb-4 h-10">{{ $doc->doc_summary ?? 'Aucun résumé.' }}</p>

                <div class="flex justify-between items-center text-xs text-gray-400 pt-3 border-t">
                    <span title="{{ $doc->original_name }}" class="truncate w-32">{{ \Illuminate\Support\Str::limit($doc->original_name, 15) }}</span>
                    <span>{{ $doc->download_count }} dl</span>
                </div>

                <button wire:click="downloadDocument('{{ $doc->id }}')" class="portal-button-secondary mt-4 w-full">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Télécharger
                </button>
            </div>
        @empty
            <div class="col-span-1 md:col-span-2 lg:col-span-3 py-10 text-center text-gray-500">
                <p>Aucun document trouvé.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $documents->links() }}
    </div>

    <livewire:documents.document-form-modal />
</div>

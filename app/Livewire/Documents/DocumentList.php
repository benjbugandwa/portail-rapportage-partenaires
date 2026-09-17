<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

class DocumentList extends Component
{
    use WithPagination;

    public $search = '';
    public $category = '';

    protected $listeners = ['document-saved' => '$refresh'];

    public function updatingSearch() { $this->resetPage(); }
    public function updatingCategory() { $this->resetPage(); }

    public function downloadDocument($id)
    {
        $document = Document::findOrFail($id);
        
        $document->increment('download_count');

        return response()->download(storage_path('app/public/' . $document->file_path), $document->original_name);
    }

    public function render()
    {
        $documents = Document::query()
            ->with('uploader')
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(doc_name) LIKE ?', ['%' . strtolower($this->search) . '%'])
                      ->orWhereRaw('LOWER(doc_summary) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            })
            ->when($this->category, function ($query) {
                $query->where('doc_category', $this->category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('livewire.documents.document-list', [
            'documents' => $documents,
            'categories' => ['Rapport', 'Carte', 'Liste', 'Evaluation', 'Autre']
        ]);
    }
}

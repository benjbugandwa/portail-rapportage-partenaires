<?php

namespace App\Livewire\Documents;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Storage;

class DocumentFormModal extends Component
{
    use WithFileUploads;

    public $show = false;
    public $document_id;
    
    public $doc_name;
    public $date_publication;
    public $doc_category = 'Rapport';
    public $doc_summary;
    public $file;
    public $existing_file_path;
    public $original_name;

    public $categories = ['Rapport', 'Carte', 'Liste', 'Evaluation', 'Autre'];

    #[On('openDocumentModal')]
    public function openModal()
    {
        $this->authorize('create', Document::class);

        $this->reset([
            'document_id', 'doc_name', 'date_publication', 
            'doc_category', 'doc_summary', 'file', 'existing_file_path', 'original_name'
        ]);
        $this->date_publication = date('Y-m-d');
        $this->doc_category = 'Rapport';
        $this->show = true;
    }

    #[On('editDocument')]
    public function editDocument($id)
    {
        $document = Document::findOrFail($id);
        $this->authorize('update', $document);
        
        $this->document_id = $document->id;
        $this->doc_name = $document->doc_name;
        $this->date_publication = $document->date_publication ? $document->date_publication->format('Y-m-d') : null;
        $this->doc_category = $document->doc_category;
        $this->doc_summary = $document->doc_summary;
        $this->existing_file_path = $document->file_path;
        $this->original_name = $document->original_name;
        
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function save()
    {
        if ($this->document_id) {
            $existingDoc = Document::findOrFail($this->document_id);
            $this->authorize('update', $existingDoc);
        } else {
            $this->authorize('create', Document::class);
        }
        $rules = [
            'doc_name' => 'required|string|max:255',
            'date_publication' => 'required|date',
            'doc_category' => 'required|string',
            'doc_summary' => 'nullable|string|max:1000',
        ];

        if (!$this->document_id) {
            $rules['file'] = 'required|file|max:20480'; // 20MB max
        } else {
            $rules['file'] = 'nullable|file|max:20480';
        }

        $this->validate($rules);

        $path = $this->existing_file_path;
        $original = $this->original_name;
        $mime = null;

        if ($this->file) {
            $path = $this->file->store('documents', 'public');
            $original = $this->file->getClientOriginalName();
            $mime = $this->file->getMimeType();
        } else {
            if ($this->document_id) {
                $doc = Document::find($this->document_id);
                $mime = $doc->mime_type;
            }
        }

        $data = [
            'doc_name' => $this->doc_name,
            'date_publication' => $this->date_publication,
            'doc_category' => $this->doc_category,
            'doc_summary' => $this->doc_summary,
            'file_path' => $path,
            'original_name' => $original,
            'mime_type' => $mime,
        ];

        if (!$this->document_id) {
            $data['uploaded_by'] = Auth::id();
        }

        Document::updateOrCreate(
            ['id' => $this->document_id],
            $data
        );

        notify()->success('Document enregistré avec succès');

        $this->close();
        $this->dispatch('document-saved');
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.documents.document-form-modal');
    }
}

<?php

namespace App\Livewire\Admin\Secteurs;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Secteur;

class SecteurList extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $secteurs = Secteur::query()
            ->when($this->search, function ($query) {
                $query->whereRaw('LOWER(denomination) LIKE ?', ['%' . strtolower($this->search) . '%']);
            })
            ->orderBy('denomination', 'asc')
            ->paginate(10);

        return view('livewire.admin.secteurs.secteur-list', [
            'secteurs' => $secteurs,
        ]);
    }
}

<?php

namespace App\Livewire\Reporting\Activites;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Activite;
use App\Models\Secteur;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class ActiviteList extends Component
{
    use WithPagination;

    public $search = '';
    public $secteur_id = '';
    public $province_id = '';
    public $statut = '';
    public $date_debut = '';
    public $date_fin = '';

    public function updatingSearch() { $this->resetPage(); }
    public function updatingSecteurId() { $this->resetPage(); }
    public function updatingProvinceId() { $this->resetPage(); }
    public function updatingStatut() { $this->resetPage(); }

    public function deleteActivite($id)
    {
        $activite = Activite::findOrFail($id);
        $this->authorize('delete', $activite);
        $activite->delete();

        notify()->success('Activité supprimée avec succès');
    }

    public function render()
    {
        $user = Auth::user();

        $activites = Activite::query()
            ->with(['secteur', 'createur.organisation'])
            ->when(!$user->hasRole('Admin'), function ($query) use ($user) {
                $query->whereHas('createur', function($q) use ($user) {
                    $q->where('organisation_id', $user->organisation_id);
                });
            })
            ->when($this->search, function ($query) {
                $query->where(function($q) {
                    $q->whereRaw('LOWER(intitule) LIKE ?', ['%' . strtolower($this->search) . '%'])
                      ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            })
            ->when($this->secteur_id, function ($query) {
                $query->where('secteur_id', $this->secteur_id);
            })
            ->when($this->statut, function ($query) {
                $query->where('statut', $this->statut);
            })
            ->when($this->province_id, function ($query) {
                $query->where('province_id', 'LIKE', '%"'.$this->province_id.'"%');
            })
            ->when($this->date_debut, function ($query) {
                $query->where('date_activite', '>=', $this->date_debut);
            })
            ->when($this->date_fin, function ($query) {
                $query->where('date_activite', '<=', $this->date_fin);
            })
            ->orderBy('date_activite', 'desc')
            ->paginate(10);

        return view('livewire.reporting.activites.activite-list', [
            'activites' => $activites,
            'secteurs' => Secteur::all(),
            'provinces' => Province::all(),
        ]);
    }
}

<?php

namespace App\Livewire\Reporting\Activites;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Activite;
use App\Models\Secteur;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ActiviteFormModal extends Component
{
    use WithFileUploads;

    public $show = false;
    public $activite_id;
    public $intitule;
    public $date_activite;
    public $secteur_id;
    public $description;
    public $defis_contraintes;
    public $localites;
    public $statut = 'en cours';
    public $nbre_personnes = 0;
    public $nbre_menage = 0;

    public $population_cible = [];
    public $province_id = [];

    public $file;
    public $existing_file_path;

    #[On('open-activite-modal')]
    public function openModal()
    {
        $this->authorize('create', Activite::class);

        $this->reset([
            'activite_id', 'intitule', 'date_activite', 'secteur_id', 
            'description', 'defis_contraintes', 'localites', 'statut', 
            'nbre_personnes', 'nbre_menage', 'population_cible', 
            'province_id', 'file', 'existing_file_path'
        ]);
        $this->show = true;
    }

    #[On('edit-activite')]
    public function editActivite($id)
    {
        $activite = Activite::findOrFail($id);
        $this->authorize('update', $activite);
        
        $this->activite_id = $activite->id;
        $this->intitule = $activite->intitule;
        $this->date_activite = $activite->date_activite->format('Y-m-d');
        $this->secteur_id = $activite->secteur_id;
        $this->description = $activite->description;
        $this->defis_contraintes = $activite->defis_contraintes;
        $this->localites = $activite->localites;
        $this->statut = $activite->statut;
        $this->nbre_personnes = $activite->nbre_personnes;
        $this->nbre_menage = $activite->nbre_menage;
        $this->population_cible = $activite->population_cible ?? [];
        $this->province_id = $activite->province_id ?? [];
        $this->existing_file_path = $activite->file_path;
        
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function save()
    {
        if ($this->activite_id) {
            $existingActivite = Activite::findOrFail($this->activite_id);
            $this->authorize('update', $existingActivite);
        } else {
            $this->authorize('create', Activite::class);
        }

        $this->validate([
            'intitule' => 'required|string|max:255',
            'date_activite' => 'required|date',
            'secteur_id' => 'required|exists:secteurs,id',
            'population_cible' => 'nullable|array',
            'description' => 'nullable|string',
            'defis_contraintes' => 'nullable|string',
            'localites' => 'nullable|string',
            'province_id' => 'nullable|array',
            'nbre_personnes' => 'nullable|integer|min:0',
            'nbre_menage' => 'nullable|integer|min:0',
            'statut' => 'required|string|in:en cours,clôturée',
            'file' => 'nullable|file|max:10240',
        ]);

        $path = $this->existing_file_path;
        if ($this->file) {
            $path = $this->file->store('justificatifs', 'public');
        }

        $data = [
            'intitule' => $this->intitule,
            'date_activite' => $this->date_activite,
            'secteur_id' => $this->secteur_id,
            'description' => $this->description,
            'defis_contraintes' => $this->defis_contraintes,
            'localites' => $this->localites,
            'statut' => $this->statut,
            'nbre_personnes' => $this->nbre_personnes ?: 0,
            'nbre_menage' => $this->nbre_menage ?: 0,
            'population_cible' => $this->population_cible,
            'province_id' => $this->province_id,
            'file_path' => $path,
        ];

        if (!$this->activite_id) {
            $data['created_by'] = Auth::id();
        }

        Activite::updateOrCreate(
            ['id' => $this->activite_id],
            $data
        );

        notify()->success('Activité enregistrée avec succès');

        $this->close();
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.reporting.activites.activite-form-modal', [
            'secteurs' => Secteur::orderBy('denomination')->get(),
            'provinces' => Province::orderBy('nom_province')->get(),
        ]);
    }
}

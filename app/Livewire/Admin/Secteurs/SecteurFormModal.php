<?php

namespace App\Livewire\Admin\Secteurs;

use Livewire\Component;
use App\Models\Secteur;
use Livewire\Attributes\On;

class SecteurFormModal extends Component
{
    public $show = false;
    public $secteur_id;
    public $denomination;
    public $description;

    #[On('openSecteurModal')]
    public function openModal()
    {
        $this->reset(['secteur_id', 'denomination', 'description']);
        $this->show = true;
    }

    #[On('editSecteur')]
    public function editSecteur($id)
    {
        $secteur = Secteur::findOrFail($id);
        $this->secteur_id = $secteur->id;
        $this->denomination = $secteur->denomination;
        $this->description = $secteur->description;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function save()
    {
        $this->validate([
            'denomination' => 'required|string|max:255|unique:secteurs,denomination,' . $this->secteur_id,
            'description' => 'nullable|string',
        ]);

        Secteur::updateOrCreate(
            ['id' => $this->secteur_id],
            [
                'denomination' => $this->denomination,
                'description' => $this->description,
            ]
        );

        notify()->success('Secteur enregistré avec succès');

        $this->close();
        $this->dispatch('secteur-saved');
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.admin.secteurs.secteur-form-modal');
    }
}

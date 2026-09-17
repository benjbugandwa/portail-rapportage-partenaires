<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Province;
use Livewire\Attributes\On;

class UserFormModal extends Component
{
    public $show = false;
    public $user_id;
    public $nom;
    public $email;
    public $organisation_id;
    public $province_id;
    public $is_active = true;
    public $role = 'Guest';

    #[On('open-user-modal')]
    public function openModal()
    {
        $this->reset(['user_id', 'nom', 'email', 'organisation_id', 'province_id', 'is_active', 'role']);
        $this->show = true;
    }

    #[On('edit-user')]
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $user->id;
        $this->nom = $user->nom;
        $this->email = $user->email;
        $this->organisation_id = $user->organisation_id;
        $this->province_id = $user->province_id;
        $this->is_active = $user->is_active;
        $this->role = $user->roles->first()->name ?? $user->role;
        $this->show = true;
    }

    public function close()
    {
        $this->show = false;
    }

    public function save()
    {
        $this->validate([
            'nom' => 'required|string|max:150',
            'email' => 'required|email|max:255|unique:users,email,' . $this->user_id,
            'organisation_id' => 'nullable|exists:organisations,id',
            'province_id' => 'nullable|exists:provinces,id',
            'is_active' => 'boolean',
            'role' => 'required|string',
        ]);

        $user = User::updateOrCreate(
            ['id' => $this->user_id],
            [
                'nom' => $this->nom,
                'email' => $this->email,
                'organisation_id' => $this->organisation_id ?: null,
                'province_id' => $this->province_id ?: null,
                'is_active' => $this->is_active,
                'role' => $this->role,
            ]
        );

        // Assigner le rôle Spatie
        $user->syncRoles([$this->role]);

        notify()->success('Utilisateur enregistré avec succès');

        $this->close();
        $this->redirect(request()->header('Referer'));
    }

    public function render()
    {
        return view('livewire.admin.users.user-form-modal', [
            'organisations' => Organisation::all(),
            'provinces' => Province::all(),
            'roles' => \Spatie\Permission\Models\Role::all(),
        ]);
    }
}

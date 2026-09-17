<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Organisation;
use App\Models\Province;

class UserList extends Component
{
    use WithPagination;

    public $search = '';
    public $organisation_id = '';
    public $province_id = '';
    public $is_active = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingOrganisationId()
    {
        $this->resetPage();
    }

    public function render()
    {
        $users = User::query()
            ->with(['organisation', 'province'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->whereRaw('LOWER(nom) LIKE ?', ['%' . strtolower($this->search) . '%'])
                      ->orWhereRaw('LOWER(email) LIKE ?', ['%' . strtolower($this->search) . '%']);
                });
            })
            ->when($this->organisation_id, function ($query) {
                $query->where('organisation_id', $this->organisation_id);
            })
            ->when($this->province_id, function ($query) {
                $query->where('province_id', $this->province_id);
            })
            ->when($this->is_active !== '', function ($query) {
                $query->where('is_active', $this->is_active);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.admin.users.user-list', [
            'users' => $users,
            'organisations' => Organisation::all(),
            'provinces' => Province::all(),
        ]);
    }
}

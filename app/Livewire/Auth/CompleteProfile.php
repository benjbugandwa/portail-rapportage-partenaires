<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Models\Organisation;
use App\Models\Province;
use Illuminate\Support\Facades\Auth;

class CompleteProfile extends Component
{
    public $organisation_id = '';
    public $province_id = '';

    protected $rules = [
        'organisation_id' => 'required|exists:organisations,id',
        'province_id' => 'required|exists:provinces,id',
    ];

    public function mount()
    {
        $user = Auth::user();
        if ($user->organisation_id && $user->province_id) {
            return redirect()->route('dashboard');
        }
    }

    public function save()
    {
        $this->validate();

        $user = Auth::user();
        $user->update([
            'organisation_id' => $this->organisation_id,
            'province_id' => $this->province_id,
        ]);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.auth.complete-profile', [
            'organisations' => Organisation::orderBy('denomination')->get(),
            'provinces' => Province::orderBy('nom_province')->get(),
        ])->layout('layouts.app', ['title' => 'Compléter votre profil']);
    }
}
